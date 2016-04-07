<?php


// Load application specific libs
function autoload_app($className) {

    $className = ltrim($className, '\\');
    $fileName = '';

    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFilePath = '../'  . DIRECTORY_SEPARATOR . $fileName;

    if(is_readable($fullFilePath))
        require_once $fullFilePath;

}
spl_autoload_register('autoload_app');