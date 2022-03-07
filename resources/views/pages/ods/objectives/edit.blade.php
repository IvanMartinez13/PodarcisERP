@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.ods') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ods.index') }}">{{ __('modules.targets') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.edit') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('ods.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.edit') . ' ' . __('modules.targets') }}</h5>
            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">

            <form action="{{ route('ods.objective.update') }}" method="POST">
                @csrf
                @method('put')

                <input type="hidden" name="token" value="{{ $objective->token }}">
                <div class="row">
                    <div class="col-lg-12 mt-3 @error('title') has-error @enderror">
                        <label for="title">{{ __('forms.title') }}:</label>
                        <input type="text" name="title" id="title" class="form-control"
                            placeholder="{{ __('forms.title') }}..." value="{{ $objective->title }}">
                    </div>

                    <div class="col-lg-12 mt-3  @error('description') has-error @enderror">
                        <label for="description">{{ __('forms.description') }}:</label>
                        <textarea type="text" name="description" id="description" class="form-conteol"
                            placeholder="{{ __('forms.description') }}...">{{ $objective->description }}</textarea>
                    </div>

                    <div class="col-lg-4 mt-3 @error('indicator') has-error @enderror">
                        <label for="indicator">{{ __('forms.indicator') }}:</label>
                        <input id="indicator" type="text" name="indicator" class="form-control"
                            placeholder="{{ __('forms.indicator') }}..." value="{{ $objective->indicator }}">
                    </div>

                    <div class="col-lg-4 mt-3 @error('increase') has-error @enderror">
                        <label for="increase">{{ __('forms.increase') . ' | ' . __('forms.decrease') }}:</label>
                        <select name="increase" id="increase" class="form-control select2">
                            <option></option>{{-- DEFAULT NULL --}}
                            <option value="1" @if ($objective->increase == 1) selected @endif>
                                {{ __('forms.increase') }}</option>
                            <option value="0" @if ($objective->increase == 0) selected @endif>
                                {{ __('forms.decrease') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-4 mt-3 @error('target') has-error @enderror">
                        <label for="target">{{ __('forms.target') }}(%):</label>
                        <input id="target" type="number" name="target" class="form-control"
                            placeholder="{{ __('forms.target') }}..." min="0" max="100" step="any"
                            value="{{ $objective->target }}">
                    </div>

                    <div class="col-lg-4 mt-3 @error('base_year') has-error @enderror">
                        <label for="base_year">{{ __('forms.base_year') }}:</label>
                        <input id="base_year" type="number" name="base_year" class="form-control"
                            placeholder="{{ __('forms.base_year') }}..." value="{{ $objective->base_year }}"
                            min="2000">
                    </div>

                    <div class="col-lg-4 mt-3 @error('target_year') has-error @enderror">
                        <label for="target_year">{{ __('forms.target_year') }}:</label>
                        <input id="target_year" type="number" name="target_year" class="form-control"
                            placeholder="{{ __('forms.target_year') }}..." value="{{ $objective->target_year }}"
                            min="2000">
                    </div>

                </div>

                <div class="text-right">
                    @can('store Ods')
                        <button type="submit" class="btn  btn-white" name="strategy" value="strategy">
                            {{ __('forms.strategy') }}
                        </button>
                    @endcan

                    <button type="submit" class="btn btn-primary">
                        {{ __('forms.edit') }}
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
            height: 100,
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
