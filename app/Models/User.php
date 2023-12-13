<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{   
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
     protected $table = 'users';
    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'dni',
        'cargo',
        'password',
    ];

    public static function crearUsuario($nombres, $apellidos, $dni, $cargo, $password)
    {
        DB::insert('INSERT INTO users (nombres, apellidos, dni, cargo, password) VALUES (?, ?, ?, ?,?)', [$nombres, $apellidos, $dni, $cargo, $password]);
        $user=null;
        $user = User::where('dni', $dni)->first();
        return $user;
    }
    public static function actualizarUsuario($userId, $nombres, $apellidos, $dni, $cargo, $password)
    {
        // Verifica si $password tiene un valor antes de realizar la actualización
        if ($password !== null) {
            DB::update('UPDATE users SET nombres = ?, apellidos = ?, dni = ?, cargo = ?, password = ? WHERE id = ?', [$nombres, $apellidos, $dni, $cargo, $password, $userId]);
        } else {
            // Si $password es NULL, omite la actualización de la columna password
            DB::update('UPDATE users SET nombres = ?, apellidos = ?, dni = ?, cargo = ? WHERE id = ?', [$nombres, $apellidos, $dni, $cargo, $userId]);
        }

        return User::find($userId);
    }
    public static function eliminarUsuario($id)
    {
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
