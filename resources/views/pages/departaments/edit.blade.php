@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.departaments') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('departaments.index') }}">{{ __('modules.departaments') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.edit') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('departaments.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.edit') . ' ' . __('modules.departaments') }}</h5>

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">

            <form action="{{ route('departaments.update') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="token" value="{{ $departament->token }}">
                <div class="row">
                    <div class="col-lg-6 mt-3 @error('name') has-error @enderror">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="{{ __('forms.name') }}..." value="{{ $departament->name }}">
                    </div>

                    {{-- SELECT BRANCHES --}}
                    <div class="col-lg-6 mt-3 @error('branches') has-error @enderror">
                        <label for="branches">{{ __('forms.branches') }}:</label>
                        <select type="text" name="branches[]" id="branches" class="form-control select2"
                            placeholder="{{ __('forms.branches') }}..." multiple="true">
                            @foreach ($branches as $branch)
                                @foreach ($departament->branches as $departament_branch)
                                    @if ($departament_branch->id == $branch->id)
                                        @php
                                            $checked = true;
                                            
                                        @endphp
                                    @break

                                @else
                                    @php
                                        $checked = false;
                                        
                                    @endphp
                                @endif
                            @endforeach
                            <option value="{{ $branch->id }}" @if ($checked) selected @endif>
                                {{ $branch->name }}</option>
                        @endforeach

                    </select>
                </div>

                {{-- SELECT USERS --}}
                <div class="col-lg-6 mt-3 @error('users') has-error @enderror">
                    <label for="users">{{ __('forms.users') }}:</label>
                    <select type="text" name="users[]" id="users" class="form-control select2"
                        placeholder="{{ __('forms.branches') }}..." multiple="true">
                        @foreach ($departament->users as $user)
                            <option value="{{ $user->id }}" selected>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


            </div>

            <div class="text-right">
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


@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(document).ready(() => {
                toastr.error("{{ $error }}")
            })
        </script>
    @endforeach
@endif

<script>
    var branches = [];
    var branches_selected = [];
    var users_options = [];

    $(document).ready(() => {

        $("#users").select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona un usuario...",
            allowClear: true
        });

        $("#branches").select2({
            theme: 'bootstrap4',
            placeholder: "Selecciona un centro...",
            allowClear: true
        });


    });
</script>

@foreach ($branches as $branch)
    <script>
        var branch = {
            id: Number("{{ $branch->id }}"),
            name: "{{ $branch->name }}",
            users: [],
        }

        //branches.push()
    </script>

    @foreach ($branch->users as $user)
        <script>
            branch.users.push({
                id: Number("{{ $user->id }}"),
                name: "{{ $user->name }}"
            })
        </script>
    @endforeach

    <script>
        branches.push(branch);
    </script>
@endforeach


{{-- AJAX --}}
<script src="{{ url('/') }}/js/ajax/departamentosForm.js"></script>
@endpush
