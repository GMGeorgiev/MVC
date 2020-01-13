<?php

function autoloader($className)
{
    $newClass = explode('\\', $className);
    $className = implode(DIRECTORY_SEPARATOR, $newClass);
    $fullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
    }
}

spl_autoload_register('autoloader');

autloadInterfaces();

function autloadInterfaces()
{
    $dir = '../core/*';
    foreach (glob($dir) as $file) {
        if (filetype($file) == 'dir') {
            foreach (glob($file . '/*') as $folder) {
                if (strpos($folder, 'Interface')) {
                    include_once($folder);
                }
            }
        }
    }
}
