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
            $router->get('admin/roles', ['as' => 'admin.roles.index', 'uses' => 'AdminController@index']);
            $router->get('admin/roles/create', ['as' => 'admin.roles.create', 'uses' => 'AdminController@create']);
            $router->get('admin/roles/{role}/edit', ['as' => 'admin.roles.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/roles', ['as' => 'admin.roles.store', 'uses' => 'AdminController@store']);
            $router->put('admin/roles/{role}', ['as' => 'admin.roles.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/roles', ['as' => 'api.roles.index', 'uses' => 'ApiController@index']);
            $router->put('api/roles/{role}', ['as' => 'api.roles.update', 'uses' => 'ApiController@update']);
            $router->delete('api/roles/{role}', ['as' => 'api.roles.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
