<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HoraAtencion;
use App\Models\Horario;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
class CitaController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    public function index(Request $request){
        $busqueda=$request->busqueda;  
        $medicos = Medico::obtenerMedicos();
        $citas = Cita::obtenerCitas($busqueda);
        return view("cita.gestionCitas", ['citas' => $citas,'medicos' => $medicos,'busqueda'=>$busqueda]);
    }
    public function indexRegistrar()
    {   
        
        $medicos = Medico::obtenerMedicos();
        $appURL = config('app.url');
        return view("cita.registrarCita", compact('medicos', 'appURL'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'medico' => 'required|numeric',
            'idPaciente' => 'required|numeric',
            'hora' => 'required|date_format:H:i',
            'fecha' => 'required|date',
            'motivo_consulta' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Error al registrar la cita. Verifica los campos e inténtalo de nuevo.')
                ->with('type', 'error');
        }
    
        $medico_id = $request->input('medico');
        $paciente_id = $request->input('idPaciente');
        $hora = $request->input('hora');
        $fecha_hora = $request->input('fecha') . " " . $hora;
        $motivo_consulta = $request->input('motivo_consulta');
        $estado = "Pendiente";
    
        Cita::crearCita($medico_id, $paciente_id, $fecha_hora, $motivo_consulta, $estado);
    
        return redirect()->route('gestionCitas')
            ->with('message', 'Cita registrada exitosamente')
            ->with('type', 'success');
    }

        
        
    public function buscarPaciente(Request $request)
    {
        $dni = $request->input('dni_paciente');
        $paciente = Paciente::buscarPacientePorDni($dni);
        $medicos = User::where('cargo', 'Medico')->get();
        $horariosDisponibles = HoraAtencion::all();
        if ($paciente) {
            return view('cita.registrarCita')->with(['medicos' => $medicos,'paciente' => $paciente,'horariosDisponibles'=> $horariosDisponibles]);
        } else {
            return view('cita.registrarCita')->with(['medicos' => $medicos,'error' => 'No se encontraron resultados para el DNI: ' . $dni]);
        }
    }
    public function editarCita($id){
        $appURL = config('app.url');
        $medicos = Medico::obtenerMedicos();
        $cita=Cita::obtenerCitasPorId($id);
        $cita[0]->fecha = Carbon::parse($cita[0]->fecha_hora)->format('Y-m-d');
        $cita[0]->hora = Carbon::parse($cita[0]->fecha_hora)->format('H:i');
        return view('cita.editarCita')->with(['medicos'=> $medicos,'Cita' => $cita,'appURL'=>$appURL]);

    }public function update(Request $request){
        $id = $request->input('idCita');
        $fecha = $request->input('fecha');
        $hora = $request->input('hora');
        $medico_id = $request->input('medico');
        $estado = $request->input('estado');
        $motivo_consulta = $request->input('motivo_consulta');
        Cita::actualizarCita($id, $fecha, $hora, $medico_id, $estado, $motivo_consulta);
        
        return redirect()->route('gestionCitas')->with('message', 'Cita actualizada correctamente')->with('type', 'info');
   
    }
   
}
