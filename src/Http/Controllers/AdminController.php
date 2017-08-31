<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Roles\Http\Requests\FormRequest;
use TypiCMS\Modules\Roles\Models\Role;
use TypiCMS\Modules\Roles\Repositories\EloquentRole;

class AdminController extends BaseAdminController
{
    public function __construct(EloquentRole $role)
    {
        parent::__construct($role);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->findAll();
        app('JavaScript')->put('models', $models);

        return view('roles::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();
        $model->permissions = [];

        return view('roles::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Role $role, $child = null)
    {
        $role->permissions = $role->permissions()->pluck('name')->all();

        return view('roles::admin.edit')
            ->with(['model' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Roles\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $data = $request->all();
        $roleData = array_except($data, ['exit', 'permissions']);
        $role = $this->repository->create($roleData);

        if ($role) {
            $permissions = isset($data['permissions']) ? $data['permissions'] : [];
            $role->syncPermissions($permissions);
        }

        return $this->redirect($request, $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Roles\Models\Role               $role
     * @param \TypiCMS\Modules\Roles\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, FormRequest $request)
    {
        $data = $request->all();
        $roleData = array_except($data, ['exit', 'permissions']);
        $permissions = isset($data['permissions']) ? $data['permissions'] : [];
        $role->syncPermissions($permissions);
        $this->repository->update($role->id, $roleData);
        $role->forgetCachedPermissions();

        return $this->redirect($request, $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Roles\Models\Role $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $deleted = $this->repository->delete($role);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
