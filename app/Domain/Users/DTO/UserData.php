<?php

namespace App\Domain\Users\DTO;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null
    ) {}

    public static function fromModel(\App\Domain\Users\Models\User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            created_at: $user->created_at?->toISOString(),
            updated_at: $user->updated_at?->toISOString()
        );
    }
}