<?php

namespace TypiCMS\Modules\Roles\Repositories;

use TypiCMS\Modules\Core\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Roles\Models\Role;

class EloquentRole extends RepositoriesAbstract implements RoleInterface
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models.
     *
     * @param array $with Eager load related models
     * @param bool  $all  Show published or all
     *
     * @return Collection|NestedCollection
     */
    public function all(array $with = [], $all = false)
    {
        return $this->make($with)->order()->get();
    }
}
