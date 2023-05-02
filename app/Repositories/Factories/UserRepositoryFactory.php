<?php

namespace App\Repositories\Factories;

use Psr\Container\ContainerInterface;
use App\Factories\HydratorFactory;
use App\Repositories\UserRepository;

class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): UserRepository
    {
        /** @var RepositoryDbalFactory */
        $repositoryFactory = $container->get(RepositoryDbalFactory::class);

        return new UserRepository(
            $repositoryFactory->get('users'),
            $container->get(HydratorFactory::class)
        );
    }
}
