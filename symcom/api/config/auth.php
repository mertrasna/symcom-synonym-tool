<?php 
    return [
        'defaults' => [
            'guard' => 'api',
            'passwords' => 'users',
        ],

        'guards' => [
            'api' => [
                'driver' => 'passport',
                'provider' => 'users',
            ],
            'admin' => [
                'driver' => 'passport',
                'provider' => 'admins',
            ],
        ],

        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => \App\User::class
            ],
            'admins' => [
                'driver' => 'eloquent',
                'model' => \App\Admin::class
            ]
        ]
    ];
?>