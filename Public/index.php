<?php

use Core\Config\Config;
use Core\Registry\Registry;
use Core\App\App;
use Core\DB\Database\Database;

//Set services here
Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());


//Boot App
$app = App::getInstance();
$app->run();