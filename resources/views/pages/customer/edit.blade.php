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
                        <strong>{{ __('forms.edit') }}</strong>
                    </li>
                </ol>
            </div>

            <div class="col-2 text-right">
                <a href="{{ route('customers.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
            </div>

        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>{{ __('forms.edit') . ' ' . __('modules.customers') }}</h5>

                <div class="ibox-tools">
                    <a class="collapse-link" href="">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>

            <div class="ibox-content">
                <div class="container-fluid">
                    <form method="POST" action="{{ route('customers.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <input type="hidden" name="token" value="{{ $customer->token }}">

                        <div class="row mb-5">

                            <div class="col-lg-4 col-md-6 mt-3 @error('company') has-error @enderror">
                                <label for="company">{{ __('forms.company') }}:</label>
                                <input type="text" name="company" id="company" class="form-control"
                                    placeholder="{{ __('forms.company') }}..." value="{{ $customer->company }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('nif') has-error @enderror">
                                <label for="nif">{{ __('forms.nif') }}:</label>
                                <input type="text" name="nif" id="nif" class="form-control"
                                    placeholder="{{ __('forms.nif') }}..." value="{{ $customer->nif }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('location') has-error @enderror">
                                <label for="location">{{ __('forms.location') }}:</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    placeholder="{{ __('forms.location') }}..." value="{{ $customer->location }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('contact') has-error @enderror">
                                <label for="contact">{{ __('forms.contact') }}:</label>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    placeholder="{{ __('forms.contact') }}..." value="{{ $customer->contact }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('contact_mail') has-error @enderror">
                                <label for="contact_mail">{{ __('forms.contact_mail') }}:</label>
                                <input type="email" name="contact_mail" id="contact_mail" class="form-control"
                                    placeholder="{{ __('forms.contact_mail') }}..."
                                    value="{{ $customer->contact_mail }}">
                            </div>


                            <div class="col-lg-4 col-md-6 mt-3 @error('phone') has-error @enderror">
                                <label for="phone">{{ __('forms.phone') }}:</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="{{ __('forms.phone') }}..." value="{{ $customer->phone }}">
                            </div>

                            <div class="col-lg-4 col-md-6 mt-3 @error('phone') has-error @enderror">
                                <label for="active">{{ __('forms.active') }}:</label> <br />
                                <input type="checkbox" class="js-switch" id="active" name="active" value="1"
                                    @if ($customer->active == 1) checked @endif />
                            </div>


                        </div>

                        <div class="row md-5">

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
    </div>
@endsection


@push('scripts')

    @foreach ($modules as $module)
        @foreach ($customer->modules as $customer_module)
            @if ($customer_module->id == $module->id)
                <script>
                    $('#{{ $module->id }}').prop('checked', true);
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
