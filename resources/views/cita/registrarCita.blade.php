@extends('layouts.sessionApp')
@section('titulo')
    Registrar Cita
@endsection

@section('style') 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('contenido')

<hr>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-12">
                    <label for="dni">Dni del Paciente</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="dni" name="dni" required>
                        <button type="button" class="btn btn-primary" onclick="buscarCliente()">Buscar</button>
                    </div>
                </div>
            </div>
            
            <div id="mensaje-error" class="row mt-2">
                <div class="col-12">    
                
                </div>
            </div>
            <hr>
            <form action="{{$appURL}}cita" method="POST" class="form">
                <h4>Cita</h4>
                @csrf
                <input type="hidden" name="idPaciente" id="idPaciente">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="paciente @error('idPaciente') border border-danger @enderror">Paciente</label>
                        <input type="text" class="form-control" id="paciente" name="paciente" required readonly>
                        @error('idPaciente')
                            <p class="text-danger">El campo paciente es requerido</p>
                        @enderror
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-7">
                        <label for="fecha">Fecha de la Cita *</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required value="{{ date('Y-m-d') }}" readonly>
                        
                    </div>
                    <div class="col-5">
                        <label for="hora">Hora *</label>
                        <input type="time" class="form-control @error('hora') border border-danger @enderror" id="hora" name="hora" value="08:00" required>
                        @error('hora')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            
                <input value="" type="hidden" name="paciente_id">
            
                <div class="row">
                    <div class="form-group col-12">
                        <label for="medico">Médicos</label>
                        <select class="form-control @error('medico') border border-danger @enderror" id="medico" name="medico" required>
                            @foreach($medicos as $medico)
                                <option value="{{ $medico->id }}" selected>{{ $medico->nombre_medico }} {{ $medico->apellido_medico }} - {{ $medico->especialidad }}</option>
                            @endforeach
                        </select>
                        @error('medico')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="estado">Estado *</label>
                        <select class="form-control @error('estado') border border-danger @enderror" id="estado" name="estado" required>
                            <option value="Pendiente" selected>Pendiente</option>
                        </select>
                        @error('estado')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="motivo_consulta">Motivo de Consulta :</label>
                        <textarea class="form-control @error('motivo_consulta') border border-danger @enderror" id="motivo_consulta" name="motivo_consulta" rows="4"></textarea>
                        @error('motivo_consulta')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" id="btnGuardar">Guardar</button>
                        <a type="button" class="btn btn-secondary" href="{{route('gestionCitas')}}">volver</a>
                    </div>
                </div>
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

@include('paciente.registrarPaciente')
@endsection
@section('script') 
    @include('calendario.calendariojs')
@endsection
