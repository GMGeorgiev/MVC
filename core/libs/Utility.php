<?php

namespace core\libs;

use Exception;

class Utility
{
    /**
     * @param string $password Password to hash 
     * @param string $hashFunction Specify php hashing function ('md5,sha1 ...etc'). If left empty default function is "password_hash"
     * @param array $options Options for the hashing function. Default options are PASSWORD_BCRYPT , 12 for "password_hash"
     * 
     */
    public static function hashPassword(string $password, string $hashFunction = 'password_hash', array $options = [])
    {
        if (count($options) === 0 && $hashFunction == 'password_hash') {
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
