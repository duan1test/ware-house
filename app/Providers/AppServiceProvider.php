<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Tecdiary\Laravel\Attachments\AttachmentsServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(
            \Illuminate\Translation\Translator::class,
            fn ($translator) => new \App\Helpers\Translator($translator->getLoader(), $translator->getLocale())
        );
        
        AttachmentsServiceProvider::ignoreMigrations();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        if (in_array(config('app.env'), ['production', 'staging'])) {
            \URL::forceScheme('https');
        }
    }
}
