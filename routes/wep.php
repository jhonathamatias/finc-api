<?php

use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/** @var Slim\App $app */

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})->add(\App\Middlewares\CorsMiddleware::class);

/**
 * Users
 */
$app->post('/signin', [App\Controllers\User::class, 'signIn'])
    ->add(\App\Middlewares\CorsMiddleware::class)
    ->add(\App\Middlewares\JsonBodyParserMiddleware::class);

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('/create', [App\Controllers\User::class, 'create']);
    $group->get('/{id}', [App\Controllers\User::class, 'getUser']);
})
    ->add(\App\Middlewares\CorsMiddleware::class)
    ->add(\App\Middlewares\AuthMiddleware::class)
    ->add(\App\Middlewares\JsonBodyParserMiddleware::class);

/**
 * Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});
