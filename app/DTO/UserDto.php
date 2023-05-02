<?php

namespace App\DTO;

class UserDto
{
    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $password
     */
    public function __construct(
        public int|null $id = null,
        public string|null $name = null,
        public string|null $email = null,
        public string|null $phone = null,
        public string|null $password = null,
    ) {}
}