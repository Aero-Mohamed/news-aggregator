<?php

namespace App\Providers;

use App\Services\Article\Contracts\ArticleServiceInterface;
use App\Services\Article\ArticleService;
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
            ArticleServiceInterface::class => ArticleService::class,
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
