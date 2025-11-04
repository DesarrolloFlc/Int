<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estado',
        'nombre',
        'password',
        'cedula',
        'expedicion',
        'nacimiento',
        'id_unidad',
        'id_rol',
        'ingreso',
        'email'
    ];

    public function SA(){
        return $this->id_rol == 1;
    }

    public function administrativo(){
        return $this->id_rol == 2;
    }

    public function asesores(){
        return $this->id_rol == 3;
    }

}
