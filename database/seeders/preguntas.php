<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class preguntas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('preguntas')->insert([
            [
                'name' => 'expedicion',
                'pregunta' => 'Ingrese la fecha de expedición de su documento'
            ],
            [
                'name' => 'nacimiento',
                'pregunta' => "Ingrese su fecha de nacimiento"
            ]
        ]);
    }
}
