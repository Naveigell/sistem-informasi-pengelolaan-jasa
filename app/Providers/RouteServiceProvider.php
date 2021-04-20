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
                    $this->mapJasaRoutes();
                    $this->mapSparepartRoutes();
                    $this->mapTechnicianRoutes();
                });
            });
    }

    /**
     * Define jasa routes
     *
     * @return void
     */
    public function mapJasaRoutes()
    {
        Route::prefix("/service")->group(function () {
            Route::get("/", "Api\Jasa\JasaController@retrieveAll");
            Route::post("/", "Api\Jasa\JasaController@insert");
            Route::patch("/activate", "Api\Jasa\JasaController@activate");
            Route::put("/", "Api\Jasa\JasaController@update");
            Route::delete("/{id}", "Api\Jasa\JasaController@delete");
        });
    }

    /**
     * Define technician routes
     *
     * @return void
     */
    public function mapTechnicianRoutes()
    {
        Route::prefix("/technicians")->group(function () {
            Route::get("/search", "Api\Technician\TechnicianController@search");
            Route::get("/{page?}", "Api\Technician\TechnicianController@retrieveAll");
            Route::get("/username/{username}", "Api\Technician\TechnicianController@retrieveByUsername");
            Route::post("/", "Api\Technician\TechnicianController@create");
            Route::delete("/{id}", "Api\Technician\TechnicianController@delete");
            Route::put("/", "Api\Technician\TechnicianController@update");
            Route::post("/reset-password", "Api\Technician\TechnicianController@resetPassword");
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
            Route::get('/image', 'Api\User\Account\BiodataController@getProfilePicture');
            Route::get('/graph', 'Api\User\Account\GraphController@retrieveData');
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
        Route::prefix("/auth")->group(function () {
            Route::post('/login', 'Api\Auth\LoginController@login');
            Route::post('/change-password', 'Api\Auth\AuthController@changePassword');
            Route::get('/logout', 'Api\Auth\AuthController@logout');
            Route::get('/check', 'Api\Auth\AuthController@check');
            Route::get('/session/data', 'Api\Auth\AuthController@sessionData');
        });
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
