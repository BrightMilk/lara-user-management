<?php

namespace App\Application\Users\Queries;

class ListUsersQuery
{
    public function __construct(
        public readonly array $filters = []
    ) {}
}
