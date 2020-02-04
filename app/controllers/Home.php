<?php

namespace app\controllers;

use app\models\User;
use core\Controller\BaseController;

class Home extends BaseController
{

    function index()
    {
        $user = new User([]);
        return ['', []];
    }
}
