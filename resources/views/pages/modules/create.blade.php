@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.modules') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('modules.index') }}">{{ __('modules.modules') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.create') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('modules.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.create') . ' ' . __('modules.modules') }}</h5>

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>

        <div class="ibox-content">

            <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-md-6 @error('name') has-error @enderror">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="{{ __('forms.name') }}...">
                    </div>

                    <div class="col-md-6 @error('icon') has-error @enderror">
                        <label for="name">{{ __('forms.icon') }}:</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="icon" type="file" name="icon" class="custom-file-input">
                                <label class="custom-file-label" for="icon">{{ __('forms.icon') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('forms.save') }}
                    </button>
                </div>

            </form>
        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy; {{ date('Y') }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init()
        })
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif
@endpush
