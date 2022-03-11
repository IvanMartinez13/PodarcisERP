<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

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

        {{--NAVBAR LANDING--}}
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">{{env('APP_NAME')}}</a>
            <button style="border: none" class="navbar-toggler border-none btn btn-primary" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{  url('/dashboard') }}" class="nav-link">Dashboard</a>
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
        {{--END NAVBAR LANDING--}}
        
        <header class="header">
            <div id="carousel" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{url('/')}}/img/landing/header_one.jpg" class="d-block mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp">
                            
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                     
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="{{url('/')}}/img/landing/header_two.png" class="d-block  mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp">
                            
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                  </div>
                </div>

              </div>
        </header>


        <main>
            {{-- DASHBOARD --}}
            <div class="container-fluid">
                <div class="container py-5">
                    <div class="row">
    
    
                        <div class="col-md-7 wow fadeInLeft">
                            <img class="img-fluid zoom" src="{{url('/')}}/img/landing/perspective.png" alt="">
                        </div>
    
                        <div class="col-md-5 wow fadeInRight">
                            <p class="mt-5">
                                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo facilis eaque molestias harum iure eos, rerum neque soluta accusamus in fuga voluptatum ipsam libero nulla doloremque nostrum commodi obcaecati ab.
                            </p>
                        </div>
    
                    </div>
                </div>
    
            </div>

                        {{--CHARTS--}}

                        <div class="container-fluid bg-charts">
                            <div class="to-right">
            
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Toda la información a tu alcance</h5>
                                    </div>
                                    <div class="ibox-content">
                                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque error laudantium omnis, vero asperiores doloribus eius ut ipsa nesciunt architecto laboriosam dolore consequatur corporis, saepe consectetur illum, rem ipsam? Quisquam.
                                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque error laudantium omnis, vero asperiores doloribus eius ut ipsa nesciunt architecto laboriosam dolore consequatur corporis, saepe consectetur illum, rem ipsam? Quisquam.
                                    </div>
                                </div>
            
                            </div>
            
            
                        </div>


            {{-- CARACTERISTICAS --}}
            <div class="container-fluid text-center bg-gray">
                <div class="py-5">
                    <h1 class="wow fadeInUp">Características</h1>
                    <div class="m-xl">
                        <div class="row">
    
                            <div class="col-lg-4 col-md-6 my-3 wow fadeInLeft">
         
                                <div class="card-caracteristicas">
        
                                    <h5>CRM</h5>
        
                                    <i class="fa-solid fa-bullseye icon"></i>
        
                                    <hr class="separador" />
        
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
                                
                            </div>
         
                             <div class="col-lg-4 col-md-6 my-3 wow fadeInDown">
                                 
         
                                <div class="card-caracteristicas">
        
                                    <h5>Proyectos</h5>
        
                                    <i class="fa-solid fa-folder icon"></i>
        
                                    <hr class="separador" />
        
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
                             </div>
         
                             <div class="col-lg-4 col-md-6 my-3 wow fadeInRight">
                                 
                                <div class="card-caracteristicas">
        
                                    <h5>Incidencias</h5>
        
                                    <i class="fa-solid fa-triangle-exclamation icon"></i>
        
                                    <hr class="separador" />
        
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
         
                             </div>
         
                             <div class="col-lg-4 col-md-6 my-3 wow fadeInLeft">
                                 
                                <div class="card-caracteristicas">
        
                                    <h5>Equipos de trabajo</h5>
        
                                    
                                    <i class="fa-solid fa-user-group icon"></i>
        
                                    <hr class="separador" />
        
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
                             </div>
         
                             <div class="col-lg-4 col-md-6 my-3 wow fadeInUp">
                                 
    
                                <div class="card-caracteristicas">
    
                                    <h5>ODS</h5>
    
                                    <i class="fa-solid fa-list-check icon"></i>
    
                                    <hr class="separador" />
    
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
                             </div>
         
                             <div class="col-lg-4 col-md-6 my-3 wow fadeInRight">
                                 
    
                                 <div class="card-caracteristicas">
    
                                    <h5>Roles y permisos</h5>
    
                                    <i class="fa-solid fa-user-tag icon"></i>
    
                                    <hr class="separador" />
    
                                    <div class="text-caracteristicas">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda iure deleniti commodi. Omnis voluptate magnam explicabo totam dolores labore consequuntur ab rerum nulla, eum cum aspernatur aperiam, corporis obcaecati cupiditate.
                                    </div>
                                </div>
                             </div>
                            
                        </div>
                    </div>
    
                </div>
    
            </div>


        </main>



        <footer class="p-3 border-top">
            <div class="float-right">
                Todos los derechos reservados.
            </div>
            <div>
                <strong>Copyright</strong> Podarcis SL. &copy; {{ date('Y') }}
            </div>
        </footer>

        <!-- Mainly scripts -->
        <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
        <script src="{{ url('/') }}/js/popper.min.js"></script>
        <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
        <script src="{{ url('/') }}/js/plugins/wow/wow.min.js"></script>
        <script>
            new WOW().init();
            document.addEventListener("DOMContentLoaded", function(){
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 500) {
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
                        // remove padding top from body
                        document.body.style.paddingTop = '0';
                    } 
                });
            }); 
        </script>

    </body>
</html>
