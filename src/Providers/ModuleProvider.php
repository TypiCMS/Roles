<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Roles\Models\Role;
use TypiCMS\Modules\Roles\Repositories\EloquentRole;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.roles'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['roles' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'roles');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'roles');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/roles'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Roles',
            \TypiCMS\Modules\Roles\Facades\Facade::class
        );
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(\TypiCMS\Modules\Roles\Providers\RouteServiceProvider::class);
        $app->register(\Spatie\Permission\PermissionServiceProvider::class);

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', \TypiCMS\Modules\Roles\Composers\SidebarViewComposer::class);

        $app->bind(\TypiCMS\Modules\Roles\Repositories\RoleInterface::class, function (Application $app) {
            return new EloquentRole(new Role());
        });
    }
}
