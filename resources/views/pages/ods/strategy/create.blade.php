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

                <li class="breadcrumb-item">
                    <a href="{{ route('ods.strategy.index', $objective->token) }}">{{ __('modules.strategy') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.create') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('ods.strategy.index', $objective->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>
    </div>

    <div class="ibox">

        <div class="ibox-title">
            <h5>
                {{ __('forms.create') . ' ' . __('modules.strategy') }}
            </h5>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <form action="{{ route('ods.strategy.store', $objective->token) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-lg-6 mt-3 @error('title') has-error @enderror">
                        <label for="title">{{ __('forms.title') }}:</label>
                        <input type="text" name="title" id="title" placeholder="{{ __('forms.title') }}..."
                            class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('indicator') has-error @enderror">
                        <label for="indicator">{{ __('forms.indicator') }}:</label>
                        <input type="text" name="indicator" id="indicator" placeholder="{{ __('forms.indicator') }}..."
                            class="form-control" value="{{ old('indicator') }}">
                    </div>

                    <div class="col-lg-6 mt-3  @error('description') has-error @enderror">
                        <label for="description">{{ __('forms.description') }}:</label>
                        <textarea type="text" name="description" id="description" class="form-conteol"
                            placeholder="{{ __('forms.description') }}...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-lg-6 mt-3  @error('performances') has-error @enderror">
                        <label for="performances">{{ __('forms.performances') }}:</label>
                        <textarea type="text" name="performances" id="performances" class="form-conteol"
                            placeholder="{{ __('forms.performances') }}...">{{ old('performances') }}</textarea>
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('forms.create') }}
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
        $('#description').summernote({
            placeholder: 'Descripción...',
            height: 200,
        });

        $('#performances').summernote({
            placeholder: 'Actuaciones...',
            height: 200,
        });
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
