<?php

namespace App\Application\Users\Handlers\Commands;

use App\Application\Users\Commands\CreateUserCommand;
use App\Domain\Users\Services\UserService;
use App\Domain\Users\Models\User;

class CreateUserHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(CreateUserCommand $command): User
    {
        return $this->userService->createUser($command->userData);
    }
}
