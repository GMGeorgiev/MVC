<?php

namespace core\Model;

use core\DB\QueryBuilder\QueryBuilder;
use core\Registry\Registry;

class Model
{
    protected $db;
    protected $table;
    private $prKey = "id";
    protected $query;

    public function __construct($data = [])
    {
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
        $this->setProperties($data);
    }
    protected function setProperties($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
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
    private function insert(): void
    {
        $sql = $this->query
            ->insert($this->table)
            ->values(
                $this->makeSetExpression('insert')
            )
            ->getQuery();
        $this->db->query($sql, array_values($this->makeSetExpression('insert')));
        $this->query->deleteQuery();
    }
    private function update(): void
    {
        $sql = $this->query
            ->update($this->table)
            ->set($this->makeSetExpression('update'))
            ->where(
                $this->query->whereAnd("{$this->prKey} = \"{$this->{$this->prKey}}\"")
            )
            ->getQuery();
        $this->db->query($sql);
        $this->query->deleteQuery();
    }
    private function makeSetExpression(string $queryType)
    {
        $properties = get_object_vars($this);
        $expressions = [];
        foreach ($properties as $key => $value) {
            if (is_object($value) || $key == 'table' || $key == 'prKey') {
                continue;
            } elseif ($queryType == 'update') {
                $value = (string) $value;
                array_push($expressions, "{$key} = \"{$value}\"");
            } elseif ($queryType == 'insert') {
                $expressions[$key] = $value;
            }
        }
        return $expressions;
    }
}
