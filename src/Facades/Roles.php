<?php

namespace TypiCMS\Modules\Roles\Facades;

use Illuminate\Support\Facades\Facade;

class Roles extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Roles';
    }
}
