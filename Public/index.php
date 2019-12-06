<?php

use Core\Config\Config;
use Core\Registry\Registry;

include 'Registry.php';

Registry::set("config", new Config());

$app = App::getInstance();
$app->run();
