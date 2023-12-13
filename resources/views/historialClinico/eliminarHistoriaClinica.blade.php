<div class="modal fade" id="delete{{$historiaClinica->id}}" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal2Label">Eliminar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{$appURL}}historias-clinicas-eliminar">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{$historiaClinica->id}}">
                    <p>Desea eliminar la historia clínica?</p>
                    <p>Titulo : {{$historiaClinica->titulo}}</p>
                    <p>Paciente : {{ $historiaClinica->paciente->nombres }} {{ $historiaClinica->paciente->apellidos }}</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit"  class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>