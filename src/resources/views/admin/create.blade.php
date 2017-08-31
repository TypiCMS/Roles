@extends('core::admin.master')

@section('title', __('New role'))

@section('content')

    @include('core::admin._button-back', ['module' => 'roles'])
    <h1>
        @lang('New role')
    </h1>

    {!! BootForm::open()->action(route('admin::index-roles'))->multipart()->role('form') !!}
        @include('roles::admin._form')
    {!! BootForm::close() !!}

@endsection
