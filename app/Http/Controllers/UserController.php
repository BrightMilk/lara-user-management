<?php

namespace App\Http\Controllers;

use App\Application\Users\Commands\CreateUserCommand;
use App\Application\Users\Commands\UpdateUserCommand;
use App\Application\Users\Commands\DeleteUserCommand;
use App\Application\Users\Handlers\Commands\CreateUserHandler;
use App\Application\Users\Handlers\Commands\UpdateUserHandler;
use App\Application\Users\Handlers\Commands\DeleteUserHandler;
use App\Application\Users\Queries\GetUserQuery;
use App\Application\Users\Queries\ListUsersQuery;
use App\Application\Users\Handlers\Queries\GetUserHandler;
use App\Application\Users\Handlers\Queries\ListUsersHandler;
use App\Domain\Shared\DTO\ApiResponseData;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Domain\Users\DTO\CreateUserData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(
        Request $request,
        ListUsersHandler $handler,
    ): JsonResponse {
        // TODO Фильтрацию можно вынести на уровень сервиса в отдельный хэлпер
        /*
         * Также можно реализовать на каждый тип фильтра свой хэлпер
         * и передавать фильтр/коллецию фильтров в репозиторий
         */
        $filters = $request->only(['name']);

        $query = new ListUsersQuery($filters);
        $users = $handler->handle($query);

        return ApiResponseData::success(
            messageKey: 'messages.users.list_retrieved',
            data: $users,
        );
    }

    public function store(
        StoreUserRequest $request,
        CreateUserHandler $handler
    ): JsonResponse {
        $userData = CreateUserData::from($request->validated());

        $command = new CreateUserCommand($userData);
        $user = $handler->handle($command);

        return ApiResponseData::success(
            messageKey: 'messages.users.created',
            data: $user,
            statusCode: 201
        );
    }

    public function show(
        int $id,
        GetUserHandler $handler
    ): JsonResponse {
        $query = new GetUserQuery($id);
        $user = $handler->handle($query);

        if (!$user) {
            return ApiResponseData::error(
                messageKey: 'messages.users.not_found',
                statusCode: 404,
            );
        }

        return ApiResponseData::success(
            messageKey: 'messages.users.retrieved',
            data: $user,
        );
    }

    public function update(
        UpdateUserRequest $request,
        int $id,
        UpdateUserHandler $handler
    ): JsonResponse {
        $command = new UpdateUserCommand($id, $request->validated());
        $result = $handler->handle($command);

        if (!$result) {
            return ApiResponseData::error(
                messageKey: 'messages.users.not_found',
                statusCode: 404,
            );
        }

        return ApiResponseData::success(
            messageKey: 'messages.users.updated',
        );
    }

    public function destroy(
        int $id,
        DeleteUserHandler $handler
    ): JsonResponse {
        $command = new DeleteUserCommand($id);
        $result = $handler->handle($command);

        if (!$result) {
            return ApiResponseData::error(
                messageKey: 'messages.users.not_found',
                statusCode: 404,
            );
        }

        return ApiResponseData::success(
            messageKey: 'messages.users.deleted',
        );
    }
}
