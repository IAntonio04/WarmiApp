<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evento extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'descripcion',
        'color',
        'textColor',
        'start',
        'end',
    ];
    
    public static function crearEvento($title, $descripcion, $start, $end, $color){
        $color = strval($color);
        $textColor = strval(Evento::determinarColores($color)['txtColor']);
        DB::insert('INSERT INTO eventos (title, descripcion, color, textColor, start, end) VALUES (?, ?, ?, ?, ?, ?)', [
            $title,
            $descripcion,
            $color,
            $textColor,
            $start,
            $end
        ]);
        
        
    }
    
    public static function determinarColores($color)
    {
        // Convertir color hexadecimal a valores RGB
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
    
        // Calcular luminosidad (brillo)
        $luminosidad = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    
        // Determinar si el fondo es claro u oscuro
        $txtColor = $luminosidad > 0.5 ? '#000' : '#fff';
    
        // Devolver un array con los colores
        return ['txtColor' => $txtColor, 'fondoColor' => $color];
    }
    
}
