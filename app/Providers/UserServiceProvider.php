<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\UserService\UserService;

// use App\Service\UserService\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(
            'App\Service\UserService\UserServiceContract', function ($app) {
                return new UserService();
              }
        );
        // $this->app->bind('App\Service\UserService\UserServiceInterface', 'App\Service\UserService\UserServiceImp');
    }
}
