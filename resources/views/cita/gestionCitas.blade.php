@extends('layouts.sessionApp')
@section('titulo')
    Gestión de Citas Médicas
@endsection
@section('contenido')
    <hr>
    <div class="d-md-flex justify-content-md-end">
        <form action="" method="GET" class="d-flex align-items-center">
            <input type="text" name="busqueda" id="busqueda" class="form-control">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="mb-4">
        <a class="btn btn-primary" href="{{route('nuevaCita')}}">Nueva Cita <i class="fa-solid fa-square-plus"></i></a>
        <a class="btn btn-success" href="{{route('gestionCitas')}}">Recargar <i class="fa-solid fa-rotate-right"></i></a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>DNI</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
        <tr>
            <td>{{ $cita->id }}</td>
            <td>{{ $cita->nombre_paciente }} {{ $cita->apellido_paciente }}</td>
            <td>{{ $cita->dni }}</td>
            <td><p class="btn 
                @if($cita->estado == 'Pendiente')
                    btn-warning
                @elseif($cita->estado == 'Confirmada')
                    btn-success
                @elseif($cita->estado == 'Atendida')
                    btn-primary
                @elseif($cita->estado == 'Cancelada')
                    btn-danger
                @endif">
                {{ $cita->estado }}
            </td>
            <td> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i a') }}</td>
            <td>
                <a href="cita/editar/{{ $cita->id }}" class="btn btn-warning">Editar <i class="fas fa-edit"></i></a>
                <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#detalle{{ $cita->id }}">Detalles <i class="fa-solid fa-circle-info"></i></button>
            </td>
        </tr>
        @include('cita.verDetallesCita')
        @endforeach
        </tbody>
    </table>
    <tfoot>
        <tr>
            <td class="row" colspan="1"> {{$citas->links()}} </td>
        </tr>
    </tfoot>
@endsection

