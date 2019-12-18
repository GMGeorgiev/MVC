<?php

namespace core\Config;

use Exception;
use core\ConfigInterface\ConfigInterface;

require_once('ConfigInterface.php');
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
            foreach (glob("../config/*.php") as $config) {
                $tempArray = include_once($config);
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
}
