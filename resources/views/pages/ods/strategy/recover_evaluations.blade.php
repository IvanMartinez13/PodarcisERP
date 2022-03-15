@extends('layouts.app')

@section('content')
<div class="row mb-2">
    <div class="col-10 my-auto">
        <h2>{{ $strategy->title }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('ods.index') }}">{{ __('modules.targets') }}</a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('ods.strategy.index', $strategy->objective->token) }}">{{ $strategy->objective->title }}</a>
                
            </li>

            <li class="breadcrumb-item active">
                <strong>{{__('recover evaluations')}}</strong>
            </li>
        </ol>
    </div>

    <div class="col-2 text-right">
        <a href="{{ route('ods.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
    </div>

</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>{{__('recover evaluations')}}</h5>

        <div class="ibox-tools">
            <a role="button" class="collapse-link">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">

        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered js_datatable">
                <thead>
                    <tr>
                        <th>{{__('columns.year')}}</th>
                        <th>{{__('columns.value')}}</th>
                        <th>{{__('columns.deleted_at')}}</th>
                        <th>{{__('columns.deleted_at_time')}}</th>
                        <th>{{__('columns.actions')}}</th>
                    </tr>
                </thead>
    
                <tbody>
                    @foreach ($deletedEvaluations as $evaluation)
                        <tr>
                            <td class="align-middle">{{$evaluation->year}}</td>
                            <td class="align-middle">{{$evaluation->value}}</td>
                            <td class="align-middle">{{ date('d/m/Y', strtotime($evaluation->deleted_at)) }}</td>
                            <td class="align-middle">{{ date('H:i:s', strtotime($evaluation->deleted_at)) }}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group-vertical">
                                    <button onclick="recover('{{$evaluation->token}}')" class="btn btn-link">
                                        <i class="fa fa-recycle" aria-hidden="true"></i>
                                    </button>
    
                                    <button class="btn btn-link" onclick="remove('{{$evaluation->token}}')">
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

    @foreach ($deletedEvaluations as $evaluation)
        <form id="recover_{{$evaluation->token}}" action="{{route('ods.evaluations.recover')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="token" value="{{$evaluation->token}}">
        </form>

        <form id="delete_{{$evaluation->token}}" action="{{route('ods.evaluations.true_delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="token" value="{{$evaluation->token}}">
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
        function recover(token){
            swal({
                title: "{{__('Are you sure?') }}",
                text: "{{__('You will recover this evaluation!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo recuperarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function () {
                $('#recover_'+token).submit();
                
            });
        }

        function remove(token){
            swal({
                title: "{{__('Are you sure?') }}",
                text: "{{__('You will not be able to recover this evaluation!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function () {
                $('#delete_'+token).submit();
                
            });
        }
    </script>
@endpush