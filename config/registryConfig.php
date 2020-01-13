<?php

return [
    'registry' => [
        'Config' => 'core\Config\ConfigInterface',
        'Database' => 'core\DB\DatabaseInterface',
        'Request' => 'core\Request\RequestInterface',
        'Response' => 'core\Response\ResponseInterface',
        'Router' => 'core\Router\RouterInterface',
        'View' => 'core\View\ViewInterface',
        'QueryBuilder' => 'core\DB\QueryBuilderInterface',
        'Authentication' => 'core\Authentication\AuthenticationInterface',
        //Add services here
    ]
];

