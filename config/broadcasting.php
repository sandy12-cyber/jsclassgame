<?php

return [

    'driver' => env('BROADCAST_CONNECTION', 'log'),

    'connections' => [

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
