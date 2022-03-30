<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


    <!-- PLUGGINS -->
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/landing.css" rel="stylesheet">

</head>

<body class="bg-white">



    <header class="header">
        {{-- NAVBAR LANDING --}}
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark bg-primary nav-init">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button style="border: none" class="navbar-toggler border-none btn btn-primary" type="button"
                data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>


                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>


            </div>
        </nav>
        {{-- END NAVBAR LANDING --}}
        <div id="carousel" class="carousel slide " data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ url('/') }}/img/landing/header_one.jpg" class="d-block mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">

                            <p>
                                El programa de gestión que tiene todo lo que necesitas… donde
                                quieras y cuando quieras.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ url('/') }}/img/landing/header_two.png" class="d-block  mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">

                            <p>
                                Libera tu potencial de crecimiento con {{ env('APP_NAME') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>


    <main>
        {{-- DASHBOARD --}}
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-7 wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.5s">
                        <img class="img-fluid zoom" src="{{ url('/') }}/img/landing/perspective.png" alt="">
                    </div>

                    <div class="col-md-5 wow fadeInRight" data-wow-duration="2s" data-wow-delay="0.5s">
                        <p class="mt-5">

                            Contamos con un panel de gestión y una interfaz de usuario muy intuitiva y amigable. De esta
                            manera podrás ser el doble de eficaz en la mitad de tiempo.
                        </p>
                    </div>

                </div>
            </div>

        </div>

        {{-- CHARTS --}}

        <div class=" bg-charts">
            <div class="bg-transparentDark">
                <div class="to-right">

                    <div class="glassCard">
                        <h3 class="text-center">
                            Toda la información a tu alcance.
                        </h3>

                        <hr class="border-white">

                        Con nuestro dashboard podrás observar de una manera rápida y detallada.
                    </div>

                </div>
            </div>



        </div>


        {{-- CARACTERISTICAS --}}
        <div class="container-fluid text-center bg-gray">
            <div class="py-5">
                <h1 class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">Características</h1>
                <div class="m-xl">
                    <div class="row">

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.5s">

                            <div class="card-caracteristicas">

                                <h5>CRM</h5>

                                <i class="fa-solid fa-bullseye icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInDown" data-wow-duration="2s" data-wow-delay="0.5s">


                            <div class="card-caracteristicas">

                                <h5>Proyectos</h5>

                                <i class="fa-solid fa-folder icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInRight" data-wow-duration="2s"
                            data-wow-delay="0.5s">

                            <div class="card-caracteristicas">

                                <h5>Incidencias</h5>

                                <i class="fa-solid fa-triangle-exclamation icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.5s">

                            <div class="card-caracteristicas">

                                <h5>Equipos de trabajo</h5>


                                <i class="fa-solid fa-user-group icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">


                            <div class="card-caracteristicas">

                                <h5>ODS</h5>

                                <i class="fa-solid fa-list-check icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 my-3 wow fadeInRight" data-wow-duration="2s"
                            data-wow-delay="0.5s">


                            <div class="card-caracteristicas">

                                <h5>Roles y permisos</h5>

                                <i class="fa-solid fa-user-tag icon"></i>

                                <hr class="separador" />

                                <div class="text-caracteristicas">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti
                                    commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum
                                    nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        {{-- UN PROBLEMA UNA APLICACION --}}
        <div class="container-fluid bg-primary">

            <div class="mx-lg-5 py-5 bg-light text-dark">
                <h1 class="text-center">Un problema, una app</h1>

                <p class="text-center">AQUI MOSTRARIAMOS LOS MÓDULOS DE LA APP</p>
            </div>

        </div>

    </main>



    <footer>

        <div class="py-3 px-5 border-top-dark bg-dark text-white">

            <div class="pt-5">
                <div class="row">
                    <div class="col-lg-4">
                        <h3>{{ env('APP_NAME') }}</h3>

                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum exercitationem, earum sed
                            ratione et maxime tenetur labore vel facilis placeat. Nam temporibus aut, fugiat
                            consequuntur dolorem incidunt voluptate similique dolore.</p>
                    </div>

                    <div class="col-lg-8">
                        <h3 class="text-center">Contáctanos</h3>

                        <div class="container-form" style="width: 50%; margin: 0 25%;">
                            <div class="mb-3">
                                <label for="name">{{ __('forms.name') }}:</label>
                                <input type="text" id="name" name="name" placeholder="{{ __('forms.name') }}..."
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="email">{{ __('forms.email') }}:</label>
                                <input type="email" id="email" name="email" placeholder="{{ __('forms.email') }}..."
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="message">{{ __('forms.message') }}:</label>
                                <textarea rows="10" type="text" id="message" name="message" placeholder="{{ __('forms.message') }}..."
                                    class="form-control"></textarea>
                            </div>

                            <button class="btn btn-primary">
                                Guardar
                            </button>



                        </div>

                    </div>
                </div>
            </div>

            <div class="pt-5">

                <div class="float-right">
                    Todos los derechos reservados.
                </div>
                <div>
                    <strong>Copyright</strong> Podarcis SL. &copy; {{ date('Y') }}
                </div>

            </div>


        </div>





    </footer>

    <!-- Mainly scripts -->
    <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/') }}/js/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/wow/wow.min.js"></script>
    <script>
        new WOW().init();
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 500) {
                    document.getElementById('navbar_top').classList.remove('nav-init');
                    document.getElementById('navbar_top').classList.add('fixed-top');
                    document.getElementById('navbar_top').classList.add('animated-fast');
                    document.getElementById('navbar_top').classList.add('slideInDown');
                    document.getElementById('navbar_top').classList.add('bg-primary');

                    // add padding top to show content behind navbar
                    navbar_height = document.querySelector('.navbar').offsetHeight;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    document.getElementById('navbar_top').classList.remove('fixed-top');
                    document.getElementById('navbar_top').classList.remove('animated-fast');
                    document.getElementById('navbar_top').classList.remove('slideInDown');
                    document.getElementById('navbar_top').classList.add('nav-init');
                    // remove padding top from body
                    document.body.style.paddingTop = '0';
                }
            });
        });
    </script>

</body>

</html>
