@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.modules') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.modules') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5 class="d-inline">{{ __('modules.modules') }}</h5>
            @can('store')
                <a href="{{ route('modules.create') }}" class="btn btn-primary d-inline">{{ __('forms.create') }}</a>
            @endcan

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="container-fluid table-responsive">
                <table class="table table-striped table-hover table-bordered js_datatable">
                    <thead>
                        <tr>
                            <th>{{ __('columns.icon') }}</th>
                            <th>{{ __('columns.name') }}</th>
                            <th>{{ __('columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                            <tr>
                                <td class="text-center align-middle">
                                    <img src="{{ url('/storage') . $module->icon }}" alt="" style="width: 45px">
                                </td>
                                <td class="align-middle">{{ $module->name }}</td>
                                <td class="text-center align-middle">
                                    <div class="btn-group-vertical">
                                        @can('update')
                                            <a href="{{ route('modules.edit', ['token' => $module->token]) }}"
                                                class="btn btn-link">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        @endcan

                                        @can('delete')
                                            <button type="button" class="btn btn-link">
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
        <div class="ibox-footer">
            Podarcis SL. &copy {{ date('Y') }}
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
