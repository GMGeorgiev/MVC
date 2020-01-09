<?php

namespace core\ViewSmarty;

include_once('ViewInterface.php');

use core\ViewInterface\ViewInterface;
use Smarty;
use core\Registry\Registry;

class ViewSmarty implements ViewInterface
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
    public function assign(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->templateEngine->assign($key, $value);
        }
    }
    private function init(): void
    {
        $this->templateEngine->setTemplateDir(Registry::get('Config')->getProperty('templateEngine', 'template_path'));
        $this->templateEngine->setCompileDir(Registry::get('Config')->getProperty('templateEngine', 'cache'));
    }
    public function render(string $tplName): void
    {
        $this->templateEngine->display($tplName);
    }
}
