<?php


namespace models;

use models\Images;
use models\Errors;

class User {
    private $conn;
    private $table = "users";
    private $table_two = "users_imgs";
    
    private $table_three = "admin";
    private $images;
    private $errors;

    public function __construct($db) {
        $this->conn = $db;
        $this->images = new Images();
        $this->errors = new Errors();
    }

    // ====================================
    // ==========Fetch users =============
    // ====================================
    public function getBarrower() {
        $role = 1;
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE role = :role ORDER BY id DESC");
        $stmt->bindValue(":role", $role);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCollector() {
        $role = 2;
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE role = :role ORDER BY id DESC");
        $stmt->bindValue(":role", $role);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function specificUser($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->conn->prepare("SELECT * FROM {$this->table_two} WHERE users_id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return [
            'user' => $user,
            'images' => $images
        ];

    }

    public function deleteUserImgs($id) {
        try {
            // Validate ID
            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                throw new \Exception("Invalid user ID.");
            }

            // Fetch images associated with the user
            $stmt = $this->conn->prepare("SELECT img_file FROM {$this->table_two} WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $image = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($image === false) {
                throw new \Exception("No images found for the given user ID.");
            }

            // Delete image files from the server
            $fileDeleted = $this->images->deleteFile('user_imgs', $image['img_file']);
            if (!$fileDeleted) {
                throw new \Exception("Failed to delete image: {$image['img_file']}");
            }

            // Delete image records from the database
            $stmt = $this->conn->prepare("DELETE FROM {$this->table_two} WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            return [
                'status' => "success",
                'message' => "User images deleted successfully.",
            ];
        } catch (\Throwable $th) {
            $this->errors->logErrorToFile($th);
            return [
                'status' => "error",
                'message' => $th->getMessage(),
            ];
        }
    }

    public function deleteUsers($data) {
        try {
            if($_SESSION['csrf_token'] !== $data['csrf_token']){
                throw new \Exception("Sorry wrong form!"); 
            }
            // Validate ID
            if (!filter_var($data['users_id'], FILTER_VALIDATE_INT)) {
                throw new \Exception("Invalid user ID.");
            }

            // Delete user record from the database
            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :users_id");
            $stmt->bindValue(":users_id", $data['users_id']);
            $stmt->execute();

            return [
                'status' => "success",
                'message' => "User deleted successfully.",
            ];
        } catch (\Throwable $th) {
            $this->errors->logErrorToFile($th);
            return [
                'status' => "error",
                'message' => $th->getMessage(),
            ];
        }
    }
    public function create($data) {

        try {

                if($_SESSION['csrf_token'] !== $data['csrf_token']):
                    throw new \Exception("Sorry wrong form!"); 
                else:

                    if(!empty($data['id'])):
                        $messages = 'Existing User Updated Successfully!';

                        $stmtSlct = $this->conn->prepare("SELECT email FROM {$this->table} WHERE email = :email AND id != :id");
                        $stmtSlct->bindParam(":id", $data['id']);
                    else:
                        $messages = 'New User Insert Successfully!';

                        $stmtSlct = $this->conn->prepare("SELECT email FROM {$this->table} WHERE email = :email");
                        
                    endif;
                    $stmtSlct->bindParam(":email", $data['email']);
                    $stmtSlct->execute();
                    $email = $stmtSlct->fetch(\PDO::FETCH_ASSOC);

                    if($email):
                        throw new \Exception("This email already taken!");
                    endif;
                    
                    if(!empty($data['password'])):
                        $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
                        $data['password'] = ($data['password'] === NULL) ? NULL : $password_hash ;
                    endif;

                    $keys = (!empty($data['password'])) ? ['full_name', 'email', 'phonenumber', 'role'] : ['full_name', 'email', 'phonenumber', 'role'];
                    
                    if ($data['role'] == 2 && !empty($data['password'])) {
                        $keys[] = 'password';
                    }

                    $set = implode(", ", array_map(fn($k)=>("$k = :$k"), $keys));
                    $columns = array_map(function($k){return":$k";}, $keys);
                    $placeholder = implode(", ", $columns);

                    $this->conn->beginTransaction();

                    if(!empty($data['id'])):
                        $stmt = $this->conn->prepare("
                            UPDATE {$this->table} SET $set WHERE id = :id");
                        
                        $stmt->bindValue(":id", $data['id']);
                    else:
                        $stmt = $this->conn->prepare("
                            INSERT INTO {$this->table} (".implode(',', $keys).")
                            VALUES ($placeholder)
                        ");
                    endif;

                    foreach ($keys as $key) {
                        $stmt->bindValue(":$key", $data[$key]);
                    }
                            
                    if ($stmt->execute()) {
                        
                        $userId = !empty($data['id']) ? $data['id'] : $this->conn->lastInsertId();

                        // Call the handleMultipleFileUploads method for multiple file uploads
                            $uploadResult = $this->images->handleMultipleFileUploads(
                                'user_imgs',
                                ['image/jpeg', 'image/png', 'image/gif'],
                                10000000
                            );


                        if(isset($uploadResult['filenames'])){
                            
                        

                            // Check the result of the upload
                            // if ($uploadResult['status'] === 'error') {
                            //     return $uploadResult;  // Return error if any file upload fails
                            // }

                            if ($uploadResult['status'] === 'error') {
                                throw new \Exception($uploadResult['message']);
                            }

                            foreach ($uploadResult['filenames'] as $filename) {
                                $stmt = $this->conn->prepare("INSERT INTO {$this->table_two} (users_id, img_file) VALUES (:user_id, :img_file)");
                                $stmt->bindParam(':user_id', $userId);  // Replace with the correct user ID
                                $stmt->bindParam(':img_file', $filename);

                                if (!$stmt->execute()) {
                                    throw new \Exception("Image DB insert failed");
                                }
                            }

                        }
                    }
                    $this->conn->commit();

                     return [
                        'status' => "success",
                        'message' => $messages,
                    ];
                endif;
        } catch (\Throwable $th) {

            if($this->conn->inTransaction())$this->conn->rollBack();

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                'code' => $th->getCode(),
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ];

            return[
                'status' => "error",
                'message' => $th->getMessage(),
            ];
        }
    }


   public function login($data)
    {
        try {

            /* ===============================
            1. CHECK ADMIN TABLE FIRST
            ================================ */
            $stmt = $this->conn->prepare("
                SELECT id, username, password
                FROM {$this->table_three}
                WHERE username = :email
                LIMIT 1
            ");
            $stmt->bindParam(":email", $data['email']);
            $stmt->execute();
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($admin && password_verify($data['password'], $admin['password'])) {

                session_regenerate_id(true);

                $_SESSION['data']    = $admin;

                return [
                    'status'   => 'success',
                    'message'  => 'dashboard'
                ];
            }

            /* ===============================
            2. CHECK USER TABLE
            ================================ */
            $stmt = $this->conn->prepare("
                SELECT id, email, password, company_id
                FROM {$this->table}
                WHERE email = :email
                LIMIT 1
            ");
            $stmt->bindParam(":email", $data['email']);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($user && password_verify($data['password'], $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['data']    = $user;

                return [
                    'status'   => 'success',
                    'message'  => 'dashboard'
                ];
            }

            /* ===============================
            3. INVALID CREDENTIALS
            ================================ */
            throw new \Exception('Invalid email or password');

        } catch (\Throwable $th) {

            return [
                'status'  => 'error',
                'message' => $th->getMessage()
            ];
        }
    }


}
