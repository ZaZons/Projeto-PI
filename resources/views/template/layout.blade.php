<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>CINEMATIC</title>
    @vite('resources/sass/app.scss')
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ms-3" href="{{ route('home') }}">
        CINEMATIC
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button>
    @guest
        <ul class="navbar-nav ms-auto me-1 me-lg-3">
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </li>
            @endif
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </li>
            @endif
        </ul>
    @else
        <div class="ms-auto me-0 me-md-2 my-2 my-md-0 navbar-text">
            {{ Auth::user()->name }}
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav me-1 me-lg-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->fullPhotoUrl }}" alt="Avatar" class="bg-dark rounded-circle" width="45"
                         height="45">
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    @if (Auth::user()->tipo == 'C')
                        <li><a class="dropdown-item" href="{{route('clientes.show', ['cliente' => Auth::user()])}}">Perfil</a></li>
                    @endif
                    <li>
                        <a class="dropdown-item"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    @endguest
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link {{ Route::currentRouteName() == 'filmes.index' ? 'active' : '' }}"
                       href="{{ route('filmes.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-film"></i></div>
                        Filmes
                    </a>
                    <a class="nav-link {{ Route::currentRouteName() == 'sessoes.index' ? 'active' : '' }}"
                       href="{{ route('sessoes.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                        Bilhetes
                    </a>
                    <a class="nav-link {{ Route::currentRouteName() == 'historico.index' ? 'active' : '' }}"
                       href="{{ route('historico.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                        Histórico
                    </a>
                    @if(Auth::check() && Auth::user()->tipo === 'C')
                        <div class="sb-sidenav-menu-heading">Espaço Privado</div>
                        <div aria-labelledby="headingOne">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Route::currentRouteName() == 'carrinho.index' ? 'active' : '' }}"
                                   href="{{ route('carrinho.index') }}">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                                    Carrinho
                                </a>
                            </nav>
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->tipo === 'A')
                        <div class="sb-sidenav-menu-heading">Gestão</div>
                        <div aria-labelledby="headingOne">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Route::currentRouteName() == 'clientes.index' ? 'active' : '' }}"
                                   href="{{ route('clientes.index') }}">Clientes</a>
                                <a class="nav-link {{ Route::currentRouteName() == 'funcionarios.index' ? 'active' : '' }}"
                                   href="{{ route('funcionarios.index') }}">Funcionários</a>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @if (session('alert-msg'))
                    @include('shared.messages')
                @endif
                @if ($errors->any())
                    @include('shared.alertValidation')
                @endif
                <h1 class="mt-4">@yield('titulo', 'CINEMATIC')</h1>
                @yield('subtitulo')
                <div class="mt-4">
                    @yield('main')
                </div>
            </div>
        </main>
    </div>
</div>
@vite('resources/js/app.js')
</body>

</html>
