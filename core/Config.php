<?php

namespace Core\Config;

class Config
{
    private static $instance;
    public $configurate = array();

    private function __construct()
    {
        $this->init();
    }

    private function init()
    {
        foreach (glob("../config/*.php") as $config) {
            $tempArray = include_once($config);
            $this->configurate[key($tempArray)] = $tempArray;
        }
    }
    public function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getSettings($key)
    {
        if ($this->configurate[$key]) {
            return $this->configurate[$key];
        } else {
            throw new \Exception("Config Not Found");
        }
    }
}

