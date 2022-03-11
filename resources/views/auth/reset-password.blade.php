@extends('layouts.guest')

@section('content')
    <div class="auth_wrapper ibox">
        <div class="ibox-title bg-primary">
            <h5>{{ __('Reset Password')}}</h5>
        </div>
        
        <div class="ibox-content">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="container">
                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <label for="email">{{__('forms.email')}}: </label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="{{__('forms.email')}}..." value="{{$request->email}}">
                        </div>

                        <!-- Password -->
                        <div class="col-12 mb-3">
                            <label for="password"> {{__('Password')}}</label>

                            <input id="password" class="form-control" type="password" name="password" placeholder="{{__('forms.password')}}..." required />
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-12 mb-3">
                            <label for="password_confirmation">{{__('Confirm Password')}}</label>

                            <input id="password_confirmation" class="form-control"
                                                type="password"
                                                name="password_confirmation" placeholder="{{__('forms.password_confirmation')}}..." required />
                        </div>

                        
                    </div>



                    <div class="col-12">
                        <button class="ml-3 btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>

                </div>
            </form>

            
        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy;
        </div>

    
    </div>
@endsection