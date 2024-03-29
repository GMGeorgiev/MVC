<?php

namespace core\Exceptions;

use Exception;

class ClassDoesntExist extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
