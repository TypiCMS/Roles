<?php

namespace TypiCMS\Modules\Roles\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarRole;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->role(trans('global.menus.users'), function (SidebarRole $role) {
            $role->addItem(trans('roles::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.roles.sidebar.icon', 'icon fa fa-fw fa-users');
                $item->weight = config('typicms.roles.sidebar.weight');
                $item->route('admin.roles.index');
                $item->append('admin.roles.create');
                $item->authorize(
                    $this->auth->hasAccess('roles.index')
                );
            });
        });
    }
}
