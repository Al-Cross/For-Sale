<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Collection;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer(['users.messages', 'users.settings'], function ($view) {
            $balance = auth()->user()->balance->getBalance();

            $view->with('balance', $balance);
        });

        \View::composer('welcome', function ($view) {
            $categories = Category::withCount('ads')->get();

            $view->with('categories', $categories);
        });

        \View::composer('partials.header', function ($view) {
            $categories = \Cache::rememberForever('categories', function() {
                return $categories = Category::get();
            });

            $view->with('categories', $categories);
        });

        Collection::macro('privateAds', function() {
            return $this->filter(function($ad) {
                return $ad->type === 'private';
            });
        });

        Collection::macro('businessAds', function() {
            return $this->filter(function($ad) {
                return $ad->type === 'business';
            });
        });
    }
}
