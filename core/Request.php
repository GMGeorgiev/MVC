<?php

namespace core\Request;

use core\RequestInterface\RequestInterface;
use Exception;

include_once('RequestInterface.php');

class Request implements RequestInterface
{
    private $request;
    public function __construct()
    {
        $this->init();
    }
    private function init(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->request = $_GET;
                break;
            case 'POST':
                $this->request = $_POST;
                break;
            default:
                throw new Exception('Invalid request');
                break;
        }
    }
    public function getProperty($key)
    {
        return $this->request[$key];
    }
}
