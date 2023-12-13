<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cita extends Model
{
    use HasFactory;
    
    protected $table = 'citas';
    protected $fillable = ['id','paciente_id', 'fecha_hora', 'descripcion', 'resultados_medicos', 'medico_id', 'estado'];
    public $timestamps = false;
    public static function obtenerCitas($busqueda) {
        return Cita::with(['paciente', 'medico.user'])
            ->select(
                'citas.*',
                'pacientes.nombres as nombre_paciente',
                'pacientes.apellidos as apellido_paciente',
                'pacientes.dni',
            )
            ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
            ->where(function ($query) use ($busqueda) {
                $query->where('pacientes.id', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('pacientes.nombres', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('pacientes.apellidos', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('pacientes.dni', 'LIKE', '%' . $busqueda . '%');
            })
            ->paginate(5);
    }
    public static function obtenerTodasLasCitas($estado = 'Todos', $idMedico = 0) {
        $citasQuery = Cita::with(['paciente', 'medico.user'])
            ->select(
                'citas.*',
                'pacientes.nombres as nombre_paciente',
                'pacientes.apellidos as apellido_paciente',
                'pacientes.dni'
            )
            ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id');
    
        if ($estado !== 'Todos') {
            $citasQuery->where('estado', $estado);
        }
    
        if ($idMedico > 0) {
            $citasQuery->where('medico_id', $idMedico);
        }
    
        return $citasQuery->get();
    }
    public static function obtenerCitaPorEstado($estado, $idMedico) {
        return Cita::with(['paciente', 'medico.user'])
            ->select(
                'citas.*',
                'pacientes.nombres as nombre_paciente',
                'pacientes.apellidos as apellido_paciente',
                'pacientes.dni',
            )
            ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
            ->when($idMedico, function ($query) use ($idMedico) {
                $query->where('citas.medico_id', $idMedico);
            })
            ->where('citas.estado', $estado)
            ->paginate(8);
    }
    
    public static function obtenerCitasPorId($id) {
        return DB::table('citas')
        ->join('pacientes', 'citas.paciente_id', '=', 'pacientes.id')
        ->select(
            'citas.*',
            'pacientes.nombres as nombre_paciente',
            'pacientes.apellidos as apellido_paciente',
            'pacientes.dni'
        )
        ->where('citas.id', '=', $id)
        ->get();
    }

    public static function crearCita($medico_id, $paciente_id, $fecha_hora, $motivo_consulta, $estado)
    {
        DB::statement("INSERT INTO citas (medico_id, paciente_id, fecha_hora, motivo_consulta, estado)
            VALUES (?, ?, ?, ?, ?)", [
            $medico_id, $paciente_id, $fecha_hora, $motivo_consulta, $estado
        ]);
    }
    
    public static function actualizarCita($id, $fecha, $hora, $medico_id, $estado, $motivo_consulta)
    {
        DB::table('citas')
            ->where('id', $id)
            ->update([
                'fecha_hora' => $fecha." ".$hora,
                'medico_id' => $medico_id,
                'estado' => $estado,
                'motivo_consulta' => $motivo_consulta,
            ]);
    }
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}
