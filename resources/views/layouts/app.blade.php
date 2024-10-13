<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha512-cOGL6gI01KK2Bws211W8S3COhzrorBbzKvLPWYOVtSEYet3yG1fzJrimtwh8rUyvMy9qjgY2e7Rt6IwyaiX1Mg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" integrity="sha512-x2MVs84VwuTYP0I99+3A4LWPZ9g+zT4got7diQzWB4bijVsfwhNZU2ithpKaq6wTuHeLhqJICjqE6HffNlYO7w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

   

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body id="fundo">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bgnavbar shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/hospitais') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/agendamento') }}">Agendar Cirurgia</a>
                        </li>
                        <!-- <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/hospitais') }}">Hospitais</a>
                        </li> -->
                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/procedimentos') }}">Procedimentos</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/pacientes') }}">Pacientes</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('') }}">Relatórios</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/usuarios') }}">Usuários</a>
                        </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('mensagem-sucesso'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('mensagem-sucesso') }}
            </div>
            @endif

            @if (session('mensagem-erro'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('mensagem-erro') }}
            </div>
            @endif



            @yield('content')
        </main>
    </div>

    @yield('scripts')

    <script>
        var mensagemErro = "{{ session('mensagem-erro') }}";
        var mensagemAlerta = "{{ session('mensagem-alerta') }}";
        var mensagemSucesso = "{{ session('mensagem-sucesso') }}";
    </script>
    <script src="{{ asset('/js/all.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertElement = document.querySelector('.alert-dismissible');

            if (alertElement) {
                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 3000);
            }
        });
    </script>

</body>

</html>