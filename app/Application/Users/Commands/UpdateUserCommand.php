<?php

namespace App\Application\Users\Commands;

class UpdateUserCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly array $data
    ) {}
}
