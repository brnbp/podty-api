<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiV1Routes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiV1Routes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => 'App\Http\Controllers\v1',
            'prefix' => 'v1/',
        ], function ($router) {
            require base_path('routes/v1/api.php');
        });
    }
}
