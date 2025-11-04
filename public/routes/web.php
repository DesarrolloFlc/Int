<?php

use App\Http\Controllers\EventosController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\PausasController;
use App\Http\Controllers\UltrabikesController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

# Login & Registro
Route::get('/', function(){
    return redirect('login');
});

Route::get('login', [LoginController::class, 'index'])->middleware('guest')->name('login.view');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('validacion', [LoginController::class, 'validacion'])->name('validacion');

Route::get('cambio/{cedula}', [LoginController::class, 'actualivista'])->name('cambio.view');
Route::post('cambio/{cedula}', [LoginController::class, 'actualizacion'])->name('cambio');
Route::post('index/cambio/{cedula}', [LoginController::class, 'actualizacionindex'])->name('cambio.index');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

#Index
Route::get('index', [MapaController::class, 'shownoticias'])->middleware(['auth', 'verified'])->name('index');

#Perfil
Route::get('perfil', [LoginController::class, 'perfil'])->middleware(['auth', 'verified'])->name('perfil');

#noticias
Route::post('datosn/{name}', [MapaController::class, 'update'])->name('datosn');

# Identidad corporativa
Route::get('identidad', [MapaController::class, 'show'])->middleware(['auth', 'verified'])->name('identidad');

Route::post('/datosi/{name}', [MapaController::class, 'edit'])->name('iden');

Route::post('/datosi/{titulo}', [MapaController::class, 'edit'])->name('iden');

# Mapa de procesos
Route::get('mapa', [MapaController::class, 'create'])->middleware(['auth', 'verified'])->name('mapa');

#reporte de seguridad
Route::get('reporte-seguridad', function(){
    return view('intranet.r-seguridad');
})->middleware(['auth', 'administrativos'])->name('reporte-seguridad');

#reporte de accidentes
Route::Get('reporte-accidentes', function(){
    return view('intranet.r-accidentes');
})->middleware(['auth', 'administrativos'])->name('reporte-accidentes');

#listado
Route::get('listado/accidentes', [FormularioController::class, 'listadoA'])->middleware(['auth', 'administrativos'])->name('listado');
Route::get('listado/novedad', [FormularioController::class, 'listadoN'])->middleware(['auth', 'administrativos'])->name('listado.novedad');


#links
Route::get('links', [MapaController::class, 'showlink'])->middleware(['auth', 'verified'])->name('links');
Route::post('datos/links', [MapaController::class, 'guardarlink'])->name('datos.link');
Route::get('get-urls-by-campaña/{id}', [MapaController::class, 'getUrlsByCampaña']);
Route::post('links/{id}/disable', [MapaController::class, 'disableLink'])->name('links.disable');
Route::post('links/eliminar', [MapaController::class, 'eliminarlink'])->name('links.eliminar');

#reporte de novedad
Route::Get('reporte-novedad', function(){
    return view('intranet.r-novedad');
})->name('reporte-novedad');

#cargar archivos
Route::get('administrar/mapa', [MapaController::class, 'index'])->middleware(['auth', 'administrativos'])->name('administrar-mapa');

#formulario
Route::post('formulario', [FormularioController::class, 'envio'])->middleware(['auth', 'administrativos'])->name('formulario');
Route::post('novedad', [FormularioController::class, 'novedad'])->middleware(['auth', 'administrativos'])->name('novedad');

#subir archivos mapa
Route::post('archivos', [MapaController::class, 'store'])->middleware(['auth', 'administrativos'])->name('cargar');
Route::post('eliminar/mapa/{id}', [MapaController::class, 'deleteFolder'])->middleware(['auth', 'administrativos'])->name('eliminar.carpeta');

#subir video pausas
Route::post('video', [MapaController::class, 'subirVideo'])->middleware(['auth', 'administrativos'])->name('cargarvideo');

#calendario

// Route::post('addEvent', [EventosController::class, 'store'])->middleware(['auth', 'administrativos'])->name('addEvent');
// Route::post('eventTitle', [EventosController::class, 'show'])->middleware(['auth', 'administrativos'])->name('eventTitle');

#Carga de archivos
Route::post('usuarios', [LoginController::class, 'registroex'])->middleware(['auth', 'administrativos'])->name('registro.ex');

#registrar Usuarios

Route::post('registar/usuario', [LoginController::class, 'registrarUser'])->middleware(['auth', 'administrativos'])->name('registrar.usuario');
Route::post('eliminar/Usuario', [LoginController::class, 'deleteUser'])->middleware(['auth', 'administrativos'])->name('eliminar.usuarios');

#registrar video
Route::post('vista/video', [ PausasController::class, 'vistaVideo'])->middleware(['auth', 'verified'])->name('vista.video');

#Organigrama
Route::get('organigrama', [MapaController::class, 'organigrama'])->middleware(['auth', 'verified'])->name('organigrama');
Route::get('mintic', [MapaController::class, 'mintic'])->middleware(['auth', 'verified'])->name('mintic');

#Ultrabikes
Route::get('ultrabikes', [UltrabikesController::class, 'index'])->middleware(['auth', 'verified'])->name('ultrabikes');
Route::post('cargar/ultrabikes', [UltrabikesController::class, 'store'])->middleware(['auth', 'verified'])->name('cargar.ultrabikes');

#Permisos
 //Route::get('calendario', [EventosController::class, 'index'])->middleware(['auth', 'verified'])->name('vista.calendario');
// Route::get('/permisos', [PermisosController::class, 'create'])->name('vista.permisos');
// Route::post('/permisos', [PermisosController::class, 'store'])->name('permisos.store');
// Route::resource('permisos', PermisosController::class);


// Route::get('/permisos', [PermisosController::class, 'index'])->middleware('auth')->name('vista.permisos');
#Gestor de Solicitudes de Permisos
// Route::get('gestor/permisos', [MapaController::class, 'gestiondepermisos'])->name('gestor.permisos');

//#registro de permisos

Route::post('solicitud', [PermisosController::class, 'solicitud'])->name('solicitud');

Route::get('listado/Permisos', [PermisosController::class, 'listado'])->name('listado.permisos');

Route::get('consultar-permisos', [PermisosController::class, 'consultar'])->middleware(['auth', 'verified'])->name('consultar-permisos');

Route::post('modificar', [PermisosController::class, 'modificarEstado'])->name('modificar.estado');

Route::get('/permisos/{id}/ver', [PermisosController::class, 'ver'])->name('permisos.ver');

Route::get('/consultar/buscar', [PermisosController::class, 'buscar']);

Route::get('calendario', [EventosController::class, 'index'])->middleware(['auth', 'verified'])->name('vista.calendario');

Route::get('/permisos/exportar', [PermisosController::class, 'exportarExcel'])->name('permisos.descargar');


Route::get('/permisos/obtener/{id}', [PermisosController::class, 'obtenerPermiso'])->name('permisos.obtener');

Route::post('/permisos/actualizar/{id}', [PermisosController::class, 'actualizar'])->name('permisos.actualizar');

Route::get('/permisos/seguimiento', [PermisosController::class, 'seguimiento'])->name('permisos.seguimiento');


Route::post('/permisos/actualizar-seguimiento', [PermisosController::class, 'actualizarSeguimiento'])->name('actualizar.seguimiento');
Route::post('/permisos/modificar', [PermisosController::class, 'modificarEstado'])->name('permisos.modificarEstado');
