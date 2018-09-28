<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Roles\Models\Role;
use TypiCMS\Modules\Roles\Repositories\EloquentRole;

class ApiController extends BaseApiController
{
    public function __construct(EloquentRole $role)
    {
        parent::__construct($role);
    }

    public function index(Request $request)
    {
        $data = QueryBuilder::for(Role::class)
            ->paginate($request->input('per_page'));

        return $data;
    }

    public function destroy(Role $role)
    {
        $deleted = $this->repository->delete($role);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
