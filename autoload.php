<?php
function autoload($className)
{
    $filePath = __DIR__ . '/' . $className . '.php';


    // Check if the class file exists
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}

// Register the autoload function
spl_autoload_register('autoload');