<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->cargo !== 'Medico') {
                return redirect()->route('inicio')->with('message', 'No tiene permisos para acceder a este contenido')->with('type', 'error');
            }
            return $next($request);
        });
    }

    public function descargarDocumentoMedicoInicial($nombres) {
        // local
        // $rutaArchivo = storage_path('app/public/hc_original/hc_inicial.pdf');
        // return response()->download($rutaArchivo, $nombres.'_hc_inicial.pdf');
        // s3
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
        // local
        // $rutaArchivo = storage_path('app/public/hc_original/hc_control.pdf');
        // return response()->download($rutaArchivo, $nombres.'_hc_control.pdf');
        // s3
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
        // local
        // $rutaArchivo = storage_path("app/public/hc_pacientes/{$nombreArchivo}");
        // return response()->download($rutaArchivo, $nombreArchivo.'.pdf');
        // s3
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
