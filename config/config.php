<?php

return [
    'repositories' => [
        'domain' => env('SELECTEL_DOMAIN_REPOSITORY', \SelectelDnsSdk\Repositories\DomainRepository::class),
        'record' => env('SELECTEL_RECORD_REPOSITORY', \SelectelDnsSdk\Repositories\RecordRepository::class),
    ],
    'default' => env('SELECTEL_DNS_CLIENT_NAME', 'default'),
    'services' => [
        'default' => [
            'class' => env('SELECTEL_DNS_CLIENT_CLASS', \SelectelDnsSdk\Client::class),
            'token' => env('SELECTELD_DNS_CLIENT_TOKEN', 'kNqz8uMBy9H5k898EzhCDy35a_66152')
        ]
    ],
];
