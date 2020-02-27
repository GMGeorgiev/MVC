<?php

/**
 * Example Controller
 */

namespace app\controllers;

use core\Controller\BaseController;

class Home extends BaseController
{

    function index()
    {
        return ['welcome.tpl', [
            'framework' => 'caVeman',
            'title' => 'caVeman'
        ]];
    }
}
