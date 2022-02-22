@extends('layouts.app')

@section('content')
    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ __('modules.branches') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('branches.index') }}">{{ __('modules.branches') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.create') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('branches.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.create') . ' ' . __('modules.branches') }}</h5>
        </div>
        <div class="ibox-content">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-lg-6">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('forms.name') }}..." value="{{ old('name') }}">
                    </div>

                    <div class="col-lg-6">
                        <label for="location">{{ __('forms.location') }}:</label>
                        <input type="text" name="location" id="location" class="form-control"
                            placeholder="{{ __('forms.location') }}..." value="{{ old('location') }}">
                    </div>

                    <div class="col-lg-6">
                        <input type="hidden" name="coordinates" id="coordinates" value="{{ old('coordinates') }}">
                        MAPA PICKER
                        <div id="map"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>
@endsection
