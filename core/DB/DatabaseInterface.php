<?php

namespace Core\DB\Database;

interface DatabaseInterface{
    public function getConnection();
    public static function getInstance();
    public function query($sql,$params=[]);
}

