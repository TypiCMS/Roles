<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Roles\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('roles', 'AdminController@index')->name('admin::index-roles')->middleware('can:see-all-roles');
                $router->get('roles/create', 'AdminController@create')->name('admin::create-role')->middleware('can:create-role');
                $router->get('roles/{role}/edit', 'AdminController@edit')->name('admin::edit-role')->middleware('can:update-role');
                $router->post('roles', 'AdminController@store')->name('admin::store-role')->middleware('can:create-role');
                $router->put('roles/{role}', 'AdminController@update')->name('admin::update-role')->middleware('can:update-role');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('roles', 'ApiController@index')->middleware('can:see-all-roles');
                    $router->patch('roles/{role}', 'ApiController@updatePartial')->middleware('can:update-role');
                    $router->delete('roles/{role}', 'ApiController@destroy')->middleware('can:delete-role');
                });
            });
        });
    }
}
