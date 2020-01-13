<?php

namespace core\Config;

interface ConfigInterface
{
    public function getProperty($config,$key);
}
