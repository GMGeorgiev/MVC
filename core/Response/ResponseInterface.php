<?php

namespace core\Response;

interface ResponseInterface
{
    public function setHeaderType($type);
    public function setContent($content,$values);
    public function setHeaderErrorCode(int $code, string $message);
    public function getContent();
    public function setCookie(...$args);
}
