<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoraAtencion extends Model
{

    protected $table = 'horasatencion';
    protected $fillable = ['id','inicio', 'fin'];
    
}
