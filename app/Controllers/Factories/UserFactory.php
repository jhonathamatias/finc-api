<?php

namespace App\Controllers\Factories;

use App\Controllers\User;
use App\Factories\HydratorFactory;
use App\Repositories\UserRepository;
use App\Services\User as UserService;
use Psr\Container\ContainerInterface;

class UserFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new User(
            $container->get(UserService::class),
            $container->get(HydratorFactory::class)
        );
    }
}