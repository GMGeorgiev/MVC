<?php

namespace core\Router;

interface RouterInterface
{
    public function parseUrl($url);
    public function callAction();
}
