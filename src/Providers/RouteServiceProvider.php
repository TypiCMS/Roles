<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Roles\Http\Controllers\AdminController;
use TypiCMS\Modules\Roles\Http\Controllers\ApiController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('roles', [AdminController::class, 'index'])->name('admin::index-roles')->middleware('can:read roles');
                $router->get('roles/create', [AdminController::class, 'create'])->name('admin::create-role')->middleware('can:create roles');
                $router->get('roles/{role}/edit', [AdminController::class, 'edit'])->name('admin::edit-role')->middleware('can:update roles');
                $router->post('roles', [AdminController::class, 'store'])->name('admin::store-role')->middleware('can:create roles');
                $router->put('roles/{role}', [AdminController::class, 'update'])->name('admin::update-role')->middleware('can:update roles');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('roles', [ApiController::class, 'index'])->middleware('can:read roles');
                    $router->patch('roles/{role}', [ApiController::class, 'updatePartial'])->middleware('can:update roles');
                    $router->delete('roles/{role}', [ApiController::class, 'destroy'])->middleware('can:delete roles');
                });
            });
        });
    }
}
