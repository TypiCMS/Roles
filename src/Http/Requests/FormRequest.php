<?php

namespace TypiCMS\Modules\Roles\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:255|unique:roles,name,'.$this->id,
        ];
    }
}
