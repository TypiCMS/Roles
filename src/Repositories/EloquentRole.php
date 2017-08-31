<?php

namespace TypiCMS\Modules\Roles\Repositories;

use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Roles\Models\Role;

class EloquentRole extends EloquentRepository
{
    protected $repositoryId = 'roles';

    protected $model = Role::class;
}
