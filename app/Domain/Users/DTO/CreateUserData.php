<?php

namespace App\Domain\Users\DTO;

use Spatie\LaravelData\Data;

class CreateUserData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {}
}
