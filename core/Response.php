<?php

namespace core\Response;

use core\ResponseInterface\ResponseInterface;
use Exception;

include_once('ResponseInterface.php');

class Response implements ResponseInterface
{
    public $headers = array();
    private $content;

    public function __construct()
    {
        $this->evalHeader();
    }
    private function evalHeader()
    {
        foreach (getallheaders() as $name => $value) {
            $this->headers[$name] = $value;
        }
    }

    public function setHeaderType($type)
    {
        if (isset($type)) {
            header("Content-Type: {$type}");
            return $this;
        } else {
            throw new Exception("Type not properly set!");
        }
        return $this;
    }

    private function getHeaderType()
    {
        try {
            $result = explode(',', getallheaders()['Accept'])[0];
            $resultAfterSlash = explode('/', $result)[1];
            return $resultAfterSlash;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function setContent($content)
    {
        if (isset($content)) {
            if (strtolower($this->getHeaderType()) == 'json') {
                if (!$this->isJSON($content)) {
                    $this->content = $this->makeJSON($content);
                }
            } else {
                $this->content = $content;
            }
        } else {
            throw new Exception('Content not requirement not met!');
        }
        return $this;
    }

    public function setHeaderErrorCode(int $code, string $message)
    {
        header('HTTP/1.1 ' . $code . ' ' . $message);
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    private function isJSON($content)
    {
        if (isset($content)) {
            json_decode($content);
            return (json_last_error() == JSON_ERROR_NONE);
        } else {
            throw new Exception('Content not requirement not met!');
        }
    }

    private function makeJSON($content)
    {
        if (isset($content)) {
            return json_encode($content);
        } else {
            throw new Exception('Content not requirement not met!');
        }
    }

    public function setCookie(...$args)
    {
        if (!empty($args)) {
            setcookie($args);
        } else {
            throw new Exception('Cookie properties not set');
        }
        return $this;
    }
}
