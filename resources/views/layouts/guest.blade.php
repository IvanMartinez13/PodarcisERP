<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
    
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    
        <!-- PLUGGINS -->
        <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="{{ url('/') }}/css/plugins/toastr/toastr.min.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
        <link href="{{ url('/') }}/css/style.css" rel="stylesheet">

    </head>
    <body style="overflow: hidden">


        @yield('content')
        <video class="video" src="{{ url('/') }}/videos/podarcis.mp4" autoplay loop muted></video>
        

        <!-- Mainly scripts -->
        <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
        <script src="{{ url('/') }}/js/popper.min.js"></script>
        <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
        <script src="{{ url('/') }}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="{{ url('/') }}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ url('/') }}/js/plugins/toastr/toastr.min.js"></script>

        <script>
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <script>
                    $(document).ready(() => {
                        toastr.error("{{ $error }}")
                    })
                </script>
            @endforeach
        @endif



    </body>
</html>
