<?php

namespace core\Model;

use core\DB\QueryBuilder\QueryBuilder;
use core\Registry\Registry;

class Model
{
    protected $db;
    protected $table;
    protected $id;
    protected $query;

    public function __construct($table)
    {
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
        $this->table = $table;
        $this->setProperties();
    }
    protected function setProperties()
    {
        $columns = $this->getColumns();
        foreach ($columns[0] as $key => $value) {
            $this->$key = $value;
        }
    }
    public function getColumns()
    {
        $sql = $this->query
            ->select($this->table, '*')
            ->getQuery();
        $columns = $this->db->query($sql);
        $this->query->deleteQuery();
        return $columns;
    }
    public function find($key, $column = null)
    {
        $sql = $this->query
            ->select($this->table, '*')
            ->where(
                $this->query->whereAnd("id = \"{$key}\"")
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
        if (count($this->find($this->id))) {
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
                $this->query->whereAnd("id = \"{$this->id}\"")
            )->getQuery();
        $this->db->query($sql);
        $this->query->deleteQuery();
    }
    private function insert(): void
    {
        $sql = $this->query
            ->insert($this->table)
            ->values(
                get_object_vars($this)
            )
            ->getQuery();
        $this->db->query($sql, array_values(get_object_vars($this)));
        $this->query->deleteQuery();
    }
    private function update(): void
    {
        $sql = $this->query
            ->update($this->table)
            ->set($this->makeSetExpression())
            ->where(
                $this->query->whereAnd("id=\"{$this->id}\"")
            )
            ->getQuery();
        $sql = $this->query->getQuery();
        $this->db->query($sql);
        $this->query->deleteQuery();
    }
    private function makeSetExpression()
    {
        $properties = get_object_vars($this);
        $expressions = [];
        foreach ($properties as $key => $value) {
            if (is_object($value) || $key == 'table') {
                continue;
            } else {
                $value = (string) $value;
                array_push($expressions, "{$key} = \"{$value}\"");
            }
        }
        return $expressions;
    }
}
