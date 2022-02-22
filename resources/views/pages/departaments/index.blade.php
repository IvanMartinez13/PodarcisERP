@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.departaments') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.departaments') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('modules.departaments') }}</h5>

            @can('store')
                <a href="{{ route('departaments.create') }}" class="btn btn-primary">{{ __('forms.create') }}</a>
            @endcan

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="container-fluid table-responsive">
                <table class="table table-bordered table-stripped table-hover js_datatable">
                    <thead>
                        <tr>
                            <th>{{ __('columns.name') }}</th>
                            <th>{{ __('columns.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($departaments as $departament)
                            <tr>
                                <td>
                                    {{ $departament->name }}
                                </td>

                                <td>
                                    {{ $departament->name }}
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
