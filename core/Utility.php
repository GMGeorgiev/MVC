<?php

namespace core\Utility;

class Utility
{
    public static function hashPassword($password)
    {   $encrypt_alg = 'PASSWORD_BCRYPT';
        $encrypt_str = 12;
        return password_hash($password, $encrypt_alg, $encrypt_str);
    }
}
