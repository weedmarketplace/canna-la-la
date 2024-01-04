<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App;
use PaginateRoute;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    public const HOMEPAGE = '/';

    public function boot()
    {
        //
        PaginateRoute::registerMacros();
        
        parent::boot();
    }

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers\\';

    public function map()
    {
        $this->configureRateLimiting();

        // $this->mapApiRoutes();

        $this->mapAdminRoutes();
        
        $this->mapWebRoutes();

    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function mapWebRoutes()
    {
        // Localization
        $request = app(\Illuminate\Http\Request::class);
        $locale = $request->segment(1);

        if($locale == 'en'){
            header("Location: /");
            exit();
        }
        // TODO ACTIVE LANG
        $activeLangs = array('am','en','ru');
        
        if ( ! in_array($locale, $activeLangs)) {
            App::setLocale(config('app.fallback_locale'));
        } else {
            App::setLocale($locale);
        }
        // Localization

        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

        // Route::prefix('auth')
        //         ->middleware('guest')
        //         ->namespace($this->namespace)
        //         ->group(base_path('routes/auth.php'));
        // $this->routes(function () {
            

                // Route::prefix('auth')
                // ->middleware('guest')
                // ->namespace($this->namespace)
                // ->group(base_path('routes/auth.php'));

            

            
        // });
    }

    protected function mapApiRoutes()
    {
        // Route::prefix('api')
        //         ->middleware('api')
        //         ->namespace($this->namespace.'API')
        //         ->group(base_path('routes/api.php'));

        // Route::prefix('api-c')
        //     ->middleware('api-c')
        //     ->namespace($this->namespace.'APIC')
        //     ->group(base_path('routes/api-carrier.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
                ->prefix('admin')
                ->namespace($this->namespace.'\Admin')
                ->group(base_path('routes/admin.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}