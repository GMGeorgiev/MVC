<?php

namespace core\RequestInterface;

interface RequestInterface
{
    public function getType();
    public function isAjax();
    public function getProperty(string $key);
    public function getProperties();
    public function getURLDomain();
    public function getURLPath();
    public function getURLQuery();
    public function getIP();
    public function getHeaderProperty(string $key);
    public function getCookieProperty(string $key);
}
