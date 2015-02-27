<?php

return [
    'defaults' => [
        'supportsCredentials' => false,
        'allowedOrigins' => [],
        'allowedHeaders' => [],
        'allowedMethods' => [],
        'exposedHeaders' => [],
        'maxAge' => 0,
        'hosts' => [],
    ],

    'paths' => [
        'api/*' => [
            'allowedOrigins' => ['*'],
            'allowedHeaders' => ['*'],
            'allowedMethods' => ['*'],
            'maxAge' => 3600,
        ],
        '*' => [
            'allowedOrigins' => ['*'],
            'allowedHeaders' => ['Content-Type'],
            'allowedMethods' => ['POST', 'PUT', 'GET', 'DELETE'],
            'maxAge' => 3600,
            'hosts' => ['api.*'],
        ],
    ],
];
