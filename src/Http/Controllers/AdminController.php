<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Roles\Http\Requests\FormRequest;
use TypiCMS\Modules\Roles\Models\Role;
use TypiCMS\Modules\Roles\Repositories\RoleInterface;

class AdminController extends BaseAdminController
{
    public function __construct(RoleInterface $role)
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
        $models = $this->repository->all([], true);
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
        $model = $this->repository->getModel();
        $permissions = [];

        return view('roles::admin.create')
            ->with(compact('model', 'permissions'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Role $role, $child = null)
    {
        $permissions = $role->permissions->pluck('name')->all();

        return view('roles::admin.edit')
            ->with([
                'model'       => $role,
                'permissions' => $permissions,
            ]);
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
        $role = $this->repository->create($request->all());

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
        $this->repository->update($request->all());

        return $this->redirect($request, $role);
    }
}
