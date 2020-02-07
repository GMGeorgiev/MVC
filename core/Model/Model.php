<?php

namespace core\Model;

use core\DB\QueryBuilder;
use core\Registry;

class Model
{
    protected $db;
    protected $table;
    protected $prKey = "id";
    protected $query;

    public function __construct()
    {
        $this->table = $this->tableSetter();
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
        $this->{$this->prKey} = 0;
    }

    private function tableSetter()
    {
        $className = explode('\\', get_class($this));
        $table = strtolower(end($className)) . 's';
        return $table;
    }

    private function getTableColumns()
    {
        $conn = $this->db->getConnection();
        $query = $conn->prepare("DESCRIBE {$this->table}");
        $query->execute();
        $columns = $query->fetchAll(\PDO::FETCH_COLUMN);
        return $columns;
    }
    private function exists()
    {
        $exists = false;
        $sql = $this->query
            ->select($this->table, "*")
            ->where(
                $this->query->whereAnd(
                    "{$this->prKey} = \"{$this->{$this->prKey}}\""
                )
            )
            ->getQuery();
        $result = $this->db->query($sql);
        if (!empty($result)) {
            $exists = true;
        }
        return $exists;
    }
    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->getTableColumns()) && $key != $this->prKey) {
                $this->{$key} = $value;
            }
        }
    }

    public function find($id)
    {
        $result = false;
        if ($this->{$this->prKey}) {
            $result = $this->findByValue([$this->prKey => $id]);
        }
        return $result;
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
        if (count($result) > 0) {
            $this->setProperties(reset($result));
            $this->setId(reset($result));
        }
        return $this;
    }

    private function setId($result)
    {
        if (isset($result[$this->prKey])) {
            $this->{$this->prKey} = $result[$this->prKey];
        }
    }
    public function getPrKey()
    {
        return $this->prKey;
    }
    public function save()
    {
        if ($this->exists()) {
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
        $this->db->query($sql, array_values($this->makeExpression()));
    }


    private function makeExpression()
    {
        $properties = get_object_vars($this);
        $expressions = [];
        foreach ($properties as $key => $value) {
            if (in_array($key, $this->getTableColumns())) {
                $expressions[$key] = $value;
            } else {
                continue;
            }
        }
        return $expressions;
    }
}
