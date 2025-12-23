<?php

namespace models;
class Errors{

    private $path;
    public function __construct($filePath = __DIR__ . '/../error_list/error_log.txt'){
        $this->path = $filePath;
    }

    public function logErrorToFile(\Throwable $th)  {
         $errorMessage = "[" . date('Y-m-d H:i:s') . "] "
        . "Error Code: " . $th->getCode() . " | "
        . "Message: " . $th->getMessage() . " | "
        . "File: " . $th->getFile() . " | "
        . "Line: " . $th->getLine() . PHP_EOL;

        file_put_contents( $this->path, $errorMessage, FILE_APPEND);
    }
}



?>