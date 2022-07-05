<?php

return [
    'storage' => 'redis',

    'stores' => [
        'file' => [
            'path' => __DIR__ . '/../cache'
        ],
        'redis' => [
            'host' => '127.0.0.1',
            'password' => null,
            'port' => 6379,
            'database' => 0,
        ],
    ], 
];