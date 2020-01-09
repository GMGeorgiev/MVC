<?php

//autoloaders and includes
include_once('../core/autoloader.php');
include_once('../vendor/autoload.php');

//Namespaces
use core\Config\Config;
use core\Registry\Registry;
use core\App\App;
use core\DB\Database\Database;
use core\Request\Request;
use core\DB\QueryBuilder\QueryBuilder;
use core\Model\Model;
use core\Response\Response;
use core\Router\Router;
use core\ViewSmarty\ViewSmarty;

//Set services here
Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());
Registry::set('Request', new Request());
Registry::set('Response', new Response());
Registry::set('Router', new Router());
Registry::set('View', new ViewSmarty(
    Registry::get('Config')->getProperty('templateEngine', 'template_path'),
    Registry::get('Config')->getProperty('templateEngine', 'cache')
));


//get App instance
$app = App::getInstance();
