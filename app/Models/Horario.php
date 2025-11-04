<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'Horarios';
    public $timestamps = true;
    protected $primaryKey = 'id';


protected $fillable = [
    'id',
    'usuario_id',
    'id_rol',
    'id_unidad',
    'jefe_id',
    'descripcion',
    'fecha_solicitar',
    'estado',
    'lunesActual',
    'martesActual',
    'miercolesActual',
    'juevesActual',
    'viernesActual',
    'sabadoActual',
    'lunesCambio',
    'martesCambio',
    'miercolesCambio',
    'juevesCambio',
    'viernesCambio',
    'sabadoCambio',
    'soporte',
    'estado_action',
    'created_at',
    'updated_at'


];
public function unidad()
{
    return $this->belongsTo(Unidad::class, 'id_unidad', 'id');
}
public function usuario(){ return $this->belongsTo(User::class, 'usuario_id'); }



}
