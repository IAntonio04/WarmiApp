<script>
    let appURL = "{{ $appURL }}";
</script>
<script>
    function buscarCliente() {
        var dni = document.getElementById('dni').value;
        axios.get(appURL+'paciente/buscar/' + dni)
            .then(function (response) {
                paciente = response.data;
                if (typeof paciente.nombres !== 'undefined' && paciente.nombres !== null) {
                    console.log(paciente.nombres);
                    document.getElementById('paciente').value = paciente.nombres + " " + paciente.apellidos;
                    document.getElementById('idPaciente').value = paciente.id;
                    document.getElementById('mensaje-error').innerHTML = '';
                } else {
                    document.getElementById('mensaje-error').innerHTML = '<p class="text-danger">No se encontró paciente con ese DNI <a class="" data-bs-toggle="modal" data-bs-target="#create">registrar Paciente?</a></p>';
                }
            })
            .catch(function (error) {
                console.error('Error al buscar cliente:', error);
            });
    }
 
    document.addEventListener('DOMContentLoaded', function () {
        let formulario = document.querySelector("form");
        const calendarEl = document.getElementById('calendar');
        let idMedico = formulario.querySelector('#medico').value;
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: "es",
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: appURL+"cita/cita-calendario/Pendiente/" + idMedico,
            dateClick: function (info) {
                formulario.fecha.value = info.dateStr;
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
            validRange: {
                start: new Date().toISOString().split("T")[0],
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

        document.getElementById("medico").addEventListener("change", function () {
            idMedico = this.value;
            calendar.destroy();
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: "es",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: appURL+"cita/cita-calendario/Pendiente/" + idMedico,
                dateClick: function (info) {
                    formulario.fecha.value = info.dateStr;
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
                validRange: {
                    start: new Date().toISOString().split("T")[0], 
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
            console.log('idMedico seleccionado:', idMedico);
        });
        function formatHour(date) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    });
</script>