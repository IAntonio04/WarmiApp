<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';
    use HasFactory;
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'cita_id',
        'titulo',
        'diagnostico',
        'archivo_adjunto_path',
        'tipo',
    ];
    public static function eliminarHistoriaClinica($id)
        {
            DB::delete('DELETE FROM historias_clinicas WHERE id = ?', [$id]);
        }
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function cita() {
        return $this->belongsTo(Cita::class);
    }
    public function medico() {
        return $this->belongsTo(Medico::class);
    }
    
}
