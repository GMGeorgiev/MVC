<?php

namespace core\ViewInterface;

interface ViewInterface
{
    public function assign(array $values): void;
    public function render(string $tplName): void;
}
