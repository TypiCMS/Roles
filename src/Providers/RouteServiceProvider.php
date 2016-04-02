<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Admin routes
             */
            $router->get('admin/roles', 'AdminController@index')->name('admin::index-roles');
            $router->get('admin/roles/create', 'AdminController@create')->name('admin::create-roles');
            $router->get('admin/roles/{role}/edit', 'AdminController@edit')->name('admin::edit-roles');
            $router->post('admin/roles', 'AdminController@store')->name('admin::store-roles');
            $router->put('admin/roles/{role}', 'AdminController@update')->name('admin::update-roles');

            /*
             * API routes
             */
            $router->get('api/roles', 'ApiController@index')->name('api::index-roles');
            $router->put('api/roles/{role}', 'ApiController@update')->name('api::update-roles');
            $router->delete('api/roles/{role}', 'ApiController@destroy')->name('api::destroy-roles');
        });
    }
}
