<?php

namespace App\Factories;

use Psr\Container\ContainerInterface;
use Laminas\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Laminas\Hydrator\ObjectPropertyHydrator;

class HydratorFactory
{
    public function __invoke(ContainerInterface $container): ObjectPropertyHydrator
    {
        $hydrator = new ObjectPropertyHydrator;
     
        $hydrator->setNamingStrategy(new UnderscoreNamingStrategy);

        return $hydrator; 
    }
}