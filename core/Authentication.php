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

    public function setTableName($tablename)
    {
        $this->table = $tablename;
        return $this;
    }

    public function setUserCol($userCol)
    {
        $this->usersCol = $userCol;
        return $this;
    }

    public function setPasswordCol($passwordCol)
    {
        $this->passwordCol = $passwordCol;
        return $this;
    }

    public function authenticate()
    {
        $auth = false;
        $request = Registry::get('Request');
        $passwordHash = Registry::get('Utility');
        $sql = Registry::get('QueryBuilder')
            ->select($this->table, ['username', 'password'])
            ->where(
                Registry::get('QueryBuilder')->whereAnd("{$this->usersCol} = {$request->getProperty('username')}"),
                Registry::get('QueryBuilder')->whereAnd("{$this->passwordCol}
                            = {$passwordHash->hashPassword($request->getProperty('password'))}")
            )->getQuery();
        $queryResult = Registry::get('Database')->query($sql);
        if (!isset($queryResult)) {
            Registry::get('Response')->setHeaderErrorCode(503, 'Username and/or password not found !');
            exit();
        } else {
            $auth = true;
        }
        return $auth;
    }
}
