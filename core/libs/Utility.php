<?php

namespace core\libs;

use core\Hasher\BcryptHasher;
use core\Hasher\Cryptography;

class Utility
{
    /**
     * @param string $password Password to hash 
     * @param array $options Options for the hashing function. If left blank defaults will be used"
     * 
     */
    public static function hash(string $password, array $options = [])
    {
        $hasher = new Cryptography(new BcryptHasher($options));
        return $hasher->hash($password);
    }

    public static function check($password, $hashedPassword)
    {
        $hasher = new Cryptography(new BcryptHasher());
        return $hasher->check($password, $hashedPassword);
    }
}
