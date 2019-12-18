<?php

namespace core\Registry;

class Registry
{
    private static $_instances = array();
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
        if (!in_array($key, array_keys(self::getAllowedKeys()))) {
            throw new \InvalidArgumentException('Invalid key given');
        }

        //validate if class implements proper interface
        $interface = self::getAllowedKeys()[$key];
        if (class_implements($instance)[$interface] != $interface) {
            throw new \InvalidArgumentException('Class ' . $key . ' does not implement ' . $interface);
        }
        
        //set instante in _instances array if properly validated
        self::$_instances[$key] = $instance;
    }
    public static function getAllowedKeys()
    {
        $allowedKeys = include('../config/registryConfig.php');
        return $allowedKeys['registry'];
    }
    public static function erase($key)
    {
        unset(self::$_instances[$key]);
    }
}
