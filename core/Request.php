<?php

namespace core\Request;

use core\RequestInterface\RequestInterface;
use Exception;

include_once('RequestInterface.php');

class Request implements RequestInterface
{
    private $requestProperties = array();
    private $url = array();
    private $ip;
    private $headers = array();
    private $cookies = array();
    private $type;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
        $this->evalHeader();
        $this->type = $_SERVER['REQUEST_METHOD'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->evalRequest();
        $this->url = parse_url($this->getRequestURL());
    }

    public function getType()
    {
        if (isset($this->type)) {
            return $this->type;
        } else {
            throw new Exception('Type is not set');
        }
    }

    public function isAjax()
    {
        $result = false;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $result = true;
        }
        return $result;
    }

    private function evalRequest(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->requestProperties = $_GET;
                break;
            case 'POST':
                $this->requestProperties = $_POST;
                break;
            case 'DELETE':
                break;
            case 'PUT':
                break;
            default:
                throw new Exception('Invalid request');
                break;
        }
    }

    public function getProperty(string $key)
    {
        if (isset($this->requestProperties[$key])) {
            return $this->requestProperties[$key];
        } else {
            throw new Exception('Key does not exist');
        }
    }
    public function getProperties()
    {
        return $this->requestProperties;
    }

    private function getRequestURL()
    {
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];

        if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
            $currentURL .= ":" . $_SERVER["SERVER_PORT"];
        }

        $currentURL .= $_SERVER["REQUEST_URI"];
        return $currentURL;
    }

    public function getURLDomain()
    {
        return $this->url['host'];
    }

    public function getURLPath()
    {
        return $this->url['path'];
    }

    public function getURLQuery()
    {
        if (isset($this->url['query'])) {
            return $this->url['query'];
        } else {
            throw new Exception('No URL query set!');
        }
    }

    public function getIP()
    {
        return $this->ip;
    }

    private function evalHeader()
    {
        foreach (getallheaders() as $name => $value) {
            $this->headers[$name] = $value;
        }
    }

    public function getHeaderProperty(string $key)
    {
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        } else {
            throw new Exception('Key does not exist');
        }
    }

    public function getCookieProperty(string $key)
    {
        if (isset($this->cookies[$key])) {
            return $this->cookies[$key];
        } else {
            throw new Exception('Key does not exist');
        }
    }
}
