<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Models\User;
use App\Domain\Users\DTO\CreateUserData;
use App\Domain\Users\DTO\UserData;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(CreateUserData $data): User;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getPaginated(array $filters = []): LengthAwarePaginator;
    public function getFiltered(array $filters = []);
}