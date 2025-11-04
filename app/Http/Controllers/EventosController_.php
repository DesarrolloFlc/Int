<?php

namespace App\Http\Controllers;

use App\Models\Eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
/**
 * La Clase se encarga de controlar (ver, crear, actualizar y eliminar) los horarios generados en el calendario.
 */
class EventosController extends Controller
{
    /**
     * La función se encarga de enviar los datos de las bases eventos y usuarios a la vista del calendario (horarios).
     */
    public function index()
    {
        $events = DB::table('eventos')->get();
        $usuarios = DB::table('users')->get();
        $unidad = DB::table('unidad')->pluck('id');

        return view('calendario.index', ['events' => $events, 'usuarios' => $usuarios, 'unidad' => $unidad]);
    }

    /**
     * La función guarda los valores ingresados (horarios) en la base de datos
     *
     * @param Request $request Son los datos que recibe del envio del formulario
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'cedula' => 'required',
            'start' => 'required',
            'end' => 'required',
            'hstart' => 'required',
            'hend' => 'required',
        ]);

        $evento = new Eventos();
        $evento -> title = $request->title;
        $evento -> usuarios = base64_encode(json_encode($request->cedula));
        $evento -> start = $request->start;
        $evento -> end = $request->end;
        $evento -> hstart = $request->hstart;
        $evento -> hend = $request->hend;
        $evento -> color = '#f27631';
        $evento -> campaña = $request->campaña;
        $evento->save();

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Calendario/Creacion: ".Auth::user()->nombre.", ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return to_route('vista.calendario');
    }

    /**
     * La función recibe un id con el cual (según la seleccion) elimina o actualiza el horario seleccionado
     *
     * @param Request $request Son los datos enviados en el formulario
     */
    public function show(Request $request)
    {
        if (isset($_POST['delete']) && isset($_POST['id'])){

            $id = $_POST['id'];

            $delete = Eventos::findOrFail($id);
            $delete -> delete();

            date_default_timezone_set("America/Bogota");
            $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
            $msg = "Calendario/Eliminacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
            $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
            fwrite($ar, $msg);
            fclose($ar);

        }elseif (isset($_POST['title']) && isset($_POST['id'])){

            $id = $_POST['id'];
            $title = $_POST['title'];

            $update = Eventos::findOrFail($id);
            $update -> title = $title;
            $update -> usuarios = base64_encode(json_encode($request->cedula));
            $update -> hstart = $request->hstart;
            $update -> hend = $request->hend;
            $update -> color = '#f27631';
            $update -> update();

            date_default_timezone_set("America/Bogota");
            $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
            $msg = "Calendario/Modificacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP:".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
            $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
            fwrite($ar, $msg);
            fclose($ar);

        }
        return to_route('vista.calendario');
    }

}
