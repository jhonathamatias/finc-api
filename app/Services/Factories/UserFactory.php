<?php

namespace App\Services\Factories;

use Psr\Container\ContainerInterface;
use App\Services\User;

class UserFactory
{
    public function __invoke(ContainerInterface $container) : User
    {
        return new User(
            $container->get(\App\Repositories\UserRepository::class),
        );
    }
}