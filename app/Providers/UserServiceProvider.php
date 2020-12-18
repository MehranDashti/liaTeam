<?php

namespace App\Providers;

use App\Builders\UserBuilder;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserBuilder::class, function () {
            return new UserBuilder();
        });
    }
}
