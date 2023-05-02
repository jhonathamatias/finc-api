<?php

namespace App\Controllers;

use App\Controllers\RequestDataValidator\User as RequestDataValidatorUser;
use App\DTO\UserDto;
use App\Repositories\Exceptions\AlreadyExistException;
use App\Repositories\Exceptions\NotFoundException;
use App\Services\User as UserService;
use Fig\Http\Message\StatusCodeInterface;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

class User
{
    public function __construct(
        protected UserService $service,
        protected ObjectPropertyHydrator $hydrator
    ) {
    }

    public function create(Request $request, Response $response)
    {
        $httpResponse = new HttpResponse($response);

        try {
            $post = $request->getParsedBody() ?? [];

            RequestDataValidatorUser::isValidPost($post);

            $user = new UserDto();

            $this->hydrator->hydrate($post, $user);

            $userCreated = $this->service->create($user);

            return $httpResponse->withJson([
                'user' => $userCreated
            ], StatusCodeInterface::STATUS_CREATED);
        } catch (NestedValidationException $e) {
            return $httpResponse->withJson([
                'validation_params' => $e->getMessages()
            ], StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        } catch (AlreadyExistException $e) {
            return $httpResponse->withJson([
                'already_exists' => $e->getMessage()
            ], StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $httpResponse->withJson([
                'server_error' => $e->getMessage()
            ], StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser(Request $request, Response $response, $attrs)
    {
        $httpResponse = new HttpResponse($response);

        try {
            $user = $this->service->getUser($attrs['id']);

            return $httpResponse->withJson([
                'user' => $user,
            ], 200);
        } catch (NotFoundException $e) {
            return $httpResponse->withJson([
                'not_found' => $e->getMessage()
            ], StatusCodeInterface::STATUS_NOT_FOUND);
        } catch (\Exception $e) {
            return $httpResponse->withJson([
                'server_error' => $e->getMessage()
            ], StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
