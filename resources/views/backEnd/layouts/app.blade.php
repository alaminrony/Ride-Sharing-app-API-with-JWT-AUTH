
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper') }}/img/apple-icon.png"> --}}
    {{-- <link rel="icon" type="image/png" href="{{ asset('paper') }}/img/favicon.png"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  
    <title>
        {{ __('FARETRIM') }}
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/7af5dc672b.js" crossorigin="anonymous"></script>
    {{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}
    <!-- CSS Files -->
    <link href="{{ asset('paper') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">

    <link href="{{ asset('paper') }}/demo/demo.css" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/custom.css" rel="stylesheet" />

    {{-- jquery --}}
    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>

</head>

<body class="{{ $class }}">
   @auth()
    <div class="wrapper">
         
        @include('backEnd.layouts.includes.sidebar')

        <div class="main-panel">
        @include('backEnd.layouts.includes.topnavbar')

            {{-- @include('backEnd.layouts.navbars.navs.auth') --}}
            @yield('content')
            @include('backEnd.layouts.includes.footer')
        </div>
    </div>
      @endauth
      @guest
     <div class="wrapper">
         @yield('content')

     </div>
      @endguest


    <!--   Core JS Files   -->
    <script src="{{ asset('paper') }}/js/jscolor.js"></script>
    <script src="{{ asset('paper') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/bootstrap.min.js"></script>
    {{-- <script src="{{ asset('paper') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script> --}}
    <!--  Google Maps Plugin    -->
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
    <!-- Chart JS -->
    <script src="{{ asset('paper') }}/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('paper') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('paper') }}/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('paper') }}/demo/demo.js"></script>
    <!-- Sharrre libray -->
    {{-- <script src="../assets/demo/jquery.sharrre.js"></script> --}}

   
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
    
    <script>
          $(document).ready(function() {
            $('.summernote').summernote({
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
});
});
    </script>
    
    @stack('scripts')

    @include('backEnd.layouts.navbars.fixed-plugin-js')
</body>

</html>
