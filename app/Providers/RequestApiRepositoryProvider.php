<?php

namespace App\Providers;

use App\Repositories\Impl\RequestApiLogRepositoryImpl;
use App\Repositories\RequestApiLogRepository;
use Illuminate\Support\ServiceProvider;

class RequestApiRepositoryProvider extends ServiceProvider
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
            RequestApiLogRepository::class,
            RequestApiLogRepositoryImpl::class
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
