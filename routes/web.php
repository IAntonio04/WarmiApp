<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HistoriasClinicasController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RespaldoMedicoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;



//<----pagina inicial---->
Route::get('',[AuthController::class,'login'])->name('login');

//<----auth---->
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'loginStore'])->name('login');
Route::get('/cerrar-sesion',[AuthController::class,'logoutStore'])->name('cerrarSesion');

//<----inicio---->
Route::get('/inicio',[DashboardController::class,'index'])->name('inicio');

//<----Usuarios---->
Route::get('/usuario',[UsuarioController::class,'index'])->name('gestionUsuarios');
Route::post('/usuario',[UsuarioController::class,'store'])->name('registrarUsuario');
Route::put('/usuario',[UsuarioController::class,'update'])->name('editarUsuario');
Route::delete('/usuario',[UsuarioController::class,'destroy'])->name('eliminarUsuario');

// <----Paciente---->
Route::get('/paciente',[PacienteController::class,'index'])->name('gestionPacientes');
Route::post('/paciente',[PacienteController::class,'store'])->name('registrarPaciente');
Route::put('/paciente',[PacienteController::class,'update'])->name('editarPaciente');
Route::delete('/paciente',[PacienteController::class,'destroy'])->name('eliminarPaciente');
Route::get('/paciente/buscar/{dni}',[PacienteController::class,'search'])->name('buscarPaciente');

// <----Citas---->
Route::get('/cita',[CitaController::class,'index'])->name('gestionCitas');
Route::get('/cita/crear',[CitaController::class,'indexRegistrar'])->name('nuevaCita');
Route::post('/cita',[CitaController::class,'store'])->name('registrarCita');
Route::get('/cita/editar/{id}',[CitaController::class,'editarCita'])->name('editarCita');
Route::put('/cita', [CitaController::class, 'update'])->name('editarCita');

// <----CalendarioCitas---->
Route::get('/calendario-citas',[CalendarioController::class,'index'])->name('calendarioCitas');
Route::get('/calendario/mostrar',[CalendarioController::class,'show'])->name('obetnerEventos');
// Route::post('/calendario',[CalendarioController::class,'store'])->name('guardarEvento');
Route::get('/cita/cita-calendario/{estado}/{idMedico}/', [CalendarioController::class, 'citasCalendario']);
Route::get('/cita/medico-calendario/', [CalendarioController::class, 'medicoCalendario']);
Route::get('/calendario/cita/{id}', [CalendarioController::class, 'obtenerDetallesCita']);



// <----Historias Clinicas---->
Route::get('/sala-espera',[HistoriasClinicasController::class,'salaDeEspera'])->name('salaDeEspera');
Route::get('/historias-clinicas',[HistoriasClinicasController::class,'index'])->name('historialClinico');
Route::get('/historias-clinicas/crear/{idPaciente}/{idCita}',[HistoriasClinicasController::class,'indexRegistrar'])->name('registrarHistoriaClinica');
Route::post('/historia-clinica',[HistoriasClinicasController::class,'store'])->name('registrarHistoriaClinica');
Route::get('/historia-clinica/editar/{id}',[HistoriasClinicasController::class,'editarHC'])->name('editarHistoriaClinica');
Route::put('/historia-clinica',[HistoriasClinicasController::class,'update'])->name('editarHistoriaClinica');
Route::post('/historias-clinicas-eliminar',[HistoriasClinicasController::class,'destroy'])->name('eliminarHistoriaClinica');


// <----Documentos---->
Route::get('/descargar-documento-inicial/{paciente}',[DocumentController::class,'descargarDocumentoMedicoInicial'])->name('descargarDocumentoInicial');
Route::get('/descargar-documento-perinatal/{paciente}',[DocumentController::class,'descargarDocumentoMedicoPerinatal'])->name('descargarDocumentoControl');
Route::get('/descargar-documento-paciente/{nombreArchivo}', [DocumentController::class, 'descargarHCPaciente'])
    ->name('descargarDocumentoPaciente');
// Route::get('/ver-historia/{id}', [DocumentController::class, 'verHistoriaClinica'])->name('verHistoriaClinica');


Route::get('/ver-documento-paciente/{nombreArchivo}', [DocumentController::class, 'verDocumentoPaciente'])->name('verDocumentoPaciente');
