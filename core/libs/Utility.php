<?php

namespace core\libs;

use Exception;

class Utility
{
    public static function hashPassword($password, string $hashFunction = 'password_hash', array $options = [])
    {
        if (count($options) == 0 && $hashFunction == 'password_hash') {
            $options = [PASSWORD_BCRYPT, [12]]; // default options
        }
        if (function_exists($hashFunction)) {
            try {
                return call_user_func_array($hashFunction, array_merge([$password], $options));
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        } else {
            throw new Exception("Hashing function does not exist");
        }
    }
}
