<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
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

        // define a separated routes
        Route::middleware("web")
            ->namespace($this->namespace)
            ->prefix("/api/v1")
            ->group(function (){

                $this->mapAuthRoutes();
                Route::middleware("auth.global")->group(function (){
                    $this->mapBiodataRoutes();
                    $this->mapSparepartRoutes();
                });
            });
    }

    /**
     * Define sparepart routes
     *
     * @return void
     */
    public function mapSparepartRoutes()
    {
        Route::prefix("/spareparts")->group(function (){
            Route::get("/search", "Api\Sparepart\SparepartController@search");
            Route::get("/retrieve/{id}", "Api\Sparepart\SparepartController@retrieve");
            Route::get("/{page?}", "Api\Sparepart\SparepartController@retrieveAll")->name('sparepart.index');
            Route::post("/", "Api\Sparepart\SparepartController@insert");
            Route::put("/", "Api\Sparepart\SparepartController@update");
            Route::delete("/{id}", "Api\Sparepart\SparepartController@delete");
        });
    }

    /**
     * Define biodata routes
     *
     * @return void
     */
    public function mapBiodataRoutes()
    {
        Route::prefix("/biodata")->group(function (){
            Route::get('/', 'Api\User\Account\BiodataController@retrieveBiodata');
            Route::put('/', 'Api\User\Account\BiodataController@updateBiodata');
            Route::post('/image', 'Api\User\Account\BiodataController@updateProfilePicture');
        });
    }

    /**
     * Define auth routes
     *
     * @return void
     */
    public function mapAuthRoutes(){
        Route::post('/auth/login', 'Api\Auth\LoginController@login');
        Route::get('/auth/check', 'Api\Auth\AuthController@check');
        Route::get('/auth/session/data', 'Api\Auth\AuthController@sessionData');
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
