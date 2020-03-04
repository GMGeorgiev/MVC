<?php

namespace core\Hasher;

use core\Hasher\HasherInterface;

class Cryptography
{
    private $hasher;

    public function __construct(HasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function setHasher(HasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hash($password)
    {
        return $this->hasher->hashPassword($password);
    }

    public function check($password, $hashedPassword)
    {
        return $this->hasher->checkPassword($password, $hashedPassword);
    }
}
