<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->adjustLocale();

        // Bind user route
        Route::bind('user', function ($value) {
            return \App\User::where('name', $value)->first();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Adjusts the locale with different browser languages
     */
    protected function adjustLocale()
    {
        if (request()->hasCookie('lang')) {
            $this->setLocale(Crypt::decrypt(request()->cookie('lang')));
        } else {
            request()->header('accept-language') ? $this->setLocale(substr(request()->header('accept-language'), 0, 2)) : null;
        }
    }

    /**
     * Switch locale
     *
     * @param $locale
     */
    private function setLocale($locale)
    {
        switch ($locale) {
            case "en":
            case "zh":
                app()->setLocale($locale);
                Carbon::setLocale($locale);
                return;
            default:
                return;
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
