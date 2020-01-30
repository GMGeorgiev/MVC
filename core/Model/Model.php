<?php

namespace core\Model;

use core\DB\QueryBuilder;
use core\Registry;

class Model
{
    public $db;
    public $table;
    private $prKey = "id";
    private $allowedColumns = array();
    public $query;

    public function __construct()
    {
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
    }
    public function setProperties($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
            array_push($this->allowedColumns,$key);
        }
    }

    public function find($key, $column = null)
    {
        $sql = $this->query
            ->select($this->table, "*")
            ->where(
                $this->query->whereAnd("{$this->prKey} = \"{$key}\"")
            );
        if ($column) {
            $this->query->whereAnd("{$$column} = '{$column}'");
        }
        $sql = $this->query->getQuery();
        $result = $this->db->query($sql);
        $this->setProperties($result);
        $this->query->deleteQuery();
        return $result;
    }

    public function save()
    {
        if (count($this->find($this->{$this->prKey}))) {
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
        $this->query->deleteQuery();
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
        $this->query->deleteQuery();
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
        $this->query->deleteQuery();
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
