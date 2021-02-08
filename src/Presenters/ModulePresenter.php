<?php

namespace TypiCMS\Modules\Roles\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    public function title(): string
    {
        return $this->entity->name;
    }
}
