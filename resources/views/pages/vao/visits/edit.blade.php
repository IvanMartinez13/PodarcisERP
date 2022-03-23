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
                    <strong>{{ __('forms.update') . ' ' . __('Visits') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('vao.details', $vao->token) }}"
                class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.update') . ' ' . __('Visits') }}</h5>

            <div class="ibox-tools">
                <a class="collapse-link" role="button">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="mx-5">
                <form action="{{ route('vao.update.visits') }}" method="POST">
                    @csrf
                    @method('put')

                    <input type="hidden" name="token" value="{{ $visit->token }}">

                    <div class="row">
                        <div class="col-lg-6 mb-3 @error('name') has-error @enderror">

                            <label for="name">{{ __('forms.name') }}:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ __('forms.name') }}..." value="{{ $visit->name }}" />
                        </div>

                        <div class="col-lg-6 mb-3 @error('color') has-error @enderror">
                            <label for="color">{{ __('forms.color') }}:</label>
                            <input class="form-control" id="color" name="color"
                                placeholder="{{ __('forms.color') }}..." value="{{ $visit->color }}" />
                        </div>

                        <div class="col-lg-6 mb-3 @error('starts_at') has-error @enderror">

                            <label for="starts_at">{{ __('forms.starts_at') }}:</label>
                            <input type="date" name="starts_at" id="starts_at" class="form-control"
                                placeholder="{{ __('forms.starts_at') }}..." value="{{ $visit->starts_at }}" />
                        </div>


                        <div class="col-lg-6 mb-3 @error('ends_at') has-error @enderror">

                            <label for="ends_at">{{ __('forms.ends_at') }}:</label>
                            <input type="date" name="ends_at" id="ends_at" class="form-control"
                                placeholder="{{ __('forms.ends_at') }}..." value="{{ $visit->ends_at }}" />
                        </div>

                        <div class="col-lg-12 mb-3 @error('users') has-error @enderror">
                            <label for="users">{{ __('forms.users') }}:</label>

                            <select name="users[]" id="users" multiple class="form-control">

                                @foreach ($users as $user)
                                    <option id="option_{{ $user->token }}" value="{{ $user->token }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 mb-3 @error('description') has-error @enderror">
                            <label for="desctiption">{{ __('forms.description') }}:</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="{{ __('forms.description') }}...">{{ $visit->description }}</textarea>
                        </div>

                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">
                            {{ __('forms.update') }}
                        </button>
                    </div>

                </form>
            </div>

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

                placeholder: "{{ __('forms.description') }}...",
                height: 100,
            });

            $('#users').select2({

                placeholder: "{{ __('forms.users') }}...",
                theme: 'bootstrap4',
                allowClear: true
            });

            $('#color').colorpicker();


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

    {{-- SET SELECT VALUE --}}
    @foreach ($users as $user)
        @foreach ($visit->users as $visit_user)
            @if ($user->token == $visit_user->token)
                <script>
                    $('#option_{{ $user->token }}').prop('selected', true);
                </script>
            @endif
        @endforeach
    @endforeach

@endpush
