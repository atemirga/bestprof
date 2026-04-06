<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.default');
        Paginator::defaultSimpleView('vendor.pagination.default');

        View::composer('layouts.app', function ($view) {
            $view->with('rootCategories', Category::roots()->active()
                ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')
                    ->with(['children' => fn($q2) => $q2->active()->orderBy('sort_order')])])
                ->orderBy('sort_order')
                ->get());

            if (!$view->offsetExists('settings')) {
                $view->with('settings', Setting::all()->pluck('value', 'key'));
            }

            if (!$view->offsetExists('seo')) {
                $view->with('seo', []);
            }
        });
    }
}
