@extends('layouts.app')

@section('content')
    <div class="text-left">

        <div class="row mb-2">
            <div class="col-10 my-auto">
                <h2>{{ __('modules.customers') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>{{ __('modules.customers') }}</strong>
                    </li>
                </ol>
            </div>

            <div class="col-2 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
            </div>

        </div>


        <div class="ibox">

            <div class="ibox-title">
                <h5 class="d-inline">{{ __('modules.customers') }}</h5>
                @can('store')
                    <a href="{{ route('customers.create') }}" class="d-inline btn btn-primary">
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
                    <table class="table table-striped table-hover table-bordered js_datatable">
                        <thead>
                            <tr>

                                <th>{{ __('columns.company') }}</th>
                                <th>{{ __('columns.nif') }}</th>
                                <th>{{ __('columns.location') }}</th>
                                <th>{{ __('columns.contact') }}</th>
                                <th>{{ __('columns.email') }}</th>
                                <th>{{ __('columns.phone') }}</th>
                                <th>{{ __('columns.manager') }}</th>
                                <th>{{ __('columns.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr>

                                    <td class="align-middle">{{ $customer->company }}</td>
                                    <td class="align-middle">{{ $customer->nif }}</td>
                                    <td class="align-middle">{{ $customer->location }}</td>
                                    <td class="align-middle">{{ $customer->contact }}</td>
                                    <td class="align-middle">{{ $customer->contact_mail }}</td>
                                    <td class="align-middle">{{ $customer->phone }}</td>
                                    <td class="align-middle">{{ $customer->manager->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group-vertical">

                                            @can('update')
                                                <a href="{{ route('customers.edit', ['token' => $customer->token]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                            @endcan

                                            @can('delete')
                                                <button class="btn btn-link">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            @endcan

                                            @can('impersonate')
                                                <a href="{{ route('user.impersonate', $customer->manager->token) }}"
                                                    class="btn btn-link">
                                                    <i class="fa-solid fa-ghost"></i>
                                                </a>
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
