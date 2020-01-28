<?php

//autoloaders and includes
include_once('../core/autoloader.php');
include_once('../vendor/autoload.php');

//Namespaces
use core\Config\Config,
    core\Registry,
    core\App,
    core\DB\Database,
    core\Request\Request,
    core\DB\QueryBuilder,
    core\Response\Response,
    core\Router\Router,
    core\View\View,
    core\Authentication\Authentication,
    core\Utility\Utility;

//Set services here

foreach(Registry::getAllowedKeys() as $key=>$value){
    Registry::set($key, new $key()); 
}

//get App instance
$app = App::getInstance();
