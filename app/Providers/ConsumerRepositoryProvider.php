<?php

namespace App\Providers;

use App\Repositories\ConsumersRepository;
use App\Repositories\Impl\ConsumersRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ConsumerRepositoryProvider extends ServiceProvider
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
            ConsumersRepository::class,
            ConsumersRepositoryImpl::class
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
