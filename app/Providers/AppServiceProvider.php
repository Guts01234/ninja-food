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
        $this->app->bind(
            \App\Repositories\LinkRepositoryInterface::class,
            \App\Repositories\LinkRepository::class
        );
        
        $this->app->bind(
            \App\Repositories\LinkVisitRepositoryInterface::class,
            \App\Repositories\LinkVisitRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
