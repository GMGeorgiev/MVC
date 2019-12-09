<?php
use Core\Config\Config;
use Core\Registry\Registry;
use Core\App\App;

Registry::set('Config', new Config());

$app = App::getInstance();
$app->run();
