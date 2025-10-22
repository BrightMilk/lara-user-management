<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Models\User;
use App\Domain\Users\DTO\CreateUserData;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(CreateUserData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }

    public function update(int $id, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return User::destroy($id);
    }

    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = User::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate(
            config('api.pagination.default_per_page', 15)
        );
    }

    public function getFiltered(array $filters = [])
    {
        $query = User::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->get();
    }
}