<?php

namespace core\DB;

interface DatabaseInterface
{
    public function getConnection();
    public static function getInstance();
    public function query($sql, $params = []);
}
