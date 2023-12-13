<div class="modal fade" id="edit{{$usuario->id}}" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addNewModalLabel">Editar Usuario</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form class="input-box"  action="{{$appURL}}usuario" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="userId" value="{{$usuario->id}}">
                  <div class="form-floating mb-3">
                    <input
                      type="text" 
                      class="form-control @error('nombres')  border border-danger @enderror" 
                      name="nombres" 
                      placeholder="nombres"
                      value="{{$usuario->nombres}}"
                    >
                    <label class=" @error('nombres') text-danger @enderror" for="nombres">Nombres *</label>
                    @error('nombres')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                  </div>
                  <div class="form-floating mb-3">
                    <input 
                      type="text" 
                      class="form-control @error('apellidos')  border border-danger @enderror" 
                      name="apellidos" 
                      placeholder="apellidos"
                      value="{{$usuario->apellidos}}"
                    >
                    <label class=" @error('apellidos') text-danger @enderror"  for="apellidos">Apellidos *</label>
                    @error('apellidos')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                  </div>
                  <div class="form-floating mb-3">
                    <input 
                      type="number" 
                      class="form-control @error('dni')  border border-danger @enderror" 
                      name="dni" 
                      placeholder="dni"
                      value="{{$usuario->dni}}"
                    >
                    <label class=" @error('dni') text-danger @enderror"  for="dni">DNI *</label>
                    @error('dni')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo</label>
                    <select class="form-select" name="cargo" required>
                        <option value="Administrador" @if($usuario->cargo === 'Administrador') selected @endif>Administrador</option>
                        <option value="Medico" @if($usuario->cargo === 'Medico') selected @endif>Medico</option>
                        <option value="Recepcionista" @if($usuario->cargo === 'Recepcionista') selected @endif>Recepcionista</option>
                    </select>
                  </div>
                  <div class="mb-3" id="especialidad-container">
                    <label for="especialidad" class="form-label">Especialidad (Solo para Medico*) </label>
                    <select class="form-select" id="especialidad" name="especialidad">
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}" @if($usuario->especialidad_id === $especialidad->id) selected @endif>
                                {{ $especialidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') border border-danger @enderror"
                      name="password" id="password" placeholder="Contraseña">
                    <label class=" @error('password') text-danger @enderror" for="password">Contraseña *</label>
                    @error('password')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                      placeholder="Confirmar Contraseña">
                    <label for="password_confirmation">Confirmar Contraseña *</label>
                  </div>
                    <button class="btn btn-lg btn-primary btn-login mb-2" type="submit">Guardar cambios</button>
                </form>
          </div>
      </div>
  </div>
</div>