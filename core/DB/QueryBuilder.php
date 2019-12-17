<?php

namespace Core\DB\QueryBuilder;

use Exception;

class QueryBuilder
{
    private $query = '';
    public function __construct()
    {
        //does nothing...
    }
    public function select(string $tableName, $params = [])
    {
        $paramsString = '';
        if (is_array($params)) {
            $paramsString = join(",", $params);
        } elseif (!is_array($params)) {
            $paramsString = $params;
        }
        $this->query = $this->query . "SELECT {$paramsString} FROM {$tableName}";
        return $this;
    }
    public function join(string $typeofJoin = "JOIN", $tableName2, string $param1, string $param2)
    {
        if (isset($tableName2) && isset($param1) && isset($param2)) {
            $typeofJoin = strtoupper($typeofJoin);
            $this->query = $this->query . " " . "{$typeofJoin} {$tableName2} ON {$param1} = {$param2}";
        } else {
            throw new Exception("Parameters not properly set");
        }
        return $this;
    }
    public function insert($tableName)
    {
        if (isset($tableName)) {
            $this->query = $this->query . "INSERT INTO {$tableName}";
        } else {
            throw new Exception("Table name not set");
        }
        return $this;
    }
    public function values($values = [])
    {
        if (isset($values)) {
            $columnNames = join(", ", array_keys($values));
            $valuesString = join(", ", array_map(function ($val) {
                return "?";
            }, array_values($values)));
            $this->query = $this->query . " ({$columnNames}) VALUES ({$valuesString})";
        } else {
            throw new Exception("Values not set");
        }
        return $this;
    }
    public function update($tableName)
    {
        if (isset($tableName)) {
            $this->query = $this->query . "UPDATE {$tableName}";
        } else {
            throw new Exception("Table name not set");
        }
        return $this;
    }
    public function set($param1, $param2)
    {
        if (isset($param1) && isset($param2)) {
            $this->query = $this->query . " " . "SET {$param1} = {$param2}";
        } else {
            throw new Exception("Parameters not properly set");
        }
        return $this;
    }
    public function delete($tableName)
    {
        if (isset($tableName)) {
            $this->query = $this->query . "DELETE FROM {$tableName}";
        } else {
            throw new Exception("Table name not set");
        }
        return $this;
    }
    public function where(...$args)
    {
        $this->query = $this->query . " " . "WHERE";
        foreach ($args as $value) {
            $this->query = $this->query . " " . $value;
        }
        return $this;
    }
    public function whereAnd(string $param): string
    {
        return "{$param} AND";
    }
    public function whereOr(string $param): string
    {
        return "{$param} OR";
    }
    public function getQuery()
    {
        return $this->query;
    }
}

