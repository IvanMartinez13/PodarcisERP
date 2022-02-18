@extends('layouts.app')


@section('content')
    <div class="text-left">
        <div class="row mb-2">
            <div class="col-10 my-auto">
                <h2>{{ __('modules.customers') }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('customers.index') }}">{{ __('modules.customers') }}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>{{ __('forms.create') }}</strong>
                    </li>
                </ol>
            </div>

            <div class="col-2 text-right">
                <a href="{{ route('customers.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
            </div>

        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>{{ __('forms.create') . ' ' . __('modules.customers') }}</h5>

                <div class="ibox-tools">
                    <a class="collapse-link" href="">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="ibox-content">
                <div class="container-fluid">
                    <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row mb-5">

                            <div class="col-lg-4 col-md-6 mt-3 @error('company') has-error @enderror">
                                <label for="company">{{ __('forms.company') }}:</label>
                                <input type="text" name="company" id="company" class="form-control"
                                    placeholder="{{ __('forms.company') }}..." value="{{ old('company') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('nif') has-error @enderror">
                                <label for="nif">{{ __('forms.nif') }}:</label>
                                <input type="text" name="nif" id="nif" class="form-control"
                                    placeholder="{{ __('forms.nif') }}..." value="{{ old('nif') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('location') has-error @enderror">
                                <label for="location">{{ __('forms.location') }}:</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    placeholder="{{ __('forms.location') }}..." value="{{ old('location') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('contact') has-error @enderror">
                                <label for="contact">{{ __('forms.contact') }}:</label>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    placeholder="{{ __('forms.contact') }}..." value="{{ old('contact') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('contact_mail') has-error @enderror">
                                <label for="contact_mail">{{ __('forms.contact_mail') }}:</label>
                                <input type="email" name="contact_mail" id="contact_mail" class="form-control"
                                    placeholder="{{ __('forms.contact_mail') }}..." value="{{ old('contact_mail') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('phone') has-error @enderror">
                                <label for="phone">{{ __('forms.phone') }}:</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="{{ __('forms.phone') }}..." value="{{ old('phone') }}">
                            </div>
                        </div>

                        <hr />

                        <div class="row">

                            <div class="col-lg-4 col-md-6 mt-3 @error('name') has-error @enderror">
                                <label for="name">{{ __('forms.name') }}:</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('forms.name') }}..." value="{{ old('name') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('username') has-error @enderror">
                                <label for="username">{{ __('forms.username') }}:</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="{{ __('forms.username') }}..." value="{{ old('username') }}">
                            </div>



                            <div class="col-lg-4 col-md-6 mt-3 @error('email') has-error @enderror">
                                <label for="email">{{ __('forms.email') }}:</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="{{ __('forms.email') }}..." value="{{ old('email') }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('password') has-error @enderror">
                                <label for="password">{{ __('forms.password') }}:</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('forms.password') }}...">
                            </div>

                            <div class="col-lg-4 col-md-6 mt-3 @error('password') has-error @enderror">
                                <label for="password_confirmation">{{ __('forms.password_confirmation') }}:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="{{ __('forms.password_confirmation') }}...">
                            </div>
                        </div>

                        <div class="row my-5">

                            @foreach ($modules as $module)
                                <div class="col-md-3">
                                    <label for="{{ $module->id }}">{{ $module->name }}:</label> <br />
                                    <input type="checkbox" class="js-switch" id="{{ $module->id }}" name="modules[]"
                                        value="{{ $module->id }}" />
                                </div>
                            @endforeach

                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                {{ __('forms.save') }}
                            </button>
                        </div>


                    </form>
                </div>
            </div>

            <div class="ibox-footer">
                Podarcis SL. &copy; {{ date('Y') }}
            </div>
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

@endpush
