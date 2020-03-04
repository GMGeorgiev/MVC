<?php

namespace core\Authentication;

use core\Registry;
use core\Authentication\AuthenticationInterface;
use app\models\User;
use core\libs\Utility;

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

    public function authenticate(User $user)
    {
        $request = Registry::get('Request');
        $sql = Registry::get('QueryBuilder')
            ->select($this->table, [$user->getPrKey(), $this->usersCol, $this->passwordCol])
            ->where(
                Registry::get('QueryBuilder')->whereAnd("{$this->usersCol} = '{$user->email}'")
            )->getQuery();
        $queryResult = Registry::get('Database')->query($sql);
        if ($queryResult && Utility::hash($request->getProperty($this->passwordCol), $queryResult[0][$this->passwordCol])) {
            $_SESSION['userid'] = $queryResult[0][$user->getPrKey()];
        } else {
            Registry::get('Response')->setHeaderLocation('home/index');
            exit();
        }
    }

    public function isAuthenticated()
    {
        $result = false;
        $user = new User();
        if (isset($_SESSION['userid'])) {
            if ($user->find($_SESSION['userid'])->getPrKey()) {
                $result = true;
            }
        }
        return $result;
    }
}
