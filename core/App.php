<?php

namespace Core\App;
use Core\Registry\Registry;

class App
{   private $router;
    private $request;
    private static $instance = null;


    private function __construct()
    {
        $this->router = $this->getRouter();
        $this->request = $this->getRequest();
    }

    public static function getInstance(){
        if (!self::$instance) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function getRouter(){
        return Registry::get('router');
    }
    public function getRequest(){
        return Registry::get('request');
    }

    public function run(){
        $this->router->setRequest($this->reguest);
        $this->router->callAction();
    }
}
