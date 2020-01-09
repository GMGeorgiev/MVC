<?php

namespace core\Controller;

use core\Registry\Registry;

class Controller
{
    private $view;

    public function __construct()
    {
        $this->view = Registry::get('View');
    }
}
