<?php

function autoloader($className)
{
    $newClass = explode('\\', $className);
    array_pop($newClass);
    $className = implode(DIRECTORY_SEPARATOR, $newClass);
    $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
    }
}

spl_autoload_register('autoloader');
