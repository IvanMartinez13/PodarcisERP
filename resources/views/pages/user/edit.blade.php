@extends('layouts.app')

@section('content')
    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ __('modules.users') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">{{ __('modules.users') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.update') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('users.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.update') . ' ' . __('modules.users') }}</h5>

            <div class="ibox-tools">
                <a class="collapse-link" href="">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <input type="hidden" name="token" value="{{ $user->token }}">
                <div class="row">

                    <div class="col-lg-6 mt-3 @error('name') has-error @enderror">
                        <label for="name">{{ __('forms.name') }}:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="{{ __('forms.name') }}..." value="{{ $user->name }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('position') has-error @enderror">
                        <label for="position">{{ __('forms.position') }}:</label>
                        <input type="text" class="form-control" name="position" id="position"
                            placeholder="{{ __('forms.position') }}..." value="{{ $user->position }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('username') has-error @enderror">
                        <label for="username">{{ __('forms.username') }}:</label>
                        <input type="text" class="form-control" name="username" id="username"
                            placeholder="{{ __('forms.username') }}..." value="{{ $user->username }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('email') has-error @enderror">
                        <label for="email">{{ __('forms.email') }}:</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="{{ __('forms.email') }}..." value="{{ $user->email }}">
                    </div>

                    <div class="col-lg-6 mt-3 @error('password') has-error @enderror">
                        <label for="password">{{ __('forms.password') }}:</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="{{ __('forms.password') }}...">
                    </div>

                    <div class="col-lg-6 mt-3 @error('password') has-error @enderror">
                        <label for="password_confirmation">{{ __('forms.password_confirmation') }}:</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" placeholder="{{ __('forms.password_confirmation') }}...">
                    </div>



                </div>


                @foreach ($modules as $module)
                    <h4 class="my-3">{{ $module->name }}</h4>
                    <div class="row">
                        <div class="col-lg-3 mt-3">
                            <label for="store_{{ $module->id }}">{{ __('forms.store') }}:</label>
                            <input type="checkbox" class="js-switch" id="store_{{ $module->id }}"
                                name="permissions[]" value="store {{ $module->name }}" />
                        </div>

                        <div class="col-lg-3 mt-3">
                            <label for="update_{{ $module->id }}">{{ __('forms.update') }}:</label>
                            <input type="checkbox" class="js-switch" id="update_{{ $module->id }}"
                                name="permissions[]" value="update {{ $module->name }}" />

                        </div>

                        <div class="col-lg-3 mt-3">
                            <label for="delete_{{ $module->id }}">{{ __('forms.delete') }}:</label>
                            <input type="checkbox" class="js-switch" id="delete_{{ $module->id }}"
                                name="permissions[]" value="delete {{ $module->name }}" />

                        </div>

                        <div class="col-lg-3 mt-3">
                            <label for="read_{{ $module->id }}">{{ __('forms.read') }}:</label>
                            <input type="checkbox" class="js-switch" id="read_{{ $module->id }}"
                                name="permissions[]" value="read {{ $module->name }}" />
                        </div>
                    </div>
                @endforeach

                <div class="text-right mt-3">
                    <button class="btn btn-primary">
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

    @foreach ($modules as $module)
        @foreach ($permissions as $permission)
            @if ($permission->name == 'store ' . $module->name)
                <script>
                    $('#store_{{ $module->id }}').prop('checked', true);
                </script>
            @endif

            @if ($permission->name == 'update ' . $module->name)
                <script>
                    $('#update_{{ $module->id }}').prop('checked', true);
                </script>
            @endif

            @if ($permission->name == 'delete ' . $module->name)
                <script>
                    $('#delete_{{ $module->id }}').prop('checked', true);
                </script>
            @endif

            @if ($permission->name == 'read ' . $module->name)
                <script>
                    $('#read_{{ $module->id }}').prop('checked', true);
                </script>
            @endif
        @endforeach
    @endforeach

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
