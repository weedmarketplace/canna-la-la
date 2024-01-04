<?php

namespace App\Providers;

use App\Http\View\Composers\DataComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        // View::composer('app.*', DataComposer::class);

        View::composer('app.*', function ($view) {
            if ($view->getName() !== 'app.blocks.cart_item_html') {
                $composer = app(DataComposer::class);
                $composer->compose($view);
            }
        });
    }
}