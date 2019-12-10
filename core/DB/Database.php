<?php

namespace Core\DB\Database;

use Core\Config\Config;
use Core\Registry\Registry;
use Core\DB\Database\DatabaseInterface;

class Database implements DatabaseInterface
{
    private static $instance = null;
    private $con;
    private function __construct()
    {
        $this->connect();
    }
    public function getDBName()
    {
        $dbName = Registry::get('Config')->getProperty('DB_NAME');
        return $dbName;
    }
    public function getDBHost()
    {
        $dbHost = Registry::get('Config')->getProperty('DB_HOST');
        return $dbHost;
    }
    public function getDBUser()
    {
        $dbUser = Registry::get('Config')->getProperty('DB_USER');
        return $dbUser;
    }
    public function getDBPsswd()
    {
        $dbPsswd = Registry::get('Config')->getProperty('DB_PSSWD');
        return $dbPsswd;
    }


    private function connect()
    {
        $this->con = new \mysqli($this->getDBHost(), $this->getDBName(), $this->getDBPsswd(), $this->getDBName());
        if ($this->con->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->con->connect_error;
            die();
        }
    }
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->con;
    }
    public function close($con)
    {
        mysqli_close($this->con);
    }
}
