<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Roles\Models\Role;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Role::class)
            ->allowedFilters([
                Filter::custom('name', FilterOr::class),
            ])
            ->paginate($request->input('per_page'));

        return $data;
    }

    public function destroy(Role $role): JsonResponse
    {
        $deleted = $role->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
