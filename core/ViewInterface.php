<?php

namespace core\ViewInterface;

interface ViewInterface
{
    public function render(string $tplName, array $values): void;
}
