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
    private $cookie = array();

    public function __construct()
    {
        $this->cookie = $_COOKIE;
        $this->evalHeader();
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->evalRequest();
        $this->url = parse_url($this->getCurrentURL());
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
            default:
                throw new Exception('Invalid request');
                break;
        }
    }

    public function getProperty(string $key)
    {
        return $this->requestProperties[$key];
    }
    public function getProperties()
    {
        return $this->requestProperties;
    }

    private function getCurrentURL()
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
        return $this->headers[$key];
    }

    public function getCookieProperty(string $key)
    {
        return $this->cookie[$key];
    }
}
