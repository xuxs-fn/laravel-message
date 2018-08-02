<?php

namespace Happyphper\LaravelMessage;

use Illuminate\Support\ServiceProvider;

class LaravelMessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-message.php' => config_path('laravel-message.php')
        ]);

        if (! class_exists('CreateLaravelMessageTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/create_laravel_message_tables.php' => database_path()."/migrations/{$timestamp}_create_laravel_message_tables.php",
            ], 'migrations');
        }
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
