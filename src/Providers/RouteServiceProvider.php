<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Roles\Http\Controllers\AdminController;
use TypiCMS\Modules\Roles\Http\Controllers\ApiController;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('roles', [AdminController::class, 'index'])->name('index-roles')->middleware('can:read roles');
            $router->get('roles/create', [AdminController::class, 'create'])->name('create-role')->middleware('can:create roles');
            $router->get('roles/{role}/edit', [AdminController::class, 'edit'])->name('edit-role')->middleware('can:read roles');
            $router->post('roles', [AdminController::class, 'store'])->name('store-role')->middleware('can:create roles');
            $router->put('roles/{role}', [AdminController::class, 'update'])->name('update-role')->middleware('can:update roles');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('roles', [ApiController::class, 'index'])->middleware('can:read roles');
            $router->patch('roles/{role}', [ApiController::class, 'updatePartial'])->middleware('can:update roles');
            $router->delete('roles/{role}', [ApiController::class, 'destroy'])->middleware('can:delete roles');
        });
    }
}
