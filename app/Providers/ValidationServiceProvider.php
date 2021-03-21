<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend("no_space", function ($attribute, $value, $parameters, $validator) {
            return !preg_match("/\s+/", $value);
        });

        // all string must be lowercase
        Validator::extend("lowercase", function ($attribute, $value, $parameters, $validator) {
            return strtolower($value) == $value;
        });
    }
}
