<?php

namespace App\Repositories;

use App\DTO\UserDto;
use App\Repositories\Exceptions\AlreadyExistException;
use App\Repositories\Exceptions\NotFoundException;
use App\Repositories\Exceptions\NotInsertedException;
use App\Repositories\RepositoryDbal;
use Laminas\Hydrator\ObjectPropertyHydrator;

class UserRepository
{
    public function __construct(
        protected RepositoryDbal $repository,
        protected ObjectPropertyHydrator $hydrator
    ) {}

    public function getUser(int $id)
    {
        $userDto = new UserDto();
        
        $user = $this->findOne($id)[0] ?? null;

        if ($user === null) {
            throw new NotFoundException('User found');
        }

        unset($userDto->password);


        return $this->hydrator->hydrate($user, $userDto);
    }

    public function create(UserDto $data): UserDto
    {
        $userExisting = $this->getByEmail($data->email);

        if ((bool)$userExisting === true) {
            throw new AlreadyExistException('Already exist user');
        }

        $created = (bool)$this->repository->insert($this->hydrator->extract($data));

        if ($created === false) {
            throw new NotInsertedException('User cannot created');
        }
        
        $data->id = $this->repository->getLastInsertId();

        unset($data->password);
        
        return $data;
    }

    public function findOne(int $id) 
    {
        return $this->repository->find($id, 'id, name, email, phone');
    }

    public function getByEmail(string $email)
    {
        return $this->repository->findByColumn('email', $email)[0] ?? null;
    }
}
