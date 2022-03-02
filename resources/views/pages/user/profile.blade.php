@extends('layouts.app')

@section('content')
    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ auth()->user()->name }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ auth()->user()->name }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ auth()->user()->name }}</h5>
                    <div class="ibox-tools">
                        <a href="" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    {{-- USER PHOTO --}}

                    <div class="text-center">
                        @if (auth()->user()->profile_photo)
                            <img id="imgUser" style="width: 200px"
                                src="{{ url('/storage') . auth()->user()->profile_photo }}" alt="">
                        @else
                            <img id="imgUser" style="width: 200px" src="{{ url('/img/user_placeholder.png') }}" alt="">
                        @endif
                    </div>

                    <form action="{{ route('profile.update', auth()->user()->token) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="@error('name') has-error @enderror mb-3">
                            <label for="name">{{ __('forms.name') }}:</label>
                            <input id="name" type="text" name="name" class="form-control"
                                placeholder="{{ __('forms.name') }}..." value="{{ auth()->user()->name }}">
                        </div>
                        <div class="@error('email') has-error @enderror mb-3">
                            <label for="email">{{ __('forms.email') }}:</label>
                            <input id="email" type="email" name="email" class="form-control"
                                placeholder="{{ __('forms.email') }}..." value="{{ auth()->user()->email }}">
                        </div>
                        <div class="@error('password') has-error @enderror mb-3">
                            <label for="password">{{ __('forms.password') }}:</label>
                            <input id="password" type="password" name="password" class="form-control"
                                placeholder="{{ __('forms.password') }}...">
                        </div>


                        <div class="@error('password') has-error @enderror mb-3">
                            <label for="password_confirmation">{{ __('forms.password_confirmation') }}:</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control" placeholder="{{ __('forms.password_confirmation') }}...">
                        </div>

                        <div class="text-left">
                            <button class="btn btn-primary">
                                Guardar
                            </button>


                            <button type="button" class="btn btn-secondary"
                                onclick="showData('password_confirmation', 'password', this)">
                                Mostrar contraseñas
                            </button>
                        </div>
                    </form>




                </div>

                <div class="ibox-footer">
                    Podarcis SL. &copy; {{ date('Y') }}
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ auth()->user()->name }}</h5>
                    <div class="ibox-tools">
                        <a href="" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <form action="{{ route('profile.photo', auth()->user()->token) }}" class="dropzone"
                        id="user-profile-photo" method="POST">
                        @csrf
                        <div class="dz-message" style="height:200px;">
                            Arrastra aqui una imagen.
                        </div>
                        <div class="dropzone-previews"></div>

                    </form>
                </div>

                <div class="ibox-footer">
                    Podarcis SL. &copy; {{ date('Y') }}
                </div>
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

    @if (session('status') == 'error')
        <script>
            $(document).ready(() => {
                toastr.error("{{ session('message') }}")
            })
        </script>
    @endif

    @if (session('status') == 'success')
        <script>
            $(document).ready(() => {
                toastr.success("{{ session('message') }}")
            })
        </script>
    @endif

    <script>
        Dropzone.options.userProfilePhoto = {
            autoProcessQueue: true,
            uploadMultiple: true,
            maxFilezise: 10,
            maxFiles: 1,
            acceptedFiles: ".jpeg, .jpg, .png, .gif",

            init: function() {
                var submitBtn = document.querySelector("#submit");

                myDropzone = this;

                this.on("addedfile", function(file) {
                    console.log(file)

                    var data = new FileReader;
                    data.readAsDataURL(file);

                    $(data).on("load", function(event) {

                        var path = event.target.result;

                        $("#imgUser").attr("src", path);

                    })
                });

                this.on("complete", function(file) {
                    myDropzone.removeFile(file);
                    console.log('hola')
                });

                this.on("success", (file, response) => {
                    toastr.success(response.message)
                    myDropzone.processQueue.bind(myDropzone)
                });
            }
        }

        function showData(password_id, confirm_id, button) {

            if (document.getElementById(password_id).getAttribute('type') == "password") {

                document.getElementById(password_id).setAttribute('type', 'text');
                document.getElementById(confirm_id).setAttribute('type', 'text');
                button.innerHTML = "Ocultar contraseñas"

            } else {
                document.getElementById(password_id).setAttribute('type', 'password');
                document.getElementById(confirm_id).setAttribute('type', 'password');
                button.innerHTML = "Mostrar contraseñas"
            }
        }
    </script>
@endpush
