<?php

namespace core;

use core\Registry;

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

    private function isUnpackable($content)
    {
        $unpackable = false;
        if (is_array($content)) {
            if (is_string($content[0]) and is_array($content[1])) {
                $unpackable = true;
            }
        }
        return $unpackable;
    }

    private function getResponseContent($content)
    {
        $response = Registry::get('Response');
        if ($this->isUnpackable($content)) {
            $response->setContent(...$content);
        } else {
            $response->setContent($content);
        }
        return $response->getContent();
    }

    public function run()
    {
        $this->router->parseUrl($this->request->getFullURL());
        $content = $this->router->callAction();
        return $this->getResponseContent($content);
    }
}
