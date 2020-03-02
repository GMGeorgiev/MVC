<?php

/**
 * Example Controller
 */

namespace app\controllers;

use core\Controller\BaseController;
use core\libs\Utility;

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
