@extends('layouts.sessionApp')
@section('titulo')
    Inicio
    
@endsection

@section('contenido')
<div class="row mb-2">
    @role('Administrador')
    <div class="col-md-4 mb-4">
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static ">
                <strong class="d-inline-block mb-2 text-primary">Administrador</strong>
                <h3 class="mb-0">Gestionar Usuarios</h3>
                <br>
                <a href="{{route('gestionUsuarios')}}" class="stretched-link">Ir a Gestionar Usuarios</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://th.bing.com/th/id/OIP.96Q3YIj8QFKUeM0UGFyovwHaGq?w=1024&h=922&rs=1&pid=ImgDetMain" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    @endrole
    
    @role('Recepcionista|Medico')
    <div class="col-md-4 mb-4">
        <!-- Tarjeta 1 -->
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Gestionar Pacientes</h3>
                <br>
                <a href="{{ route('gestionPacientes') }}" class="stretched-link">Ir a Pacientes</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://fitnesslifestylehealthclub.com/wp-content/uploads/2018/7/improving-communication-with-your-asthma-doctor.jpg" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    @endrole
    @role('Recepcionista|Medico')
    <div class="col-md-4 mb-4">
        <!-- Tarjeta 2 -->
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Gestionar <br> Citas</h3>
                <br>
                <a href="{{ route('gestionCitas') }}" class="stretched-link">Ir a Citas</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://th.bing.com/th/id/OIP.rcm5w3ZiE_CBeI5x--YvPgHaE8?rs=1&pid=ImgDetMain" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    @endrole
    @role('Recepcionista|Administrador')
    <div class="col-md-4 mb-4">
        <!-- Tarjeta 3 -->
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Calendario de Citas</h3>
                <br>
                <a href="{{ route('calendarioCitas') }}" class="stretched-link">Ir a Calendario</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://www.nubimed.com/wp-content/uploads/calendario-gestion-citas.jpg" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    </div>
    @endrole
    

    @role('Medico')
    <div class="col-md-4 mb-4">
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Citas Confirmadas en Espera</h3>
                <br>
                <a href="{{route('salaDeEspera')}}" class="stretched-link">Ir a citas en Espera</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://s-media-cache-ak0.pinimg.com/originals/25/ea/d6/25ead676ea9d47b996eb86fbaf45d978.jpg" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    @endrole
    @role('Medico')
    <div class="col-md-4 mb-4">
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Historia Clinica</h3>
                <br>
                <a href="{{route('gestionCitas')}}" class="stretched-link">Ir a Historia Clinica</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://th.bing.com/th/id/R.fd42fa829a1b49607dffdc69841eb09a?rik=LisQ%2frlRWpFw0Q&pid=ImgRaw&r=0" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    @endrole

    @role('Medico')
    <div class="col-md-4 mb-4">
        <!-- Tarjeta 3 -->
        <div class="card h-md-250 border rounded overflow-hidden flex-md-row shadow-sm position-relative" style="background-color: white;">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">Calendario Medico</h3>
                <br>
                <a href="{{ route('calendarioCitas') }}" class="stretched-link">Ir a Calendario</a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <!-- Reemplazar 'ruta_de_la_imagen' con la ruta de tu imagen -->
                <img src="https://www.nubimed.com/wp-content/uploads/calendario-gestion-citas.jpg" alt="Imagen" width="200" height="250" style="object-fit: cover;">
            </div>
        </div>
    </div>
    </div>
    @endrole
</div>
@endsection
