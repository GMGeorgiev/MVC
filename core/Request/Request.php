<?php

namespace core\Request;

use core\Request\RequestInterface;
use core\Registry;
use Exception;

class Request implements RequestInterface
{
    private $requestProperties = array();
    private $url = array();
    private $ip;
    private $headers = array();
    private $cookies = array();
    private $type;
    private $files;

    public function __construct()
    {
        $this->init();
    }
    public function init()
    {
        if ($_FILES) {
            $this->files = $this->evalUploadedFiles();
        }
        if (!empty($_COOKIE)) {
            $this->cookies = $_COOKIE;
        }
        $this->evalHeader();
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->type = $_SERVER['REQUEST_METHOD'];
            $this->evalRequest();
        }
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($this->getRequestURL()) {
            $this->url = parse_url($this->getRequestURL());
        }
    }

    private function evalUploadedFiles()
    {
        $files = $_FILES;
        $formattedFiles = [];
        foreach ($files as $fileInfo) {
            $filesByInput = [];
            foreach ($fileInfo as $key => $indevidualInfo) {
                if (is_array($indevidualInfo)) {
                    foreach ($indevidualInfo as $key2 => $value) {
                        $filesByInput[$key2][$key] = $value;
                    }
                } else {
                    $filesByInput[] = $fileInfo;
                    break;
                }
            }
            $formattedFiles = array_merge($formattedFiles, $filesByInput);
        }
        $filesRemovedEmpty = [];
        foreach ($formattedFiles as $file) {
            if (!$file['error']) $filesRemovedEmpty[] = $file;
        }
        return $filesRemovedEmpty;
    }

    public function getFiles()
    {
        if (isset($this->files)) {
            return $this->files;
        } else {
            throw new Exception('No files detected');
        }
    }

    public function getFilesCount()
    {
        if (isset($this->files)) {
            return count($this->files);
        } else {
            throw new Exception('No files detected');
        }
    }

    public function getRequestFromat()
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
        $currentURL = isset($_SERVER["HTTPS"]) ? "https://" : "http://";
        $currentURL .= isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : '';
        $serverPort = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : '';

        if ($serverPort != "80" && $serverPort != "443") {
            $currentURL .= ":" . $serverPort;
        }

        $currentURL .= isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
        return $currentURL;
    }
    public function getURLScheme()
    {
        return $this->url['scheme'] . '://';
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

    public function getFullURL()
    {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
            return $url;
        } else {
            throw new Exception("URL not properly set");
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
