<?php
include_once('../core/autoloader.php');

use core\Config\Config;
use core\Registry\Registry;
use core\App\App;
use core\DB\Database\Database;

//Set services here
Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());

//Boot App
$app = App::getInstance();
$app->run();
