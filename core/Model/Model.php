<?php

namespace core\Model;

use core\DB\QueryBuilder;
use core\Exceptions\ClassDoesntExist;
use core\Exceptions\ColumnNotAllowed;
use core\Registry;
use core\libs\Plural;
use Exception;

class Model
{
    protected $db;
    protected $table;
    protected $prKey = "id";
    protected $query;
    protected $allowedColumns = null;

    public function __construct(array $data)
    {
        $this->table = $this->tableSetter();
        $this->query = new QueryBuilder();
        $this->db = Registry::get('Database');
        $this->{$this->prKey} = 0;
        $this->setPropertyValues($data);
    }

    private function tableSetter()
    {
        $className = explode('\\', get_class($this));
        $table = strtolower(Plural::pluralize(end($className)));
        return $table;
    }

    protected function getTableColumns()
    {
        $conn = $this->db->getConnection();
        $query = $conn->prepare("DESCRIBE {$this->table}");
        $query->execute();
        $columns = $query->fetchAll(\PDO::FETCH_COLUMN);
        return $columns;
    }
    protected function exists()
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
    public function setPropertyValues(array $data)
    {
        $allowedColumns = isset($this->allowedColumns) ? $this->allowedColumns : $this->getTableColumns();
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedColumns) && in_array($key, $this->getTableColumns()) && $key != $this->prKey) {
                $this->{$key} = $value;
            } else if ($key == $this->prKey) {
                continue;
            } else {
                throw new ColumnNotAllowed("`{$key} is not in the AllowedColumns!");
            }
        }
        return $this;
    }

    public static function find($id)
    {
        $className = get_called_class();
        if (class_exists($className)) {
            $model = new $className([]);
            $model->findByValue([$model->getPrKey() => $id]);
            return $model;
        } else {
            throw new ClassDoesntExist("Model: {$className} doesn't exist");
        }
    }

    public function getAll()
    {
        $className = get_called_class();
        if (class_exists($className)) {
            $model = new $className([]);
            $modelCollection = array();
            $sql = $this->query
                ->select($model->table, '*')
                ->getQuery();
            $result = $this->db->query($sql);
            foreach ($result as $key => $value) {
                $model = new $className($value);
                array_push($modelCollection, $model);
            }
            return $modelCollection;
        } else {
            throw new ClassDoesntExist("Model: {$className} doesn't exist");
        }
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
            $this->setPropertyValues(reset($result));
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
