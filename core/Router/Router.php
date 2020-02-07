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
        $url = base64_encode($url);
        $url = base64_decode($url);
        $this->url = explode('/', filter_var(rtrim($url, '/')));
        $this->setController($this->url);
    }

    private function setController($parsedParams): void
    {
        $controllerName = (isset($parsedParams[0])) ? $parsedParams[0] : '';
        array_shift($parsedParams);
        $actionName = (isset($parsedParams[0])) ? $parsedParams[0] : 'index';
        array_shift($parsedParams);
        if ($controllerName && array_key_exists($controllerName, $this->routes)) {
            $this->controller = new $this->routes[$controllerName];
            $this->setAction($actionName);
            $this->setParameters($parsedParams);
        } else {
            throw new Exception('Controller does not exist');
        }
    }

    private function setAction($actionName = 'index'): void
    {
        if (isset($this->controller)) {
            if (method_exists($this->controller, $actionName)) {
                $this->action = $actionName;
            } else {
                throw new Exception("Action does not exist!");
            }
        }
    }
    private function setParameters($parsedParams): void
    {
        if (!empty($parsedParams)) {
            foreach ($parsedParams as $value) {
                array_unshift($this->params, $value);
            }
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
