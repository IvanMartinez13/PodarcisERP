@extends('layouts.guest')

@section('content')
    <div class="auth_wrapper ibox">
        <div class="ibox-title bg-primary">
            <h5>LOGIN</h5>
        </div>
        
        <div class="ibox-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="username">{{__('forms.username')}}: </label>
                            <input type="text" id="username" class="form-control" name="username" placeholder="{{__('forms.username')}}...">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="password">{{__('forms.password')}}: </label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="{{__('forms.password')}}...">
                        </div>
                    </div>

                    <div class="col-12">
                                    
                        <div class="block">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
            
                            <button class="ml-3 btn btn-primary">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            
        </div>

        <div class="ibox-footer">
            Podarcis SL. &copy;
        </div>

    
    </div>
@endsection