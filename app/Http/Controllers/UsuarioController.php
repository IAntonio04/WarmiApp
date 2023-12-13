<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Model_has_roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->cargo !== 'Administrador') {
                return redirect()->route('inicio')->with('message', 'No tiene permisos para acceder a este contenido')->with('type', 'error');
            }
    
            return $next($request);
        });
    }
    public function index(Request $request) {
        
        $appURL = config('app.url'); 
        $busqueda = $request->busqueda;
        $especialidades = Especialidad::all();
        $usuarios = User::where('id', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('nombres', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('apellidos', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('dni', 'LIKE', '%' . $busqueda . '%')
                        ->paginate(7);

        return view("user.gestionUsuarios", compact('usuarios', 'busqueda','especialidades','appURL'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nombres'=>'required',
            'apellidos'=>'required',
            'dni'=>'required|unique:users|numeric|digits:8',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
            'cargo' => [
                'required',
                Rule::in(['Administrador', 'Medico', 'Recepcionista'])
            ]
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Error al registrar el Usuario. Verifica los campos e inténtalo de nuevo.')->with('type', 'error')
                ->with('type', 'error')
                ->with('open_modal', true);
        }

        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $dni = $request->input('dni');
        $cargo= $request->input('cargo');
        $especialidad= $request->input('especialidad');
        $password = bcrypt($request->input('password'));

        $user = User::crearUsuario($nombres,$apellidos,$dni,$cargo,$password);
        $role = Role::where('name', $cargo)->first();
        Model_has_roles::asignarRol($role->id,"App\Models\User",$user->id);
        if ($cargo === 'Medico' ) {
            Medico::crearMedico($user->id,$especialidad);
        }
        
        return redirect()->route('gestionUsuarios')->with('message', 'Usuario registrado exitosamente')->with('type', 'success');
    
    }

    public function update(Request $request){
        $userId  = $request->input('userId');
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => ['required', 'numeric', 'digits:8', Rule::unique('users')->ignore($userId)],
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/'
            ],
            'cargo' => [
                'required',
                Rule::in(['Administrador', 'Medico', 'Recepcionista'])
            ]
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Error al actualizar el Usuario. Verifica los campos e inténtalo de nuevo.')
                ->with('type', 'error')
                ->with('open_modal_edit', true);
        }
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');
        $dni = $request->input('dni');
        $cargo = $request->input('cargo');
        $especialidad = $request->input('especialidad');
        $password = $request->filled('password') ? bcrypt($request->input('password')) : null;
        $user = User::actualizarUsuario($userId, $nombres, $apellidos, $dni, $cargo, $password);
        
        $role = Role::where('name', $cargo)->first();
        Model_has_roles::where('model_id', $user->id)->delete();
        Model_has_roles::asignarRol($role->id, "App\Models\User", $user->id);
        if ($cargo === 'Medico') {
            $medico = Medico::where('user_id', $user->id)->first();
            if ($medico) {
                if ($especialidad) {
                    $medico->especialidad_id = $especialidad;
                    $medico->save();
            } else {
                }
            } else {
                Medico::crearMedico($user->id, $especialidad);
            }
        } else {
            $medico = Medico::where('user_id', $user->id)->first();
            if ($medico) {
                $medico->delete();
            }
        }
        
        return redirect()->route('gestionUsuarios')->with('message', 'Usuario actualizado exitosamente')->with('type', 'info');
    }
    
    public function destroy(Request $request){
    $id = $request->input('id');

    try {
        $user = User::find($id);
        User::eliminarUsuario($id);
        Model_has_roles::where('model_id', $id)->delete();
        if ($user && $user->cargo === 'Medico') {
            Medico::where('user_id', $id)->delete();
        }
        return redirect()->route('gestionUsuarios')->with('message', 'Usuario Eliminado exitosamente')->with('type', 'info');
    } catch (\Exception $e) {
        return redirect()->route('gestionUsuarios')->with('message', 'Error al intentar eliminar el usuario, tiene consultas pendientes')->with('type', 'error');
    }
}

}
