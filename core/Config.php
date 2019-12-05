<?php

namespace Core\Config;

use Exception;

class Config
{
    private static $instance;
    public $configuration = array();

    private function __construct()
    {
        $this->init();
    }

    private function init()
    {
        try {
            foreach (glob("../config/*.php") as $config) {
                $tempArray = include_once($config);
                $this->configurate[key($tempArray)] = $tempArray;
            }
        } catch (Exception $e) {
            echo 'Folder not found ', $e->getMessage(), "\n";
        }
    }
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getSettings($key)
    {
        if ($this->configuration[$key]) {
            return $this->configuration[$key];
        } else {
            throw new \Exception("Config Not Found");
        }
    }
}
