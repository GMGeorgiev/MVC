<?php

namespace core\ViewSmarty;

include_once('ViewInterface.php');

use core\ViewInterface\ViewInterface;
use Exception;
use Smarty;

class ViewSmarty implements ViewInterface
{
    private $templateEngine;
    public function __construct()
    {
        try {
            $this->templateEngine = new Smarty();
        } catch (Exception $e) {
            echo $e->getMessage(), $e;
        }
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

    public function setTemplateDir($path): void
    {
        $this->templateEngine->setTemplateDir($path);
    }
    public function setCompileDir($path): void
    {
        $this->templateEngine->setCompileDir($path);
    }
}
