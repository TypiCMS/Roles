<?php

namespace TypiCMS\Modules\Roles\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read roles')) {
            return;
        }
        $view->sidebar->group(__('Users and roles'), function (SidebarGroup $group) {
            $group->id = 'users';
            $group->weight = 50;
            $group->addItem(__('Roles'), function (SidebarItem $item) {
                $item->id = 'roles';
                $item->icon = config('typicms.roles.sidebar.icon');
                $item->weight = config('typicms.roles.sidebar.weight');
                $item->route('admin::index-roles');
                $item->append('admin::create-role');
            });
        });
    }
}
