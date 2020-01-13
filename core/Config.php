<?php

namespace core\Config;

use Exception;
use core\ConfigInterface\ConfigInterface;

class Config implements ConfigInterface
{
    private $configuration = array();

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        try {
            foreach (glob(__DIR__ . "/../config/*.php") as $config) {
                $tempArray = include_once($config);
                if (is_bool($tempArray)) {
                    continue;
                }
                $this->configuration[key($tempArray)] = $tempArray[key($tempArray)];
            }
        } catch (Exception $e) {
            echo 'Folder not found ', $e->getMessage(), "\n";
        }
    }

    public function getProperty($config, $key)
    {
        return $this->configuration[$config][$key];
    }

    public function getProperties($config)
    {
        return $this->configuration[$config];
    }
}
