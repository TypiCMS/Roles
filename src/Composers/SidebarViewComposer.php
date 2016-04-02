<?php

namespace TypiCMS\Modules\Roles\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.users'), function (SidebarGroup $role) {
            $role->addItem(trans('roles::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.roles.sidebar.icon', 'icon fa fa-fw fa-users');
                $item->weight = config('typicms.roles.sidebar.weight');
                $item->route('admin::index-roles');
                $item->append('admin::create-roles');
                $item->authorize(
                    auth()->user()->can('index-roles')
                );
            });
        });
    }
}
