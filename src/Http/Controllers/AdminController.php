<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Roles\Http\Requests\FormRequest;
use TypiCMS\Modules\Roles\Models\Role;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('roles::admin.index');
    }

    public function create(): View
    {
        $model = new Role();
        $model->permissions = [];

        return view('roles::admin.create')
            ->with(compact('model'));
    }

    public function edit(Role $role, $child = null): View
    {
        $role->permissions = $role->permissions()->pluck('name')->all();

        return view('roles::admin.edit')
            ->with(['model' => $role]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $permissions = $request->input('permissions', []);
        $data = $request->except(['exit', 'permissions']);

        $this->storeNewPermissions($permissions);

        $role = Role::create($data);
        $role->syncPermissions($permissions);

        return $this->redirect($request, $role);
    }

    public function update(Role $role, FormRequest $request): RedirectResponse
    {
        $permissions = $request->input('permissions', []);
        $data = $request->except(['exit', 'permissions']);
        $role->update($data);

        $this->storeNewPermissions($permissions);
        $role->syncPermissions($permissions);
        $role->forgetCachedPermissions();

        return $this->redirect($request, $role);
    }

    private function storeNewPermissions($permissions)
    {
        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }
    }
}
