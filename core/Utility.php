<?php

namespace core\Utility;

use core\UtilityInterface\UtilityInterface;

class Utility implements UtilityInterface
{
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, 12);
    }
}
