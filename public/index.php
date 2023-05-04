<?php

use App\Handlers\HttpErrorHandler;
use App\Handlers\ShutdownHandler;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';
require 'config/config-env.php';

// Set that to your needs
$displayErrorDetails = true;

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

AppFactory::setContainer($container);

$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$app->addBodyParsingMiddleware();

// Add Routing Middleware
$app->addRoutingMiddleware();

require 'routes/wep.php';

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();