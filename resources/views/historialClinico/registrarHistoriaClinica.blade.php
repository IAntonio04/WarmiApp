@extends('layouts.sessionApp')
@section('titulo')
    Registrar Historia Clinica
@endsection

@section('contenido')
<div class="container mt-5">
    @foreach ($paciente as $paciente)
    <a href="/descargar-documento-inicial/{{$paciente->nombres}} {{ $paciente->apellidos }}" class="btn btn-success" download><i class="fa-solid fa-download"></i> HC Inicial</a>
    <a href="/descargar-documento-perinatal/{{$paciente->nombres}} {{ $paciente->apellidos }}" class="btn btn-info" download><i class="fa-solid fa-download"></i> HC Perinatal</a>
    
    @endforeach
    <hr>

    <div class="container mt-4"  style="overflow-y: auto; max-height: 60vh" >
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-5">
                <div class="col-md-12">
            <h2 class="text-center">Información del Paciente</h2>
            <ul class="list-group">
                <li class="list-group-item"><strong>Nombre:</strong> {{ $paciente->nombres }} {{ $paciente->apellidos }}</li>
                <li class="list-group-item"><strong>DNI:</strong> {{ $paciente->dni }}</li>
                <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fechaNacimiento)->locale('es_ES')->isoFormat('LL') }} </li>
                <li class="list-group-item"><strong>Teléfono:</strong> {{ $paciente->telefono }}</li>
                <li class="list-group-item"><strong>Dirección:</strong> {{ $paciente->direccion }}</li>
            </ul>
        </div>

        <div class="col-md-12 mt-4">
            <h2 class="text-center">Información de la Cita</h2>
            @forelse ($cita as $cita)
            <ul class="list-group">
                <li class="list-group-item"><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->locale('es_ES')->isoFormat('LL') }}, {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i a') }}</li>
                <li class="list-group-item"><strong>Estado:</strong> {{ $cita->estado }}</li>
                <li class="list-group-item"><strong>Motivo de Consulta:</strong> {{ $cita->motivo_consulta }} </li>
            @empty
                <li class="list-group-item">No hay contenido disponible.</li>
            @endforelse
            </ul>
        </div>
        <div class="col-md-12 mt-4">
            <h2 class="text-center">Historias Clínicas Anteriores</h2>
            <ul class="list-group" style="overflow-y: auto; max-height: 200px">
                @forelse ($historiasClinicas as $historiaClinica)
                    <li class="list-group-item">
                        <strong>{{ $historiaClinica->titulo }} : </strong>{{ \Illuminate\Support\Str::limit($historiaClinica->diagnostico, 50, '...') }},
                        {{ \Carbon\Carbon::parse($historiaClinica->created_at)->locale('es_ES')->isoFormat('LL') }}
                        <a href="/descargar-documento-paciente/{{$historiaClinica->archivo_adjunto_path}}" class="btn" download><i class="fa-solid fa-download"></i></a>
                    </li>
                @empty
                    <li class="list-group-item">No hay contenido disponible.</li>
                @endforelse
            </ul>
            
        </div>
    </div>
    <div class="col-md-7">
        <div class="col-md-12">
            <h2 class="text-center">Consulta Actual</h2>
            <form action="{{$appURL}}historia-clinica" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" class="form-control" id="paciente_id" name="paciente_id" value="{{ $paciente->id }}" >
                @if(isset($cita->id))
                    <input type="hidden" class="form-control" id="cita_id" name="cita_id" value="{{ $cita->id }}" required>
                @else
                    <p>No existe una cita asociada*</p>
                @endif
                <div class="row g-3">
                    <div class="col-md-7">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control @error('titulo') border border-danger @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" >
                        @error('titulo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select class="form-select @error('tipo') border border-danger @enderror" id="tipo" name="tipo" >
                            <option value="Inicial">Inicial</option>
                            <option value="Perinatal">Perinatal</option>
                        </select>
                        @error('tipo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-md-12">
                        <label for="archivo_respaldo" class="form-label">Documento:</label>
                        <input type="file" class="form-control @error('archivo_respaldo') border border-danger @enderror" value="{{ old('archivo_respaldo') }}"  id="archivo_respaldo" name="archivo_respaldo" accept=".pdf,.doc,.docx">
                        @error('archivo_respaldo')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-md-12">
                        <label for="diagnostico" class="form-label">Diagnóstico:</label>
                        <textarea class="form-control @error('diagnostico') border border-danger @enderror" id="diagnostico" value="{{ old('diagnostico') }}"  name="diagnostico" style="min-height: 100px" ></textarea>
                        @error('diagnostico')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-md-7 mt-3">
                        <button type="submit" class="btn btn-primary">Guardar Historia Clínica</button>
                    </div>
                </div>
            </form>
            
        </div>
        <div class="col-md-12 mt-4">
            <h2 class="text-center">Documento Médico Actual</h2>
            <embed id="visorPDF" type="application/pdf" width="100%" height="600" readonly>
        </div>
    </div>
</div>
    
    <script>
        const archivoInput = document.getElementById('archivo_respaldo'); // Cambiar a archivo_respaldo
        const visorPDF = document.getElementById('visorPDF');
    
        archivoInput.addEventListener('change', function() {
            const archivo = archivoInput.files[0];
            if (archivo) {
                if (archivo.type === 'application/pdf' || archivo.type === 'application/msword') {
                    const objetoURL = URL.createObjectURL(archivo);
                    visorPDF.setAttribute('src', objetoURL);
                } else {
                    alert('Formato de archivo no válido. Se admiten archivos PDF y DOC.');
                    archivoInput.value = '';
                }
            } else {
                visorPDF.removeAttribute('src');
            }
        });
    </script>
@endsection