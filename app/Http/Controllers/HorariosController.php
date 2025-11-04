<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Horario;

class HorariosController extends Controller
{
    public function index()
    {
        $rol = Auth::user()->id_rol;
        if ($rol == 1) {
            $usuario = User::whereIn('id_rol', [2, 3, 4, 5])->where('estado', 1)->get();
        } elseif ($rol == 4) {
           $usuario = User::where('id_rol', 2)
                ->whereIn('id_unidad', [7, 8])
                ->where('estado', 1)
                ->get();
        } else {
            $usuario = collect();
        }
        $roles = DB::table('roles')->where('id', Auth::user()->id_rol)->value('rol');
        $unidad = DB::table('unidad')->where('id', Auth::user()->id_unidad)->value('unidad');

        return view('horarios.horarios', ['unidad' => $unidad, 'roles' => $roles, 'usuario' => $usuario]);
    }

    public function listado(Request $request)
    {
        $busqueda = trim((string) $request->input('busqueda_gen', ''));

        $query = Horario::with(['usuario:id,nombre', 'unidad:id,unidad'])
            ->where('usuario_id', Auth::id());

        if ($busqueda !== '') {
            $query->where(function ($q) use ($busqueda) {

                // ID numérico (permite buscar por Nº de solicitud)
                if (ctype_digit($busqueda)) {
                    $q->orWhere('id', (int) $busqueda)
                        ->orWhere('usuario_id', (int) $busqueda);
                }

                // Descripción
                $q->orWhere('descripcion', 'like', "%{$busqueda}%");

                // Nombre del usuario
                $q->orWhereHas('usuario', function ($u) use ($busqueda) {
                    $u->where('nombre', 'like', "%{$busqueda}%");
                });

                // Unidad
                $q->orWhereHas('unidad', function ($u) use ($busqueda) {
                    $u->where('unidad', 'like', "%{$busqueda}%");
                });

                // Estado por texto (mapea a tu numeración)
                $q->orWhere(function ($w) use ($busqueda) {
                    $map = [
                        'pendiente'  => 0,
                        'en proceso' => 1,
                        'aprobado'   => 2,
                        'rechazado'  => 3,
                        'parcialmente aprobado'   => 4,
                    ];
                    $k = mb_strtolower($busqueda, 'UTF-8');
                    if (isset($map[$k])) {
                        $w->where('estado', $map[$k]);
                    }
                });
            });
        }

        $datos = $query
            ->orderBy('estado')       // primero por estado
            ->orderByDesc('id')       // dentro del estado, los más nuevos
            ->paginate(10)
            ->appends($request->only('busqueda_gen')); // conserva el término

        return view('horarios.listado', compact('datos'));
    }

    public function permisoHorario(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 401, 'No autenticado');

        $userId         = (int)($user->id ?? 0);
        $rolIdActual    = (int)($user->id_rol ?? $user->rol_id ?? 0);
        $unidadIdActual = (int)($user->id_unidad ?? $user->unidad_id ?? 0);

        $idParam  = trim((string)$request->query('id', ''));
        $busqueda = trim((string)$request->query('busqueda_gen', ''));

        $esR2U7 = ($rolIdActual === 2 && $unidadIdActual === 7);
        $esR2U4  = ($rolIdActual === 2 && $unidadIdActual === 4);

        // 1) Query base: joins + borrado lógico + filtros de búsqueda
        $base = \App\Models\Horario::query()
            ->leftJoin('users  as u',  'u.id',  '=', 'Horarios.usuario_id')
            ->leftJoin('users  as uj', 'uj.id',  '=', 'Horarios.jefe_id')
            ->leftJoin('roles  as r',  'r.id',  '=', 'Horarios.id_rol')
            ->leftJoin('unidad as un', 'un.id', '=', 'Horarios.id_unidad')
            ->where('Horarios.estado_action', '!=', 1)
            ->when($idParam !== '', fn($q) => $q->where('Horarios.id', (int)$idParam))
            ->when($busqueda !== '', function ($q) use ($busqueda) {
                $q->where(function ($w) use ($busqueda) {
                    if (ctype_digit($busqueda)) {
                        $w->orWhere('Horarios.id',         (int)$busqueda)
                            ->orWhere('Horarios.usuario_id', (int)$busqueda);
                    }
                    $w->orWhere('Horarios.descripcion', 'like', "%{$busqueda}%")
                        ->orWhere('u.nombre',            'like', "%{$busqueda}%")
                        ->orWhere('un.unidad',           'like', "%{$busqueda}%")
                        ->orWhere('r.rol',               'like', "%{$busqueda}%");
                });
                // Estado por texto (mapea a tu numeración)
                $q->orWhere(function ($w) use ($busqueda) {
                    $map = [
                        'pendiente'  => 0,
                        'en proceso' => 1,
                        'aprobado'   => 2,
                        'rechazado'  => 3,
                        'parcialmente aprobado'   => 4,
                    ];
                    $k = mb_strtolower(trim($busqueda), 'UTF-8');

                    // Texto (pendiente, aprobado, etc.)
                    if (isset($map[$k])) {
                        $w->where('Horarios.estado', $map[$k]);
                    }

                    // Búsqueda numérica directa
                    if (is_numeric($busqueda)) {
                        $w->orWhere('Horarios.estado', (int)$busqueda);
                    }
                });
            });

        $visQuery = clone $base;

        if ($userId === 25) {//id se�ora ivone
            $visQuery->whereIn('Horarios.estado', [1, 2, 4]);
        } elseif (! $esR2U4) { // << CLAVE: si NO es R2U4, sí filtras por jefe
            $visQuery->where('Horarios.jefe_id', $userId);
        }



        // Caso especial rol=2 y unidad=7: si HAY propios, mostrar solo los míos
        if ($esR2U7) {
            $hayPropios = (clone $visQuery)
                ->where('Horarios.usuario_id', $userId)
                ->exists();

            if ($hayPropios) {
                $visQuery->where('Horarios.usuario_id', $userId);
            }
        }

        // 3) Select + orden + paginación
        $datos = $visQuery
            ->orderByDesc('Horarios.id')
            ->select(
                'Horarios.id',
                'Horarios.usuario_id',
                'Horarios.jefe_id',
                'Horarios.estado',
                'Horarios.fecha_solicitar',
                'Horarios.estado_action',
                'Horarios.descripcion',
                'uj.id_rol as jefe_rol_id',
                'Horarios.created_at',
                'Horarios.lunesActual',
                'Horarios.martesActual',
                'Horarios.miercolesActual',
                'Horarios.juevesActual',
                'Horarios.viernesActual',
                'Horarios.sabadoActual',
                'Horarios.lunesCambio',
                'Horarios.martesCambio',
                'Horarios.miercolesCambio',
                'Horarios.juevesCambio',
                'Horarios.viernesCambio',
                'Horarios.sabadoCambio',
                'Horarios.soporte',
                'u.nombre  as usuario_nombre',
                'uj.nombre as jefe_nombre',
                'r.rol     as cargo',
                'un.unidad as unidad'
            )
            ->paginate(15)           // tamaño de página (ajusta a tu preferencia)
            ->withQueryString();    // conserva ?busqueda_gen=... & ?id=...

        // 4) Añadir formato de fecha a cada item de esta página
        $datos->getCollection()->transform(function ($h) {
            $h->fecha_creacion_fmt = $h->created_at
                ? \Carbon\Carbon::parse($h->created_at)->format('d/m/Y')
                : null;
            return $h;
        });

        // 5) Para resaltado en la vista (y evitar errores si no existe)
        $idSeleccionado = $idParam !== '' && \App\Models\Horario::whereKey((int)$idParam)->exists()
            ? (int)$idParam
            : null;

        // 6) Entregar a la vista:
        //    - $rows: colección de la página actual (para @forelse y cálculos locales)
        //    - $datos: paginator (para tu paginación custom)
        $rows = collect($datos->items());

        $html = view('horarios.AprobacionHorarios', compact(
            'rows',
            'datos',
            'idSeleccionado',
            'rolIdActual',
            'userId'
        ))->render();

        // Debug opcional
        $payload = [
            'fn'        => __FUNCTION__,
            'idParam'   => $idParam,
            'rows_cnt'  => $rows->count(),
            'rol_id'    => $rolIdActual,
            'user_id'   => $userId,
            'unidad_id' => $unidadIdActual,
            'busqueda'  => $busqueda,
            'ts'        => date('Y-m-d H:i:s'),
        ];

        $html .= "<script>
      document.addEventListener('DOMContentLoaded', function(){
        console.log('AprobacionHorarios DBG:', " . json_encode($payload) . ");
        document.body.setAttribute('data-rol-id', " . json_encode($rolIdActual) . ");
        document.body.setAttribute('data-unidad-id', " . json_encode($unidadIdActual) . ");
      });
    </script>";

        return response($html)->header('X-Debug-Rol-Id', (string)$rolIdActual);
    }

    public function aprobar(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);

        $user = Auth::user();
        abort_unless($user, 401, 'No autenticado');

        $accion = strtolower((string) $request->input('accion', 'aprobar')); // 'aprobar'|'rechazar'
        if (!in_array($accion, ['aprobar', 'rechazar'], true)) {
            return back()->with('error', 'Acción inválida.');
        }

        // Identidad y elegibilidad (SIN CAMBIOS)
        $userId         = (int)($user->id ?? 0);
        $rolIdActual    = (int)($user->id_rol ?? $user->rol_id ?? 0);
        $unidadIdActual = (int)($user->id_unidad ?? $user->unidad_id ?? 0);

        $esR2U7  = ($rolIdActual === 2 && $unidadIdActual === 7);
        $esR2U4  = ($rolIdActual === 2 && $unidadIdActual === 4);
        $esIdEsp = ($userId === 25); // ajusta si aplica //id se�ora ivonne

        $estadoActual = (int)($horario->estado ?? 0);

        $autorizado =
            ($esR2U7  && $estadoActual === 0) ||
            ($esR2U4  && $estadoActual === 3) ||
            ($esIdEsp && $estadoActual === 4
            );

        if (!$autorizado) {
            return back()->with('error', 'No puedes realizar esta acción con tu rol/unidad y el estado actual.');
        }

        // Detectar soporte existente (SIN CAMBIOS)
        $tieneSoporte = !empty($horario->soporte)
            || !empty($horario->soporte_path)
            || !empty($horario->adjunto)
            || !empty($horario->archivo)
            || !empty($horario->ruta_soporte);

        // Próximo estado (SIN CAMBIOS)
        $next = null;
        if ($accion === 'rechazar') {
            $next = 1;
        } else { // aprobar
            if ($esR2U7)  $next = 3; // 0 -> 4
            elseif ($esR2U4)  $next = 4; // 4 -> 1
            elseif ($esIdEsp) $next = 2; // 1 -> 2
        }
        if ($next === null) {
            return back()->with('error', 'Transición no permitida.');
        }

        $horario->estado = $next;
        $horario->save();

        // ====== CORREOS con MISMO TEXTO/ASUNTO que actualizarEstado ======
        $nombreUsuario = $horario->usuario_nombre ?? ($user->name ?? 'Usuario');
        $descripcion   = (string)($horario->descripcion ?? '');
        $fechaCreada   = ($horario->fecha_creacion ?? $horario->created_at)
            ? \Carbon\Carbon::parse($horario->fecha_creacion ?? $horario->created_at)->format('Y-m-d H:i')
            : '';
        $fechaCreatedAt = $horario->created_at
            ? \Carbon\Carbon::parse($horario->created_at)->format('Y-m-d H:i')
            : '';

        try {
            if ($next == 4) {
                // === Estado 1: En Proceso (idéntico a actualizarEstado) ===
                $destinatario = 'ivonne.claros@finlecobpo.com'; // señora ivonne
                Mail::raw(
                    "Cordial saludo,\n\n" .
                        "Nos permitimos informarle que el usuario {$nombreUsuario} ha registrado una " .
                        "solicitud de cambio de horario identificada con el No. {$horario->id} la cual actualmente se encuentra en estado 'Parcialmente Aprobado' y requiere de su revisión.\n\n" .
                        "• Descripción: {$descripcion}\n" .
                        "• Fecha de Solicitud: {$fechaCreatedAt}\n\n" .
                        "Puede validar más detalles ingresando al siguiente link: " . route('aprobacion.horarios') . "\n\n" .
                        "Cordialmente,\n\nFinleco BPO - Intranet",
                    function ($message) use ($destinatario, $horario) {
                        $message->to($destinatario)
                            ->subject("📌 Pendiente por aprobación Cambio de horario No. {$horario->id}");
                    }
                );
            } elseif (in_array($next, [2, 1], true)) {
                // === Estado 2/3: Aprobado / Rechazado (idéntico a actualizarEstado) ===
                $estadoTexto  = $next == 2 ? 'aprobado' : 'rechazado';
                $destinatario = optional(User::find($horario->jefe_id))->email;
                if ($destinatario) {
                    Mail::raw(
                        "Cordial saludo,\n\n" .
                            "Nos permitimos informarle que el Cambio de horario No.{$horario->id} realizado fue {$estadoTexto}.\n\n" .
                            "• Fecha de Solicitud: {$fechaCreada}\n\n" .
                            "• Descripcion: {$descripcion}\n\n" .
                            "Puede verificar esta solicitud en el siguiente link: " . route('aprobacion.horarios') . "\n\n" .
                            "Cordialmente,\n\nFinleco BPO - Intranet",
                        function ($message) use ($destinatario, $horario, $estadoTexto) {
                            $message->to($destinatario)
                                ->subject("📌 El Cambio de horario No. {$horario->id} fue {$estadoTexto}");
                        }
                    );
                }
            } elseif ($next == 3) {
                // === Estado 4: (idéntico a actualizarEstado; copy original dice "En Proceso") ===// novedades
                $destinatario = 'novedadesnomina@finlecobpo.com';
                Mail::raw(
                    "Cordial saludo,\n\n" .
                        "Nos permitimos informarle que el usuario {$nombreUsuario} ha registrado una " .
                        "solicitud de cambio de horario identificada con el No. {$horario->id} la cual actualmente se encuentra en estado 'En proceso' y requiere de su revision.\n\n" .
                        "• Descripción: {$descripcion}\n" .
                        "• Fecha de Solicitud: {$fechaCreatedAt}\n\n" .
                        "Puede validar más detalles ingrese al siguiente link: " . route('aprobacion.horarios') . "\n\n" .
                        "Cordialmente,\n\nFinleco BPO - Intranet",
                    function ($message) use ($destinatario, $horario) {
                        $message->to($destinatario)
                            ->subject("📌 Pendiente por aprobación Cambio de horario No. {$horario->id}");
                    }
                );
            }
        } catch (\Throwable $e) {
            // sin logs a petición (no rompemos el flujo si falla el correo)
        }

        return back()->with('success', $accion === 'rechazar'
            ? 'Solicitud rechazada.'
            : 'Estado actualizado correctamente.');
    }

    public function eliminarSolicitud(Request $request, int $id)
    {
        $user = Auth::user();
        abort_unless($user, 401, 'No autenticado');

        // Marca eliminado SOLO si estado_action == 0
        $affected = Horario::where('id', $id)
            ->where('estado_action', 0)
            ->update([
                'estado_action' => 1,
                // 'eliminado_por' => $user->id,
                // 'eliminado_en'  => now(),
                'updated_at'    => now(),
            ]);

        if ($affected === 1) {
            return redirect()->route('aprobacion.horarios')
                ->with('success', 'Registro eliminado correctamente.');
        }

        // Mensaje más claro según el caso
        $estadoActual = Horario::where('id', $id)->value('estado_action');
        $msg = is_null($estadoActual)
            ? 'No se encontró el registro.'
            : 'No se pudo eliminar: ya estaba eliminado.';
        return redirect()->route('aprobacion.horarios')->with('error', $msg);
    }


   public function store(Request $request)
    {
        logger()->alert('HIT /horarios.store', ['all' => $request->all()]);

        $request->validate([
            'tipo_horario' => 'required|in:indefinido,un_dia',
            'jefe_id'      => 'required|integer',
            'descripcion'  => 'required',
            'fecha_solicitar' => 'nullable|date_format:Y-m-d',
            'dia_unico'    => 'required_if:tipo_horario,un_dia|nullable|in:lunes,martes,miercoles,jueves,viernes,sabado',
            'horario_actual.*.ingreso'     => 'nullable|date_format:H:i',
            'horario_actual.*.salida'      => 'nullable|date_format:H:i',
            'horario_solicitado.*.ingreso' => 'nullable|date_format:H:i',
            'horario_solicitado.*.salida'  => 'nullable|date_format:H:i',
        ]);


        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

        $mapActual = [
            'lunes' => 'lunesActual',
            'martes' => 'martesActual',
            'miercoles' => 'miercolesActual',
            'jueves' => 'juevesActual',
            'viernes' => 'viernesActual',
            'sabado' => 'sabadoActual',
        ];
        $mapCambio = [
            'lunes' => 'lunesCambio',
            'martes' => 'martesCambio',
            'miercoles' => 'miercolesCambio',
            'jueves' => 'juevesCambio',
            'viernes' => 'viernesCambio',
            'sabado' => 'sabadoCambio',
        ];

        $pack = function ($base, $dia) use ($request) {
            $ing = $request->input("$base.$dia.ingreso");
            $sal = $request->input("$base.$dia.salida");
            if (!$ing && !$sal) return null;
            return $ing && $sal ? "$ing-$sal" : ($ing ?: $sal);
        };

        $valsActual = [];
        foreach ($dias as $d) {
            $valsActual[$mapActual[$d]] = $pack('horario_actual', $d);
        }

        $valsCambio = array_fill_keys(array_values($mapCambio), null);
        if ($request->input('tipo_horario') === 'indefinido') {
            foreach ($dias as $d) {
                $valsCambio[$mapCambio[$d]] = $pack('horario_solicitado', $d);
            }
        } else {
            $d = $request->input('dia_unico');
            if ($d && isset($mapCambio[$d])) {
                $valsCambio[$mapCambio[$d]] = $pack('horario_solicitado', $d);
            }
        }

        logger()->alert('PACKED', ['A' => $valsActual, 'C' => $valsCambio]);

        try {
            $horario = new Horario();
            $horario->usuario_id  = Auth::id();
            $horario->id_rol      = Auth::user()->id_rol ?? null;
            $horario->id_unidad   = Auth::user()->id_unidad ?? $request->input('unidad_id');
            $horario->jefe_id     = (int) $request->input('jefe_id');
            $horario->descripcion = $request->input('descripcion');
            $horario->estado      = 0; // pendiente

            foreach ($valsActual as $col => $val) {
                $horario->{$col} = $val;
            }
            foreach ($valsCambio as $col => $val) {
                $horario->{$col} = $val;
            }

            logger()->alert('ABOUT_TO_SAVE', $horario->getAttributes());
            $raw = $request->input('fecha_solicitar');
            $fechaSolicitar = null;

            if (!empty($raw)) {
                // intenta primero YYYY-MM-DD (cl�sico de <input type="date">)
                try {
                    $fechaSolicitar = Carbon::createFromFormat('Y-m-d', $raw)->toDateString();
                } catch (\Throwable $e) {
                    // si viene como dd/mm/YYYY, convi�rtela
                    try {
                        $fechaSolicitar = Carbon::createFromFormat('d/m/Y', $raw)->format('Y-m-d');
                    } catch (\Throwable $e2) {
                        logger()->warning('fecha_solicitar inválida o en formato desconocido', ['raw' => $raw]);
                    }
                }
            }

            $horario->fecha_solicitar = $fechaSolicitar;
            $ok = $horario->save();
            logger()->alert('SAVE_OK', ['ok' => $ok, 'id' => $horario->id]);

            /* ===========================
         *  ENV�O DE CORREO AL JEFE
         * =========================== */
            try {
                $jefe = \App\Models\User::find($horario->jefe_id);
                $destinatario = $jefe?->email;

                if (!$destinatario) {
                    logger()->warning("Horario {$horario->id}: jefe_id {$horario->jefe_id} sin email; no se envía correo.");
                } else {
                    $solicitante   = \App\Models\User::find($horario->usuario_id);
                    $nombreUsuario = $solicitante->nombre ?? (Auth::user()->name ?? 'Usuario');

                    Mail::raw(
                        "Cordial saludo,\n\n" .
                            "Nos permitimos informarle que el usuario {$nombreUsuario} ha registrado una " .
                            "solicitud de cambio de horario identificada con el No. {$horario->id}.\n\n" .
                            "• Descripción: {$horario->descripcion}\n" .
                            "• Fecha de Solicitud: " . Carbon::parse($horario->created_at)->format('Y-m-d H:i') . "\n\n" .
                            "Para validar más detalles ingrese al siguiente link: " . route('aprobacion.horarios') . "\n\n" .
                            "Cordialmente,\n\nFinleco BPO - Intranet",
                        function ($message) use ($destinatario, $horario) {
                            $message->to($destinatario)
                                ->subject("📌 Solicitud de cambio de horario No. {$horario->id}");
                        }
                    );
                    logger()->info("Correo enviado a {$destinatario} por horario {$horario->id}");
                }
            } catch (\Throwable $mailEx) {
                logger()->error("Error correo (Horario ID {$horario->id}): " . $mailEx->getMessage());
            }

            return redirect()
                ->route('horarios.index')
                ->with('success', 'Su solicitud de cambio de horario fue guardada.');
        } catch (\Throwable $e) {
            logger()->critical('ERROR al guardar horario', [
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return back()->with('error', 'No se pudo guardar: ' . $e->getMessage())->withInput();
        }
    }
public function showJson(Horario $horario)
{
    if ($horario->usuario_id !== Auth::id()) {
        abort(403);
    }

    // Normaliza fecha_solicitar a Y-m-d para <input type="date">
    $fecha = $horario->fecha_solicitar;
    if ($fecha instanceof \DateTimeInterface) {
        $fechaYmd = $fecha->format('Y-m-d'); // <<-- Y-m-d (NO d-m-Y)
    } else {
        $s = (string) $fecha;
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $s)) {           // Y-m-d[...]
            $fechaYmd = substr($s, 0, 10);
        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $s)) {  // d/m/Y
            [$d,$m,$y] = explode('/', $s);
            $fechaYmd = sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        } else {
            $fechaYmd = null;
        }
    }

    $dias = ['lunes','martes','miercoles','jueves','viernes','sabado'];

    $split = function (?string $r) {
        if (!$r) return [null, null];
        if (preg_match_all('/\b(\d{1,2}:\d{2})\b/u', $r, $m) && count($m[1]) >= 1) {
            $i = $m[1][0] ?? null; $s = $m[1][1] ?? null;
            return [$i ?: null, $s ?: null];
        }
        $norm = str_replace(['–','—',' a ',' A ',' – ',' — '], '-', $r);
        if (str_contains($norm, '-')) {
            [$i,$s] = array_map('trim', explode('-', $norm, 2));
            return [$i ?: null, $s ?: null];
        }
        $r = trim($r);
        if (preg_match('/^\d{1,2}:\d{2}$/', $r)) return [$r, null];
        return [null, null];
    };

    $Actual = $Cambio = [];
    $cCount = 0; $cDay = null;
    foreach ($dias as $d) {
        [$ai,$as] = $split($horario->{$d.'Actual'} ?? null);
        [$ci,$cs] = $split($horario->{$d.'Cambio'} ?? null);
        $Actual[$d] = ['ingreso'=>$ai,'salida'=>$as];
        $Cambio[$d] = ['ingreso'=>$ci,'salida'=>$cs];
        if ($ci || $cs) { $cCount++; $cDay = $d; }
    }

    $tipo = $cCount === 1 ? 'un_dia' : 'indefinido';
    $dia_unico = $tipo === 'un_dia' ? $cDay : null;

    return response()->json([
        'id'               => $horario->id,
        'descripcion'      => $horario->descripcion,
        'estado'           => $horario->estado,
        'tipo_horario'     => $tipo,
        'dia_unico'        => $dia_unico,
        'fecha_solicitar' => $fechaYmd, // <-- Y-m-d (p.ej. 2025-09-17)
        'Actual'           => $Actual,
        'Cambio'           => $Cambio,
    ]);
}


    /**
     * Actualiza la solicitud desde el modal.
     */
    public function update(Request $request, Horario $horario)
    {
        if ($horario->usuario_id !== Auth::id()) {
            abort(403);
        }
        // Solo permitir editar pendientes (ajusta si quieres otra regla)
        if ((int)$horario->estado !== 0) {
            return back()->with('error', 'Solo puedes editar solicitudes en estado Pendiente.');
        }

        $request->validate([
            'fecha_solicitar' => 'required|string|max:255',
            'descripcion'   => 'required|string|max:255',
            'tipo_horario'  => 'required|in:indefinido,un_dia',
            'dia_unico'     => 'required_if:tipo_horario,un_dia|nullable|in:lunes,martes,miercoles,jueves,viernes,sabado',

            // tiempos en formato HH:MM
            'horario_actual.*.ingreso'      => 'nullable|date_format:H:i',
            'horario_actual.*.salida'       => 'nullable|date_format:H:i',
            'horario_solicitado.*.ingreso'  => 'nullable|date_format:H:i',
            'horario_solicitado.*.salida'   => 'nullable|date_format:H:i',
        ]);

        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

        // Empaqueta a "HH:MM-HH:MM" o null
        $pack = function (string $base, string $dia) use ($request) {
            $ing = $request->input("$base.$dia.ingreso");
            $sal = $request->input("$base.$dia.salida");
            if (!$ing && !$sal) return null;
            return ($ing && $sal) ? "$ing-$sal" : ($ing ?: $sal);
        };

        // ---------- ACTUAL ----------
        $A = [];
        if ($request->tipo_horario === 'indefinido') {
            // conserva lo que había si no viene en el form
            foreach ($dias as $d) {
                $nuevoA = $pack('horario_actual', $d);
                $A[$d . 'Actual'] = $nuevoA !== null ? $nuevoA : $horario->{$d . 'Actual'};
            }
        } else {
            // un_dia: LIMPIA todos los Actual y solo setea el día elegido
            foreach ($dias as $d) {
                $A[$d . 'Actual'] = null;
            }
            $dSel = $request->input('dia_unico');
            if ($dSel) {
                $A[$dSel . 'Actual'] = $pack('horario_actual', $dSel); // puede quedar null si no mandas horas
            }
        }

        // ---------- CAMBIO ----------
        $C = [];
        if ($request->tipo_horario === 'indefinido') {
            foreach ($dias as $d) {
                $nuevoC = $pack('horario_solicitado', $d);
                $C[$d . 'Cambio'] = $nuevoC !== null ? $nuevoC : $horario->{$d . 'Cambio'};
            }
        } else {
            // un_dia: limpia todos y solo setea el seleccionado
            foreach ($dias as $d) {
                $C[$d . 'Cambio'] = null;
            }
            $dSel = $request->input('dia_unico');
            if ($dSel) {
                $C[$dSel . 'Cambio'] = $pack('horario_solicitado', $dSel);
            }
        }

        $horario->update(array_merge([
            'descripcion'      => $request->input('descripcion'),
            'fecha_solicitar'  => $request->input('fecha_solicitar'), // <-- AÑADIDO
        ], $A, $C));


        return back()->with('success', '✅ Solicitud de horario actualizada correctamente.');
    }

    public function subirSoporte(Request $request, $id)
    {
        try {
            $horario = Horario::findOrFail($id);

            // Si YA existe un soporte y NO viene replace=1 → bloquear
            $yaTiene = !empty($horario->soporte);
            $quiereReemplazar = $request->boolean('replace');

            if ($yaTiene && !$quiereReemplazar) {
                return redirect()->route('aprobacion.horarios')
                    ->with('error', 'Este registro ya tiene un soporte');
            }

            if (!$request->hasFile('soporte')) {
                return redirect()->route('aprobacion.horarios')
                    ->with('error', 'No llegó ningún archivo.');
            }

            $request->validate([
                'soporte' => ['required', 'file', 'max:8192'], // máximo 8 MB
            ]);

            // Si va a reemplazar, elimina el anterior (opcional)
            if ($yaTiene && $quiereReemplazar && Storage::disk('public')->exists($horario->soporte)) {
                Storage::disk('public')->delete($horario->soporte);
            }

            $path = $request->file('soporte')->store('soportes', 'public');
            $horario->soporte = $path;
            $horario->save();

            return redirect()->route('aprobacion.horarios')
                ->with('success', $yaTiene ? 'Soporte reemplazado correctamente.' : 'Soporte subido correctamente.');
        } catch (\Throwable $e) {
            Log::error('ERROR subirSoporte', ['horario_id' => $id, 'msg' => $e->getMessage()]);
            return redirect()->route('aprobacion.horarios')
                ->with('error', 'No se pudo subir el soporte (revisa laravel.log).');
        }
    }

    public function descargarSoporte($id)
    {
        $h   = Horario::findOrFail($id);
        $ref = $h->soporte ?? $h->soporte_path ?? $h->adjunto ?? $h->archivo ?? $h->ruta_soporte ?? null;
        abort_if(!$ref, 404, 'No hay soporte adjunto.');

        // 1) Si es URL, se redirige (no podemos forzar nombre desde aquí)
        if (filter_var($ref, FILTER_VALIDATE_URL)) {
            return redirect()->away($ref);
        }

        // 2) data URI: data:mime;base64,XXXX
        if (preg_match('/^data:(.*?);base64,(.+)$/', $ref, $m)) {
            $mime = $m[1] ?: 'application/octet-stream';
            $bin  = base64_decode($m[2], true);
            abort_if($bin === false, 404, 'Soporte dañado (base64).');

            $ext      = $this->guessExtensionFromMime($mime) ?: 'bin';
            $filename = "soporte.$ext";

            return response($bin, 200)->withHeaders([
                'Content-Type'        => $mime,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // 3) Base64 “crudo”
        if (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $ref) && strlen($ref) > 200) {
            $bin = base64_decode($ref, true);
            abort_if($bin === false, 404, 'Soporte dañado (base64).');

            // Detectar MIME por contenido
            $mime = 'application/octet-stream';
            if (function_exists('finfo_open')) {
                $f = finfo_open(FILEINFO_MIME_TYPE);
                if ($f) {
                    $det = finfo_buffer($f, $bin);
                    if ($det) $mime = $det;
                    finfo_close($f);
                }
            }

            $ext      = $this->guessExtensionFromMime($mime) ?: 'bin';
            $filename = "soporte.$ext";

            return response($bin, 200)->withHeaders([
                'Content-Type'        => $mime,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        // 4) Archivo en disco
        $abs = $this->resolveAbsolutePath($ref, 'public');
        abort_if(!$abs || !is_file($abs), 404, 'Archivo de soporte no encontrado.');

        // MIME por contenido (fallback a File::mimeType)
        $mime = 'application/octet-stream';
        if (function_exists('finfo_open')) {
            $f = finfo_open(FILEINFO_MIME_TYPE);
            if ($f) {
                $det = finfo_file($f, $abs);
                if ($det) $mime = $det;
                finfo_close($f);
            }
        }
        if ($mime === 'application/octet-stream') {
            $mime = \Illuminate\Support\Facades\File::mimeType($abs) ?: 'application/octet-stream';
        }

        // Extensión: primero la del path, si no, por MIME
        $ext = pathinfo($abs, PATHINFO_EXTENSION);
        if ($ext === '' || $ext === null) {
            $ext = $this->guessExtensionFromMime($mime) ?: 'bin';
        }

        // ⬅️ Nombre forzado:
        $filename = "soporte_cambio_horario_$id.$ext";

        return response()->download($abs, $filename, ['Content-Type' => $mime]);
    }

    /* ====== Helpers ====== */

    private function resolveAbsolutePath(string $ref, string $disk = 'public'): ?string
    {
        $path = preg_replace('#^[/\\\\]?(storage/|public/)#', '', (string)$ref);
        $path = ltrim($path, "/\\");

        $root = config("filesystems.disks.$disk.root") ?: storage_path('app/' . $disk);
        $abs  = rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $path;
        if (is_file($abs)) return $abs;

        $alt = public_path('storage' . DIRECTORY_SEPARATOR . $path);
        if (is_file($alt)) return $alt;

        if (is_file($ref)) return $ref;

        return null;
    }
}
