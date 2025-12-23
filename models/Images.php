<?php

namespace models;

class Images {

    // Handle multiple file uploads
    public function handleMultipleFileUploads($fieldName, $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxFileSize = 5000000) 
    {
        // Check if files exist
        if (!isset($_FILES[$fieldName]) || !is_array($_FILES[$fieldName]['name'])) {
            return [
                "status" => "error",
                "message" => "No files uploaded."
            ];
        }

        $uploadedFiles = [];

        // Loop through each file
        foreach ($_FILES[$fieldName]['name'] as $index => $name) {

            // Build a proper file array for this upload
            $file = [
                "name"     => $_FILES[$fieldName]['name'][$index],
                "type"     => $_FILES[$fieldName]['type'][$index],
                "tmp_name" => $_FILES[$fieldName]['tmp_name'][$index],
                "error"    => $_FILES[$fieldName]['error'][$index],
                "size"     => $_FILES[$fieldName]['size'][$index]
            ];

            // Upload it
            $upload = $this->handleFileUpload($fieldName, $file, $validMimeTypes, $maxFileSize);

            if ($upload['status'] === 'error') {
                return $upload;
            }

            $uploadedFiles[] = $upload['filename'];
        }

        return [
            "status" => "success",
            "filenames" => $uploadedFiles
        ];
    }


    // Handle single file upload
    public function handleSingleFileUploads($fieldName, $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxFileSize = 10000000) 
    {
        // Check if files exist
        if (!isset($_FILES[$fieldName])) {
            return [
                "status" => "error",
                "message" => $_FILES[$fieldName]
            ];
        }


        // Build a proper file array for this upload
        $file = [
            "name"     => $_FILES[$fieldName]['name'],
            "type"     => $_FILES[$fieldName]['type'],
            "tmp_name" => $_FILES[$fieldName]['tmp_name'],
            "error"    => $_FILES[$fieldName]['error'],
            "size"     => $_FILES[$fieldName]['size']
        ];

        // Upload it
        $upload = $this->handleFileUpload('loans_imgs', $file, $validMimeTypes, $maxFileSize);

        if ($upload['status'] === 'error') {
            return $upload;
        }

        return [
            "status" => "success",
            "filenames" => $upload['filename']
        ];
    }

    public function handleFileUpload($fieldName, $file, $validMimeTypes, $maxFileSize)
    {
        // Check errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ["status" => "error", "message" => "File upload error."];
        }

        if ($file['size'] > $maxFileSize) {
            return ["status" => "error", "message" => "File too large."];
        }

        // Check MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!in_array($mime, $validMimeTypes)) {
            return ["status" => "error", "message" => "Invalid file format."];
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = $this->generateFilename($fieldName, $ext);

        // Directory
        $uploadDir = $this->getUploadDirectory($fieldName);
        $uploadPath = __DIR__ . '/../public' . $uploadDir;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $destination = $uploadPath . $newName;

        // Move file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ["status" => "error", "message" => "Failed to move file."];
        }

        return ["status" => "success", "filename" => $newName];
    }

    public function deleteFile($fieldName, $fileName): bool
    {
        $uploadDir = $this->getUploadDirectory($fieldName);
        $filePath  = __DIR__ . '/../public' . $uploadDir . $fileName;

        if (!is_file($filePath)) {
            return false;
        }

        return unlink($filePath);
    }

    // Generate unique filename
    private function generateFilename($fieldName, $ext)
    {
        // Much stronger randomness than uniqid()
        $unique = bin2hex(random_bytes(2)); // 10 characters

        switch ($fieldName) {
            case "user_imgs":
                return "u_$unique.$ext";
            case "loans_imgs":
                return "l_$unique.$ext";
            default:
                return "img_$unique.$ext";
        }
    }


    // Directory routing
    private function getUploadDirectory($fieldName)
    {
        switch ($fieldName) {
            case "user_imgs":
                return "/upload_files/user_imgs/";
            case "loans_imgs":
                return "/upload_files/loans_imgs/";
            default:
                return "/upload_files/";
        }
    }


    
}

?>
