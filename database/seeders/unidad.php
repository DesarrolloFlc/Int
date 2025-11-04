<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class unidad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('unidad')->insert([
            [
                'unidad' => 'Calidad'
            ],
            [
                'unidad' => 'Gerencia'
            ],
            [
                'unidad' => 'Asistente Administrativa'
            ],
            [
                'unidad' => 'Gestión Humana'
            ],
            [
                'unidad' => 'Contabilidad'
            ],
            [
                'unidad' => 'Tecnologia'
            ],
            [
                'unidad' => 'Coordinadores'
            ],
            [
                'unidad' => 'Gestion Documental'
            ],
            [
                'unidad' => 'Formacion'
            ],



            [
                'unidad' => 'Cartera Propia'
            ],
            [
                'unidad' => 'Colsubsidio'
            ],
            [
                'unidad' => 'Claro'
            ],
            [
                'unidad' => 'Credivalores'
            ],
            [
                'unidad' => 'Santander'
            ],
            [
                'unidad' => 'Vanti'
            ],
            [
                'unidad' => 'Previsora'
            ],
            [
                'unidad' => 'OLX'
            ],
            [
                'unidad' => 'Otro'
            ]
        ]);
    }
}
