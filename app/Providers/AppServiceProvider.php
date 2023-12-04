<?php

namespace App\Providers;
use App\Models\FooterContent;
use App\Models\Pages;
use App\Models\Categories;
use Illuminate\Support\Facades\View;
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
        view()->composer('*', function ($view) {
            $pages = Pages::all();
            $view->with('pages', $pages);
        });
        view()->composer('*', function ($view) {
            $categories = Categories::all();
            $view->with('categories', $categories);
        });
    }
}
