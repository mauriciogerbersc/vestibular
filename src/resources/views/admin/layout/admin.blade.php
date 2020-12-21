<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="AeroTD">
  <meta property="fb:app_id" content="124285848214697" />
  <meta name="og:image" content="https://aerotd.com.br/wp-content/uploads/2020/10/aerotd-faculdade-color-rgb-280x100.png">


  <meta name="twitter:title" content="Venha fazer parte da AeroTD">
  <meta name="twitter:description" content="Para quem não sabe e sou aluno da AEROTD. Achei o curso de altíssimo nível e acho que você também vai gostar! Esta eu indico! Acesse o link para ganhar desconto!">
  <meta name="twitter:image:src" content="https://aerotd.com.br/wp-content/uploads/2020/10/aerotd-faculdade-color-rgb-280x100.png">
  <meta name="twitter:site" content="@AeroTD">
  <meta name="twitter:card" content="summary_large_image">

  <title>AEROTD Faculdade de Tecnologia - Inscrição Vestibular</title>
  <!-- Bootstrap core CSS -->

  <!-- vendor css -->
  <link href="{{asset('assets/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

  @yield('css')

  <link rel="stylesheet" href="{{asset('assets/css/dashforge.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/dashforge.dashboard.css')}}">

  <style>
    .not-active {
      pointer-events: none;
      cursor: default;
      text-decoration: none;
      color: black;
    }
  </style>

  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId: '299598081472424',
        autoLogAppEvents: true,
        xfbml: true,
        version: 'v2.10'
      });
      FB.AppEvents.logPageView();
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {
        return;
      }
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
</head>

<body class="page-profile">

  @component('admin.layout.component_navbar', [ "current" => $current ?? '' ]) @endcomponent

  @yield('conteudo')


  <script src="{{asset('assets/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/lib/feather-icons/feather.min.js')}}"></script>
  <script src="{{asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/lib/jqueryui/jquery-ui.min.js')}}"></script>

  <script src="{{asset('assets/js/dashforge.js')}}"></script>

  @yield('scripts')

</body>

</html>