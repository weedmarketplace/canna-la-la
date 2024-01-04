<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Blade;

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
        // Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
        //     $explode = explode(',', $value);
        //     $allow = ['png', 'jpg', 'jpeg'];
        //     $format = str_replace(
        //         [
        //             'data:image/',
        //             ';',
        //             'base64',
        //         ],
        //         [
        //             '', '', '',
        //         ],
        //         $explode[0]
        //     );

        //     // check file format
        //     if (!in_array($format, $allow)) {
        //         return false;
        //     }

        //     // check base64 format
        //     if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
        //         return false;
        //     }

        //     return true;
        // });

        Blade::directive('currency', function ($expression) {
            return "<?php echo formatCurrency($expression); ?>";
        });

        if(app()->environment('production')){
            URL::forceScheme('https');  
        }
        

        
        // view()->share('cart', $cart);
    }
}