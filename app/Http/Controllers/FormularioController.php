<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * La clase se encarga de realizar el envio del formulario a la base de datos
 */
class FormularioController extends Controller
{
    /**
     * La función se encarga de realizar el envio (de los datos recibidos) a la base de datos.
     *
     * @param Request $request Son los datos que recibe al realizar el envio del formulario
     */
    public function envio(Request $request){
        $formulario = new Formulario();
        $formulario -> fecha = $request->fecha;
        $formulario -> lugar = $request->lugar;
        $formulario -> colaborador = $request->colaborador;
        $formulario -> cedula = $request->cedula;
        $formulario -> cargo = $request->cargo;
        $formulario -> creador = $request->creador;
        $formulario -> descripcion = $request->descripcion;
        $formulario -> save();

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Reporte/Creacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return redirect()->back();
    }

    public function novedad(Request $request){
        $novedad = new Novedad();
        $novedad -> fecha = $request->fecha;
        $novedad -> lugar = $request->lugar;
        $novedad -> colaborador = $request->colaborador;
        $novedad -> creador = $request->creador;
        $novedad -> observaciones = $request->observacion;
        $novedad -> save();

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Novedad/Creacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return redirect()->back();
    }

    public function listadoA(){
        $datos = DB::table('formularios')->get();
        return view('intranet.listado', ['datos' => $datos]);
    }

    public function listadoN(){
        $datos = DB::table('novedads')->get();
        return view('intranet.listadon', ['datos' => $datos]);

    }
}
