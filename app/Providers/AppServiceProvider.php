<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Validates @cityu.edu / @cityuniversity.edu
        Validator::extend('cityu', function ($attribute, $value, $parameters, $validator) {
            $validDomains = ['cityu.edu', 'cityuniversity.edu'];
            $parts = explode('@', $value);
            $domain = $parts[1];

            return in_array($domain, $validDomains);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
