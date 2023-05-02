<?php

namespace App\Repositories\Factories;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use App\Repositories\RepositoryDbal;
use App\Interfaces\RepositoryInterface;

class RepositoryDbalFactory
{
    protected Connection $register;

    public function __invoke(ContainerInterface $container): RepositoryDbalFactory
    {
        $this->register = $container->get(Connection::class);

        return $this;
    }

    public function get(string $repository = ''): RepositoryInterface
    {
        return new RepositoryDbal($this->register, $repository);
    }
}
