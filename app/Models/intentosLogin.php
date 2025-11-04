<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class intentosLogin extends Model
{
    use HasFactory;

    protected $table = "intentos_login";

    protected $fillable = [
        "id_usuario",
        "intentos"
    ];

}
