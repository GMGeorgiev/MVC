<?php

namespace core\Router;

use core\Registry\Registry;
use core\RouterInterface\RouterInterface;
use Exception;

include_once('RouterInterface.php');

class Router implements RouterInterface
{
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
        if (in_array($parsedParams[0], $this->routes)) {
            $this->controller = $parsedParams[0];
            unset($this->url[0]);
            require_once "../app/controllers/{$this->controller}.php";
            $this->controller = new $this->controller;
        } else {
            throw new Exception("Controller doesn't exist!");
        }
    }

    private function setAction($parsedParams): void
    {
        if (isset($this->controller)) {
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
        call_user_func_array([$this->controller, $this->action], $this->params);
    }
}
