<?php

namespace App\Application\Users\Queries;

class GetUserByEmailQuery
{
    public function __construct(
        public readonly string $email
    ) {}
}
