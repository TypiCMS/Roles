<?php

namespace TypiCMS\Modules\Roles\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get title.
     */
    public function title(): string
    {
        return $this->entity->name;
    }
}
