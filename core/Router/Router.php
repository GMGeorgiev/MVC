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
        $this->setParams($this->url);
    }

    private function setController($parsedParams): void
    {
        $controllerName = (isset($parsedParams[0])) ? $parsedParams[0]:'';
        $actionName = (isset($parsedParams[1])) ? $parsedParams[1]:'index';
        if($controllerName && array_key_exists($controllerName,$this->routes)) {
            $this->controller = new $this->routes[$controllerName];
            $this->setAction($actionName);
        } else {
            throw new Exception('Controller does not exist');
        }
    }

    private function setAction($actionName='index'): void
    {
        if (isset($this->controller)) {
            if (method_exists($this->controller, $actionName)) {
                $this->action = $actionName;
            } else {
                throw new Exception("Action does not exist!");
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
        } else {
            throw new Exception('Controller and/or action not set!');
        }
    }
}
