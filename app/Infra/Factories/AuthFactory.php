<?php

namespace App\Infra\Factories;

use App\Infra\Auth;

class AuthFactory
{
    public function __invoke(): Auth
    {
        return new Auth;
    }
}