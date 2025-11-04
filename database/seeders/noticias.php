<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class noticias extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        return DB::table('noticias')->insert([
            [
                'titulo' => 'Finleco Implementará La Norma ISO 27001',
                'descripcion' => 'ISO 27001 es una norma internacional que permite el aseguramiento, la confidencialidad e integridad de los datos y de la información, así como de los sistemas que la procesan. El estándar ISO 27001:2013 para los Sistemas Gestión de la Seguridad de la Información permite a las organizaciones la evaluación del riesgo y la aplicación de los controles necesarios para mitigarlos o eliminarlos. La aplicación de ISO-27001 significa una diferenciación respecto al resto, que mejora la competitividad y la imagen de una organización.',
                'icono' => 'storage/iconos/advertencia.png'
            ],
            [
                'titulo' => 'Tips De Seguridad',
                'descripcion' => 'La seguridad informática es, a día de hoy, un asunto de vital importancia para todos. Ya seamos particulares o empresas, al operar con nuestro ordenador pueden aparecer amenazas a nuestra seguridad informática prácticamente cada vez que nos conectamos a Internet. Por este motivo, en FinlecoBPO hemos querido recopilar algunas de las recomendaciones más efectivas y sencillas para que cualquiera pueda estar protegido frente a los ciberdelincuentes. Aunque algunas sean procesos y métodos para potenciar nuestra seguridad informática, la mayoría de estos consejos son hábitos saludables que seguir en nuestro día a día manejando dispositivos de cualquier tipo.',
                'icono' => 'storage/iconos/lock.png'
            ],
            [
                'titulo' => 'Mejore Su Atención Al Cliente',
                'descripcion' => 'La atención al cliente consiste en dar soporte al consumidor, resolver sus problemas y, en consecuencia, velar por su satisfacción. Para ofrecer un buen servicio al cliente, es fundamental que tu equipo esté bien preparado para garantizar una comunicación clara, humana, empática y proactiva con los clientes. Sabiendo qué es la atención al cliente, podemos profundizar en su importancia. Este aspecto es esencial para el éxito de tu negocio, a tal punto que el trato al consumidor se considera incluso más importante que el precio del producto.',
                'icono' => 'storage/iconos/notification.png'
            ]
        ]);
    }
}
