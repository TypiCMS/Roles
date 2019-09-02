<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
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
        $model = new Role;
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
        $data = $request->all();
        $roleData = Arr::except($data, ['exit', 'permissions']);
        $role = Role::create($roleData);

        if ($role) {
            $permissions = isset($data['permissions']) ? $data['permissions'] : [];
            $role->syncPermissions($permissions);
        }

        return $this->redirect($request, $role);
    }

    public function update(Role $role, FormRequest $request): RedirectResponse
    {
        $data = $request->all();
        $roleData = Arr::except($data, ['exit', 'permissions']);
        $permissions = isset($data['permissions']) ? $data['permissions'] : [];
        $role->syncPermissions($permissions);
        $role->update($roleData);
        $role->forgetCachedPermissions();

        return $this->redirect($request, $role);
    }
}
