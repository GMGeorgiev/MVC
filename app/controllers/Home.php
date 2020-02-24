<?php

namespace app\controllers;

use app\models\User;
use core\Controller\BaseController;
use core\Registry;

class Home extends BaseController
{

    function index()
    {
        Registry::get('Response')->setHeaderType('application/json');

        return ['',["a"=>1,"b"=>2]];
        // return ['', []];
    }
}
