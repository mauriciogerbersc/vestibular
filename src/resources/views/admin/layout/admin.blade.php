<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v3.8.6">
  <title>AEROTD Faculdade de Tecnologia - Inscrição Vestibular</title>
  <!-- Bootstrap core CSS -->

  <!-- vendor css -->
  <link href="{{asset('assets/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('assets/css/dashforge.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/dashforge.dashboard.css')}}">
  @yield('css')
  <style>
    .not-active {
      pointer-events: none;
      cursor: default;
      text-decoration: none;
      color: black;
    }
  </style>
</head>

<body class="page-profile">

  @component('admin.layout.component_navbar', [ "current" => $current ?? '' ]) @endcomponent

  @yield('conteudo')


  <script src="{{asset('assets/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/lib/feather-icons/feather.min.js')}}"></script>
  <script src="{{asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

  <script src="{{asset('assets/js/dashforge.js')}}"></script>

  @yield('scripts')

</body>

</html>