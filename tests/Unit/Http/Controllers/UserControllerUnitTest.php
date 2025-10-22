<?php

namespace Tests\Unit\Http\Controllers;

use App\Application\Users\Commands\DeleteUserCommand;
use App\Application\Users\Commands\UpdateUserCommand;
use App\Application\Users\Handlers\Commands\DeleteUserHandler;
use App\Application\Users\Handlers\Commands\UpdateUserHandler;
use App\Application\Users\Handlers\Queries\GetUserHandler;
use App\Application\Users\Handlers\Queries\ListUsersHandler;
use App\Application\Users\Queries\GetUserQuery;
use App\Application\Users\Queries\ListUsersQuery;
use App\Http\Controllers\UserController;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserControllerUnitTest extends TestCase
{
    private UserController $controller;
    private MockInterface $listUsersHandlerMock;
    private MockInterface $getUserHandlerMock;
    private MockInterface $updateUserHandlerMock;
    private MockInterface $deleteUserHandlerMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listUsersHandlerMock = Mockery::mock(ListUsersHandler::class);
        $this->getUserHandlerMock = Mockery::mock(GetUserHandler::class);
        $this->updateUserHandlerMock = Mockery::mock(UpdateUserHandler::class);
        $this->deleteUserHandlerMock = Mockery::mock(DeleteUserHandler::class);

        $this->controller = new UserController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_returns_users_list(): void
    {
        $request = Request::create('/users', 'GET', ['name' => 'John']);
        $expectedUsers = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com'],
        ];

        $this->listUsersHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (ListUsersQuery $query) {
                return $query->filters === ['name' => 'John'];
            }))
            ->andReturn(collect($expectedUsers));

        $response = $this->controller->index($request, $this->listUsersHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.list_retrieved'), $responseData['message']);
        $this->assertEquals($expectedUsers, $responseData['data']);
    }

    public function test_show_returns_404_when_user_not_found(): void
    {
        $userId = 999;

        $this->getUserHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (GetUserQuery $query) use ($userId) {
                return $query->userId === $userId;
            }))
            ->andReturn(null);

        $response = $this->controller->show($userId, $this->getUserHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.not_found'), $responseData['message']);
    }

    public function test_update_updates_user_successfully(): void
    {
        $userId = 1;
        $updateData = ['name' => 'Updated Name', 'email' => 'updated@example.com'];

        $requestMock = Mockery::mock(UpdateUserRequest::class);
        $requestMock->shouldReceive('validated')
            ->once()
            ->andReturn($updateData);

        $this->updateUserHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (UpdateUserCommand $command) use ($userId, $updateData) {
                return $command->userId === $userId
                    && $command->data === $updateData;
            }))
            ->andReturn(true);

        $response = $this->controller->update($requestMock, $userId, $this->updateUserHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.updated'), $responseData['message']);
    }

    public function test_update_returns_404_when_user_not_found(): void
    {
        $userId = 999;
        $updateData = ['name' => 'Updated Name'];

        $requestMock = Mockery::mock(UpdateUserRequest::class);
        $requestMock->shouldReceive('validated')
            ->once()
            ->andReturn($updateData);

        $this->updateUserHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (UpdateUserCommand $command) use ($userId) {
                return $command->userId === $userId;
            }))
            ->andReturn(false);

        $response = $this->controller->update($requestMock, $userId, $this->updateUserHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.not_found'), $responseData['message']);
    }

    public function test_destroy_deletes_user_successfully(): void
    {
        $userId = 1;

        $this->deleteUserHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (DeleteUserCommand $command) use ($userId) {
                return $command->userId === $userId;
            }))
            ->andReturn(true);

        $response = $this->controller->destroy($userId, $this->deleteUserHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.deleted'), $responseData['message']);
    }

    public function test_destroy_returns_404_when_user_not_found(): void
    {
        $userId = 999;

        $this->deleteUserHandlerMock
            ->shouldReceive('handle')
            ->once()
            ->with(Mockery::on(function (DeleteUserCommand $command) use ($userId) {
                return $command->userId === $userId;
            }))
            ->andReturn(false);

        $response = $this->controller->destroy($userId, $this->deleteUserHandlerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $responseData = $response->getData(true);
        $this->assertEquals(__('messages.users.not_found'), $responseData['message']);
    }
}
