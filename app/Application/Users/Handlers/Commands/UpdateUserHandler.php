<?php

namespace App\Application\Users\Handlers\Commands;

use App\Application\Users\Commands\UpdateUserCommand;
use App\Domain\Users\Services\UserService;

class UpdateUserHandler
{
    public function __construct(
        private UserService $userService
    ) {}

    public function handle(UpdateUserCommand $command): bool
    {
        return $this->userService->updateUser($command->userId, $command->data);
    }
}
