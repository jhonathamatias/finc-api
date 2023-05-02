<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            App\Repositories\Factories\RepositoryDbalFactory::class   => App\Repositories\Factories\RepositoryDbalFactory::class,
            App\Repositories\UserRepository::class   => App\Repositories\Factories\UserRepositoryFactory::class,
        ],
    ],
];
