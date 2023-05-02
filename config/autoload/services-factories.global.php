<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            App\Services\User::class   => App\Services\Factories\UserFactory::class,
        ],
    ],
];
