<?php

namespace core\AuthenticationInterface;

interface AuthenticationInterface
{
    public function setTableInfo($tablename, $usersCol, $passwordCol);
    public function authenticate();
}
