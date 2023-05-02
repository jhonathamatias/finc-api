<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function insert(array $columns): int|bool;
}