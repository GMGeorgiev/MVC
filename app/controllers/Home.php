<?php

/**
 * Example Controller
 */

namespace app\controllers;

use app\models\User;
use core\Controller\BaseController;

class Home extends BaseController
{

    function index()
    {
        return ['welcome.tpl', [
            'framework' => 'ca<span id="v">V</span>eman',
            'title' => 'caVeman'
        ]];
    }
}
