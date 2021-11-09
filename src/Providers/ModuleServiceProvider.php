<?php

namespace TypiCMS\Modules\Roles\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Roles\Facades\Roles;
use TypiCMS\Modules\Roles\Models\Role;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.roles');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'roles');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/roles'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php'),
            __DIR__.'/../../database/seeders/PermissionSeeder.php' => database_path('seeders/PermissionSeeder.php'),
            __DIR__.'/../../database/seeders/PermissionRoleSeeder.php' => database_path('seeders/PermissionRoleSeeder.php'),
        ], 'seeders');

        AliasLoader::getInstance()->alias('Roles', Roles::class);

        View::composer('core::admin._sidebar', \TypiCMS\Modules\Roles\Composers\SidebarViewComposer::class);
    }

    public function register(): void
    {
        $this->app->register(\TypiCMS\Modules\Roles\Providers\RouteServiceProvider::class);

        $this->app->bind('Roles', Role::class);
    }
}
