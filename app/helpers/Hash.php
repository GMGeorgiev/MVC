<?php

namespace app\helpers;

use core\Hasher\BcryptHasher;

class Hash
{
    /**
     * @param string $password Password to hash 
     * @param array $options Options for the hashing function. If left blank defaults will be used"
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
