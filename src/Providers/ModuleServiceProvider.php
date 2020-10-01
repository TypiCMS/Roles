<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Roles\Facades\Roles;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.roles');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['roles' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'roles');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/roles'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php'),
            __DIR__.'/../database/seeders/PermissionSeeder.php' => database_path('seeders/PermissionSeeder.php'),
            __DIR__.'/../database/seeders/PermissionRoleSeeder.php' => database_path('seeders/PermissionRoleSeeder.php'),
        ], 'seeders');

        AliasLoader::getInstance()->alias('Roles', Roles::class);

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', \TypiCMS\Modules\Roles\Composers\SidebarViewComposer::class);
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(\TypiCMS\Modules\Roles\Providers\RouteServiceProvider::class);

        $app->bind('Roles', Role::class);
    }
}
