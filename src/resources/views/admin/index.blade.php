@extends('core::admin.master')

@section('title', __('Roles'))

@section('content')

<div ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'roles'])

    <h1>@lang('Roles')</h1>

    <div class="btn-toolbar">
        @include('core::admin._button-select')
        @include('core::admin._button-actions', ['only' => ['delete']])
    </div>

    <div class="table-responsive">

        <table st-persist="rolesTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="name" class="name st-sort" st-sort-default="true">{{ __('Name') }}</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="name" class="form-control form-control-sm" placeholder="@lang('Filter')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td>
                        <input type="checkbox" checklist-model="checked.models" checklist-value="model">
                    </td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'roles'])
                    </td>
                    <td>@{{ model.name }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
