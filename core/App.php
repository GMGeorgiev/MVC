<?php

namespace core\App;
use core\Registry\Registry;

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
        return Registry::get('Router');
    }
    public function getRequest(){
        return Registry::get('Request');
    }

    public function run(){
        $this->router->parseUrl($this->request->getFullURL());
        $this->router->callAction();
    }
}
