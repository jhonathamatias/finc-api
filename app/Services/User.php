<?php

namespace App\Services;

use App\DTO\UserDto;
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
}