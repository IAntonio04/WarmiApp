<div class="modal fade" id="modalDocumento{{$historiaClinica->id}}" tabindex="-1" aria-labelledby="modalDocumentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDocumentoLabel">Documento del Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- local --}}
                {{-- <embed src="{{ route('verDocumentoPaciente', ['nombreArchivo' => $historiaClinica->archivo_adjunto_path]) }}" type="application/pdf" width="100%" height="600"> --}}
                {{-- s3 --}}
                    <embed src="{{Storage::disk('s3')->url('hc_pacientes/'.$historiaClinica->archivo_adjunto_path) }}" type="application/pdf" width="100%" height="600">
            </div>
            <div class="modal-footer">
                <a href="/descargar-documento-paciente/{{$historiaClinica->archivo_adjunto_path}}" class="btn btn-info" download>
                    <i class="fa-solid fa-download"></i>
                </a>
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>