<?php

namespace TypiCMS\Modules\Roles\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Roles\Models\Role;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Role::class)
            ->allowedSorts(['name'])
            ->allowedFilters([
                AllowedFilter::custom('name', new FilterOr()),
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
