<?php

namespace App\Application\Users\Queries;

class GetUserQuery
{
    public function __construct(
        public readonly int $userId
    ) {}
}
