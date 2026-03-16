<?php
return [

    'default' => env('QUEUE_CONNECTION', 'rabbitmq'),

    'connections' => [

        'rabbitmq' => [
            'driver' => 'rabbitmq',
            'queue' => env('RABBITMQ_QUEUE', 'default'),

            'hosts' => [
                [
                    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
                    'port' => env('RABBITMQ_PORT', 5672),
                    'user' => env('RABBITMQ_USER', 'guest'),
                    'password' => env('RABBITMQ_PASSWORD', 'guest'),
                    'vhost' => env('RABBITMQ_VHOST', '/'),
                ],
            ],
        ],

    ],
];