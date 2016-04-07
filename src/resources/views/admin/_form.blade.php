{!! BootForm::hidden('id') !!}

@include('core::admin._buttons-form')

<div class="row">

    <div class="col-sm-6">
        {!! BootForm::text(trans('validation.attributes.name'), 'name') !!}
    </div>

</div>

<label>@lang('roles::global.Role permissions')</label>
@include('core::admin._permissions-form')
