<?php

namespace App\Application\Users\Commands;

use App\Domain\Users\DTO\CreateUserData;

class CreateUserCommand
{
    public function __construct(
        public readonly CreateUserData $userData
    ) {}
}
