<?php

namespace core\Model;

use core\DB\QueryBuilder;
use core\Registry;
use PDO;

class Model
{
    protected $db;
    protected $table;
    protected $prKey = "id";
    protected $allowedColumns = array();
    protected $query;

    public function __construct()
    {
        $this->table = $this->tableSetter();
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
        $this->{$this->prKey} = null;
    }

    private function tableSetter()
    {
        $className = explode('\\', get_class($this));
        $table = strtolower(end($className)) . 's';
        return $table;
    }

    private function getTableColumns()
    {
        $query = $this->db->getConnection()->prepare("DESCRIBE {$this->table}");
        $query->execute();
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->getTableColumns())) {
                $this->{$key} = $value;
                array_push($this->allowedColumns, $key);
            }
        }
    }

    public function find($id)
    {
        $result = false;
        if (isset($this->{$this->prKey})) {
            $result = $this->findByValue([$this->prKey => $id]);
            $this->$this->setProperties($result);
        }
        return $this;
    }

    public function findByValue(array $values)
    {
        $whereArguments = '';
        foreach ($values as $key => $value) {
            $whereArguments .= "AND `{$key}` = '{$value}'";
        }
        $sql = $this->query
            ->select($this->table, "*")
            ->where($whereArguments)
            ->getQuery();

        $result = $this->db->query($sql);
        $this->setProperties($result);
        return $this;
    }

    public function save()
    {
        if ($this->find($this->{$this->prKey})) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function delete(): void
    {
        $sql = $this->query
            ->delete($this->table)
            ->where(
                $this->query->whereAnd("{$this->prKey} = \"{$this->{$this->prKey}}\"")
            )->getQuery();
        $this->db->query($sql);
    }

    public function insert(): void
    {
        $sql = $this->query
            ->insert($this->table)
            ->values(
                $this->makeExpression()
            )
            ->getQuery();
        $this->db->query($sql, array_values($this->makeExpression()));
        $this->{$this->prKey} = $this->db->getConnection()->lastInsertId();
    }

    public function update(): void
    {
        $sql = $this->query
            ->update($this->table)
            ->set($this->makeExpression())
            ->where(
                $this->query->whereAnd("{$this->prKey} = \"{$this->{$this->prKey}}\"")
            )
            ->getQuery();
        $this->db->query($sql);
    }

    private function isAllowedKey($key)
    {
        $notAllowed = ['prKey', 'db', 'table'];
        $result = false;
        if ((empty($this->allowedColumns) || in_array($key, $this->allowedColumns)) && !in_array($key, $notAllowed)) {
            $result = true;
        }
        return $result;
    }

    private function makeExpression()
    {
        $properties = get_object_vars($this);
        $expressions = [];
        foreach ($properties as $key => $value) {
            if ($this->isAllowedKey($key)) {
                $expressions[$key] = $value;
            } else {
                continue;
            }
        }
        return $expressions;
    }
}
