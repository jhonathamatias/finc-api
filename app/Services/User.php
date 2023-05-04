<?php

namespace App\Services;

use App\DTO\UserDto;
use App\Infra\Auth;
use App\Repositories\UserRepository;

class User
{
    public function __construct(protected UserRepository $repo)
    {}

    public function create(UserDto $data): UserDto
    {
        return $this->repo->create($data);
    }

    public function getUser(int $id)
    {
        return $this->repo->getUser($id);
    }

    public function signIn(string $email, string $password)
    {
        $user = $this->repo->getByEmailAndPass($email, $password);

        $auth = new Auth;

        $user->accessToken = $auth->createToken();

        return $user;
    }
}