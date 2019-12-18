<?php

namespace core\DB\Database;

use core\DB\QueryBuilder\QueryBuilder;
use core\Registry\Registry;
use core\DB\DatabaseInterface\DatabaseInterface;
use Exception;
use PDO;
use PDOException;


include_once('DatabaseInterface.php');
class Database implements DatabaseInterface
{
    private static $instance = null;
    private $con;
    private $result;

    private function __construct()
    {
        $this->connect();
    }
    private function getDBName()
    {
        $dbName = Registry::get('Config')->getProperty('database','DB_NAME');
        return $dbName;
    }
    private function getDBHost()
    {
        $dbHost = Registry::get('Config')->getProperty('database','DB_HOST');
        return $dbHost;
    }
    private function getDBUser()
    {
        $dbUser = Registry::get('Config')->getProperty('database','DB_USER');
        return $dbUser;
    }
    private function getDBPsswd()
    {
        $dbPsswd = Registry::get('Config')->getProperty('database','DB_PSSWD');
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

    public function query($sql, $params = [])
    {
        $query = $this->con->prepare($sql);
        $indexedPosition = 1;
        if (count($params)) {
            foreach ($params as $param) {
                $this->query->bindValue($indexedPosition, $param);
                $indexedPosition++;
            }
        }
        if ($query->execute()) {
            $this->result = $query->fetchAll();
            return $this->result;
        } else {
            throw new Exception("Query Execution Failed");
        }
    }
}
