<?php

namespace core\View;

interface ViewInterface
{
    public function render($templateName, $templateValues);
}
