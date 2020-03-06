<?php

namespace core\DB;

interface DatabaseInterface
{
    public function getConnection();
    public function fetchResults($sql, $params = []);
    public function fetchObject($sql, string $model);
}
