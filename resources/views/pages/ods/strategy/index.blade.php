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
                    <strong>{{ __('modules.strategy') }}</strong>
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
                {{ __('modules.strategy') }}
            </h5>

            @can('store Ods')
                <a href="{{ route('ods.strategy.create', $objective->token) }}" class="btn btn-primary">
                    {{ __('forms.create') }}
                </a>
            @endcan
            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
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

                                        @can('delete Ods')
                                            <a href="{{ route('ods.evaluations.deleted', $strategy->token) }}" class="btn btn-link">
                                                <i class="fa-solid fa-recycle"></i>
                                            </a>
                                        @endcan
                                        
                                        
                                        

                                        @can('delete Ods')
                                            <button class="btn btn-link">
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
