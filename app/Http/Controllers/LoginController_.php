<?php

namespace App\Http\Controllers;

use App\Models\intentosLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * La clase se encarga de mostrar, validar y actualizar datos de inicio de sesion de los usuarios
 */
class LoginController extends Controller
{
    /**
     * La función muestra la vista login y envia una pregunta aleatoria de la base de datos
     */
    public function index(){
        $preguntas = DB::table('preguntas')->orderByRaw("RAND()")->get();
        return view('login', ['preguntas' => $preguntas]);
    }

    /**
     * La función se encarga de validar los datos ingresados a la hora de iniciar sesion
     *
     * @param Request $request Son los valores que recibe al hacer envio del formulario de inicio de sesion
     */
    public function login(Request $request){
        $request->validate([
            'cedula' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('cedula', 'password');
        if(Auth::attempt($credentials)) {
            date_default_timezone_set('America/Bogota');
            $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
            $msg = 'Inicio de sesion: '.Auth::user()->nombre.', '.Auth::user()->cedula.', IP: '.$ip.", ". date('d/m/Y H:i') . PHP_EOL;
            $ar = fopen(base_path().'/storage/logs/login.log', 'a');
            fwrite($ar, $msg);
            fclose($ar);

            $id = DB::table("users")->where("cedula", $request["cedula"])->pluck("id")[0];
            $intentos = DB::delete("delete from intentos_login where id_usuario = '".$id."'");

            return redirect()->intended(route('index'))->withSuccess('Bienvenido!');
        }

        try {
            $id = DB::table("users")->where("cedula", $request["cedula"])->pluck("id")[0];
            $intentos = DB::table("intentos_login")->where("id_usuario", $id)->count();

            if($intentos + 1 == 3)
                return redirect("login")->withFail("Demasiados intentos, intente de nuevo mas tarde o reestablezca su contraseña");

            intentosLogin::create([
                "id_usuario" => $id,
                "intentos" => $intentos + 1,
            ]);

        } catch (\Throwable $th) {
            return redirect("login")->withFail("Cédula o contraseña incorrecta.");
        }

        return redirect("login")->withFail("Cédula o contraseña incorrecta.");
    }

    /**
     * La funcion se encarga de validar los campos de cambio de contraseña
     *
     * @param Request $request Son los datos que recibe a la hora de enviar los datos para el cambio de contraseña.
     */
       public function validacion(Request $request)
{
    $name = $request->name;

    // Convertir valor si es fecha
    $valor = $request->$name;
    if (in_array($name, ['nacimiento', 'expedicion'])) {
        $valor = date('Y-m-d', strtotime(str_replace('/', '-', $valor)));
    }
    // Validación combinada
    $usuario_valido = DB::table('users')
        ->where('cedula', $request->cedula)
        ->where($name, $valor)
        ->exists();

    // Respuesta
    if ($usuario_valido) {
        return to_route('cambio.view', ['cedula' => $request->cedula]);
    } else {
        return redirect()
            ->route('login')
            ->with('error', "La información ingresada para {$name} no coincide. Por favor verifica los datos.");
    }
}    /**
     * La función se encarga de retornar a la vista de cambio de contraseña, enviando la contraseña relacionada al usuario
     * realizara el cambio.
     *
     * @param string $cedula Es la cedula relacionada a la persona que cambiara su contraseña.
     */
    public function actualivista($cedula){
        return view('cambio', ['cedula' => $cedula]);
    }

    /**
     * La función actualiza la contraseña teniendo en cuenta la cedula enviada
     *
     * @param Request $request Los datos recibidos a la hora de realizar el envio del formulario
     * @param string $cedula Es la cedula de la persona que realiza el cambio de contraseña
     */
    public function actualizacion(Request $request, $cedula){
        $id = DB::table('users')->where('cedula', $cedula)->pluck('id');
        $id = $id[0];

        $p1 = $request->p1;
        $p2 = $request->p2;

        $password = User::find($id);

        if($p1 == $p2){
            $password -> password = Hash::make($p1);
            $password -> ingreso = 1;
            $password -> save();
            return to_route('login');
        }
        else
            return redirect()->back();

    }

    /**
     * La funcion actualiza la contraseña al iniciar sesion por primera vez
     *
     * @param Request $request Los datos recibidos a la hora de realizar el envio del formulario respectivo
     * @param string $cedula Es la cedula de la persona que realiza el cambio de contraseña
     */
    public function actualizacionindex(Request $request, $cedula){
        $id = DB::table('users')->where('cedula', $cedula)->pluck('id');
        $id = $id[0];

        $p1 = $request->p1;
        $p2 = $request->p2;

        $password = User::find($id);

        if($p1 == $p2){
            $password -> password = Hash::make($p1);
            $password -> ingreso = 1;
            $password -> save();
            return redirect()->back()->withGood('Cambio de contraseña Exitoso!');
        }
        else
            return redirect()->back();

    }

    /**
     * La función se encarga de realizar el cierre de sesion de la cuenta activa
     *
     * @param Request $request Los datos recibidos a la hora de realizar el envio del formulario
     */
    public function logout(Request $request){

        date_default_timezone_set("America/Bogota");
        $ip = empty($_SERVER["REMOTE_ADDR"]) ? "Desconocida" : $_SERVER["REMOTE_ADDR"];
        $msg = "Cierre de sesion: ".Auth::user()->nombre.", ".Auth::user()->cedula.", IP: ".$ip.", ".date("d/m/Y H:i"). PHP_EOL;
        $ar = fopen(base_path()."/storage/logs/login.log", "a");
        fwrite($ar, $msg);
        fclose($ar);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }

    public function registroex(Request $request){
        $documento = IOFactory::load('C:\Users\1013099528\Intranet\public\storage\excel\usuarios.xlsx');
        $hoja = $documento -> getSheet(0);

        $nmfila = $hoja->getHighestRow();
        $lmcolumna = $hoja->getHighestColumn();
        $nmcolumna = Coordinate::columnIndexFromString($lmcolumna);

        for ($x=2; $x <= $nmfila ; $x++) {

            $usuario = new User();
            $usuario -> nombre = $hoja -> getCell('A'.$x);
            $usuario -> cedula = $hoja -> getCell('B'.$x);
            $usuario -> password = Hash::make($hoja -> getCell('B'.$x));
            $usuario -> expedicion = $hoja -> getCell('C'.$x);
            $usuario -> nacimiento = $hoja -> getCell('D'.$x);
            $usuario -> id_unidad = $hoja -> getCell('E'.$x);
            $usuario -> id_rol = $hoja -> getCell('F'.$x);
            $usuario -> ingreso = 0;

            $usuario -> save();

            // $nombre =  $hoja -> getCell('C'.$x);

            // echo $nombre.'<br>';
        }
        // echo json_encode("Los datos se ingresaron correctamente");
        return;
    }

    public function registrarUser(Request $request){
        $users = new User;
        $users->nombre = $request->nombre;
        $users->password = Hash::make($request->cedula);
        $users->cedula = $request->cedula;
        $users->expedicion = $request->expedicion;
        $users->nacimiento = $request->nacimiento;
        $users->id_unidad = $request->id_unidad;
        $users->id_rol =  $request->id_rol;
        $users->email = $request->email;
        $users->estado = 1;

        if ($request->hasFile('foto')) {
            $users->foto = $request->file('foto')->store('public/usuarios');
        }

        if($request->file()) {
            $fileName = $request->foto->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('usuarios/', $fileName, 'public');
            $users->foto = 'storage/' . $filePath;
        }

        $users->ingreso = 0;
        $users->save();

        return back();
    }

    public function perfil(){
        $unidad = DB::table('unidad')->whereId(Auth::user()->id_unidad)->pluck('unidad');
        $unidad = $unidad[0];
        return view('intranet.perfil', ['unidad' => $unidad]);
    }


    public function deleteUser(Request $request){
        $id = DB::table('users')->whereCedula($request->cedula)->pluck('id');
        // $id = $id[0];
        if(count($id) == 0){
            return back()->with('NoUser', 'NO existen usuarios con la cedula indicada');
        }
        else{
            $id = $id[0];
            $usuario = User::find($id);
            Storage::delete(str_replace('storage', 'public', $usuario->foto));
            $usuario->delete();
            return back()->with('User', 'Usuario Eliminado con exito');
        }
    }

}
