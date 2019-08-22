<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\TaskService\TaskService;

class TaskServiceProvider extends ServiceProvider
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
            'App\Service\TaskService\TaskServiceContract', function ($app) {
                return new TaskService();
              }
        );
    }
}
