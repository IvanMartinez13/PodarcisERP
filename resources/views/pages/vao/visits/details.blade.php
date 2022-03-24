@extends('layouts.app')

@section('content')
    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ $vao->title }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.index') }}">{{ __('modules.vao') }}</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('vao.details', $vao->token) }}">{{ $vao->title }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $visit->name }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('vao.details', $vao->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li><a class="nav-link bg-transparent active" data-toggle="tab" href="#controls-tab"> {{ __('Controls') }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" id="controls-tab" class="tab-pane active">
                <div class="panel-body bg-transparent animated fadeIn">

                    <div class="animated fadeInLeft">
                        <div class="ibox">

                            <div class="ibox-title">
                                <h5>{{ __('Controls') }}</h5>

                                <button class="btn btn-primary"> {{ __('forms.create') }} </button>

                                <div class="ibox-tools">
                                    <a href="" class="collapse-link">
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">

                                <div class="container-fluid table-responsive">
                                    <table class="table table-hover table-bordered table-striped js_datatable">
                                        <thead>
                                            <tr>
                                                <th>{{ __('columns.name') }}</th>
                                                <th>{{ __('columns.description') }}</th>
                                                <th>{{ __('columns.measures') }}</th>
                                                <th>{{ __('columns.performances') }}</th>
                                                <th>{{ __('columns.target') }}</th>
                                                <th>{{ __('columns.environmental_factor') }}</th>
                                                <th>{{ __('columns.control_place') }}</th>
                                                <th>{{ __('columns.users') }}</th>
                                                <th>{{ __('columns.actions') }}</th>
                                            </tr>
                                        </thead>
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
@endsection

@push('scripts')
    <script src="{{ url('/') }}/js/tables.js"></script>
@endpush
