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
            <li><a class="nav-link bg-transparent active" data-toggle="tab" href="#dashboard">Dashboard</a></li>
            <li><a class="nav-link bg-transparent" data-toggle="tab" href="#objective-tab">Creación de objetivos</a></li>
        </ul>
        <div class="tab-content">

            <div role="tabpanel" id="dashboard" class="tab-pane active">
                <div class="panel-body bg-transparent">
                    <div class="animated fadeIn">
                        <dashboard-ods></dashboard-ods>
                    </div>
                </div>
            </div>

            <div role="tabpanel" id="objective-tab" class="tab-pane">
                <div class="panel-body bg-transparent">
                    <div class="animated fadeIn">

                        <div class="ibox animated fadeInRight">
                            <div class="ibox-title">
                                <h5 class="">{{ __('modules.targets') }}</h5>

                                @can('store Ods')
                                    <a href="{{ route('ods.objective.create') }}" class="btn btn-primary">
                                        {{ __('forms.create') }}
                                    </a>
                                @endcan

                                @can('delete Ods')
                                    <a href="{{ route('ods.objective.recover') }}" class="btn btn-secondary">
                                        {{ __('Recover') }}
                                    </a>
                                @endcan

                                <div class="ibox-tools">
                                    <a href="#" class="collapse-link">
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">
                                {{-- PANEL --}}
                                <div class="container-fluid table-responsive">
                                    <table class="table table-hover table-striped table-bordered js_datatable w-100">
                                        <thead>
                                            <tr>
                                                <th style="10%">{{ __('columns.title') }}</th>
                                                <th style="width: 20%">{{ __('columns.description') }}</th>
                                                <th style="width: 15%">{{ __('columns.indicator') }}</th>
                                                <th style="width: 15%">
                                                    {{ __('columns.increase') . ' | ' . __('columns.decrease') }} </th>
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
                                                                <a href="{{ route('ods.strategy.index', $objective->token) }}"
                                                                    class="btn btn-link" title="Estrategias">
                                                                    <i class="fas fa-clipboard-check"></i>
                                                                </a>
                                                            @endcan

                                                            @can('store Tareas')
                                                                <a href="{{ route('ods.objective.toTask', $objective->token) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fa-solid fa-shuffle"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete Ods')
                                                                <a href="{{ route('ods.strategy.recover', $objective->token) }}"
                                                                    class="btn btn-link" title="Recuperar estrategias.">
                                                                    <i class="fa fa-recycle" aria-hidden="true"></i>
                                                                </a>

                                                                <button onclick="remove('{{ $objective->token }}')"
                                                                    class="btn btn-link" title="Eliminar">
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



                    </div>


                </div>
            </div>
        </div>


    </div>


    @foreach ($objectives as $objective)
        <form action="{{ route('ods.objective.delete') }}" id="delete_{{ $objective->token }}" method="POST">
            @csrf
            @method('put')
            <input name="token" type="hidden" value="{{ $objective->token }}">
        </form>
    @endforeach
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

    <script>
        function remove(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this objective!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarlo",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }
    </script>
@endpush
