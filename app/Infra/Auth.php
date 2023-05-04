<?php

namespace App\Infra;

use DateTimeImmutable;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;

class Auth
{
    public function __construct()
    {}

    public function createToken(): string
    {
        $facade = new JwtFacade();
        $key = InMemory::plainText($_ENV['JWT_SECRET_KEY']);
        $token = $facade->issue(
            new Sha256,
            $key,
            static fn (Builder $builder, DateTimeImmutable $issuedAt): Builder =>
            $builder
                ->permittedFor($_ENV['JWT_ALLOWED_HOST'])
                ->expiresAt($issuedAt->modify($_ENV['JWT_EXPIRE_TIME']))
        );

        return $token->toString();
    }

    public function verifyToken(string $token)
    {
        try {
            $parser = new Parser(new JoseEncoder);
            $validator = new Validator;
            $parserToken = $parser->parse($token);
    
            $validator->assert($parserToken, new PermittedFor($_ENV['JWT_ALLOWED_HOST']));
            $validator->assert($parserToken, new SignedWith(
                new Sha256,
                InMemory::plainText($_ENV['JWT_SECRET_KEY'])
            ));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
