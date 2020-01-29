<?php

namespace core\Controller;

use core\Registry;

class BaseController
{
    protected $parameters;

    public function __construct()
    {
        $this->parameters = (Registry::get('Request'))->getProperties();
    }
}