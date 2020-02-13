<?php

namespace core\View;

interface ViewInterface
{
    public function render($templateName, $templateValues);
    public function assign(array $values);
}
