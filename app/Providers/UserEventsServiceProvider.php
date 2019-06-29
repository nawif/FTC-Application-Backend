<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\EventService\EventService;

class UserEventsServiceProvider extends ServiceProvider
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
            'App\Service\EventService\EventServiceContract', function ($app) {
                return new EventService();
              }
        );
    }
}
