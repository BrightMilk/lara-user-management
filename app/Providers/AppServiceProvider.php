<?php

namespace App\Providers;

use App\Application\Users\Handlers\Commands\CreateUserHandler;
use App\Application\Users\Handlers\Commands\DeleteUserHandler;
use App\Application\Users\Handlers\Commands\UpdateUserHandler;
use App\Application\Users\Handlers\Queries\GetUserByEmailHandler;
use App\Application\Users\Handlers\Queries\GetUserHandler;
use App\Application\Users\Handlers\Queries\ListUsersHandler;
use Illuminate\Support\ServiceProvider;
use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Domain\Users\Repositories\EloquentUserRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        $this->app->bind(
            CreateUserHandler::class
        );
        $this->app->bind(
            UpdateUserHandler::class
        );
        $this->app->bind(
            DeleteUserHandler::class
        );

        $this->app->bind(
            GetUserHandler::class
        );
        $this->app->bind(
            ListUsersHandler::class
        );
        $this->app->bind(
            GetUserByEmailHandler::class
        );
    }

    public function boot(): void
    {
        app()->setLocale(config('app.locale'));
        app()->setFallbackLocale(config('app.fallback_locale'));

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('users', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });
    }
}
