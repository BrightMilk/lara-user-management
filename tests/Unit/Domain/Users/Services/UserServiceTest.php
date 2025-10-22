<?php

namespace Tests\Unit\Domain\Users\Services;

use App\Domain\Users\DTO\CreateUserData;
use App\Domain\Users\DTO\UserData;
use App\Domain\Users\Models\User;
use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Domain\Users\Services\UserService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private MockInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function test_can_create_user(): void
    {
        $userData = Mockery::mock(CreateUserData::class);
        $userData->shouldReceive('toArray')->andReturn([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123',
        ]);

        $userModel = Mockery::mock(User::class);
        $userModel->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $userModel->shouldReceive('getAttribute')->with('name')->andReturn('Test User');
        $userModel->shouldReceive('getAttribute')->with('email')->andReturn('test@example.com');
        $userModel->shouldReceive('getAttribute')->with('created_at')->andReturn(now());
        $userModel->shouldReceive('getAttribute')->with('updated_at')->andReturn(now());

        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn($userModel);

        $result = $this->userService->createUser($userData);

        $this->assertEquals('Test User', $result->name);
        $this->assertEquals('test@example.com', $result->email);
    }

    public function test_can_get_user_by_id(): void
    {
        $userModel = Mockery::mock(User::class);
        $userModel->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $userModel->shouldReceive('getAttribute')->with('name')->andReturn('Test User');
        $userModel->shouldReceive('getAttribute')->with('email')->andReturn('test@example.com');
        $userModel->shouldReceive('getAttribute')->with('created_at')->andReturn(now());
        $userModel->shouldReceive('getAttribute')->with('updated_at')->andReturn(now());

        $this->userRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($userModel);

        $result = $this->userService->getUserById(1);

        $this->assertInstanceOf(UserData::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function test_returns_null_when_user_not_found(): void
    {
        $this->userRepository
            ->shouldReceive('findById')
            ->once()
            ->with(999)
            ->andReturn(null);

        $result = $this->userService->getUserById(999);

        $this->assertNull($result);
    }

    public function test_can_update_user(): void
    {
        $this->userRepository
            ->shouldReceive('update')
            ->once()
            ->with(1, ['name' => 'Updated Name'])
            ->andReturn(true);

        $result = $this->userService->updateUser(1, ['name' => 'Updated Name']);

        $this->assertTrue($result);
    }

    public function test_can_delete_user(): void
    {
        $this->userRepository
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->userService->deleteUser(1);

        $this->assertTrue($result);
    }
}
