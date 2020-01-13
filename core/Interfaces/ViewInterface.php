<?php

namespace core\ViewInterface;

interface ViewInterface
{
    public function render($templateName, $templateValues);
}
