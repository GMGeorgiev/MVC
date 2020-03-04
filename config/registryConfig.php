<?php

return [
    'registry' => [
        'core\\Config\\Config' => 'core\Config\ConfigInterface',
        'core\\View\\View' => 'core\View\ViewInterface',
        'core\\DB\\Database' => 'core\DB\DatabaseInterface',
        'core\\Request\\Request' => 'core\Request\RequestInterface',
        'core\\Response\\Response' => 'core\Response\ResponseInterface',
        'core\\Router\\Router' => 'core\Router\RouterInterface',
        'core\\DB\\QueryBuilder' => 'core\DB\QueryBuilderInterface',
        'core\\Authentication\\Authentication' => 'core\Authentication\AuthenticationInterface',
        //Add services => interface here or comment to dissable
    ]
];
