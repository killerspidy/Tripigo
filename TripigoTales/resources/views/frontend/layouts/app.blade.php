<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Travelin - Travel Tour Booking HTML Templates</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />

<!-- Bootstrap core CSS -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Custom CSS -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

<!-- Plugin CSS -->
<link href="{{ asset('css/plugin.css') }}" rel="stylesheet" type="text/css" />

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" />

<!-- Line Icons -->
<link rel="stylesheet" href="{{ asset('fonts/line-icons.css') }}" type="text/css" />

  </head>
<body>
  <!-- Preloader -->
    <div id="preloader" style="display: none !important;">
      <div id="status" style="display: none !important;"></div>
    </div>
    <!-- Preloader Ends -->
@include('frontend.partials.header')

<main style="padding:20px;">
    @yield('content')
</main>

@include('frontend.partials.footer')

<!-- *Scripts* -->
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/fontawesome.min.js') }}"></script>
<script src="{{ asset('js/particles.js') }}"></script>
<script src="{{ asset('js/particlerun.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/main.js') }}?v=2"></script>
<script src="{{ asset('js/custom-swiper.js') }}"></script>
<script src="{{ asset('js/custom-nav.js') }}"></script>

</body>
</html>
