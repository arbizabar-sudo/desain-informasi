<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Temporary: add logging middleware to web group for debugging auth/session
        if ($this->app->runningInConsole() === false) {
            $router = $this->app->make('router');
            if (method_exists($router, 'pushMiddlewareToGroup')) {
                $router->pushMiddlewareToGroup('web', \App\Http\Middleware\LogAuthSession::class);
                // Update last_activity for signed-in users (used for "online" indicator)
                $router->pushMiddlewareToGroup('web', \App\Http\Middleware\UpdateLastActivity::class);
                // Prevent caching of HTML pages to avoid stale auth state in browser
                $router->pushMiddlewareToGroup('web', \App\Http\Middleware\PreventPageCache::class);
            }
        }
    }
}
