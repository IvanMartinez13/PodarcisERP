@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.tasks') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('tasks.index') }}">{{ __('modules.projects') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.edit') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('tasks.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.edit') . ' ' . __('modules.projects') }}</h5>

            <div class="ibox-tools">
                <a href="" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <form action="{{ route('tasks.project.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="token" value="{{ $project->token }}">

                <div class="row">
                    <div class="col-lg-12 mb-3 @error('name') has-error @enderror">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="{{ __('forms.name') }}..." value="{{ $project->name }}">
                    </div>

                    <div class="col-lg-12 mb-3 @error('description') has-error @enderror">
                        <label for="description">{{ __('forms.description') }}:</label>
                        <textarea id="description" class="form-control"
                            name="description">{{ $project->description }}</textarea>
                    </div>

                    <div class="col-lg-6 mb-3 @error('color') has-error @enderror">
                        <label for="color">{{ __('forms.color') }}:</label>
                        <input type="text" id="color" name="color" class="form-control"
                            placeholder="{{ __('forms.color') }}..." value="{{ $project->color }}">

                    </div>

                    <div class="col-lg-6 mb-3 @error('image') has-error @enderror">
                        <label for="image">{{ __('forms.image') }}:</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="image" type="file" name="image" class="custom-file-input">
                                <label class="custom-file-label" for="image">{{ __('forms.image') }}</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('forms.update') }}
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
        $(document).ready(() => {
            $('#description').summernote({

                placeholder: 'Descripción...',
                height: 100,
            });

            $('#color').colorpicker();

            bsCustomFileInput.init();
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
