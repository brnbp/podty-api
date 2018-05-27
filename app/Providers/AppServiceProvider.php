<?php

namespace App\Providers;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('float_between', function ($attribute, $value, $parameters, $validator) {
            if (!is_numeric($value)) {
                return false;
            }

            list($min, $max) = $parameters;
            $value = (float) $value;

            return  $value >= $min && $value <= $max;
        });

        Validator::replacer('float_between',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace([':min', ':max'], [$parameters[0], $parameters[1]], $message);
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        $this->app->alias('bugsnag.logger', Log::class);
        $this->app->alias('bugsnag.logger', LoggerInterface::class);
    }
}
