<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TokenRepositoryInterface::class, function ($app) {
            $factory = $app->make(PasswordBrokerFactory::class);
            return $factory->broker()->getRepository();
        });

        $this->app->singleton(UserProvider::class, function ($app) {
            return $app->auth->createUserProvider(config('auth.passwords.users.provider'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
