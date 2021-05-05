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
                    $this->mapAdminRoutes();
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
        Route::prefix("/service")->middleware("should.has.role:admin")->group(function () {
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
            Route::get("/{id}/graph", "Api\Technician\GraphController@retrieve")->middleware("should.has.role:admin,teknisi");
            Route::get("/username/{username}", "Api\Technician\TechnicianController@retrieveByUsername")->middleware("should.has.role:admin,teknisi");
            Route::post("/", "Api\Technician\TechnicianController@create")->middleware("should.has.role:admin");
            Route::delete("/{id}", "Api\Technician\TechnicianController@delete")->middleware("should.has.role:admin");
            Route::put("/", "Api\Technician\TechnicianController@update")->middleware("should.has.role:admin");
            Route::post("/reset-password", "Api\Technician\TechnicianController@resetPassword")->middleware("should.has.role:admin");
        });
    }

    /**
     * Define admin routes
     */
    public function mapAdminRoutes()
    {
        Route::prefix("/admins")->group(function () {
            Route::get("/{page?}", "Api\Admin\AdminController@retrieveAll");
            Route::post("/", "Api\Admin\AdminController@create")->middleware("should.has.role:admin");
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
            Route::get("/search", "Api\Sparepart\SparepartController@search")->middleware("should.has.role:admin,teknisi");
            Route::get("/retrieve/{id}", "Api\Sparepart\SparepartController@retrieve")->middleware("should.has.role:admin,teknisi");
            Route::get("/{page?}", "Api\Sparepart\SparepartController@retrieveAll")->middleware("should.has.role:admin,teknisi")->name('sparepart.index');
            Route::post("/", "Api\Sparepart\SparepartController@insert")->middleware("should.has.role:admin");
            Route::put("/", "Api\Sparepart\SparepartController@update")->middleware("should.has.role:admin");
            Route::delete("/{id}", "Api\Sparepart\SparepartController@delete")->middleware("should.has.role:admin");
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
            Route::get('/', 'Api\User\Account\BiodataController@retrieveBiodata')->middleware("should.has.role:admin,teknisi,user");
            Route::get('/image', 'Api\User\Account\BiodataController@getProfilePicture')->middleware("should.has.role:admin,teknisi,user");
            Route::get('/graph', 'Api\User\Account\GraphController@retrieveData')->middleware("should.has.role:teknisi");
            Route::put('/', 'Api\User\Account\BiodataController@updateBiodata')->middleware("should.has.role:admin,teknisi,user");
            Route::post('/image', 'Api\User\Account\BiodataController@updateProfilePicture')->middleware("should.has.role:admin,teknisi,user");
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
