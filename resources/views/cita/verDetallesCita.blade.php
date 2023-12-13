<div class="modal fade" id="detalle{{ $cita->id }}" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal1Label">Detalles de Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID de Cita:</strong> {{ $cita->id }}</p>
                <p><strong>Paciente:</strong> {{ $cita->nombre_paciente }}  {{$cita->apellido_paciente }}</p>
                <p><strong>Fecha de Cita:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('Y-m-d') }}</p>
                <p><strong>Hora de Cita:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i a') }}</p>
                <p><strong>Estado:</strong> {{ $cita->estado  }}</p>
                @foreach ($medicos as $medico)
                    @if ($cita->medico_id == $medico->id)
                        <p><strong>Medico:</strong> {{ $medico->nombre_medico }} {{ $medico->apellido_medico }}</p>
                        <p><strong>Especialidad:</strong> {{ $medico->especialidad }}</p>
                    @endif
                @endforeach 
                <p><strong>Descripción:</strong> {{ $cita->motivo_consulta }}</p>
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
