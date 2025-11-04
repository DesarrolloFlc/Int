<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class campañas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('campañas')->insert([
            [
                'campaña' => 'Claro',
                'image' => 'storage/clientes/Claro.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Colsubsidio',
                'image' => 'storage/clientes/Colsubsidio.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Credivalores',
                'image' => 'storage/clientes/CREDIVALORES.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Vanti',
                'image' => 'storage/clientes/Vanti.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Cartera Propia',
                'image' => 'storage/logos/name.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Gestion Documental',
                'image' => 'storage/clientes/Gestion.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Previsora',
                'image' => 'storage/clientes/previsora.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Enel',
                'image' => 'storage/clientes/Enel.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Ban100',
                'image' => 'storage/clientes/Ban100.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'PAYJOY',
                'image' => 'storage/clientes/PAYJOY.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Calidad',
                'image' => 'storage/clientes/calidad.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Gestion Administrativa',
                'image' => 'storage/clientes/GA.png',
                'estado' => 0,
            ],
            [
                'campaña' => 'Glpi',
                'image' => 'storage/clientes/GLPI.png',
                'estado' => 0,
            ],

        ]);
    }
}
