<?php

namespace Core\DB\Database;

interface DatabaseInterface{
    public function getConnection();
    public function close();
    public static function getInstance();
}

