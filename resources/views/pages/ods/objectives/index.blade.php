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

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('modules.targets') }}</h5>

            @can('store Ods')
                <a href="{{ route('ods.objective.create') }}" class="btn btn-primary">
                    {{ __('forms.create') }}
                </a>
            @endcan

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>

        <div class="ibox-content">
            <div class="container-fluid table-responsive">
                <table class="table table-hover table-striped table-bordered js_datatable">
                    <thead>
                        <tr>
                            <th style="10%">{{ __('columns.title') }}</th>
                            <th style="width: 20%">{{ __('columns.description') }}</th>
                            <th style="width: 15%">{{ __('columns.indicator') }}</th>
                            <th style="width: 15%">{{ __('columns.increase') . ' | ' . __('columns.decrease') }}</th>
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

        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
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
