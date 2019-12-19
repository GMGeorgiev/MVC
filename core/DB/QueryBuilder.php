<?php

namespace core\DB\QueryBuilder;

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
        $tableName = "`{$tableName}`";
        $params = array_map(function ($val) {
            return "`{$val}`";
        }, $params);
        $paramsString = '';
        if (is_array($params)) {
            $paramsString = implode(",", $params);
        } elseif (!is_array($params)) {
            $paramsString = $params;
        }
        $this->query = $this->query . "SELECT {$paramsString} FROM {$tableName}";
        return $this;
    }
    public function join($tableName, $onArray = [], string $typeofJoin = "JOIN")
    {
        $onArguments = implode(' AND ', $onArray);
        if (isset($tableName) && isset($onArray)) {
            $typeofJoin = strtoupper($typeofJoin);
            if ($this->validateQuery('select')) {
                $this->query = $this->query . " " . "{$typeofJoin} {$tableName} ON {$onArguments}";
            } else {
                throw new Exception("Cannot use join withot a SELECT statement");
            }
        } else {
            throw new Exception("Parameters not properly set");
        }
        return $this;
    }
    public function insert($tableName)
    {
        $tableName = "`{$tableName}`";
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
            $newValues = array_map(function ($val) {
                return "`{$val}`";
            }, array_keys($values));
            $columnNames = implode(", ", $newValues);
            $valuesString = implode(", ", array_map(function ($val) {
                return "?";
            }, array_values($newValues)));
            if ($this->validateQuery('insert')) {
                $this->query = $this->query . " ({$columnNames}) VALUES ({$valuesString})";
            } else {
                throw new Exception("Cannot put VALUES on a query without INSERT statement");
            }
        } else {
            throw new Exception("Values not set");
        }
        return $this;
    }
    public function update($tableName)
    {
        if (isset($tableName)) {
            $tableName = "'{$tableName}'";
            $this->query = $this->query . "UPDATE {$tableName}";
        } else {
            throw new Exception("Table name not set");
        }
        return $this;
    }
    public function set($columnName, $value)
    {
        if (isset($columnName) && isset($value)) {
            if ($this->validateQuery('update')) {
                $this->query = $this->query . " " . "SET {$columnName} = {$value}";
            } else {
                throw new Exception("Cannot use SET without an UPDATE statement!");
            }
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
        if (isset($args)) {
            if ($this->validateQuery('select', 'insert', 'update', 'delete')) {
                $this->query = $this->query . " " . "WHERE " . "1";
                foreach ($args as $value) {
                    $this->query = $this->query . " " . $value;
                }
            } else {
                throw new Exception("Cannot use WHERE clause without a Query Statement");
            }
        } else {
            throw new Exception("Arguments not set");
        }
        return $this;
    }
    public function whereAnd(string $param): string
    {
        if (isset($param)) {
            return "AND {$param}";
        } else {
            throw new Exception("Parameter not set");
        }
    }
    public function whereOr(string $param): string
    {
        if (isset($param)) {
            return "OR {$param}";
        } else {
            throw new Exception("Parameter not set");
        }
    }
    private function validateQuery(...$args)
    {
        $result = true;
        foreach ($args as $value) {
            switch ($value) {
                case 'select':
                    if (strpos($this->query, 'SELECT') !== 0) {
                        $result = false;
                    }
                    break;
                case 'insert':
                    if (strpos($this->query, 'INSERT') !== 0) {
                        $result = false;
                    }
                    break;
                case 'update':
                    if (strpos($this->query, 'UPDATE') !== 0) {
                        $result = false;
                    }
                    break;
                case 'delete':
                    if (strpos($this->query, 'DELETE') !== 0) {
                        $result = false;
                    }
                    break;
                default:
                    throw new Exception("Invalid statement passed");
                    break;
            }
            if ($result == true) break;
        }
        return $result;
    }
    public function getQuery()
    {
        return $this->query;
    }
}
