<?php

namespace core\Hasher;

use core\Hasher\HasherInterface;
use Exception;

class BcryptHasher implements HasherInterface
{
    private $cost = 10;
    private $memory = 1024;
    private $time = 2;
    private $threads = 2;

    /**
     * @param array $options Specify options as an associative array example: 'cost'=>10, 'memory'=> 1024, 'time'=>2, 'threads'=>2
     */
    public function __construct(array $options = [])
    {
        $this->cost = $options['cost'] ?? $this->cost;
        $this->memory = $options['memory'] ?? $this->memory;
        $this->time = $options['time'] ?? $this->time;
        $this->threads = $options['threads'] ?? $this->threads;
    }

    public function hashPassword($password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, [
            'cost' => $this->cost,
            'memory' => $this->memory,
            'time' => $this->time,
            'threads' => $this->threads
        ]);
        if ($hash == false) {
            throw new Exception("Bcrypt hashing failed!");
        }
        return $hash;
    }

    public function checkPassword(string $password, string $hashedPassword)
    {
        if (password_get_info($hashedPassword)['algoName'] != 'bcrypt') {
            throw new Exception("This password doesn't use the Bcrypt algorithm!");
        }
        return password_verify($password, $hashedPassword);
    }
}
