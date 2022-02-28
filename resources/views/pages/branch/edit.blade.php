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
                    <strong>{{ __('forms.edit') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('branches.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.edit') . ' ' . __('modules.branches') }}</h5>

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <form action="{{ route('branches.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="token" value="{{ $branch->token }}">
                <div class="row">
                    <div class="col-lg-6 mt-3 @error('name') has-error @enderror">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('forms.name') }}..." value="{{ $branch->name }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('location') has-error @enderror">
                        <label for="location">{{ __('forms.location') }}:</label>
                        <input type="text" name="location" id="location" class="form-control"
                            placeholder="{{ __('forms.location') }}..." value="{{ $branch->location }}">
                    </div>

                    {{-- SELECT USERS --}}
                    <div class="col-lg-12 mt-3  @error('users') has-error @enderror">
                        <label for="users">{{ __('forms.users') }}:</label>

                        <select type="text" name="users[]" id="users" class="form-control select2"
                            placeholder="{{ __('forms.users') }}..." multiple="true">
                            {{-- SET OPTIONS --}}
                            @foreach ($users as $user)
                                <option id="{{ $user->id }}" value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- COORDINATES MAP --}}
                    <div class="col-lg-12 mt-3  @error('coordinates') has-error @enderror">
                        <label for="coordinates">{{ __('forms.coordinates') }}:</label>
                        <input type="text" name="coordinates" id="coordinates" class="form-control"
                            placeholder="{{ __('forms.coordinates') }}..." value="{{ $branch->coordinates }}">
                    </div>

                    <div class="col-lg-12 mt-3">
                        <div id="map" style="height: 500px"></div>

                    </div>


                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary">
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
    <script src="{{ url('/') }}/js/maps/mapCreate.js"></script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif

    @foreach ($users as $user)
        @foreach ($branch->users as $branch_user)
            @if ($branch_user->id == $user->id)
                <script>
                    $('#{{ $user->id }}').prop('selected', true)
                </script>
            @endif
        @endforeach
    @endforeach

    <script>
        $(document).ready(() => {
            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Selecciona un usuario...",
                allowClear: true
            });

            //SET MAP PIN

            addPin('{{ $branch->coordinates }}')
        });
    </script>
@endpush
