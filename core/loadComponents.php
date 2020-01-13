<?php

//autoloaders and includes
include_once('../core/autoloader.php');
include_once('../vendor/autoload.php');

//Namespaces
use core\Config\Config;
use core\Registry;
use core\App;
use core\DB\Database;
use core\Request\Request;
use core\DB\QueryBuilder;
use core\Response\Response;
use core\Router\Router;
use core\View\ViewSmarty;
use core\Authentication\Authentication;
use core\Utility\Utility;

//Set services here
Registry::set('QueryBuilder', new QueryBuilder());
Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());
Registry::set('Request', new Request());
Registry::set('View', new ViewSmarty());
Registry::set('Response', new Response());
Registry::set('Router', new Router());
Registry::set('Authentication', new Authentication);

//get App instance
$app = App::getInstance();
