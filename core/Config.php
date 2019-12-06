<?php

namespace Core\Config;

include_once('ConfigInterface.php');

use Exception;
use Core\ConfigInterface\ConfigInterface;

class Config implements ConfigInterface
{
    public $configuration = array();

    public function __construct()
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
    public function getSetting($key)
    {
        if ($this->configuration[$key]) {
            return $this->configuration[$key];
        } else {
            throw new \Exception("Config Not Found");
        }
    }
}
