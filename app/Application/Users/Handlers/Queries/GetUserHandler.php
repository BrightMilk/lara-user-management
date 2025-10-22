<?php

namespace App\Application\Users\Handlers\Queries;

use App\Application\Users\Queries\GetUserQuery;
use App\Domain\Users\Services\UserService;
use App\Domain\Users\DTO\UserData;

class GetUserHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(GetUserQuery $query): ?UserData
    {
        return $this->userService->getUserById($query->userId);
    }
}
