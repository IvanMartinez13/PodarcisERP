<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">


</head>

<body>

    <div id="wrapper">

        {{-- SIDEBAR --}}
        @include('shared.sidebar')

        <div id="page-wrapper" class="gray-bg">
            {{-- TOPNAV --}}
            @include('shared.topnav')

            {{-- CONTENT --}}
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center m-t-lg">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            @include('shared.footer')

            <form id="logout_form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/') }}/js/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ url('/') }}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('/') }}/js/inspinia.js"></script>
    <script src="{{ url('/') }}/js/plugins/pace/pace.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>
