<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'dni',
        'fechaNacimiento',
        'direccion',
        'telefono',
    ];
    public static function listarPacientes($busqueda)
    {
        $busqueda="prue";
        // Realizar la consulta SQL
        $pacientes = DB::select("SELECT * FROM pacientes 
            WHERE id LIKE :busqueda 
            OR nombres LIKE :busqueda 
            OR apellidos LIKE :busqueda 
            OR dni LIKE :busqueda", ['busqueda' => '%' . $busqueda . '%']);
        $perPage = 5;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $pacientesPaginados = array_slice($pacientes, $offset, $perPage);
        $pacientesPaginados = new LengthAwarePaginator($pacientesPaginados, count($pacientes), $perPage, $page);
        return $pacientesPaginados;
    }
        public static function crearPaciente($nombres, $apellidos, $dni, $fechaNacimiento, $direccion, $telefono)
        {
            DB::insert('INSERT INTO pacientes (nombres, apellidos, dni, fechaNacimiento, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?)', [$nombres, $apellidos, $dni, $fechaNacimiento, $direccion, $telefono]);
        }
        public static function actualizarPaciente($id, $nombres, $apellidos, $dni, $fechaNacimiento, $direccion, $telefono)
        {
            DB::update('UPDATE pacientes SET nombres = ?, apellidos = ?, dni = ?, fechaNacimiento = ?, direccion = ?, telefono = ? WHERE id = ?', [
                $nombres,
                $apellidos,
                $dni,
                $fechaNacimiento,
                $direccion,
                $telefono,
                $id,
            ]);
        }
        public static function eliminarPaciente($id)
        {
            DB::delete('DELETE FROM pacientes WHERE id = ?', [$id]);
        }
        
        public static function buscarPacientePorDni($id)
        {
            return DB::select('SELECT * FROM pacientes WHERE id = ? LIMIT 1', [$id]);
        }
        
        public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }
}
