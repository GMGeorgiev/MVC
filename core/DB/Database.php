<?php

namespace core\DB;

use core\Registry;
use core\DB\DatabaseInterface;
use Exception;
use PDO;
use PDOException;

class Database implements DatabaseInterface {
    private static $instance = null;
    private $con;
    private $result = [];

    public function __construct() {
        $this->connect();
    }

    private function getDBName() {
        $dbName = Registry::get('Config')->getProperty('database', 'DB_NAME');
        return $dbName;
    }

    private function getDBHost() {
        $dbHost = Registry::get('Config')->getProperty('database', 'DB_HOST');
        return $dbHost;
    }

    private function getDBUser() {
        $dbUser = Registry::get('Config')->getProperty('database', 'DB_USER');
        return $dbUser;
    }

    private function getDBPsswd() {
        $dbPsswd = Registry::get('Config')->getProperty('database', 'DB_PSSWD');
        return $dbPsswd;
    }


    private function connect() {
        try {
            $this->con = new PDO("mysql:host={$this->getDBHost()};dbname={$this->getDBName()}", $this->getDBUser(), $this->getDBPsswd());
            $this->con->setAttribute(PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->con;
    }

    public function query($sql, $params = []) {
        $query = $this->con->prepare($sql);
        if ($query->execute($params)) {
            if ($this->resultFlag($sql)) {
                $this->result = $query->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->result = "Rows affected: " . $query->rowCount();
            }
        } else {
            throw new Exception("Query Execution Failed");
        }
        return $this->result;
    }

    private function resultFlag($sql) {
        $result = false;
        if (strpos($sql, 'SELECT') === 0) {
            $result = true;
        }
        return $result;
    }
}
