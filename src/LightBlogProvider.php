<?php

namespace Disatapp\LightBlog;

use Illuminate\Support\ServiceProvider;

class LightBlogProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'lightBlog');
        $this->publishes([
            __DIR__ . '/config' => config_path('light-blog-demo'),
            __DIR__.'/resources/views' => base_path('resources/views'),
        ]);

        $this->publishes([
            __DIR__ . '/database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
