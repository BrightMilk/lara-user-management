<?php

namespace Database\Seeders;

use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('local')) {
            User::factory()->count(5)->create();
            $this->command->info('5 test users created for local development');
        }
    }
}