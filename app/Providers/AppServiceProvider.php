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
        \View::composer(['errors::403', 'users.messages', 'users.settings'],
            'App\Http\Composers\Error403Composer');

        \View::composer(['partials.header', 'welcome'], function ($view) {
            $categories = Category::withCount('ads')->get();

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
