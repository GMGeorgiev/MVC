<?php

namespace core;

use core\Registry;
use Exception;

class App
{
    private $router;
    private $request;
    private static $instance = null;


    private function __construct()
    {
        $this->router = Registry::get('Router');
        $this->request = Registry::get('Request');
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new App();
        }
        return self::$instance;
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
        try {
            $this->router->parseUrl($this->request->getFullURL());
            $content = $this->router->callAction();
            echo  $this->getResponseContent($content);
        } catch (Exception $e) {
            return $this->getResponseContent(['404error.tpl', ['error' => $e->getMessage()]]);
        }
    }
}
