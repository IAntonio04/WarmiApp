@extends('layouts.sessionApp')
@section('titulo')
    Sala de Espera
@endsection

@section('contenido')
<hr>
<div class="d-md-flex justify-content-md-end">
    
</div>
<div class="mb-4">
</div>
<table class="table">
    <thead>
        <th>ID</th>
        <th>Paciente</th>
        <th>DNI</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Acciones</th>
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
        <td> {{ \Carbon\Carbon::parse($cita->fecha_hora)->locale('es_ES')->isoFormat('LL') }}</td>
        <td>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i a') }}</td>
        <td>
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#detalle{{ $cita->id }}">Detalles <i class="fa-solid fa-circle-info"></i></button>
            
            <a class="btn btn-success" href="/historias-clinicas/crear/{{$cita->paciente_id}}/{{$cita->id}}">
                Comenzar <i class="fa-solid fa-circle-up fa-rotate-90"></i>
            </a>
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