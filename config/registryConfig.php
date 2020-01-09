<?php

return [
    'registry' => [
        'Config' => 'core\ConfigInterface\ConfigInterface',
        'Database' => 'core\DB\DatabaseInterface\DatabaseInterface',
        'Request' => 'core\RequestInterface\RequestInterface',
        'Response' => 'core\ResponseInterface\ResponseInterface',
        'Router' => 'core\RouterInterface\RouterInterface',
        'View' => 'core\ViewInterface\ViewInterface',
        //Add services here
    ]
];
