<?php

namespace TypiCMS\Modules\Roles\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Roles\Presenters\ModulePresenter;

class Role extends Base implements RoleContract
{
    use HasPermissions;
    use Historable;
    use PresentableTrait;
    use RefreshesPermissionCache;

    protected $presenter = ModulePresenter::class;

    public $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.roles'));
    }

    /**
     * Get front office uri.
     *
     * @param string $locale
     *
     * @return string
     */
    public function uri($locale = null)
    {
        return '/';
    }

    public static function create(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        if (static::where('name', $attributes['name'])->where('guard_name', $attributes['guard_name'])->first()) {
            throw RoleAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions')
        );
    }

    /**
     * Find a role by its name and guard name.
     *
     * @param string $name
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
     *
     * @throws \Spatie\Permission\Exceptions\RoleDoesNotExist
     */
    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? config('auth.defaults.guard');

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::create($name);
        }

        return $role;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     *
     * @throws \Spatie\Permission\Exceptions\GuardMismatch
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission, $this->getGuardName());
        }

        if ($permission->guard_name !== $this->getGuardName()) {
            throw GuardDoesNotMatch::create($permission->guard_name, $this->getGuardName());
        }

        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * Sync permissions.
     *
     * @param array $permissions
     *
     * @return null
     */
    public function syncPermissions($permissions)
    {
        $permissionIds = [];
        foreach ($permissions as $name) {
            $permissionIds[] = app(PermissionContract::class)->firstOrCreate(['name' => $name])->id;
        }
        $this->permissions()->sync($permissionIds);
    }
}
