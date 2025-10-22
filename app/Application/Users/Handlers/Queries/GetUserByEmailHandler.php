<?php

namespace App\Application\Users\Handlers\Queries;

use App\Application\Users\Queries\GetUserByEmailQuery;
use App\Domain\Users\Models\User;
use App\Domain\Users\Services\UserService;

class GetUserByEmailHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(GetUserByEmailQuery $query): ?User
    {
        return $this->userService->getUserByEmail($query->email);
    }
}
