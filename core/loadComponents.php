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
    core\View\ViewSmarty,
    core\Authentication\Authentication,
    core\Utility\Utility;

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
