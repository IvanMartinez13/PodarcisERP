@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.ods') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.targets') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li><a class="nav-link active" data-toggle="tab" href="#dashboard">Dashboard</a></li>
            <li><a class="nav-link" data-toggle="tab" href="#objective-tab">Creación de objetivos</a></li>
        </ul>
        <div class="tab-content">

            <div role="tabpanel" id="dashboard" class="tab-pane active">
                <div class="panel-body">
                    <div class="animated fadeIn">
                        <dashboard-ods></dashboard-ods>
                    </div>
                </div>
            </div>

            <div role="tabpanel" id="objective-tab" class="tab-pane">
                <div class="panel-body">
                    <div class="animated fadeIn">
                        <div class="d-block mb-3">
                            <h2 class="d-inline">{{ __('modules.targets') }}</h2>

                            @can('store Ods')
                                <a href="{{ route('ods.objective.create') }}" class="btn btn-primary d-inline">
                                    {{ __('forms.create') }}
                                </a>
                            @endcan
                        </div>

                        {{-- PANEL --}}
                        <div class="container-fluid table-responsive">
                            <table class="table table-hover table-striped table-bordered js_datatable w-100">
                                <thead>
                                    <tr>
                                        <th style="10%">{{ __('columns.title') }}</th>
                                        <th style="width: 20%">{{ __('columns.description') }}</th>
                                        <th style="width: 15%">{{ __('columns.indicator') }}</th>
                                        <th style="width: 15%">
                                            {{ __('columns.increase') . ' | ' . __('columns.decrease') }}
                                        </th>
                                        <th style="width: 10%">{{ __('columns.target') }}</th>
                                        <th style="width: 12.5%">{{ __('columns.base_year') }}</th>
                                        <th style="width: 12.5%">{{ __('columns.target_year') }}</th>
                                        <th style="width: 5%">{{ __('columns.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objectives as $objective)
                                        <tr>
                                            <td class="align-middle">{{ $objective->title }}</td>
                                            <td class="align-middle">{!! $objective->description !!}</td>
                                            <td class="align-middle">{{ $objective->indicator }}</td>
                                            <td class="align-middle">
                                                {{ $objective->increase == 0 ? __('columns.decrease') : __('columns.increase') }}
                                            </td>
                                            <td class="align-middle">{{ $objective->target }} %</td>
                                            <td class="align-middle">{{ $objective->base_year }}</td>
                                            <td class="align-middle">{{ $objective->target_year }}</td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group-vertical">

                                                    @can('update Ods')
                                                        <a href="{{ route('ods.objective.edit', $objective->token) }}"
                                                            class="btn btn-link" title="Editar">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan

                                                    @can('read Ods')
                                                        <a href="{{ route('ods.objective.evaluate', $objective->token) }}"
                                                            class="btn btn-link" title="Seguimiento">
                                                            <i class="fa-solid fa-clipboard-check"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete Ods')
                                                        <button class="btn btn-link" title="Eliminar">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
@endsection


@push('scripts')

    <script src="{{ url('/') }}/js/tables.js"></script>

    @if (session('status') == 'error')
        <script>
            $(document).ready(() => {
                toastr.error("{{ session('message') }}")
            })
        </script>
    @endif

    @if (session('status') == 'success')
        <script>
            $(document).ready(() => {
                toastr.success("{{ session('message') }}")
            })
        </script>
    @endif
@endpush
