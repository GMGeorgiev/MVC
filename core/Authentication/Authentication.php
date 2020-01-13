<?php

namespace core\Authentication;


use core\Registry;
use core\Authentication\AuthenticationInterface;

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

    private function generateToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }

    public function authenticate()
    {
        $request = Registry::get('Request');
        $utility = Registry::get('Utility');
        $sql = Registry::get('QueryBuilder')
            ->select($this->table, ['id', 'username', 'password'])
            ->where(
                Registry::get('QueryBuilder')->whereAnd("{$this->usersCol} = {$request->getProperty('username')}"),
                Registry::get('QueryBuilder')->whereAnd("{$this->passwordCol}
                            = {$utility::hashPassword($request->getProperty('password'))}")
            );
        $query = $sql->getQuery();
        $queryResult = Registry::get('Database')->query($query);
        if (!isset($queryResult)) {
            Registry::get('Response')->setHeaderErrorCode(503, 'Username and/or password not found !');
            exit();
        } else {
            session_id($queryResult[0]['id']);
            $_SESSION['token'] = $this->generateToken(200);
            Registry::get('Response')->setCookie('authToken', $this->generateToken(200), time() + 3600, "/", Registry::get('Request')->getURLDomain(), 1);
        }
    }
}
