<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $table = 'permisos';
    public $timestamps = true;
    protected $primaryKey = 'id_permisos';


protected $fillable = [
    'id_permisos',
    'fecha_permiso',
    'hora_salida',
    'hora_llegada',
    'total_horas',
    'usuario_id',
    'id_rol',
    'id_unidad',
    'jefe_id',
    'descripcion',
    'fecha_desde',
    'fecha_hasta',
    'hora_dia_1',
    'hora_dia_2',
    'hora_dia_3',
    'hora_dia_4',
    'hora_dia_5',
    'fecha_creacion',
    'estado',
    'seguimiento',
    'created_at',
    'updated_at'


];



public function usuario()
{
    return $this->belongsTo(User::class, 'usuario_id','id');
}


public function unidad()
{
    return $this->belongsTo(Unidad::class, 'id_unidad', 'id');
}
public function roles()
{
    return $this->belongsTo(Roles::class, 'id_rol', 'id');
}
public function jefe()
{
    return $this->belongsTo(User::class, 'jefe_id');
}


}
