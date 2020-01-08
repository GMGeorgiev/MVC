<?php
include_once('../core/autoloader.php');

use core\Config\Config;
use core\Registry\Registry;
use core\App\App;
use core\DB\Database\Database;
use core\Request\Request;
use core\DB\QueryBuilder\QueryBuilder;
use core\Model\Model;
use core\Response\Response;
use core\Router\Router;

//Set services here
Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());
Registry::set('Request', new Request());
Registry::set('Response',new Response());
Registry::set('Router', new Router());

//Boot App
$app = App::getInstance();
$app->run();

