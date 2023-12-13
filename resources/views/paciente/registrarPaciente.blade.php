<div class="modal fade" id="create" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addNewModalLabel">Registrar Paciente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{$appURL}}paciente">
                @csrf
                <div class="row g-3">
                    <div class="col-sm-12">
                        <label class="@error('nombres') text-danger @enderror" for="nombres">Nombres *</label>
                        <input 
                            type="text" 
                            class="form-control @error('nombres') border border-danger @enderror" 
                            id="nombres" 
                            name="nombres" 
                            value="{{ old('nombres') }}" 
                        >
                        @error('nombres')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-sm-12">
                        <label class="@error('apellidos') text-danger @enderror" for="apellidos">Apellidos *</label>
                        <input 
                            type="text" 
                            class="form-control @error('apellidos') border border-danger @enderror" 
                            id="apellidos" 
                            name="apellidos" 
                            value="{{ old('apellidos') }}" 
                        >
                        @error('apellidos')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-5">
                        <label class="@error('dni') text-danger @enderror" for="dni">DNI *</label>
                        <input 
                            type="number" 
                            class="form-control @error('dni') border border-danger @enderror" 
                            id="dni" 
                            name="dni" 
                        >
                        @error('dni')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-7">
                        <label class="@error('fechaNacimiento') text-danger @enderror" for="fechaNacimiento">Fecha de Nacimiento *</label>
                        <input 
                            type="date" 
                            max="{{ date('Y-m-d') }}"
                            value="2000-01-01" 
                            class="form-control @error('fechaNacimiento') border border-danger @enderror" 
                            id="fechaNacimiento" 
                            name="fechaNacimiento"
                            required
                        >
                        @error('fechaNacimiento')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-7">
                        <label class="@error('direccion') text-danger @enderror" for="direccion">Dirección *</label>
                        <input 
                            type="text" 
                            class="form-control @error('direccion') border border-danger @enderror" 
                            id="direccion" 
                            name="direccion" 
                            value="{{ old('direccion') }}" 
                        >
                        @error('direccion')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="col-5">
                        <label class="@error('telefono') text-danger @enderror" for="telefono">Teléfono *</label>
                        <input 
                            type="text" 
                            class="form-control @error('telefono') border border-danger @enderror" 
                            id="telefono" 
                            name="telefono" 
                            value="{{ old('telefono') }}" 
                        >
                        @error('telefono')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
                </div>
            </form>
            
          </div>
      </div>
  </div>
</div>










