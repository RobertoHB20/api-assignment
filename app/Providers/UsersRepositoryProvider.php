<?php

namespace App\Providers;

use App\Repositories\Impl\UsersRepositoryImpl;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UsersRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            UsersRepository::class,
            UsersRepositoryImpl::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
