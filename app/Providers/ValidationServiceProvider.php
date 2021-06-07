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

        // make string must have at least one character
        Validator::extend("at_least_one_character", function ($attribute, $value, $parameters, $validator) {
            return preg_match("/[a-zA-z]+/", $value) > 0;
        });

        // check if the first letter in string is an alphabet
        Validator::extend("first_letter_must_alphabet", function ($attribute, $value, $parameters, $validator) {
            if (strlen($value) <= 0) {
                return false;
            }

            return !is_numeric($value[0]);
        });
    }
}
