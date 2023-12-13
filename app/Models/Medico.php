<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medico extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'especialidad_id',
        'nombres',
        'apellidos',
        'especialidad',
    ];
    public static function crearMedico($user_id, $especialidad_id)
    {
        DB::insert('INSERT INTO medicos (user_id, especialidad_id) VALUES (?, ?)', [$user_id, $especialidad_id]);
    }
    public static function obtenerMedicos()
    {
        return DB::table('medicos')
        ->join('users', 'medicos.user_id', '=', 'users.id')
        ->join('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
        ->select('users.id as id_user', 'users.nombres as nombre_medico', 'users.apellidos as apellido_medico', 'medicos.id as id', 'especialidades.nombre as especialidad', 'medicos.especialidad_id')
        ->get();
    
    }
    public static function obtenerMedicoPorId($idMedico)
    {
        return DB::table('medicos')
            ->join('users', 'medicos.user_id', '=', 'users.id')
            ->join('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
            ->where('users.id', $idMedico) 
            ->select('users.id as id_user', 'users.nombres as nombre_medico', 'users.apellidos as apellido_medico', 'medicos.id as id', 'especialidades.nombre as especialidad', 'medicos.especialidad_id')
            ->first(); 
    }
        
    // Relación con Especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }

}

