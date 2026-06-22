<?php

return [

    'default' => env('SESSION_DRIVER', 'database'),

    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
    'encrypt' => env('SESSION_ENCRYPT', false),
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE', 'jsclassgame_session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => env('SESSION_HTTP_ONLY', true),
    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    'store' => env('SESSION_STORE', 'database'),

    'connection' => env('SESSION_CONNECTION'),

    'drivers' => [
        'database' => [
            'table' => 'sessions',
        ],
    ],

];
