<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Tests\Traits\MocksServices;

class UserManagementTest extends TestCase
{
    use MocksServices;

    public function test_unauthenticated_user_cannot_list_users(): void
    {
        $this->mockUserService();

        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }
}
