<?php

namespace core\Router;

use core\Registry;
use core\Router\RouterInterface;
use Exception;

class Router implements RouterInterface
{
    const PATH = __DIR__ . '/../../app/controllers/';
    const EXT = '.php';
    public $controller;
    public $action;
    public $params = [];
    public $routes;
    public $url = array();

    public function __construct()
    {
        $this->routes = Registry::get('Config')->getProperties('routes');
    }

    public function parseUrl($url)
    {
        $this->url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));
        $this->setController($this->url);
        $this->setAction($this->url);
        $this->setParams($this->url);
    }

    private function setController($parsedParams): void
    {
        strlen($parsedParams[0]);
        if (in_array($parsedParams[0], $this->routes) && isset($parsedParams[0])) {
            $this->controller = $parsedParams[0];
            unset($this->url[0]);
            require_once(self::PATH . $this->controller . self::EXT);
            $this->controller = new $this->controller;
        } else {
            if (strlen($parsedParams[0]) > 0 && !in_array($parsedParams[0], $this->routes)) {
                throw new Exception("Controller doesn't exist!");
            }
        }
    }

    private function setAction($parsedParams): void
    {
        if (isset($this->controller) && isset($parsedParams[1])) {
            if (method_exists($this->controller, $parsedParams[1])) {
                $this->action = $parsedParams[1];
                unset($this->url[1]);
            } else {
                throw new Exception("Method doesn't exist!");
            }
        }
    }

    private function setParams($parsedParams): void
    {
        if (!empty($parsedParams)) {
            $this->params = $parsedParams;
        }
    }

    public function callAction()
    {
        if (isset($this->controller) && isset($this->action)) {
            return call_user_func_array([$this->controller, $this->action], $this->params);
        }
    }
}
