<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_has_roles extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];

    public static function asignarRol($role_id,$model_type,$model_id){
        DB::insert('INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (?, ?, ?)', [$role_id, $model_type, $model_id]);
    }


}
