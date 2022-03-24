<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


    <!-- PLUGGINS -->
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/dataTables/dataTables.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/leaflet/leaflet.css" rel="stylesheet">
    <link src="{{ url('/') }}/js/plugins/leaflet/groupLayerControl/dist/leaflet.groupedlayercontrol.min.css"
        rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href='{{ url('/') }}/js/plugins/leaflet/fullscreen/dist/leaflet.fullscreen.css' rel='stylesheet' />

    <!-- Styles -->
    <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">

    @stack('styles')


</head>

<body class="md-skin">

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
                        <div class="text-left">
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
    <script src="{{ url('/') }}/js/plugins/dataTables/dataTables.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/dataTables/fixedHeader.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/dataTables/colreorder.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/switchery/switchery.js"></script>
    <script src="{{ url('/') }}/js/plugins/bs-custom-file/bs-custom-file-input.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/leaflet.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/groupLayerControl/dist/leaflet.groupedlayercontrol.min.js">
    </script>
    <script src="{{ url('/') }}/js/plugins/toastr/toastr.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/select2/select2.full.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/summernote/summernote-bs4.js"></script>
    <script src="{{ url('/') }}/js/plugins/dropzone/dropzone.js"></script>
    <script src="{{ url('/') }}/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"
        integrity="sha512-xQBQYt9UcgblF6aCMrwU1NkVA7HCXaSN2oq0so80KO+y68M+n64FOcqgav4igHe6D5ObBLIf68DWv+gfBowczg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/shapes/shp.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/shapes/leaflet.shpfile.js"></script>
    <script src='{{ url('/') }}/js/plugins/leaflet/fullscreen/dist/Leaflet.fullscreen.min.js'></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/wms/dist/leaflet.wms.js"></script>


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


    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <script>
        $(document).ready(() => {
            var switches = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            switches.forEach(function(input) {
                var switchery = new Switchery(input, {
                    color: '#1ab394',
                    jackColor: '#f3f3f4'
                });
            });

        })
    </script>

</body>

</html>
