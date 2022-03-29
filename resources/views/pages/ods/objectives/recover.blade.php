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
                    <a href="{{ route('ods.index') }}">{{ __('modules.targets') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('Recover objetives') }}</strong>
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
                {{ __('Recover objetives') }}
            </h5>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered table-hover table-striped js_datatable">
                    <thead>
                        <tr>
                            <th class="align-middle">{{ __('columns.title') }}</th>
                            <th class="align-middle">{{ __('columns.description') }}</th>
                            <th class="align-middle">{{ __('columns.indicator') }}</th>
                            <th class="align-middle">{{ __('columns.base_year') }}</th>
                            <th class="align-middle">{{ __('columns.target_year') }}</th>
                            <th class="align-middle">{{ __('columns.deleted_at') }}</th>
                            <th class="align-middle">{{ __('columns.deleted_at_time') }}</th>
                            <th class="align-middle">{{ __('columns.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($objectives as $objective)
                            <tr>
                                <td class="align-middle">{{ $objective->title }}</td>
                                <td class="align-middle">{!! $objective->description !!}</td>
                                <td class="align-middle">{{ $objective->indicator }}</td>
                                <td class="align-middle">{{ $objective->base_year }}</td>
                                <td class="align-middle">{{ $objective->target_year }}</td>
                                <td class="align-middle">{{ date('d/m/Y', strtotime($objective->deleted_at)) }}</td>
                                <td class="align-middle">{{ date('H:i:s', strtotime($objective->deleted_at)) }}</td>
                                <td class="align-middle text-center">
                                    <div class="btn-group-vertical">
                                        <button onclick="recover('{{ $objective->token }}')" class="btn btn-link">
                                            <i class="fa fa-recycle" aria-hidden="true"></i>
                                        </button>

                                        <button onclick="remove('{{ $objective->token }}')" class="btn btn-link">
                                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                        </button>
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

    @foreach ($objectives as $objective)
        <form id="recover_{{ $objective->token }}" action="{{ route('ods.objective.recovered') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="token" value="{{ $objective->token }}">
        </form>

        <form id="delete_{{ $objective->token }}" action="{{ route('ods.objective.true_delete') }}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="token" value="{{ $objective->token }}">
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
        function recover(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will recover this objective!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo recuperarlo",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#recover_' + token).submit();

            });
        }

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
