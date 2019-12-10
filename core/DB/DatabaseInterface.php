<?php

namespace Core\DB\Database;

interface DatabaseInterface{
    public function getDBName();
    public function getDBHost();
    public function getDBUser();
    public function getDBPsswd();
    public function getConnection();
    public function close($con);
}