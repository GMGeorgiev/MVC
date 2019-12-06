<?php

use Core\Config\Config;
use Core\Registry\Registry;
include '../core/Config.php';
include '../core/App.php';

Registry::set('Config', new Config());

$app = App::getInstance();
$app->run();
