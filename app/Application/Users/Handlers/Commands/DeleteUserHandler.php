<?php

namespace App\Application\Users\Handlers\Commands;

use App\Application\Users\Commands\DeleteUserCommand;
use App\Domain\Users\Services\UserService;

class DeleteUserHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(DeleteUserCommand $command): bool
    {
        return $this->userService->deleteUser($command->userId);
    }
}
