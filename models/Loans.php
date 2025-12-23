<?php

namespace models;

use models\Images;
use models\Errors;
use models\Phpmailers;

class Loans{
    
    private $conn;
    private $table = "loan";
    private $table_two = "loan_weekly";
    private $table_three = "users";
    private $table_four = "percentage";
    private $images;
    private $errors;
    private $phpmailers;
    public function __construct($db){
      $this->conn = $db;
      $this->images = new Images();
      $this->errors = new Errors();
      $this->phpmailers = new Phpmailers();   
    }
    

    public function insertLoans($data)
    {
        try {

            if($_SESSION['csrf_token'] !== $data['csrf_token']):
                    throw new \Exception("Sorry wrong form!"); 
            endif;

            // Ensure a transaction is started
            if (!$this->conn->inTransaction()) {
                $this->conn->beginTransaction(); // Start the transaction if it's not already active
            }


            
            // Select data for processing
            $slct = "SELECT * FROM {$this->table_four} LIMIT 1";
            $stmtSlct = $this->conn->prepare($slct);
            $stmtSlct->execute();
            $result = $stmtSlct->fetch(\PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new \Exception("Interest percentage not found.");
            }

            $stmtSlct = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
            $stmtSlct->bindParam(':id', $data['id']);
            $stmtSlct->execute();
            $oldData = $stmtSlct->fetch(\PDO::FETCH_ASSOC);

            if(!empty($_FILES['loans_imgs']['name']) && !empty($data['id'])):

                $fileDeleted = $this->images->deleteFile('loans_imgs', $oldData['proof_img']);

                if (!$fileDeleted) {
                    throw new \Exception("Failed to delete image: {$oldData['proof_img']}");
                }

            endif;

            if(!empty($_FILES['loans_imgs']['name'])):
                // File upload logic
                $uploadResult = $this->images->handleSingleFileUploads(
                    'loans_imgs',
                    ['image/jpeg', 'image/png', 'image/gif'],
                    10000000
                );

                if ($uploadResult['status'] === 'error') {
                    // Rollback if file upload fails
                    $this->conn->rollBack();
                    return $uploadResult;
                }
                $memessages = "wala file totoo!";
                // Store the uploaded filename
                $data['proof_img'] = $uploadResult['filenames'];
            else:
                $data['proof_img'] = NULL;
            endif;
            $data['amount'] = (float) $data['amount'];

            switch ($data['loan_option']) {
                case '1':
                    $data['rate_interest'] = (float) str_replace(',', '', $result['p_interest']);
                    $data['rate_penalty'] = (float) str_replace(',', '', $result['p_penalty']);
                    $data['interest'] = $data['amount'] * ($data['rate_interest'] / 100); // total interest
                    $numPayments = 4;
                    break;
                
                case '2':
                    $data['rate_interest'] = (float) str_replace(',', '', $result['sm_interest']);
                    $data['rate_penalty'] = (float) str_replace(',', '', $result['sm_penalty']);
                    $data['interest'] = $data['amount'] * ($data['rate_interest'] / 100); // total interest
                    $numPayments = 2;
                    break;
            }
            $data['return_amount'] = $data['amount'] + $data['interest']; // total return
            $weekly_amount = $data['return_amount'] / $numPayments;
            // Prepare the loan data
            $data['p_collector'] = (float) str_replace(',', '', $result['p_collector']);
      

            // Prepare the query for the loan insertion
            $keys = ['barrower_id', 'collector_id', 'amount', 'interest', 'return_amount', 'barrow_date', 'rate_interest', 'rate_penalty', 'p_collector', 'loan_option', 'proof_img'];
            $set = implode(", ", array_map(fn($col)=> "$col = :$col", $keys));
            $columns = array_map(function($k) { return ":$k"; }, $keys);
            $placeholder = implode(", ", $columns);
            
            if(!empty($data['id'])):
                $stmt = $this->conn->prepare("
                    UPDATE {$this->table} SET $set WHERE id = :id");
                
                $stmt->bindValue(":id", $data['id']);
            else:
                $stmt = $this->conn->prepare("INSERT INTO {$this->table} (" . implode(', ', $keys) . ") VALUES ($placeholder)");
            endif;
            foreach ($keys as $key) {
                $stmt->bindValue(":$key", $data[$key]);
            }

            // Execute the loan insert
            if ($stmt->execute() === false) {
                throw new \Exception("Loan Creation Failed.");
            }

            $loan_id = isset($data['id']) && !empty($data['id']) ? $data['id'] : $this->conn->lastInsertId();

            
            $sqlStatus = false;

            // Prepare the deadlines (weekly)
            $startDate = new \DateTime($data['barrow_date']);

            switch ($data['loan_option']) {
                case '1':
                    $interval = new \DateInterval('P1W');
                    $period = new \DatePeriod((clone $startDate)->modify('+1 week'), $interval, $numPayments - 1);
                    break;
                case '2':
                    $interval = new \DateInterval('P15D');
                    $period = new \DatePeriod((clone $startDate)->modify('+14 days'), $interval, $numPayments - 1);
                    break;
            }

            if (isset($oldData['loan_option']) && $oldData['loan_option'] != $data['loan_option'] || isset($oldData['barrow_date']) && $oldData['barrow_date'] != $data['barrow_date']) {

                // Delete existing deadlines if loan option has changed
                $deleteStmt = $this->conn->prepare("DELETE FROM {$this->table_two} WHERE loan_id = :loan_id");
                $deleteStmt->bindParam(":loan_id", $oldData['id']);
                
                if ($deleteStmt->execute() === false) {
                    throw new \Exception("Failed to delete existing deadlines.");
                }
            }
            // Insert the deadlines into the database
            foreach ($period as $date) {
                $deadline_date = $date->format('Y-m-d');

                if (isset($data['id']) && !empty($data['id'])) {
                    $messages = "Loan Updated Successfully!";
                }else{
                    $messages = "New Loan Inserted Successfully!";
                }
                $stmt = $this->conn->prepare("INSERT INTO {$this->table_two} (loan_id, deadline_date, amount) VALUES (:loan_id, :deadline_date, :amount)");
                $stmt->bindParam(':loan_id', $loan_id);
                $stmt->bindParam(':deadline_date', $deadline_date);
                $stmt->bindParam(':amount', $weekly_amount);

                if ($stmt->execute()) {
                    $sqlStatus = true;
                } else {
                    $sqlStatus = false;
                    break;
                }
            }

            if ($sqlStatus === false) {
                throw new \Exception("Weekly Deadline Insertion Failed.");
            }

            // Commit the transaction if everything is successful
            if ($this->conn->inTransaction()) {
                $this->conn->commit();
            }

            return [
                "status" => "success",
                "message" => $messages
            ];
        } catch (\Throwable $th) {
            // Rollback if there is any error
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            // Log the error details
            $this->errors->logErrorToFile($th);

            return [
                'status' => 'error',
                'message' => [
                    'Error Code' => $th->getCode(),
                    'Message' => $th->getMessage(),
                    'File' => $th->getFile(),
                    'Line' => $th->getLine(),
                ]
            ];
        }
    }



    public function getLoans(){

        try {
            $stmt = $this->conn->prepare("
                    SELECT l.*, b.full_name AS b_fn, c.full_name AS c_fn
                    FROM {$this->table} l
                    INNER JOIN {$this->table_three} b
                        ON b.id = l.barrower_id
                    INNER JOIN {$this->table_three} c
                        ON c.id = l.collector_id
                    ORDER BY l.id DESC");
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if($result === false){
                throw new \Exception('Loan Failed to Fetch');
            }
            return $result;

        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $errorDetails
            ];
        }
    }
    public function getPercentage(){

        try {
            $stmt = $this->conn->prepare("
                    SELECT *
                    FROM {$this->table_four}");
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if(!$result){
                throw new \Exception('Loan Failed to Fetch');
            }

            return $result;
        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $errorDetails
            ];
        }
        
    }
    public function getDashboard(): array {
        try {
            
            $stmt_four = $this->conn->prepare("
                SELECT 
                    capital
                FROM {$this->table_four}
            ");
            $stmt_four->execute();
            $capital = $stmt_four->fetch(\PDO::FETCH_ASSOC);

            if ($capital === false) {
                throw new \Exception('Dashboard Failed to Fetch 1');
            }

            $stmt_amount = $this->conn->prepare("
                SELECT 
                    SUM(amount) AS amount,
                    SUM(interest) AS interest,
                    SUM(additional_interest) AS additional_interest
                FROM {$this->table}
                WHERE loan_status = 2
            ");
            $stmt_amount->execute();
            $amount = $stmt_amount->fetch(\PDO::FETCH_ASSOC);

            if ($amount === false) {
                throw new \Exception('Dashboard Failed to Fetch 2');
            }
            
            $stmt_amount = $this->conn->prepare("
                SELECT 
                    SUM(total_penalty) AS penalty
                FROM {$this->table_two}
                WHERE status = 2 AND paid_date is not NULL
            ");
            $stmt_amount->execute();
            $penalty = $stmt_amount->fetch(\PDO::FETCH_ASSOC);

            if ($penalty === false) {
                throw new \Exception('Dashboard Failed to Fetch 3');
            }

            $stmt_amount = $this->conn->prepare("
                SELECT 
                    lw.deadline_date,
                    l.rate_penalty,
                    l.amount
                FROM {$this->table_two} lw
                LEFT JOIN(
                    SELECT id, rate_penalty, amount FROM {$this->table}
                ) AS l ON l.id = lw.loan_id
                WHERE status = 1 AND paid_date IS NULL AND deadline_date < CURDATE()
            ");
            $stmt_amount->execute();
            $all_penaltys = $stmt_amount->fetchAll(\PDO::FETCH_ASSOC);
            
            if (empty($all_penaltys)) {
                $totalDaysPassed = 0;
            }else{
                $totalDaysPassed = 0;

                foreach ($all_penaltys as $all_penalty) {
                    
                    $penalties = $all_penalty['amount'] * ($all_penalty['rate_penalty'] / 100);
                    $startDate = new \DateTime($all_penalty['deadline_date']); 
                    $currentDate = new \DateTime();  // Get the current date
                    $interval = $startDate->diff($currentDate);  // Calculate the difference

                    $daysPassed = $interval->days;  // Get the number of days

                    $totalDaysPassed += $daysPassed;

                    
                }
                $totalDaysPassed = $penalties * $totalDaysPassed;
            }
            $stmt = $this->conn->prepare("
                SELECT 
                    SUM(interest) AS revenue,
                    SUM(interest) * 0.70 AS owner_income,
                    SUM(additional_interest) AS additional_interest,
                    p_collector
                FROM {$this->table}
                WHERE loan_status = 1
            ");
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new \Exception('Dashboard Failed to Fetch 5');
            }

        $stmt2 = $this->conn->prepare("
            SELECT 
                YEAR(l.barrow_date) AS year, 
                MONTH(l.barrow_date) AS month, 
                SUM(l.amount) AS revenue,
                SUM(IFNULL(lw.penalty, 0)) AS penalty
            FROM {$this->table} l
            LEFT JOIN (
                SELECT loan_id, SUM(total_penalty) AS penalty 
                FROM {$this->table_two} 
                WHERE status = 2 AND paid_date is not NULL
                GROUP BY loan_id
            ) AS lw ON l.id = lw.loan_id
            WHERE loan_status = 1
            GROUP BY MONTH(l.barrow_date)
            ORDER BY MONTH(l.barrow_date)
        ");
        $stmt2->execute();
        $charts = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        if ($charts === false) {
            throw new \Exception('Dashboard Failed to Fetch 6');
        }

        $monthlyRevenue = [];
        $months = [];

        foreach ($charts as $chart) {
            $monthlyRevenue[] = $chart['penalty'] + $chart['revenue'];
            $months[] = date('M', strtotime("{$chart['year']}-{$chart['month']}-01"));  // "Jan 2025"
        }
 

            $current_capital = $capital['capital'] - $amount['amount'];
            $result['capital'] = $current_capital + $result['revenue'] + $penalty['penalty'] + $result['additional_interest'];
            $result['revenue'] = $result['revenue'] + $penalty['penalty'] + $result['additional_interest'];
            $dividend = (100 - $result['p_collector']) / 100;
            $result['owner_income'] = $dividend * $result['revenue'];
            $result['pending_income'] = $amount['amount'] + $amount['interest'] + $totalDaysPassed + $amount['additional_interest'] - $result['revenue'];

        
            return [
                'capital'         => $result['capital'] ?? 0,
                'revenue'         => $result['revenue'] ?? 0,
                'owner_income'    => $result['owner_income'] ?? 0,
                'pending_income'  => $result['pending_income'] ?? 0,
                'months'          => $months,
                'charts'          => $monthlyRevenue
            ];

        } catch (\Throwable $th) {
            $this->errors->logErrorToFile($th);

            return [
                'status'  => 'error',
                'message' => $th->getMessage()
            ];
        }
    }


    public function getWeekly($data) {

        try {
            //get weekly payment
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table_two} WHERE loan_id = :loan_id");
            $stmt->bindParam(":loan_id", $data['loan_id']);
            $stmt->execute();
            $weeklyPayment = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            if($weeklyPayment){
                foreach ($weeklyPayment as &$wp) {

                    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
                    $stmt->bindParam(":id", $data['loan_id']);
                    $stmt->execute();
                    $loan = $stmt->fetch(\PDO::FETCH_ASSOC);

                    $daily_penalty = $loan['amount'] * ($loan['rate_penalty'] / 100);
                    $wp['daily_penalty'] = number_format($daily_penalty, 2);

                    $total_amount = $daily_penalty + $wp['amount'];

                    $wp['amount'] = number_format( $wp['amount'],  2);
                    $wp['total_amount'] = number_format($total_amount, 2);   
                    $wp['return_amount'] = number_format( $loan['return_amount'],  2);     
                }
            }else{
                throw new \Exception('Weekly Payment Failed to Fetch');
            }
            return $weeklyPayment;

        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $errorDetails
            ];
        }
    }

    public function dueDate(){
        try {
            
            $stmt = $this->conn->prepare("
                SELECT 
                    lw.*,
                    l.*,
                    l.amount l_amount, 
                    b.full_name AS b_fn, 
                    c.full_name AS c_fn
                FROM {$this->table_two} lw
                LEFT JOIN {$this->table} l
                    ON l.id = lw.loan_id
                LEFT JOIN {$this->table_three} b
                    ON b.id = l.barrower_id
                LEFT JOIN {$this->table_three} c
                    ON c.id = l.collector_id
                WHERE lw.status = 1 AND (lw.deadline_date < CURDATE() OR lw.deadline_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY))
                GROUP BY lw.ID
            ");
            $stmt->execute();
            $dueDate = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if ($dueDate === false) {
                throw new \Exception('Due Date Failed to Fetch');
            }
            return $dueDate;
        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $errorDetails
            ];
        }
    }

    public function  updatePercentage($values) {

        try {
            
            $this->conn->beginTransaction();

            $keys = ['p_interest', 'p_penalty', 'sm_penalty', 'sm_interest', 'p_collector', 'capital'];

            $values['capital'] = number_format((float)str_replace(',', '', $values['capital']), 2, '.', '');

            $set = implode(", ", array_map(fn($cols) => "$cols = :$cols" , $keys));
        
            $stmt = $this->conn->prepare("
                UPDATE {$this->table_four} SET $set WHERE id = 1
            ");
            foreach ($keys as $key) {
                $stmt->bindValue(":$key", $values[$key]);
            }
            if (!$stmt->execute()) {
                throw new \Exception('Update All Percentage Failed');
            }

            $this->conn->commit();

            return [
                "status" => "success",
                "message" => "Update All Percentage Successfully."
            ];

        }catch (\Throwable $th) {

            if($this->conn->inTransaction())$this->conn->rollBack();

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $errorDetails
            ];
        }
    }

    public function updateWeeklyPayment($values){

        try {
            $this->conn->beginTransaction();

            $values['paid_date'] = date("y-m-d");
            $values['status'] = 2;
            $values['total_penalty'] = $values['penalty'];
            
            $keys = ['total_penalty', 'status', 'paid_date'];
            $columns = implode(", ", array_map(fn($col)=> "$col = :$col", $keys));

            $stmt = $this->conn->prepare("UPDATE {$this->table_two} SET $columns WHERE id = :id");

            foreach ($keys as $key) {
                $stmt->bindValue("$key", $values[$key]);
            }
            $stmt->bindParam(":id", $values['id']);
            
            if($stmt->execute() === false){
                throw new \Exception("Cannot update paid status!");
            }
            $this->conn->commit();

            return[
                'status' => 'success',
                'message' => 'Paid Sucessfully!'
            ];
        } catch (\Throwable $th) {
            if ($this->conn->inTransaction())$this->conn->rollBack();

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                'line' => $th->getLine(),
                'code' => $th->getCode(),
                'file' => $th->getFile(),
                'message' => $th->getMessage(),
            ];

            return[
                'status' => 'error',
                'message' => $errorDetails,
            ];


        }
    }

    public function editLoan($id){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $loan = $stmt->fetch(\PDO::FETCH_ASSOC);

            if($loan === false){
                throw new \Exception('Loan Failed to Fetch');
            }
            return $loan;

        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                // 'code' => $th->getCode(),
                // 'file' => $th->getFile(),
                // 'line' => $th->getLine(),
                'message' => $th->getMessage()
            ];
            return[
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

    public function deleteLoanInfo($data){
        try {
            if($_SESSION['csrf_token'] !== $data['csrf_token']):
                    throw new \Exception("Sorry wrong form!"); 
            endif;

            $stmtSlct = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmtSlct->bindParam(':id', $data['loan_id']);
            $stmtSlct->execute();
            $oldData = $stmtSlct->fetch(\PDO::FETCH_ASSOC);

            if (!empty($oldData['proof_img'])) {

                $fileDeleted = $this->images->deleteFile('loans_imgs', $oldData['proof_img']);
                
                if (!$fileDeleted) {
                    throw new \Exception("Failed to delete image: {$oldData['proof_img']}");
                }
            }

            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(":id", $data['loan_id']);
            
            if($stmt->execute() === false){
                throw new \Exception("Cannot delete loan info!");
            }

            return[
                'status' => 'success',
                'message' => 'Loan Deleted Sucessfully!'
            ];
        } catch (\Throwable $th) {

            $this->errors->logErrorToFile($th);

            $errorDetails = [
                'line' => $th->getLine(),
                'code' => $th->getCode(),
                'file' => $th->getFile(),
                'message' => $th->getMessage(),
            ];

            return[
                'status' => 'error',
                'message' => $errorDetails,
            ];
        }
    }

    public function sendDueDate() {
        $stmt = $this->conn->prepare("
                    SELECT 
                        lw.deadline_date, 
                        lw.total_penalty,
                        lw.amount, 
                        l.rate_penalty, 
                        l.amount AS l_amount, 
                        u.email, 
                        u.full_name
                    FROM {$this->table_two} lw
                    LEFT JOIN {$this->table} l ON l.id = lw.loan_id
                    LEFT JOIN {$this->table_three} u ON u.id = l.barrower_id
                    WHERE deadline_date <= CURDATE() AND status = 1 AND paid_date IS NULL
                ");
        $stmt->execute();
        $loans = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$loans) {
            return true; // No due loans to process
        }

        


        foreach ($loans as $loan) {
            $l_amount = (float) $loan['l_amount'];
            $rate_penalty = ($loan['rate_penalty'] / 100) * $l_amount;

            $startDate = new \DateTime($loan['deadline_date']); 
            $currentDate = new \DateTime();  // Get the current date
            $interval = $startDate->diff($currentDate);  // Calculate the difference

            $daysPassed = $interval->days;  // Get the number of days
            $total_penalty = $rate_penalty * $daysPassed;

            $loan_amount = $loan['amount'] + $total_penalty;
            $total_loan = number_format($loan_amount, 2);
            $amount = number_format($loan['amount'], 2);
            $penalty_formatted = number_format($total_penalty, 2);
            $formattedDate = date('F j, Y', strtotime($loan['deadline_date']));
            $email = $loan['email'];
            $messages = "
                Mahal kong <b>{$loan['full_name']}</b>,
                <br><br>
                Ito po ay isang paalala na ang inyong loan ay mayroong deadline ng {$loan['deadline_date']}, at ngayon po ay ang araw ng pagbabayad. Sa kadahilanang kayo po ay nahulog sa inyong takdang oras ng pagbabayad, nais naming ipaalam na may karagdagang penalty na idadagdag sa inyong loan.
                <br><br>
                Narito ang mga detalye ng inyong loan:
                <br>
                <br>
                Total ng babayarin: <b>₱{$total_loan}</b><br>
                Halaga ng Loan: <b>₱{$amount}</b><br>
                Karagdagang Penalty: <b>₱{$penalty_formatted}</b><br>
                Deadline ng Pagbabayad: <b>{$formattedDate}</b><br>
                <br><br>
                Upang maiwasan ang karagdagang mga problema, hinihiling namin na magbayad kayo agad upang mabawasan ang mga karagdagang bayarin.
                <br><br>
                Kung kayo po ay may mga katanungan o nais mag-ayos ng inyong pagbabayad, mangyaring makipag-ugnayan sa amin agad.
                <br><br>
                Maraming salamat po at ingat!
                <br><br>
                Lubos na gumagalang,
                <br>
                <b>Lending MS</b>
            ";

            $subject = "Loan Due Date";

            if (!$this->phpmailers->sendOTPEmail($email, $messages, $subject)) {
                $this->errors->logErrorToFile(new \Exception("Failed to send due date email to {$email}"));
            }
        }
        return true;
    }

    public function additionInterest()
    {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    id,
                    barrow_date,
                    interest
                FROM {$this->table}
                WHERE loan_status = 2
            ");
            $stmt->execute();

            $loans = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($loans)) {
                return;
            }

            $currentDate = new \DateTime();

            foreach ($loans as $loan) {

                $startDate = new \DateTime($loan['barrow_date']);

                // Calculate full months difference
                $interval = $startDate->diff($currentDate);
                $monthsPassed = ($interval->y * 12) + $interval->m;

                if ($monthsPassed <= 0) {
                    continue;
                }

                $additionalInterest = $loan['interest'] * $monthsPassed;

                // Update additional_interest
                $updateStmt = $this->conn->prepare("
                    UPDATE {$this->table}
                    SET additional_interest = :additional_interest
                    WHERE id = :id
                ");

                $updateStmt->execute([
                    ':additional_interest' => $additionalInterest,
                    ':id' => $loan['id']
                ]);
            }
        } catch (\Throwable $th) {
            $this->errors->logErrorToFile($th);

            return [
                'status'  => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

}
?>