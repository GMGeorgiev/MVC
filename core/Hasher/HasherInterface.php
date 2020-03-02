<?php

namespace core\Hasher;

interface HasherInterface
{
    public function hashPassword(string $password);
    public function checkPassword(string $password, string $hashedPassword);
}
