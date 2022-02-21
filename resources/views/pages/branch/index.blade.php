@extends('layouts.app')

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('modules.branches') }}</h5>
            @can('store')
                <button class="btn btn-primary">
                    {{ __('forms.create') }}
                </button>
            @endcan

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <div class="container-fluid table-responsive">

            </div>
        </div>
        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>
@endsection
