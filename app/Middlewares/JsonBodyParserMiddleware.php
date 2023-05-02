<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class JsonBodyParserMiddleware
{
    public function __invoke(Request $request, RequestHandlerInterface $handler)
    {
        $response = $handler->handle($request);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
