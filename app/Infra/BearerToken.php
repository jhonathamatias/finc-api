<?php

namespace App\Infra;

class BearerToken
{
    public function __construct(protected string $bearerToken)
    {
    }

    protected function hasBearer(): bool
    {
        return (bool)preg_match('/^Bearer/', $this->bearerToken);
    }

    protected function hasToken(): bool
    {
        return count(explode(' ', $this->bearerToken)) > 1;
    }

    public function isValid()
    {
        if (
            $this->hasBearer() === false
            || $this->hasToken() === false
        ) {
            return false;
        }

        return true;
    }

    public function getToken(): string
    {
        return explode(' ', $this->bearerToken)[1];
    }
}
