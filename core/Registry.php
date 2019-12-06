<?php

namespace Core\Registry;

class Registry
{
    private static $_instances = array();
    private function __construct() {
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
        if (!in_array($key, self::getAllowedKeys())) {
            throw new \InvalidArgumentException('Invalid key given');
        }

        self::$_instances[$key] = $instance;
    }
    public static function getAllowedKeys()
    {
        $allowedKeys = include('../config/registryConfig.php');
        return $allowedKeys;
    }
    public static function erase($key)
    {
        unset(self::$_instances[$key]);
    }
}
