<?php

namespace Core\DB\Database;

use Core\Registry\Registry;
use Core\DB\Database\DatabaseInterface;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private static $instance = null;
    private $con;
    private function __construct()
    {
        $this->connect();
    }
    private function getDBName()
    {
        $dbName = Registry::get('Config')->getProperty('DB_NAME');
        return $dbName;
    }
    private function getDBHost()
    {
        $dbHost = Registry::get('Config')->getProperty('DB_HOST');
        return $dbHost;
    }
    private function getDBUser()
    {
        $dbUser = Registry::get('Config')->getProperty('DB_USER');
        return $dbUser;
    }
    private function getDBPsswd()
    {
        $dbPsswd = Registry::get('Config')->getProperty('DB_PSSWD');
        return $dbPsswd;
    }


    private function connect()
    {
        try {
            $this->con = new PDO("mysql:host={$this->getDBHost()};dbname={$this->getDBName()}", $this->getDBUser(), $this->getDBPsswd());
            $this->con->setAttribute(PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
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
    public function close()
    {
        mysqli_close($this->con);
    }
}
