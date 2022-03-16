@extends('layouts.app')

@section('content')

    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ __('modules.vao') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.vao') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ __('modules.vao') }}</h5>

            <a href="{{route('vao.create')}}" class="btn btn-primary">{{__('forms.create')}}</a>

            <div class="ibox-tools">
                <a role="button" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered js_datatable">
                    <thead>
                        <tr>
                            <th>{{__('columns.title')}}</th>
                            <th>{{__('columns.description')}}</th>
                            <th>{{__('columns.starts_at')}}</th>
                            <th>{{__('columns.code')}}</th>
                            <th>{{__('columns.state')}}</th>
                            <th>{{__('columns.actions')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vaos as $vao)
                            <tr>
                                <td class="align-middle">{{$vao->title}}</td>
                                <td class="align-middle">{!!$vao->description!!}</td>
                                <td class="align-middle">{{ date( 'd/m/Y', strtotime($vao->starts_at) ) }}</td>
                                <td class="align-middle">{{$vao->code}}</td>
                                <td class="align-middle text-center">

                                    @switch($vao->state)
                                        @case('pending')
                                            <span class="p-2 rounded bg-success">{{__('Start pending')}}</span>
                                            @break
                                        @case('process')
                                            <span class="p-2 rounded bg-warning">{{__('In process')}}</span>
                                            @break

                                        @case('stopped')
                                            <span class="p-2 rounded bg-danger">{{__('Stopped')}}</span>
                                            @break

                                        @case('finished')
                                            <span class="p-2 rounded bg-primary">{{__('Finished')}}</span>
                                            @break
                                        @default
                                            <span class="p-2 rounded bg-dark">{{__('Not defined')}}</span>
                                             @break
                                    @endswitch
                                    
                                </td>
                                <td class="align-middle text-center">
                                   <div class="btn-group-vertical">
                                       @can('update Vigilancia Ambiental')
                                            <a href="{{route('vao.edit', $vao->token)}}" class="btn btn-link">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                       @endcan

                                       @can('read Vigilancia Ambiental')
                                            <a href="{{route('vao.details', $vao->token)}}" class="btn btn-link">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        @endcan

                                        <button class="btn btn-link">
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
            Podarcis SL. &copy; {{date('Y')}}
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