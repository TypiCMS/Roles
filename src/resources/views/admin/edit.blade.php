@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'roles'])
        <h1 class="header-title @empty($model->title)text-muted @endempty">
            {{ $model->present()->title ?: __('Untitled') }}
        </h1>
    </div>

    {!! BootForm::open()->put()->action(route('admin::update-role', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('roles::admin._form')
    {!! BootForm::close() !!}

@endsection
