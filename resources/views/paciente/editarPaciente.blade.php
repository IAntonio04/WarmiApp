<div class="modal fade" id="edit{{$paciente->id}}" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal1Label">Editar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{$appURL}}paciente">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$paciente->id}}">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="nombres" class="form-label">Nombres *</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder="" value="{{$paciente->nombres}}" required>
                        </div>
  
                        <div class="col-sm-12">
                            <label for="apellidos" class="form-label">Apellidos *</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="" value="{{$paciente->apellidos}}" required>
                        </div>

                        <div class="col-5">
                            <label for="dni" class="form-label">DNI *</label>
                            <input type="number" class="form-control" id="dni" name="dni" placeholder="" value="{{$paciente->dni}}">
                        </div>
  
                        <div class="col-7">
                            <label for="fechaNacimiento" class="form-label">Fecha Nacimiento *</label>
                            <input type="date" max="{{date('Y-m-d')}}" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="{{$paciente->fechaNacimiento}}" required>
                        </div>
                        <div class="col-7">
                            <label for="direccion" class="form-label">Dirección *</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="" value="{{$paciente->direccion}}">
                        </div>
                        <div class="col-5">
                            <label for="telefono" class="form-label">Telefono *</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="" value="{{$paciente->telefono}}">
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit"  class="btn btn-warning">Modificar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>