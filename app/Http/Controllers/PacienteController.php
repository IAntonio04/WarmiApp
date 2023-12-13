<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PacienteController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function index(Request $request){  
        $busqueda=$request->busqueda;
        $appURL = config('app.url');  
        $pacientes = Paciente::where('id', 'LIKE', '%' . $busqueda . '%')
                            ->orWhere('nombres', 'LIKE', '%' . $busqueda . '%')
                            ->orWhere('apellidos', 'LIKE', '%' . $busqueda . '%')
                            ->orWhere('dni', 'LIKE', '%' . $busqueda . '%')
                            ->paginate(6);
                    
        return view("paciente.gestionPacientes", compact('pacientes','busqueda','appURL'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'fechaNacimiento' => 'required|date',
            'dni' => 'required|unique:pacientes|numeric|digits:8',
        ]);
    
        $validator->stopOnFirstFailure(); 
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Error al registrar el paciente. Verifica los campos e inténtalo de nuevo.')->with('type', 'error')
                ->with('type', 'error')
                ->with('open_modal', true);
        }

        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $dni = $request->input('dni');
        $fechaNacimiento = $request->input('fechaNacimiento');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono');
        Paciente::crearPaciente($nombres, $apellidos, $dni, $fechaNacimiento, $direccion, $telefono);
        return back()->with('message', 'Paciente registrado exitosamente')->with('type', 'success');
    }

    public function update(Request $request){
        $id = $request->input('id');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $dni = $request->input('dni');
        $fechaNacimiento = $request->input('fechaNacimiento');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono');
        Paciente::actualizarPaciente($id, $nombres, $apellidos, $dni, $fechaNacimiento, $direccion, $telefono);
        return redirect()->route('gestionPacientes')->with('message', 'Paciente actualizado correctamente')->with('type', 'info');
    }

    public function destroy(Request $request){
        $id = $request->input('id');
        $citas = Cita::where('paciente_id', $id)->get();
        if ($citas->isNotEmpty()) {
            return redirect()->route('gestionPacientes')->with('message', 'No se puede eliminar al paciente, tiene citas asociadas.')->with('type', 'error');
        }
        Paciente::eliminarPaciente($id);
        return redirect()->route('gestionPacientes')->with('message', 'Paciente eliminado correctamente')->with('type', 'info');
    }

    public function search($dni) {
        $paciente = Paciente::where('dni', $dni)->first();
        return response()->json($paciente);
    }
    
}
