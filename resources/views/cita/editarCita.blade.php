@extends('layouts.sessionApp')
@section('titulo')
    Editar Cita
@endsection

@section('style') 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.js"></script>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection

@section('contenido')

<hr>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <form action="{{$appURL}}cita" method="POST" class="form">
                @csrf
                @method('PUT')
            
                @foreach ($Cita as $cita)
                    <input type="hidden" name="idCita" id="idCita" value="{{ $cita->id }}">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="paciente">Paciente</label>
                            <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $cita->nombre_paciente }} {{ $cita->apellido_paciente }}" required readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <label for="fecha">Fecha de la Cita *</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ $cita->fecha }}" readonly>
                        </div>
                        <div class="col-5">
                            <label for="hora">Hora *</label>
                            <input type="time" class="form-control" id="hora" name="hora" required value="{{ $cita->hora }}">
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="medico">Médicos</label>
                            <select class="form-control" id="medico" name="medico" required>
                                @foreach($medicos as $medico)
                                    <option value="{{ $medico->id }}" {{ $cita->medico_id == $medico->id ? 'selected' : '' }}>
                                        {{ $medico->nombre_medico }} {{ $medico->apellido_medico }} - {{ $medico->especialidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="estado">Estado *</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Confirmada" {{ $cita->estado == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="Cancelada" {{ $cita->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="motivo_consulta">Descripcion</label>
                            <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="4" required>{{$cita->motivo_consulta}}</textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success" id="btnGuardar">Guardar Cambios</button>
                            <a type="button" class="btn btn-secondary" href="{{route('gestionCitas')}}">volver</a>
                        </div>
                    </div>
            
                @endforeach
            
            </form>
            <div id="status-list">
                <div class="status-item">
                    <div class="status-circle" style="background-color: yellow;"></div>
                    Pendiente
                </div>
                <div class="status-item">
                    <div class="status-circle" style="background-color: green;"></div>
                    Confirmado
                </div>
                <div class="status-item">
                    <div class="status-circle" style="background-color: lightblue;"></div>
                    Atendido
                </div>
                <div class="status-item">
                    <div class="status-circle" style="background-color: red;"></div>
                    Cancelado
                </div>
            </div>
            
            
        </div>
        <div class="col-md-8">
            <div id="calendar"></div>
        </div>
            {{-- modal de deatalles de cita --}}
        <div class="modal fade" id="evento" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div style="max-width: 30%;" class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Cita</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Body
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
@section('script') 
    @include('calendario.calendariojs')
@endsection