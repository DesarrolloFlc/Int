<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('roles')->insert([
            [
                'rol' => 'SA'
            ],
            [
                'rol' => 'Administrativos'
            ],
            [
                'rol' => 'Coordinadores'
            ],
            [
                'rol' => 'Asesores'
            ]
        ]);
    }
}
