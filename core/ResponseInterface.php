<?php

namespace core\ResponseInterface;

interface ResponseInterface
{
    public function setHeaderType($type);
    public function setContent($content);
    public function setHeaderErrorCode(int $code, string $message);
    public function getContent();
    public function setCookie(...$args);
}
