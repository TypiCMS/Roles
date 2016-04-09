@extends('core::admin.master')

@section('title', trans('roles::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'roles'])

    <h1>
        <span>@{{ models.length }} @choice('roles::global.roles', 2)</span>
    </h1>

    <div class="btn-toolbar">
    </div>

    <div class="table-responsive">

        <table st-persist="rolesTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="name" class="name st-sort" st-sort-default="true">Name</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="name" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model, model.name)"></td>
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
