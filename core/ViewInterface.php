<?php

namespace core\ViewInterface;

interface ViewInterface
{
    public function assign(array $values): void;
    public function render(string $tplName): void;
    public function setTemplateDir($path): void;
    public function setCompileDir($path): void;
}
