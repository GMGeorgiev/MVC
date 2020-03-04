<?php

namespace app\helpers;

use core\Hasher\BcryptHasher;

class Hash
{
    /**
     * @param string $password Password to hash 
     * @param string $hashFunction Specify php hashing function ('md5,sha1 ...etc'). If left empty default function is "password_hash"
     * @param array $options Options for the hashing function. Default algorythm option is PASSWORD_BCRYPT for "password_hash"
     * 
     */
    public static function hash(string $password, array $options = [])
    {
        $hasher = new BcryptHasher($options);
        return $hasher->hashPassword($password);
    }

    public static function check($password, $hashedPassword)
    {
        $hasher = new BcryptHasher();
        return $hasher->checkPassword($password, $hashedPassword);
    }
}
