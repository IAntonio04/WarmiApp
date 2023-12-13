<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function descargarDocumentoMedicoInicial($nombres) {
        $rutaArchivoS3 = 'hc_original/hc_inicial.pdf';
        $nombreDescarga = $nombres . '_hc_inicial.pdf';
    
        try {
            $contenidoArchivo = Storage::disk('s3')->get($rutaArchivoS3);
    
            return response($contenidoArchivo, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $nombreDescarga . '"');
        } catch (\Exception $e) {
            return response('Error al descargar el archivo desde S3', 500);
        }
    }
    public function descargarDocumentoMedicoPerinatal($nombres) {
        $rutaArchivoS3 = 'hc_original/hc_perinatal.doc';
        $nombreDescarga = $nombres . '_hc_perinatal.doc';
    
        try {
            $contenidoArchivo = Storage::disk('s3')->get($rutaArchivoS3);
            return response($contenidoArchivo, 200)
                ->header('Content-Type', 'application/msword') 
                ->header('Content-Disposition', 'attachment; filename="' . $nombreDescarga . '"');
        } catch (\Exception $e) {
            return response('Error al descargar el archivo desde S3', 500);
        }
    }

    public function descargarHCPaciente($nombreArchivo) {
        $rutaArchivoS3 = 'hc_pacientes/'.$nombreArchivo; 
        try {
            $contenidoArchivo = Storage::disk('s3')->get($rutaArchivoS3);
            return response($contenidoArchivo, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment');
        } catch (\Exception $e) {
            return response('Error al descargar el archivo desde S3', 500);
        }
    }
    public function verDocumentoPaciente($nombreArchivo) {
        $path = storage_path('app/public/hc_pacientes/'.$nombreArchivo);
    return response()->file($path);
    }
    

}
