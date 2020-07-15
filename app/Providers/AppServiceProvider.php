<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
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
       if ($this->app->isLocal()) {
           $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
       }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191);

        View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function() {
               return Channel::all();
            });

           $view->with('channels', $channels);
        });
    }
}
