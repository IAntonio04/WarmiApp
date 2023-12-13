<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo') - Warmi'A </title>
    {{-- boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- boxicons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{-- fuente letra --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    {{-- calendario --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon-16x16.png') }}">
    @yield('style')
</head>
<body class="">
  
      <div class="main-container d-flex">
        {{-- inicio dashboard --}}
        <div class="sidebar" id="side_nav">
            <div class="header-box pt-3 px-4 pb-4 d-flex justify-content-between">
                {{-- logo --}}
                <h1 class="fs-4">
                    <img class="logo" src="{{ asset('img/logo-app.jpg') }}" alt="" width="200" height="70">
                </h1>
            </div>
            <ul class="list-unstyled px-2">
                <li class="{{ request()->is('inicio') ? 'active' : '' }}">
                    <a href="{{ route('inicio') }}" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </li>
                @role('Administrador')
                <li class="mt-3">
                    <hr class="h-color mx-2">
                    <p class="px-3 d-block">Control</p>
                    
                    <li class="{{ request()->is('usuario') ? 'active' : '' }}">
                        <a href="{{ route('gestionUsuarios') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa fa-list"></i> Gestion de Usuarios
                        </a>
                    </li>
                </li>
                @endrole
                
                @role('Recepcionista|Medico')
                <li class="mt-3">
                    <hr class="h-color mx-2">
                    <p class="px-3 d-block">Control</p>
                    <li class="{{ request()->is('paciente') ? 'active' : '' }}">
                        <a href="{{ route('gestionPacientes') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa-solid fa-hospital-user"></i> Gestion de Pacientes
                        </a>
                    </li>
                    <li class="{{ request()->is('cita','cita/*') ? 'active' : '' }}">
                        <a href="{{ route('gestionCitas') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa-solid fa-calendar-check"></i> Gestion de Citas
                        </a>
                    </li>
                @endrole
                    @role('Medico')
                    <li class="{{ request()->is('sala-espera','sala-espera/*') ? 'active' : '' }}">
                        <a href="{{ route('salaDeEspera') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa-solid fa-hourglass-start"></i> Sala de Espera
                        </a>
                    </li>
                </li>
                <li class="mt-3">
                    <hr class="h-color mx-2">
                    <p class="px-3 d-block">Documentos</p>
                    
                    <li class="{{ request()->is('historias-clinicas','historias-clinicas/*','historia-clinica/*') ? 'active' : '' }}">
                        <a href="{{ route('historialClinico') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa-solid fa-folder-open"></i> Historias Clinicas
                        </a>
                    </li>
                </li>
                @endrole

                @role('Recepcionista|Administrador|Medico')
                <li class="mt-3">
                    <hr class="h-color mx-2">
                    <p class="px-3 d-block">Otros</p>
                    
                    <li class="{{ request()->is('calendario-citas') ? 'active' : '' }}">
                        <a href="{{ route('calendarioCitas') }}" class="text-decoration-none px-3 py-2 d-block">
                            <i class="fa fa-calendar"></i> Calendario de Citas
                        </a>
                    </li>
                </li>
                @endrole
            </ul>
            
            <hr class="h-color mx-2">
            
            <ul class="list-unstyled px-2">
                <li class="">
                    <a href="{{ route('cerrarSesion') }}" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesion
                    </a>
                </li>
            </ul>
            

        </div>
            {{-- Fin dashboard --}}
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent" style="height:70px">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <p class="nav-link active" aria-current="page"><strong>{{ auth()->user()->cargo }} </strong>
                                <br>
                                {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} | <a href="{{route('cerrarSesion')}}">Cerrar Sesión</a>
                            </li>
                            <li class="nav-item">
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>

            <main class="dashboard-content px-3 pt-4">
                <h4>@yield('titulo')</h4>
                <div>
                    @yield('contenido')
                </div>
            </main>
      </div>
  </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @if (Session::has('message') && Session::has('type'))
    <script>
        @php
            $type = Session::get('type');
            $message = Session::get('message');
        @endphp
        @if($type == 'success')
            toastr.success("{{ $message }}", null, {
                positionClass: 'toast-bottom-left',
                progressBar: true
            }); 
        @elseif($type == 'info')
            toastr.info("{{ $message }}", null, {
                positionClass: 'toast-bottom-left',  
                progressBar: true
            });
        @elseif($type == 'error')
            toastr.error("{{ $message }}", null, {
                positionClass: 'toast-bottom-left',
                progressBar: true
            });
        @endif
    </script>
@endif
    <script>
        @if (session('open_modal'))
            $(document).ready(function() {
                $('#create').modal('show');
            });
        @endif
    </script>
    @yield('script')
</body>
</html>