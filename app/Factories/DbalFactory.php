<?php

namespace App\Factories;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;

class DbalFactory
{
    public function __invoke(ContainerInterface $container): Connection
    {
        $config = $container->get('config');
 
        return DriverManager::getConnection($config['database']);
    }
}