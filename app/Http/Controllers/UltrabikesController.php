<?php

namespace App\Http\Controllers;

use App\Models\mapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UltrabikesController extends Controller
{
    public function index(){
        return view('ultrabikes.index');
    }

    public function store(Request $req){
        foreach($req->file('file') as $file){
            $fileModel = new mapa;
            $carpeta1 = $fileModel -> carpeta1 = $req -> carpeta1;
            $carpeta2 = $fileModel -> carpeta2 = $req -> carpeta2;

            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('ultrabikes/'.$carpeta1.'/'.$carpeta2, $fileName, 'public');
            $fileModel -> nombre = $fileName;
            $fileModel -> ruta = 'public/' . $filePath;
            $fileModel -> save();
        }

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Ultrabikes/Mapa: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return back()
            ->with('successUltra','El archivo se cargó exitosamente.')
            ->with('file', $fileName);
    }
}
