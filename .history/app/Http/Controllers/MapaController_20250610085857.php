<?php

namespace App\Http\Controllers;

use App\Models\mapa;
use App\Models\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * La clase se encarga de manejar los archivos que se pueden visualizar en el mapa de procesos
 */
class MapaController extends Controller
{
    /**
     * Se encarga de retornar a la vista de carga de archivos enviando los datos respectivos que se pueden actualizar
     *
     * @return
     */
    public function index()
    {
        $somos = DB::table('identidad')->where('name', 'somos')->value('descripcion');
        $mision = DB::table('identidad')->where('name', 'mision')->value('descripcion');
        $vision = DB::table('identidad')->where('name', 'vision')->value('descripcion');
        $proposito = DB::table('identidad')->where('name', 'proposito')->value('descripcion');
        $sig = DB::table('identidad')->where('name', 'sig')->value('descripcion');
        $notifinleco = DB::table('noticias_2')->where('titulo', 'notifinleco')->value('descripcion');
        $notifinleco2 = DB::table('noticias_2')->where('titulo', 'notifinleco2')->value('descripcion');
        $notifinleco3 = DB::table('noticias_2')->where('titulo', 'notifinleco3')->value('descripcion');

        $titulo1 = DB::table('noticias')->where('id', 1)-> value('titulo');
        $descripcion1 = DB::table('noticias')->where('id', 1)->value('descripcion');
        $titulo2 = DB::table('noticias')->where('id', 2)-> value('titulo');
        $descripcion2 = DB::table('noticias')->where('id', 2)->value('descripcion');
        $titulo3 = DB::table('noticias')->where('id', 3)-> value('titulo');
        $descripcion3 = DB::table('noticias')->where('id', 3)->value('descripcion');
        $titulo4 = DB::table('noticias')->where('id', 4)->value('titulo');
        $descripcion4 = DB::table('noticias')->where('id', 4)->value('descripcion');

        $unidades = DB::table('unidad')->get();
        $roles = DB::table('roles')->get();

        $campañas = DB::table('campañas')->get();

        return view('administracion.cargar', ['campañas' => $campañas, 'somos' => $somos, 'mision' => $mision, 'vision' => $vision, 'proposito' => $proposito, 'sig' => $sig, 'notifinleco' => $notifinleco, 'notifinleco2' => $notifinleco2, 'notifinleco3' => $notifinleco3, 'titulo1' => $titulo1, 'descripcion1' => $descripcion1, 'titulo2' => $titulo2, 'descripcion2' => $descripcion2, 'titulo3' => $titulo3, 'descripcion3' => $descripcion3, 'titulo4' => $titulo4, 'descripcion4' => $descripcion4, 'unidades' => $unidades, 'roles' => $roles]);
    }

    /**
     * La función retorna a la vista del mapa de procesos enviando las rutas de los archivos de la base de datos.
     *
     * @return
     */

    public function eliminar(Request $request)
        {
            $linkId = $request->input('link_id');

            $link = Links::find($linkId);

            if ($link) {
                $link->delete();
                return redirect()->back()->with('success', 'El link fue eliminado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se encontró el link.');
            }
        }

        public function create()
        {
            $folders = DB::table('mapas')->get();
            return view('intranet.mapa', ['folders' => $folders]);
        }

    public function create()
    {
        $folders = DB::table('mapas')->get();
        return view('intranet.mapa', ['folders' => $folders]);
    }

    /**
     * La función permite cargar los archivos a la base de datos y los guarda en la respectiva carpeta
     *
     * @param Request $request Son los datos recibidos a la hora de hacer envio del fomrulario
     * @return
     */
    public function store(Request $req)
    {
        // $req->validate([$file => 'required|mimes:csv,txt,xlx,xls,xlsx,pdf']);

        foreach($req->file('file') as $file){
            $fileModel = new mapa;
            $carpeta1 = $fileModel -> carpeta1 = $req -> carpeta1;
            $carpeta2 = $fileModel -> carpeta2 = $req -> carpeta2;
            if($carpeta1 == 'Compras' || $carpeta1 == 'Financiera'){
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('mapa/GestionAdministrativa/'.$carpeta1.'/'.$carpeta2, $fileName, 'public');
                $fileModel -> nombre = $fileName;
                $fileModel -> ruta = 'public/' . $filePath;
                $fileModel -> save();
            }
            else{
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('mapa/'.$carpeta1.'/'.$carpeta2, $fileName, 'public');
                $fileModel -> nombre = $fileName;
                $fileModel -> ruta = 'public/' . $filePath;
                $fileModel -> save();
            }
        }

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Mapa/Creacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);


        return back()
            ->with('success','El archivo se cargó exitosamente.')
            ->with('file', $fileName);
    }

    /**
     * La función permite actualizar el video del apartado de pausas activas
     *
     * @param Request $request envia el video para que se cargue su ruta, tanto en la base de datos como en la carpeta, reemplazando
     * el video anteriormente subido
     * @return
     */
    public function subirVideo(Request $request)
    {
        $request->validate(['video' => 'required|file|mimetypes:video/mp4']);
        $videoModel = new mapa;
        if($request->file()){
            $videoName = $request->video->getClientOriginalName();
            $videoPath = $request->file('video')->storeAs('pausas-activas/', 'pausas-activas.mp4', 'public');
            $videoModel->nombre = $request->video->getClientOriginalName();
            $videoModel->ruta = '/storage/'. $videoPath;
            $videoModel ->carpeta1 = 'pausas-activas';
            $videoModel ->carpeta2 = 'none';
            $videoModel->save();

            date_default_timezone_set("America/Bogota");
            $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
            $msg = "Video/Cargue: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
            $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
            fwrite($ar, $msg);
            fclose($ar);

            return back()->with('video-success', 'Video cargado');
        }
        return back()->with('video-error', 'Error al cargar el video');
    }

    /**
     * La función se encarga de enviar a la vista de identidad corporativa, enviando los datos que se podran ver en cada apartado
     *
     * @return
     */
    public function show()
    {
        $somos = DB::table('identidad')->where('name', 'somos')->value('descripcion');
        $mision = DB::table('identidad')->where('name', 'mision')->value('descripcion');
        $vision = DB::table('identidad')->where('name', 'vision')->value('descripcion');
        $proposito = DB::table('identidad')->where('name', 'proposito')->value('descripcion');
        $sig = DB::table('identidad')->where('name', 'sig')->value('descripcion');

        return view('intranet.identidad', ['somos' => $somos, 'mision' => $mision, 'vision' => $vision, 'proposito' => $proposito, 'sig' => $sig]);
    }

    /**
     * La función retorna a la vista index, enviando las noticias respectivas, alojadas en la base de datos.
     *
     * @return
     */
    public function shownoticias()
    {
        $noticias = DB::table('noticias')->get();
        $noticias2 = DB::table('noticias_2')->where('titulo', 'notifinleco')->value('descripcion');
        $noticias3 = DB::table('noticias_2')->where('titulo', 'notifinleco2')->value('descripcion');
        $noticias4 = DB::table('noticias_2')->where('titulo', 'notifinleco3')->value('descripcion');

        // Pasar ambas variables a la vista
        return view('intranet.index', [
            'noticias' => $noticias,
            'notifinleco' => $noticias2,
            'notifinleco2' => $noticias3,
            'notifinleco3' => $noticias4
        ]);
    }

    /**
     * La función permite actualizar los datos que se ven en la vista de identidad corporativa
     *
     * @param Request $request Los datos que recibe al hacer el envio del formulario respectivo
     * @param string $name Es el nombre de la propiedad que va a actualizar
     * @return
     */
    public function edit(Request $request, $name)
    {
        $valors = ['descripcion' => $request->descripcion];
        DB::table('identidad')->where('name', $name)->update($valors);

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Valores/Modificacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return back()->with('success-identidad','Información actualizada');
    }

    /**
     * La función se encarga de actualizar las noticias, ingresando el titlo, descripcion y el icono
     *
     * @param Request $request Los datos recibidos al momento de hacer el envio del formulario respectivo
     * @param $id Es el id de la noticia que se va a actualizar
     * @return
     */
    public function update(Request $request, $id)
    {

        $file = DB::table('noticias')->where('id', $id)->value('descripcion');
        Storage::delete(str_replace('storage', 'public', $file));

        $name = $request->img->getClientOriginalName();
        $request->file('img')->storeAs('inicio/', $name, 'public');
        $valor = ['titulo' => $name, 'icono' => $name, 'descripcion' => 'storage/inicio/'.$name];
        DB::table('noticias')->where('id', $id)->update($valor);

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Noticia/Modificacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i").PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return back()->with('noticias-succces', 'Noticia actualizada con exito!');
    }
    public function update2(Request $request, $id)
    {

        $file = DB::table('noticias')->where('id', $id)->value('descripcion');
        Storage::delete(str_replace('storage', 'public', $file));

        $name = $request->img->getClientOriginalName();
        $request->file('img')->storeAs('inicio/', $name, 'public');
        $valor = ['titulo' => $name, 'icono' => $name, 'descripcion' => 'storage/inicio/'.$name];
        DB::table('noticias')->where('id', $id)->update($valor);

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Noticia/Modificacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i").PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return back()->with('noticias-succces', 'Noticia actualizada con exito!');
    }


    /**
     * La función se encarga de guardar los enlaces agregados en la pagina del administrador.
     *
     * @param Request $request Los datos recibidos al momento de hacer el envio del formulario respectivo
     * @return
     */
    public function guardarlink(Request $request)
    {
        $links = new Links();
        $links->campaña_id = $request->campaña;
        $links->url = $request->url;
        $links->nombre = $request->nombre;
        $links->save();

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Link/Creacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        return response()->json(['link-success'=> 'links guardados exitosamente']);
    }
    /**
     * La funcion muestra los links que estanregistrados y a que campaña pertenecen
     *
     * @return
     */
    public function showLink()
    {
        // Obtenemos todas las unidades y links
        $unidades = DB::table('unidad')->get();
        $links = DB::table('links')->get();

        // Filtramos las campañas activas (estado = 0)
        $campañas = DB::table('campañas')->where('estado', 0)->get();

        // Obtenemos la unidad y rol del usuario autenticado
        $unidad = DB::table('unidad')->where('id', Auth::user()->id_unidad)->value('unidad');
        $rol = DB::table('roles')->where('id', Auth::user()->id_rol)->value('rol');

        return view('intranet.links', [
            'rol' => $rol,
            'unidad' => $unidad,
            'links' => $links,
            'unidades' => $unidades,
            'campañas' => $campañas
        ]);
    }
    public function getUrlsByCampaña($campañaId)
{
    // Obtener los registros de la tabla links que coincidan con campaña_id
    $urls = DB::table('links')
              ->where('campaña_id', $campañaId)
              ->select('id', 'url', 'nombre', 'estado') // Seleccionar solo las columnas necesarias
              ->get();

    // Retornar los datos en formato JSON
    return response()->json(['urls' => $urls]);
}

public function disableLink($id)
{
    $link = DB::table('links')->find($id);

    if ($link) {
        // Cambiar el estado del enlace de 0 a 1
        $newEstado = $link->estado == 0 ? 1 : 0; // Cambia el estado entre 0 y 1

        DB::table('links')->where('id', $id)->update([
            'estado' => $newEstado
        ]);
    }

    return response()->json(['success' => 'Estado actualizado correctamente.']);
}
    /**
     * Elimina el archivo que coincida con la ruta y el nombre enviados
     *
     * @param Request $request Son los datos recibidos al momento de hacer el envio de la peticion de eliminar
     * @param string $id recibe el nombre del archivo
     * @return
     */
    public function deleteFolder(Request $request, $id){
        // echo $id;
        $nombre = DB::table('mapas')->where('nombre', $id)->pluck('id');

        if(count($nombre) == 0){
            echo "No hay nada";
        }
        else{
            $nombre = $nombre[0];
            $file = mapa::find($nombre);
            Storage::delete($file->ruta);
            $file->delete();

            // date_default_timezone_set("America/Bogota");
            // $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
            // $msg = "Mapa/Eliminacion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
            // $ar = fopen(base_path()."/storage/logs/informacion.log", "a");
            // fopen($ar, $msg);
            // fclose($ar);

            return back();
        }
    }
    /**
     * Retorna a la vista donde se encuentra el organigrama
     */
    public function organigrama(){
        return view('intranet.organigrama');
    }
    public function mintic(){
        return view('intranet.mintic');
    }
}
