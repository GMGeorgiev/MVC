<?php

function autoloader($className)
{
    $newClass = explode('\\', $className);
    $className = implode(DIRECTORY_SEPARATOR, $newClass);
    $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';
    $interface = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . 'Interface' . '.php';
    if (file_exists($interface)) {
        include $interface;
    }
    if (file_exists($fullPath)) {
        include $fullPath;
    }
}

spl_autoload_register('autoloader');
