<?php
session_start();
spl_autoload_register(function($fileName){
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);

    
    $files = [
        'config' => __DIR__ . '/config/',
        'models' => __DIR__ . '/models/',
        'controllers' => __DIR__ . '/controllers/',
    ];

    foreach ($files as $namespace => $baseDir){
        // Check if fileName belongs to this namespace
        if(strpos($fileName, $namespace) === 0){

            // Remove namespace prefix + separator from class path
            $relativeClass = ltrim(substr($path, strlen($namespace)), DIRECTORY_SEPARATOR); 

            // Compose full file path
            $file = $baseDir . $relativeClass . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        };
    };
});

?>