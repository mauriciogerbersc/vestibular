<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="AeroTD vestibular">
       <!-- CSRF Token -->
       <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AEROTD Faculdade de Tecnologia - Inscrição Vestibular</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" crossorigin="anonymous">
    <meta name="theme-color" content="#563d7c">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <link href="{{asset('assets/css/default.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
</head>

<body class="bg-light">
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-4"
                src="https://cdn.shortpixel.ai/client/to_avif,q_glossy,ret_img/https://aerotd.com.br/wp-content/uploads/2020/10/aerotd-faculdade-color-rgb-280x100.png"
                alt="" width="" height="72">
        </div>
    </div>

    @yield('conteudo')

    <div class="container">
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2020 - AeroTD Faculdade de Tecnologia e Escola de Aviação Civil</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://www.facebook.com/AeroTD"><i class="fa fa-facebook"
                            aria-hidden="true"></i></a></li>
                <li class="list-inline-item"><a href="https://twitter.com/aerotd"><i class="fa fa-twitter"
                            aria-hidden="true"></i></a></li>
                <li class="list-inline-item"><a href="https://www.instagram.com/aerotd/"><i class="fa fa-instagram"
                            aria-hidden="true"></i></a></li>
                <li class="list-inline-item"><a href="https://www.youtube.com/c/escolaaviacao"><i class="fa fa-youtube"
                            aria-hidden="true"></i></a></li>
            </ul>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    @yield('scripts')
</body>

</html>