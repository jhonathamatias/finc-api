<?php

namespace App\Middlewares;

use App\Infra\Auth;
use App\Infra\BearerToken;
use App\Infra\HttpResponse;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandlerInterface $handler)
    {
        $response = new Response();

        $httpResponse = new HttpResponse($response);

        $authorization = $request->getHeader('Authorization')[0] ?? null;

        if ($authorization === null) {
            return $httpResponse->withJson([
                'unauthorized' => 'Cannot access'
            ], StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        $bearerToken = new BearerToken($authorization);

        if ($bearerToken->isValid() === false) {
            return $httpResponse->withJson([
                'unauthorized' => 'Invalid token'
            ], StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        if((new Auth)->verifyToken($bearerToken->getToken()) === false) {
            return $httpResponse->withJson([
                'unauthorized' => 'Invalid, check the token'
            ], StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        return $handler->handle($request);
    }
}