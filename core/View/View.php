<?php

namespace core\View;

use core\View\ViewInterface;
use Smarty;
use core\Registry;

class View implements ViewInterface
{
    private $templateEngine;

    public function __construct()
    {
        if (class_exists('Smarty')) {
            $this->templateEngine = new Smarty();
        } else {
            exit("Smarty Template Engine classname not found!");
        }
        $this->init();
    }

    private function init(): void
    {
        $this->templateEngine->setTemplateDir(Registry::get('Config')->getProperty('templateEngine', 'template_path'));
        $this->templateEngine->setCompileDir(Registry::get('Config')->getProperty('templateEngine', 'cache'));
    }

    public function render($templateName, $templateValues = [])
    {
        if (is_array($templateValues)) {
            foreach ($templateValues as $key => $value) {
                $this->templateEngine->assign($key, $value);
            }
        }
        $this->templateEngine->display($templateName);
    }
    public function assign(array $values)
    {
        foreach ($values as $key => $value) {
            $this->templateEngine->assign($key, $value);
        }
    }
}
