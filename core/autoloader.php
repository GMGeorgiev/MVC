<?php

function autoloader($className)
{
    $newClass = explode('\\', $className);
    array_pop($newClass);
    $className = implode('/', $newClass);
    $fullPath = dirname(__DIR__) . '/' . $className . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
    } else{
        throw new Exception("File does not exist!");
    }
}

spl_autoload_register('autoloader');
