<?php

namespace App\Http\Controllers;

use App\Models\Pausas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PausasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function vistaVideo(Request $request)
    {
        $cedula = $request->cedula;
        $fecha = $request->fecha;

        $data = new Pausas();
        $data->nombre = $request->nombre;
        $data->cedula = $cedula;
        $data->fecha = $fecha;
        $data->diario = $cedula.$fecha;
        $data->save();

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADD"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Pausas/Vista: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pausas $pausas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pausas $pausas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pausas $pausas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pausas $pausas)
    {
        //
    }
}
