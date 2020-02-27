<?php

/**
 * Example Controller
 */

namespace app\controllers;

use core\Controller\BaseController;
use core\Registry;

class Home extends BaseController
{

    function index()
    {
        return ['welcome.tpl', [
            'framework' => 'caVeman'
        ]];
    }
}
