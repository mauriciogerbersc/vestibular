@if(Auth::user())
<header class="navbar navbar-header navbar-header-fixed">
  <a href="/admin" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
  <div class="navbar-brand">
    <a href="/admin" class="df-logo">AeroTD</a>
  </div><!-- navbar-brand -->
  <div id="navbarMenu" class="navbar-menu-wrapper">
    <div class="navbar-menu-header">
      <a href="/admin" class="df-logo">AeroTD</a>
      <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
    </div><!-- navbar-menu-header -->
    <ul class="nav navbar-menu">

      <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Menu Navegação</li>
      <li class='nav-item @if($current=="dashboard")active @endif'><a href="/admin" class="nav-link">Página Inicial</a></li>
      <li class='nav-item with-sub  @if($current=="cursos")active @endif'>
        <a href="" class="nav-link"><i data-feather="package"></i> Cursos</a>
        <ul class="navbar-menu-sub">
          <li class="nav-sub-item"><a href="/admin/cursos" class="nav-sub-link"><i data-feather="calendar"></i>Listar Cursos</a></li>
          <li class="nav-sub-item"><a href="{{ route('criar_curso') }}" class="nav-sub-link"><i data-feather="message-square"></i>Criar Curso</a></li>
        </ul>
      </li>

      <li class='nav-item with-sub  @if($current=="temas")active @endif'>
        <a href="" class="nav-link"><i data-feather="package"></i> Temas</a>
        <ul class="navbar-menu-sub">
          <li class="nav-sub-item"><a href="/admin/redacao-temas" class="nav-sub-link"><i data-feather="calendar"></i>Listar Temas</a></li>
          <li class="nav-sub-item"><a href="{{ route('criar_tema') }}" class="nav-sub-link"><i data-feather="message-square"></i>Criar Tema</a></li>
        </ul>
      </li>

      <li class='nav-item @if($current=="redacoes")active @endif'><a href="/admin/redacoes" class="nav-link"> Redações Alunos</a></li>
      <li class='nav-item @if($current=="inscritos")active @endif'><a href="/admin/inscritos" class="nav-link"> Inscrições Gerais</a></li>
     
      <li class='nav-item with-sub  @if($current=="users")active @endif'>
        <a href="" class="nav-link"><i data-feather="package"></i> Administrativo</a>
        <ul class="navbar-menu-sub">
          <li class="nav-sub-item"><a href="/admin/processoSeletivo" class="nav-sub-link"><i data-feather="calendar"></i>Processos Seletivos</a></li>
          <li class="nav-sub-item"><a href="/admin/usuarios" class="nav-sub-link"><i data-feather="calendar"></i>Usuários</a></li>
          <li class="nav-sub-item"><a href="/admin/usuarios/create" class="nav-sub-link"><i data-feather="message-square"></i>Novo Usuário</a></li>
        </ul>
      </li>

      
  
    </ul>
  </div><!-- navbar-menu-wrapper -->
  <div class="navbar-right">

    <div class="dropdown dropdown-profile">
      <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
        <div class="avatar avatar-sm">
          <img src="https://via.placeholder.com/500" class="rounded-circle" alt="">
        </div>
      </a><!-- dropdown-link -->
      <div class="dropdown-menu dropdown-menu-right tx-13">
        <div class="avatar avatar-lg mg-b-15"><img src="https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
        <h6 class="tx-semibold mg-b-5">{{ Auth::user()->name ?? '' }}</h6>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          {{ __('Sair do Sistema') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>


      </div><!-- dropdown-menu -->
    </div><!-- dropdown -->
  </div><!-- navbar-right -->

</header><!-- navbar -->
@endif