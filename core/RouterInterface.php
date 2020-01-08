<?php

namespace core\RouterInterface;

interface RouterInterface
{
    public function parseUrl($url);
    public function callAction();
}
