<?php

namespace core\ViewSmarty;

include_once('ViewInterface.php');

use core\ViewInterface\ViewInterface;
use Smarty;

class ViewSmarty implements ViewInterface
{
    private $templateEngine;
    public function __construct($temPlatePath, $compilePath)
    {
        if (class_exists('Smarty')) {
            $this->templateEngine = new Smarty();
        } else {
            exit("Smarty Template Engine classname not found!");
        }
        $this->templateEngine->setTemplateDir($temPlatePath);
        $this->templateEngine->setCompileDir($compilePath);
    }
    public function assign(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->templateEngine->assign($key, $value);
        }
    }

    public function render(string $tplName): void
    {
        $this->templateEngine->display($tplName);
    }
}
