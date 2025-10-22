<?php

namespace App\Application\Users\Commands;

class DeleteUserCommand
{
    public function __construct(
        public readonly int $userId
    ) {}
}
