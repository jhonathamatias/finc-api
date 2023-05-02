<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            App\Controllers\User::class   => App\Controllers\Factories\UserFactory::class,
        ],
    ],
];
