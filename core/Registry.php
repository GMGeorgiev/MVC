<?php

namespace Core\Registry;

include_once('Config.php');

use Core\Config\Config;

class Registry
{
    private static $_instances = array();
    public $allowedKeys = Config::getInstance()->getSettings('registry');
    private function __construct()
    {
        // do nothing
    }
    public static function get($key, $default = null)
    {
        if (isset(self::$_instances[$key])) {
            return self::$_instances[$key];
        }
        return $default;
    }
    public static function set($key, $instance = null)
    {
        self::$_instances[$key] = $instance;
    }
    public static function erase($key)
    {
        unset(self::$_instances[$key]);
    }
}
