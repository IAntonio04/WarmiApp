<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Evento;
use App\Models\Medico;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }
    public function index(){
        $user = auth()->user();
        $appURL = config('app.url');
        if($user->cargo=="Medico"){
            return view("calendario.calendarioMedico",compact('appURL'));
        }else{
            return view("calendario.calendarioCita",compact('appURL'));
        }
    }
    public function store(Request $request){
        
        $title = $request->input('title');
        $descripcion = $request->input('descripcion');
        $color = $request->input('color');
        $hora = $request->input('hora');
        $start = $request->input('start') . " " . $hora;
        $end = $request->input('end') . " " . $hora;
        Evento::crearEvento($title, $descripcion, $start, $end, $color);
    }
    public function show(Request $request){
        $eventos = Evento::all();
        return response()->json($eventos);
        
    }

    public function citasCalendario($estado, $idMedico) {
        $citas = Cita::obtenerTodasLasCitas($estado, $idMedico);
        $events = $this->obtenerEventosCita($citas);
    
        return response()->json($events);
    }
    public function obtenerDetallesCita($idCita) {
        $cita = Cita::with(['paciente', 'medico.especialidad'])->find($idCita);
        if (!$cita) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }
        $detallesCita = [
            'idCita' => $cita->id,
            'fecha_hora' => $cita->fecha_hora,
            'motivo_consulta' => $cita->motivo_consulta,
            'estado' => $cita->estado,
            'paciente' => [
                'id' => $cita->paciente->id,
                'nombres' => $cita->paciente->nombres,
                'apellidos' => $cita->paciente->apellidos,
                'dni' => $cita->paciente->dni,
                'fechaNacimiento' => $cita->paciente->fechaNacimiento,
                'direccion' => $cita->paciente->direccion,
                'telefono' => $cita->paciente->telefono,
            ],
            'medico' => [
                'id' => $cita->medico->id,
                'nombres' => $cita->medico->user->nombres,
                'apellidos' => $cita->medico->user->apellidos,
                'especialidad' => [
                    'id' => $cita->medico->especialidad->id,
                    'nombre' => $cita->medico->especialidad->nombre,
                ],
            ],
        ];
    
        return response()->json($detallesCita);
    }
    public function medicoCalendario() {
        $user = auth()->user();
        $events = array();
        $medico = Medico::where('user_id', $user->id)->first();
    
        if ($medico) {
            $idMedico = $medico->id;
            $citas = Cita::obtenerTodasLasCitas("Todos", $idMedico);
            $events = $this->obtenerEventosCita($citas);
        }
    
        return response()->json($events);
    }

    private function obtenerEventosCita($citas) {
        $events = array();
    
        foreach ($citas as $cita) {
            switch ($cita->estado) {
                case 'Pendiente':
                    $color = '#FFFF00'; // Amarillo
                    $textColor = "#000";
                    break;
                case 'Cancelada':
                    $color = '#FF0000'; // Rojo
                    $textColor = "#fff";
                    break;
                case 'Confirmada':
                    $color = '#008000'; // Verde
                    $textColor = "#fff";
                    break;
                case 'Atendida':
                    $color = '#0066cc'; // Azul
                    $textColor = "#fff";
                    break;
            }
    
            $events[] = [
                'title' => explode(" ", $cita->apellido_paciente)[0],
                'start' => $cita->fecha_hora,
                'id' => $cita->id,
                'end' => $cita->fecha_hora,
                'color' => $color,
                'textColor' => $textColor,
            ];
        }
    
        return $events;
    }
    
}
