<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class identidad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('identidad')->insert([
            [
                'name' => 'somos',
                'descripcion' => 'Tenemos más de 17 años de experiencia conjunta trabajando con empresas multinacionales del sector Financiero, Asegurador, Telecom y Real. Nos especializamos en recaudo de cartera, servicio al cliente, ventas telefónicas y gestión documental. Ayudamos a nuestros clientes a incrementar los porcentajes de eficiencia a través de estrategias efectivas basados en analítica e Inteligencia Artificial para alcanzar sus KPIs de manera más eciente.',
            ],
            [
                'name' => 'mision',
                'descripcion' => 'Somos aliados estratégicos en BPO, generando transformaciones empresariales innovadoras a nuestros clientes, permitiéndoles optimizar sus procesos y agregando valor a través de nuestras soluciones integrales.',
            ],
            [
                'name' => 'vision',
                'descripcion' => 'Ser reconocidos en el sector BPO como agentes transformadores de procesos operativos mediante innovadoras herramientas tecnológicas que superan las expectativas de nuestros clientes actuales y futuros',
            ],
            [
                'name' => 'proposito',
                'descripcion' => 'Construir una empresa altamente productiva, que mejore la calidad de vida de los colaboradores para crecer en conjunto con ellos.',
            ]
        ]);
    }
}
