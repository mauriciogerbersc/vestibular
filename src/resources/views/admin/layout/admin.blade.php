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
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="{{asset('assets/css/admin.css')}}" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">AeroTD</a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        
        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

        <form id="logout-form" Daction="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
        </form>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      
      @component('admin.layout.component_navbar', [ "current" => $current ?? '' ]) @endcomponent

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        @yield('conteudo')
      </main>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  @yield('scripts')

</body>

</html>