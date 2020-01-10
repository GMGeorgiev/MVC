<?php

namespace core\App;

use core\Registry\Registry;
use core\ViewSmarty\ViewSmarty;

class App
{
    private $router;
    private $request;
    private static $instance = null;


    private function __construct()
    {
        $this->router = $this->getRouter();
        $this->request = $this->getRequest();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function getRouter()
    {
        return Registry::get('Router');
    }
    public function getRequest()
    {
        return Registry::get('Request');
    }


    public function run()
    {
        $this->router->parseUrl($this->request->getFullURL());
        $content = $this->router->callAction();
        Registry::get('Response')
            ->setContent(...$content)
            ->getContent();
    }
}
