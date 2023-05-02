<?php

namespace App\Controllers\RequestDataValidator;

use Respect\Validation\Validator as v;

class User
{
    /**
     * @param array $data
     * @return bool
     * @throws
     */
    public static function isValidPost(array $data): bool
    {
        try {
            v::key('name', v::stringType()->length(3, 20))
                ->key('email', v::stringType()->length(10, 1500))
                ->key('phone', v::stringType())
                ->key('password', v::stringType()
                    ->notBlank()
                    ->length(6, 20))
            ->assert($data);
    
            return true;
        } catch(\Respect\Validation\Exceptions\NestedValidationException $e) {
            throw $e;
        };
    }
}