<?php

namespace App\Providers;

use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $bindings = [
            // Format: Interface => Implementation
            UserServiceInterface::class => UserService::class,
        ];

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
