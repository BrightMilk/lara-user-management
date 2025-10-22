<?php

namespace Tests\Traits;

use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Domain\Users\Services\UserService;
use Mockery;
use Mockery\MockInterface;

trait MocksServices
{
    protected function mockUserRepository(array $methods = []): MockInterface
    {
        $mock = Mockery::mock(UserRepositoryInterface::class);

        foreach ($methods as $method => $returnValue) {
            $mock->shouldReceive($method)->andReturn($returnValue);
        }

        $this->app->instance(UserRepositoryInterface::class, $mock);

        return $mock;
    }

    protected function mockUserService(array $methods = []): MockInterface
    {
        $mock = Mockery::mock(UserService::class);

        foreach ($methods as $method => $returnValue) {
            $mock->shouldReceive($method)->andReturn($returnValue);
        }

        $this->app->instance(UserService::class, $mock);

        return $mock;
    }
}
