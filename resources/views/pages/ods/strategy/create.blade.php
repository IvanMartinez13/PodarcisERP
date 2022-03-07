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
                    <div class="col-lg-12 mt-3 @error('title') has-error @enderror">
                        <label for="title">{{ __('forms.title') }}:</label>
                        <input type="text" name="title" id="title" placeholder="{{ __('forms.title') }}..."
                            class="form-control" value="{{ old('title') }}">
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

                    <div class="col-lg-4 mt-3 @error('indicator') has-error @enderror">
                        <label for="indicator">{{ __('forms.indicator') }}:</label>
                        <input id="indicator" type="text" name="indicator" class="form-control"
                            placeholder="{{ __('forms.indicator') }}..." value="{{ old('indicator') }}">
                    </div>

                    <div class="col-lg-4 mt-3 @error('increase') has-error @enderror">
                        <label for="increase">{{ __('forms.increase') . ' | ' . __('forms.decrease') }}:</label>
                        <select name="increase" id="increase" class="form-control select2">
                            <option></option>{{-- DEFAULT NULL --}}
                            <option value="1">{{ __('forms.increase') }}</option>
                            <option value="0">{{ __('forms.decrease') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-4 mt-3 @error('target') has-error @enderror">
                        <label for="target">{{ __('forms.target') }}(%):</label>
                        <input id="target" type="number" name="target" class="form-control"
                            placeholder="{{ __('forms.target') }}..." value="{{ old('target') }}" min="0" max="100"
                            step="any">
                    </div>

                    <div class="col-lg-4 mt-3 @error('base_year') has-error @enderror">
                        <label for="base_year">{{ __('forms.base_year') }}:</label>
                        <input id="base_year" type="number" name="base_year" class="form-control"
                            placeholder="{{ __('forms.base_year') }}..." value="{{ old('base_year') }}" min="2000">
                    </div>

                    <div class="col-lg-4 mt-3 @error('target_year') has-error @enderror">
                        <label for="target_year">{{ __('forms.target_year') }}:</label>
                        <input id="target_year" type="number" name="target_year" class="form-control"
                            placeholder="{{ __('forms.target_year') }}..." value="{{ old('target_year') }}"
                            min="2000">
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

        $("#increase").select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona una opcion...",
            allowClear: true
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
