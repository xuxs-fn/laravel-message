<?php

namespace Happyphper\LaravelChat;

use Illuminate\Support\ServiceProvider;

class LaravelChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations'),
            __DIR__ . '/config/laravel-chat.php' => base_path('config/laravel-chat.php')
        ], 'laravel-chat');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
