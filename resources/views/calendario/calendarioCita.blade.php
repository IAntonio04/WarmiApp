@extends('layouts.sessionApp')

@section('style') 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.js"></script>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection

@section('titulo')
    Calendario de Citas,  {{auth()->user()->cargo}} : {{auth()->user()->nombres}} {{auth()->user()->apellidos}} 
@endsection

@section('contenido')
<hr>
<div class="row">
    @include('calendario.calendario')
</div>
<style>
    .modal-dialog {
        max-width: 30%;
    }
</style>

@endsection

@section('script') 
    <script>
        let appURL = "{{ $appURL }}";
    </script> 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let formulario = document.querySelector("form");
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: "es",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: appURL+"cita/cita-calendario/Todos/0",
                dateClick: function (info) {
                    formulario.reset();
                    formulario.start.value=info.dateStr;
                    formulario.end.value=info.dateStr;

                    $("#evento").modal("show");
                },
            eventClick:function(info){
                var evento=info.event;
                axios.get(appURL+"calendario/cita/"+info.event.id).
                then((response)=>{
                    var cita = response.data;
                    $("#modalTitleId").text("Detalles de Cita, " + cita.estado);
                    var modalBodyContent = `
                        <p><strong>Fecha y Hora:</strong> ${cita.fecha_hora}</p>
                        <p><strong>Motivo de Consulta:</strong> ${cita.motivo_consulta}</p>
                        <p><strong>Estado:</strong> ${cita.estado}</p>
                        <!-- Agregar más detalles según sea necesario -->

                        <!-- Ejemplo: Detalles del Paciente -->
                        <p><strong>Paciente:</strong> ${cita.paciente.nombres} ${cita.paciente.apellidos}</p>
                        <p><strong>DNI:</strong> ${cita.paciente.dni}</p>
                        
                        <!-- Ejemplo: Detalles del Médico -->
                        <p><strong>Médico:</strong> ${cita.medico.nombres} ${cita.medico.apellidos}</p>
                        <p><strong>Especialidad:</strong> ${cita.medico.especialidad.nombre}</p>
                    `;

                    $(".modal-body").html(modalBodyContent);
                    $("#evento").modal("show");
                    
                })
                .catch(function (error) {
                    console.error('Error al consultar detalles de cita:', error);
                });
            },
                eventContent: function (arg) {
                    return {
                        html: `
                        <div style="background-color: ${arg.event.backgroundColor}; color: ${arg.event.textColor}; padding: 5px;">
                        <div>${formatHour(arg.event.start)} ${arg.event.title}</div>
                        </div>`,
                    };
                },
            });
            calendar.render();
        });
        function formatHour(date) {
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
    </script>
@endsection
