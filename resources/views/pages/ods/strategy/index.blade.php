@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ $objective->title }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('ods.index') }}">{{ __('modules.targets') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $objective->title }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('ods.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>
                {{ $objective->title }}
            </h5>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">


            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#evaluation-tab">
                            {{ __('Evaluation') }}</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#strategy-tab">{{ __('modules.strategy') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="evaluation-tab" class="tab-pane active">
                        <div class="panel-body">

                            <objective-evaluation objective="{{ json_encode($objective) }}"
                                update="{{ Auth::user()->can('update Ods') }}"
                                delete="{{ Auth::user()->can('delete Ods') }}">
                            </objective-evaluation>
                        </div>
                    </div>
                    <div role="tabpanel" id="strategy-tab" class="tab-pane">
                        <div class="panel-body">
                            <div class="animated fadeInRight">
                                <div class="d-block mb-5">
                                    <h2 class="d-inline h6">
                                        {{ __('modules.strategy') }}
                                    </h2>

                                    @can('store Ods')
                                        <a href="{{ route('ods.strategy.create', $objective->token) }}"
                                            class="btn btn-primary d-inline">
                                            {{ __('forms.create') }}
                                        </a>
                                    @endcan
                                </div>


                                <div class="container-fluid table-responsive">
                                    <table class="table table-hover table-striped table-bordered js_datatable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('columns.title') }}</th>
                                                <th style="width: 25%">{{ __('columns.description') }}</th>
                                                <th>{{ __('columns.indicator') }}</th>
                                                <th style="width: 30%">{{ __('columns.performances') }}</th>
                                                <th>{{ __('columns.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($strategies as $strategy)
                                                <tr>
                                                    <td class="align-middle">{{ $strategy->title }}</td>
                                                    <td class="align-middle">{!! $strategy->description !!}</td>
                                                    <td class="align-middle">{{ $strategy->indicator }}</td>
                                                    <td class="align-middle">{!! $strategy->performances !!}</td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group-vertical">
                                                            @can('update Ods')
                                                                <a href="{{ route('ods.strategy.edit', [$objective->token, $strategy->token]) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                            @endcan

                                                            @can('read Ods')
                                                                <a href="{{ route('ods.objective.evaluate', $strategy->token) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fas fa-clipboard-check"></i>
                                                                </a>
                                                            @endcan

                                                            @can('store Tareas')
                                                                <a href="{{ route('ods.strategy.toTask', $strategy->token) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fa-solid fa-shuffle"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete Ods')
                                                                <a href="{{ route('ods.evaluations.deleted', $strategy->token) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fa-solid fa-recycle"></i>
                                                                </a>
                                                            @endcan




                                                            @can('delete Ods')
                                                                <button onclick="remove('{{ $strategy->token }}')"
                                                                    class="btn btn-link">
                                                                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
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


        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>


    @foreach ($strategies as $strategy)
        <form action="{{ route('ods.strategy.delete') }}" id="delete_{{ $strategy->token }}" method="POST">
            @csrf
            @method('put')

            <input name="token" value="{{ $strategy->token }}" type="hidden">
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
                text: "{{ __('You will not be able to recover this strategy!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }
    </script>
@endpush
