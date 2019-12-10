<?php

use Core\Config\Config;
use Core\Registry\Registry;
use Core\App\App;
use Core\DB\Database\Database;

Registry::set('Config', new Config());
Registry::set('Database', Database::getInstance());
$app = App::getInstance();
$app->run();