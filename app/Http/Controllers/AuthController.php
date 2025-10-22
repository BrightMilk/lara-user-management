<?php

namespace App\Http\Controllers;

use App\Application\Users\Commands\CreateUserCommand;
use App\Application\Users\Handlers\Commands\CreateUserHandler;
use App\Application\Users\Queries\GetUserByEmailQuery;
use App\Application\Users\Handlers\Queries\GetUserByEmailHandler;
use App\Domain\Shared\DTO\ApiResponseData;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Domain\Users\DTO\CreateUserData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(
        RegisterRequest $request,
        CreateUserHandler $handler
    ): JsonResponse {
        $userData = CreateUserData::from([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $command = new CreateUserCommand($userData);
        $user = $handler->handle($command);

        $token = $user->createToken('auth-token')->plainTextToken;

        return ApiResponseData::success(
            messageKey: 'messages.auth.register_success',
            data: [
                'user' => $user,
                'token' => $token
            ],
            statusCode: 201
        );
    }

    /**
     * @throws ValidationException
     */
    public function login(
        LoginRequest $request,
        GetUserByEmailHandler $handler
    ): JsonResponse {
        $query = new GetUserByEmailQuery($request->email);
        $user = $handler->handle($query);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('messages.auth.invalid_credentials')],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return ApiResponseData::success(
            messageKey: 'messages.auth.login_success',
            data: [
                'user' => $user,
                'token' => $token
            ],
        );
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return ApiResponseData::success(
            messageKey: 'messages.auth.logout_success',
        );
    }
}
