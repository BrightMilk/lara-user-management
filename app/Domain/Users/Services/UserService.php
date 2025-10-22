<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Domain\Users\DTO\CreateUserData;
use App\Domain\Users\DTO\UserData;
use App\Domain\Users\Models\User;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function createUser(CreateUserData $data): User
    {
        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function getUserById(int $id): ?UserData
    {
        $user = $this->userRepository->findById($id);
        return $user ? UserData::fromModel($user) : null;
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function getUsers(array $filters = [])
    {
        $users = $this->userRepository->getFiltered($filters);
        return $users->map(fn($user) => UserData::fromModel($user));
    }
}
