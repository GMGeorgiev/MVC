<?php

namespace core\DB\QueryBuilderInterface;

interface QueryBuilderInterface{
    public function select(string $tableName, $params);
    public function join($tableName, $onArray = [], string $typeofJoin = "JOIN");
    public function insert($tableName);
    public function values($values = []);
    public function update($tableName);
    public function set($expressions = []);
    public function delete($tableName);
    public function where(...$args);
    public function whereAnd(string $param): string;
    public function whereOr(string $param): string;
    public function getQuery();
    public function deleteQuery(): void;
}