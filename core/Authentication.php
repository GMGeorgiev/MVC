<?php

namespace core\Authentication;


use core\Registry\Registry;
use core\AuthenticationInterface\AuthenticationInterface;

include_once('AuthenticationInteface.php');
class Authentication implements AuthenticationInterface
{
    private $table;
    private $usersCol;
    private $passwordCol;

    public function setTableInfo($tablename, $usersCol, $passwordCol)
    {
        $this->table = $tablename;
        $this->usersCol = $usersCol;
        $this->passwordCol = $passwordCol;
        return $this;
    }

    private function buildQuery()
    {
        $request = Registry::get('Request');
        $sql = Registry::get('QueryBuilder')
            ->select($this->table, ['username', 'password'])
            ->where(
                Registry::get('QueryBuilder')->whereAnd("{$this->usersCol} = {$request->getProperty('username')}"),
                Registry::get('QueryBuilder')->whereAnd("{$this->passwordCol} = {$request->getProperty('password')}")
            )->getQuery();
        return $sql;
    }


    public function authenticate()
    {
        $auth = false;
        $sql = $this->buildQuery();

        if (isset($this->username) && isset($this->password)) {
            $queryResult = Registry::get('Database')->query($sql);
            if (!isset($queryResult)) {
                Registry::get('Response')->setHeaderErrorCode(503, 'Username and/or password not found !');
                exit();
            } else {
                $auth = true;
            }
        }
        return $auth;
    }
}
