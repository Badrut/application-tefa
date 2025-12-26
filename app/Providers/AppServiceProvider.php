<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        Validator::replacer('*', function ($message, $attribute) {
            $attribute = Str::of($attribute)
                ->replace('_', ' ')
                ->title();

            return str_replace(':attribute', $attribute, $message);
        });
    }
}
