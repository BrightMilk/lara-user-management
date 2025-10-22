<?php

namespace App\Application\Users\Handlers\Queries;

use App\Application\Users\Queries\ListUsersQuery;
use App\Domain\Users\Services\UserService;
use Illuminate\Support\Collection;

class ListUsersHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(ListUsersQuery $query): Collection
    {
        return $this->userService->getUsers($query->filters);
    }
}
