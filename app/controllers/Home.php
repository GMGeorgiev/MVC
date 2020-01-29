<?php
namespace app\controllers;

use app\models\User;

class Home {
    function index(){
        $user = new User([]);
        return ['',[]];
    }
}