<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(preguntas::class);
        $this->call(roles::class);
        $this->call(unidad::class);
        $this->call(noticias::class);
        $this->call(identidad::class);
        $this->call(campañas::class);
    }
}
