<?php

namespace App\Repositories;

use Doctrine\DBAL\Connection;
use App\Interfaces\RepositoryInterface;

class RepositoryDbal implements RepositoryInterface
{
    public function __construct(
       protected Connection $dbal,
       protected string $repository
    )
    {}

    public function setRepository(string $repository): void
    {
        $this->repository = $repository;
    }

    public function find(int $id, $columns = '*'): array
    {
        $statement = $this->dbal->executeQuery("SELECT $columns FROM $this->repository WHERE id=?", [$id]);

        return $statement->fetchAllAssociative();
    }

    public function insert(array $columns): int|bool
    {
        $this->dbal->insert($this->repository, $columns);

        return (int)$this->getLastInsertId();
    }
    
    public function findByColumn(string $column, mixed $value): array
    {
        $statement = $this->dbal->executeQuery("SELECT * FROM $this->repository WHERE $column = ?", [$value]);

        return $statement->fetchAllAssociative();
    }

    public function getLastInsertId()
    {
        return $this->dbal->lastInsertId();
    }

    public function getAll(string $columns = '*', string $where = '', array $values=[])
    {
        $statement = $this->dbal->executeQuery("SELECT $columns FROM $this->repository $where", $values);
        
        return $statement->fetchAllAssociative();
    }

    public function executeQuery(string $query, array $columns)
    {
        return $this->dbal->executeQuery($query, $columns);
    }

    public function query()
    {
        return $this->dbal->createQueryBuilder();
    }
}