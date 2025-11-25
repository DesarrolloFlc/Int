<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermisosExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;





class PermisosController extends Controller
{
           const ESTADOS = [
        'pendiente'     => 0,
        'en proceso'    => 1,
        'aprobado'      => 2,
        'rechazado'     => 3,
        'eliminado'     => 4,
        'recibido' => 6,
    ];
    /**
     * La funciÃ³n se encarga de realizar el envio (de los datos recibidos) a la base de datos.
     *
     * @param Request $request Son los datos que recibe al realizar el envio del formulario
     */
    //Funcion para guardar la informacion de la solicitud de permisos en la base de datos
public function exportarExcel()
{
    $permisos = \App\Models\Permiso::where('estado', 2)->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Permisos Aprobados');

    // Encabezados
   $headers = [
        'No..', 'Nombre', 'Unidad','Fecha Permiso',
        'Descripcion', 'Total Horas', 'Fecha Desde', 'Fecha Hasta',
        'Horas por Dia', 'Estado', 'Seguimiento'
    ];

    $sheet->fromArray($headers, null, 'A1');

    // Estilo para encabezado
    $styleHeader = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '1F4E78'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];

    $sheet->getStyle('A1:K1')->applyFromArray($styleHeader);

    // Llenar datos
    $fila = 2;
    foreach ($permisos as $permiso) {
        $sheet->setCellValue("A{$fila}", $permiso->id_permisos);
        $sheet->setCellValue("B{$fila}", optional($permiso->usuario)->nombre);
        $sheet->setCellValue("C{$fila}", optional($permiso->unidad)->unidad);
        $sheet->setCellValue("D{$fila}", $permiso->fecha_permiso);
        $sheet->setCellValue("E{$fila}", $permiso->descripcion);
        $sheet->setCellValue("F{$fila}", $permiso->total_horas);
        $sheet->setCellValue("G{$fila}", $permiso->fecha_desde);
        $sheet->setCellValue("H{$fila}", $permiso->fecha_hasta);
        $sheet->setCellValue("I{$fila}", $permiso->horas_dia);

        // Estado
        $estadoTexto = match($permiso->estado) {
            1 => 'En proceso',
            2 => 'Aprobado',
            3 => 'Rechazado',
            6 => 'Recibido',
            default => 'Pendiente',
        };
        $sheet->setCellValue("J{$fila}", $estadoTexto);

        // Seguimiento
        $seguimientoTexto = match($permiso->seguimiento) {
            0 => 'Por revisar',
            1 => 'Completado',
            2 => 'No completado',
            default => 'Por revisar',
        };
        $sheet->setCellValue("K{$fila}", $seguimientoTexto);

        $fila++;
    }

    // Autoajustar columnas
    foreach (range('A', 'M') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Generar archivo
    $writer = new Xlsx($spreadsheet);
    $filename = 'permisos_aprobados.xlsx';

    // Encabezados de descarga
    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Cache-Control' => 'max-age=0',
    ]);
}

protected $fillable = [
  'fecha_permiso','hora_salida','hora_llegada','total_horas',
  'usuario_id','id_rol','id_unidad','jefe_id','descripcion',
  'fecha_desde','fecha_hasta',
  'hora_dia_1','hora_dia_2','hora_dia_3','hora_dia_4','hora_dia_5',
  'fecha_creacion','firma_1','firma_2','firma_3','estado'
];


public function solicitud(Request $request)
{
    Log::debug('Iniciando solicitud de permiso', $request->all());

    try {
                // --- Normalizar horas por día (horas_dia_1..5) ---
        // Acepta "HH:MM" o decimal (7.5 / 7,5). Limita a 0..8h.
        $toMins = function (?string $v): int {
            $v = trim((string)$v);
            if ($v === '') return 0;
            if (preg_match('/^\d{1,2}:[0-5]\d$/', $v)) {
                [$hh, $mm] = explode(':', $v);
                return ((int)$hh) * 60 + (int)$mm;
            }
            $n = (float) str_replace(',', '.', $v);
            return (int) round($n * 60);
        };
        $mins = [];
        for ($i = 1; $i <= 5; $i++) {
            $m = $toMins($request->input("horas_dia_$i"));
            // clamp a 0..480 (máx. 8h por día)
            $mins[$i] = max(0, min($m, 8 * 60));
        }
        $fmt = function (int $m): string {
            // si quieres guardar NULL en vez de "", cambia '' por null
            if ($m === 0) return '';
            return sprintf('%02d:%02d', intdiv($m, 60), $m % 60);
        };
        $totalMin  = array_sum($mins);
        $totalHHMM = sprintf('%02d:%02d', intdiv($totalMin, 60), $totalMin % 60);
        $permiso = new Permiso();
        $permiso->fecha_permiso = $request->fecha_permiso;
        $permiso->hora_salida = $request->hora_salida;
        $permiso->hora_llegada = $request->hora_llegada;
        $permiso->total_horas = $request->total_horas;
        $permiso->usuario_id = $request->usuario_id;
        $permiso->id_rol = Auth::user()->id_rol;
        $permiso->id_unidad = Auth::user()->id_unidad;
        $permiso->jefe_id = $request->jefe_id;
        $permiso->descripcion = $request->descripcion;
        $permiso->fecha_desde = $request->fecha_desde;
        $permiso->fecha_hasta = $request->fecha_hasta;
        // ⬇️ nuevo: guardar las horas por día (normalizadas a HH:MM o NULL)
        $permiso->hora_dia_1 = ($mins[1] > 0) ? $fmt($mins[1]) : null;
        $permiso->hora_dia_2 = ($mins[2] > 0) ? $fmt($mins[2]) : null;
        $permiso->hora_dia_3 = ($mins[3] > 0) ? $fmt($mins[3]) : null;
        $permiso->hora_dia_4 = ($mins[4] > 0) ? $fmt($mins[4]) : null;
        $permiso->hora_dia_5 = ($mins[5] > 0) ? $fmt($mins[5]) : null;
        $permiso->fecha_creacion = \Carbon\Carbon::now('America/Bogota');
        $permiso->estado = 0;
      // Normalizar total de permiso que viene del request
$reqTotalMins = $toMins($request->input('total_horas'));

// Validar que coincida con la suma de horas por día
if ($reqTotalMins !== $totalMin) {
    return back()
        ->withInput()
        ->with('error', "El total de horas de reposición (" . $totalHHMM .
               ") no coincide con el total del permiso (" . $request->total_horas . ").");
}



        if ($permiso->jefe_id == 25 || $permiso->jefe_id == 27) {
            Log::debug('Jefe es Ivonne (ID 25), estado marcado como 6');
            $permiso->estado = 6;
        } else {
            Log::debug('Jefe diferente de Ivonne, estado marcado como 0');
            $permiso->estado = 0;
        }

        $permiso->save();
        Log::info("Permiso guardado correctamente con ID: {$permiso->id_permisos}");
//arreglar el correo de novedades
$destinatarioPrincipal = User::find($request->jefe_id)->email;
$destinatarioSecundario = 'novedadesnomina@finlecobpo.com';

Log::info("Enviando notificacion de solicitud de permiso a: $destinatarioPrincipal y $destinatarioSecundario");

Mail::raw(
    "Cordial Saludo,\n\n" .
    "Nos permitimos informarle que el usuario {$permiso->usuario->nombre} ha registrado una solicitud de permiso identificada con el No. {$permiso->id_permisos} para el dia {$permiso->fecha_permiso} con los siguientes detalles: \n\n" .
    "- Hora salida: " . Carbon::parse($permiso->hora_salida)->format('h:i A') . "\n" .
    "- Hora llegada: " . Carbon::parse($permiso->hora_llegada)->format('h:i A') . "\n" .
    "- Descripcion: {$permiso->descripcion}.\n\n" .
    "Para consultar mas detalles sobre esta solicitud, puede acceder al siguiente enlace: http://intranet.finlecobpo.com/intranet/consultar-permisos\n\n" .
    "Cordialmente,\n\n" .
    "Finleco BPO-Intranet",
    function ($message) use ($destinatarioPrincipal, $destinatarioSecundario, $permiso) {
        $message->to([$destinatarioPrincipal, $destinatarioSecundario])
                ->subject("Usted tiene una nueva solicitud de permiso No.{$permiso->id_permisos} en la Intranet");
    }
);

        Log::info("Correo enviado exitosamente para el permiso ID: {$permiso->id_permisos}");

        return redirect()->back()->with('success', 'Permiso registrado correctamente.');
    } catch (\Exception $e) {
        Log::error('Error al guardar el permiso: ' . $e->getMessage());
        return back()->with('error', 'No se pudo guardar el permiso: ' . $e->getMessage());
    }
}

    //Muestra el listado de permisos del usuario autenticado con bÃºsqueda opcional.
    public function listado(Request $request)
    {
        $usuarioId = Auth::id();
        //crea consulta base con relaciones
        $query = Permiso::with(['usuario', 'unidad', 'roles'])
            ->where('usuario_id', $usuarioId);

        // BÃºsqueda general
        if ($request->filled('busqueda_generall')) {
            $busqueda = strtolower(trim($request->busqueda_generall));

            $estadoMap = [
                'pendiente'   => 0,
                'en proceso'  => 1,
                'aprobado'    => 2,
                'rechazado'   => 3,
                'eliminado'  => 4,
                'recibido' => 6,
            ];

            $estado = array_key_exists($busqueda, $estadoMap) ? $estadoMap[$busqueda] : null;

            $query->where(function ($q) use ($busqueda, $estado) {
                $q->where('descripcion', 'like', "%$busqueda%")
                    ->orWhere('fecha_permiso', 'like', "%$busqueda%")
                    ->orWhere('id_permisos', 'like', "%$busqueda%")
                    ->orWhere('total_horas', 'like', "%$busqueda%")
                    ->orWhere('fecha_creacion', 'like', "%$busqueda%")
                    ->orWhere('fecha_desde', 'like', "%$busqueda%")
                    ->orWhereHas('usuario', function ($uq) use ($busqueda) {
                        $uq->where('nombre', 'like', "%$busqueda%"); // Cambia a 'name' si es el campo en users
                    })
                    ->orWhereHas('unidad', function ($uq) use ($busqueda) {
                        $uq->where('unidad', 'like', "%$busqueda%");
                    })
                    ->orWhereHas('roles', function ($uq) use ($busqueda) {
                        $uq->where('rol', 'like', "%$busqueda%");
                    });

                if (!is_null($estado)) {
                    $q->orWhere('estado', $estado);
                }
            });
        }
$query->orderBy('id_permisos', 'DESC');

        $datos = $query->paginate(25)->appends($request->all());
        return view('intranet.listados', ['datos' => $datos]);

    }
    //Consulta permisos para el jefe o administrador segÃºn rol/unidad.
    public function Consultar(Request $request)
    {
        $usuario = Auth::user();

        // Crear la base de la consulta
        $query = Permiso::with(['usuario', 'unidad']);

    if ($usuario->id == 27) { // id don carlos
        $query->whereIn('estado', [2, 6])
      ->whereHas('usuario', function ($q) {
          $q->where('id_rol', 2);
      });
    }
    // Filtrar según rol y unidad
    elseif ($usuario->id_rol == 5 && $usuario->id_unidad == 2) {
        $query->whereIn('estado', [1, 2]);
    } elseif ($usuario->id_unidad == 4) {
        $query->whereIn('estado', [0, 1, 2, 3,6]);
    } else {
        $query->where('jefe_id', $usuario->id);
    }

        // BÃºsqueda general
        if ($request->filled('busqueda_general')) {
            $busqueda = strtolower(trim($request->busqueda_general));

            $estadoMap = [
                'en proceso'  => 1,
                'aprobado'    => 2,
                'recibido'    => 6,
            ];

            $estado = array_key_exists($busqueda, $estadoMap) ? $estadoMap[$busqueda] : null;

            $query->where(function ($q) use ($busqueda, $estado) {
                $q->where('descripcion', 'like', "%$busqueda%")
                    ->orWhere('fecha_permiso', 'like', "%$busqueda%")
                    ->orWhere('id_permisos', 'like', "%$busqueda%")
                    ->orWhere('total_horas', 'like', "%$busqueda%")
                    ->orWhere('fecha_creacion', 'like', "%$busqueda%")
                    ->orWhere('fecha_desde', 'like', "%$busqueda%")
                    ->orWhereHas('usuario', function ($uq) use ($busqueda) {
                        $uq->where('nombre', 'like', "%$busqueda%"); // Cambia a 'name' si es el campo en users
                    })
                    ->orWhereHas('unidad', function ($uq) use ($busqueda) {
                        $uq->where('unidad', 'like', "%$busqueda%");
                    })
                    ->orWhereHas('roles', function ($uq) use ($busqueda) {
                        $uq->where('rol', 'like', "%$busqueda%");
                    });

                if (!is_null($estado)) {
                    $q->orWhere('estado', $estado);
                }
            });
        }

    $query->orderBy('fecha_permiso', 'DESC');

        // Paginar y pasar a la vista
        $datos = $query->paginate(10)->appends($request->all());

        return view('calendario.consultar', ['datos' => $datos]);
    }
    //Modifica el estado de un permiso (aprobar/rechazar).
public function modificarEstado(Request $request)
{
    try {
        $id_permisos = $request->input('id_permiso');
        $accion = $request->input('accion'); // 'aprobar', 'rechazar' o 'inactivar'

        if (!in_array($accion, ['aprobar', 'rechazar', 'inactivar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Acción no válida. Debe ser "aprobar", "rechazar" o "inactivar".'
            ], 400);
        }

        $permiso = Permiso::with('usuario')->find($id_permisos);
        if (!$permiso) {
            return response()->json([
                'success' => false,
                'message' => 'Registro no encontrado.'
            ], 404);
        }

        $usuario = auth()->user();

        // --- INACTIVAR ---
        if ($accion == 'inactivar') {
            if ($permiso->estado != 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se puede inactivar un permiso en estado pendiente.'
                ], 403);
            }

            if ($usuario->id_rol == 5 || $usuario->id_unidad == 4) {
                $permiso->estado = 4;
                $permiso->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Permiso inactivado correctamente.',
                    'nuevo_estado' => $permiso->estado
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permisos para inactivar este permiso.'
                ], 403);
            }
        }

        // Ya está finalizado
        if (in_array($permiso->estado, [2, 3])) {
            return response()->json([
                'success' => false,
                'message' => 'No es posible modificar un permiso que ya fue aprobado o rechazado.'
            ], 400);
        }

        // --- ESTADO 0: Pendiente ---
        if ($permiso->estado == 0) {
            if (in_array($permiso->usuario->id_rol, [2,6]) && $permiso->jefe_id == $usuario->id) {
                if ($accion == 'aprobar') {
                    $permiso->estado = 6;
                    $permiso->save();

                    // Notificar a usuario 253
                    $correo253 = 'ernesto.reyes@finlecobpo.com'; //::##
                    Mail::raw(
                        "Cordial Saludo,\n\n" .
                        "Nos permitimos informarle que el usuario {$permiso->usuario->nombre} ha registrado una solicitud de permiso identificada con el No. {$permiso->id_permisos} para el día {$permiso->fecha_permiso}:\n\n" .
                        "- Hora salida: " . Carbon::parse($permiso->hora_salida)->format('h:i A') . "\n" .
                        "- Hora llegada: " . Carbon::parse($permiso->hora_llegada)->format('h:i A') . "\n" .
                        "- Descripción: {$permiso->descripcion}.\n\n" .
                        "Revísela en: http://intranet.finlecobpo.com/intranet/consultar-permisos\n\n" .
                        "Cordialmente,\nFinleco BPO - Intranet.",
                        function ($message) use ($correo253, $permiso) {
                            $message->to($correo253)
                                    ->subject("Tiene un nuevo permiso No.{$permiso->id_permisos} por aprobar en la intranet");
                        }
                    );

                    return response()->json([
                        'success' => true,
                        'message' => 'Permiso marcado como recibido y notificado.',
                        'nuevo_estado' => $permiso->estado
                    ]);
                } else {
                    $permiso->estado = 3;
                    $permiso->save();
                }
            } elseif ($permiso->jefe_id == $usuario->id) {
                $permiso->estado = ($accion == 'aprobar') ? 1 : 3;
                $permiso->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede modificar, se requiere la aprobación del jefe inmediato.'
                ], 403);
            }
        }

        // --- ESTADO 6: Recibido ---
        elseif ($permiso->estado == 6) {
            if ($usuario->id == 27) {
                if ($accion == 'aprobar') {
                    $permiso->estado = 1;
                } elseif ($accion == 'rechazar') {
                    $permiso->estado = 3;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Acción no válida para este permiso en estado recibido.'
                    ], 403);
                }
                $permiso->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No puede gestionar un permiso En proceso..'
                ], 403);
            }
        }

        // --- ESTADO 1: En proceso ---
        elseif ($permiso->estado == 1) {
            if ($usuario->id_rol == 5 && $usuario->id_unidad == 2) {
                $permiso->estado = ($accion == 'aprobar') ? 2 : 3;
                $permiso->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Este permiso se encuentra en proceso de aprobación.'
                ], 403);
            }
        }

        // Otros estados
        else {
            return response()->json([
                'success' => false,
                'message' => 'El permiso está en un estado que no se puede modificar.'
            ], 403);
        }

        // === NOTIFICACIONES ===
//arreglar el correo de la señora ivonne
        // Notificación cuando pasa a estado 1
        if ($permiso->estado == 1) {
            $destinatario = 'ivonne.claros@finlecobpo.com';
            Mail::raw(
                  "Cordial saludo,\n\n" .
        "Nos permitimos informarle que el usuario {$permiso->usuario->nombre} ha registrado la solicitud de permiso No.{$permiso->id_permisos} la cual actualmente se encuentra en estado 'En Proceso' y requiere de su revision.\n\n" .
        "- Fecha del permiso: {$permiso->fecha_permiso}\n" .
        "- Descripcion: {$permiso->descripcion}\n\n" .
        "Puede gestionar esta solicitud ingresando al siguiente enlace:\n" .
        "http://intranet.finlecobpo.com/intranet/consultar-permisos\n\n" .
        "Cordialmente,\n" .
        "Finleco BPO - Intranet.",
        function ($message) use ($destinatario, $permiso) {
            $message->to($destinatario)
                    ->subject("Permiso No.{$permiso->id_permisos} en proceso de aprobacion");
                }
            );
        }

        // Notificación si se mantiene en estado 6 (recibido)
        if ($permiso->estado == 6) {
            $correo253 = 'ernesto.reyes@finlecobpo.com'; // :##
            Mail::raw(
  "Cordial Saludo,\n\n" .
                "Nos permitimos informarle que el usuario {$permiso->usuario->nombre} ha registrado una solicitud de permiso identificada con el No. {$permiso->id_permisos} para el dia {$permiso->fecha_permiso} con los siguientes detalles: \n\n" .
                "- Hora salida: " . Carbon::parse($permiso->hora_salida)->format('h:i A') . "\n" .
                "- Hora llegada: " . Carbon::parse($permiso->hora_llegada)->format('h:i A') . "\n" .
                "- Descripcion: {$permiso->descripcion}.\n\n" .
                "Para consultar mas detalles sobre esta solicitud, puede acceder al siguiente enlace: http://intranet.finlecobpo.com/intranet/consultar-permisos\n\n" .
                "Cordialmente,\n\n" .
                "Finleco BPO-Intranet",
                function ($message) use ($destinatario, $permiso) {
                   $message->to($destinatario)
                            ->subject("Tiene un nuevo permiso No.{$permiso->id_permisos} por aprobar en la intranet");
                }
            );
        }

        // Notificación si es aprobado (2) o rechazado (3)
        if (in_array($permiso->estado, [2, 3])) {
            $estadoTexto = $permiso->estado == 2 ? 'aprobada' : 'rechazada';
            $destinatario = User::find($permiso->jefe_id)?->email;

            Mail::raw(
        "Cordial saludo,\n\n" .
        "Nos permitimos informarle que el permiso No.{$permiso->id_permisos} realizado fue {$estadoTexto}.\n\n" .
        "- Fecha del permiso: {$permiso->fecha_permiso}\n" .
        "- Descripcion: {$permiso->descripcion}\n\n" .
        "Puede verificar esta solicitud en el siguiente enlace:\n" .
        "http://intranet.finlecobpo.com/intranet/consultar-permisos\n\n" .
        "Cordialmente,\n" .
        "Finleco BPO - Intranet.",
        function ($message) use ($destinatario, $permiso, $estadoTexto) {
            $message->to($destinatario)
                    ->subject("Su solicitud de permiso No.{$permiso->id_permisos} fue {$estadoTexto}");
                }
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Permiso actualizado correctamente.',
            'nuevo_estado' => $permiso->estado
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Hubo un error al actualizar el permiso.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function Modificar(Request $request, $id_permisos)
{
    // Buscar el registro por ID
    $permiso = Permiso::find($id_permisos);
    if (!$permiso) {
        return response()->json(['error' => 'Permiso no encontrado.'], 404);
    }

    // Actualizar los campos necesarios (ajusta segÃºn tu estructura)
    $permiso->descripcion = $request->input('descripcion');
    $permiso->fecha_permiso = $request->input('fecha_permiso');
    $permiso->fecha_desde = $request->input('fecha_desde');
    $permiso->fecha_hasta = $request->input('fecha_hasta');
    $permiso->fecha_hasta = $request->input('hora_dia_1');
    $permiso->fecha_hasta = $request->input('hora_dia_2');
    $permiso->fecha_hasta = $request->input('hora_dia_3');
    $permiso->fecha_hasta = $request->input('hora_dia_4');
    $permiso->fecha_hasta = $request->input('hora_dia_5');
    $permiso->hora_salida = $request->input('hora_salida');
    $permiso->hora_llegada = $request->input('hora_llegada');

    // Guardar cambios
    $permiso->save();

    $permiso->fecha_actualizacion = \Carbon\Carbon::now('America/Bogota');

    return response()->json(['mensaje' => 'Permiso modificado correctamente.'], 200);
}


public function obtenerPermiso($id_permisos)
{
    Log::info('PERMISOS.obtenerPermiso: IN', [
        'id' => $id_permisos,
        'ts' => now()->toDateTimeString(),
    ]);

    $p = Permiso::find($id_permisos);

    if (!$p) {
        Log::warning('PERMISOS.obtenerPermiso: not found', ['id' => $id_permisos]);
        return response()->json(['error' => 'Permiso no encontrado.'], 404);
    }

    // Log de TODOS los atributos tal cual están en BD
    Log::debug('PERMISOS.obtenerPermiso: attrs', [
        'attributes' => $p->getAttributes(),
    ]);

    // Log específico de horas_dia
    $rawHoras = $p->horas_dia ?? null;
    Log::debug('PERMISOS.obtenerPermiso: horas_dia raw', [
        'type'  => gettype($rawHoras),
        'value' => $rawHoras,
        'len'   => is_string($rawHoras) ? strlen($rawHoras) : null,
    ]);

    // Intento de parseo (por si está guardado como string JSON)
    $parsed = null;
    $parsedOk = false;
    if (is_string($rawHoras)) {
        try {
            $parsed = json_decode($rawHoras, true, 512, JSON_THROW_ON_ERROR);
            $parsedOk = is_array($parsed);
        } catch (\Throwable $e) {
            Log::error('PERMISOS.obtenerPermiso: horas_dia json_decode failed', [
                'msg'  => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }
    } elseif (is_array($rawHoras)) {
        $parsed = $rawHoras;
        $parsedOk = true;
    }

    Log::info('PERMISOS.obtenerPermiso: horas_dia parsed', [
        'ok'    => $parsedOk,
        'count' => $parsedOk ? count($parsed) : null,
    ]);

    // Normalizador simple HH:MM (para horas de salida/llegada)
    $fmt = function ($t) {
        if (!$t) return null;
        try { return Carbon::parse($t)->format('H:i'); } catch (\Throwable $e) { return $t; }
    };

    $resp = [
        'id_permisos'   => $p->id_permisos,
        'estado'        => $p->estado,
        'fecha_permiso' => $p->fecha_permiso,
        'descripcion'   => $p->descripcion,
        'fecha_desde'   => $p->fecha_desde,
        'fecha_hasta'   => $p->fecha_hasta,
        'hora_salida'   => $fmt($p->hora_salida),
        'hora_llegada'  => $fmt($p->hora_llegada),
        'total_horas'   => $p->total_horas,

        // Entrega array si se pudo parsear; de lo contrario tal cual
        'horas_dia'     => $parsedOk ? $parsed : $rawHoras,

        // Si tienes secuenciales, también los devolvemos (para comparar en front)
        'hora_dia_1'    => $fmt($p->hora_dia_1 ?? null),
        'hora_dia_2'    => $fmt($p->hora_dia_2 ?? null),
        'hora_dia_3'    => $fmt($p->hora_dia_3 ?? null),
        'hora_dia_4'    => $fmt($p->hora_dia_4 ?? null),
        'hora_dia_5'    => $fmt($p->hora_dia_5 ?? null),
    ];

    Log::debug('PERMISOS.obtenerPermiso: OUT', [
        'keys' => array_keys($resp),
        'horas_dia_type' => gettype($resp['horas_dia']),
    ]);

    return response()->json($resp);
}


public function actualizar(Request $request)
{
    Log::info('PERMISOS.actualizar: IN', [
        'keys' => array_keys($request->all()),
        'id'   => $request->id_permisos ?? null,
    ]);

    // Log explícito de horas_dia (string/array) y secuenciales
    Log::debug('PERMISOS.actualizar: horas_dia payload', [
        'type'  => gettype($request->input('horas_dia')),
        'value' => $request->input('horas_dia'),
    ]);
    Log::debug('PERMISOS.actualizar: secuenciales', [
        'hora_dia_1' => $request->input('hora_dia_1'),
        'hora_dia_2' => $request->input('hora_dia_2'),
        'hora_dia_3' => $request->input('hora_dia_3'),
        'hora_dia_4' => $request->input('hora_dia_4'),
        'hora_dia_5' => $request->input('hora_dia_5'),
    ]);

    $permiso = Permiso::findOrFail($request->id_permisos);

    $permiso->update([
        'fecha_permiso' => $request->fecha_permiso,
        'descripcion'   => $request->descripcion,
        'fecha_desde'   => $request->fecha_desde,
        'fecha_hasta'   => $request->fecha_hasta,
        'hora_dia_1'    => $request->hora_dia_1,
        'hora_dia_2'    => $request->hora_dia_2,
        'hora_dia_3'    => $request->hora_dia_3,
        'hora_dia_4'    => $request->hora_dia_4,
        'hora_dia_5'    => $request->hora_dia_5,
        'total_horas'   => $request->total_horas,
        'hora_salida'   => $request->hora_salida,
        'hora_llegada'  => $request->hora_llegada,

        // Si también guardas JSON:
        'horas_dia'     => $request->input('horas_dia'),
    ]);

    Log::info('PERMISOS.actualizar: SAVED', [
        'id'        => $permiso->id_permisos,
        'wasChanged'=> $permiso->wasChanged(),
        'changed'   => $permiso->getChanges(),
    ]);

    $toast = $permiso->wasChanged()
        ? ['type' => 'success', 'title' => "Permiso #{$permiso->id_permisos}", 'text' => 'Actualizado correctamente']
        : ['type' => 'info',    'title' => "Permiso #{$permiso->id_permisos}", 'text' => 'No hubo cambios'];

    return redirect()->route('listado.permisos')->with('toast', $toast);
}

        //Muestra el listado de permisos del usuario autenticado con bÃºsqueda opcional.
    public function seguimiento(Request $request)
    {
        //crea consulta base con relaciones
        $query = Permiso::with(['usuario', 'unidad', 'roles'])
            ->where('estado', 2);

        // BÃºsqueda general
if ($request->filled('busqueda_generall')) {
    $busqueda = strtolower(trim($request->busqueda_generall));

    $estadoMap = [
        'aprobado' => 2,
    ];

    $seguimientoMap = [
        'por revisar'      => 0,
        'finalizado'       => 2,
        'completado'  => 1,
    ];

    $estado = array_key_exists($busqueda, $estadoMap) ? $estadoMap[$busqueda] : null;
    $seguimiento = array_key_exists($busqueda, $seguimientoMap) ? $seguimientoMap[$busqueda] : null;

    $query->where(function ($q) use ($busqueda, $estado, $seguimiento) {
        $q->where('descripcion', 'like', "%$busqueda%")
            ->orWhere('fecha_permiso', 'like', "%$busqueda%")
            ->orWhere('id_permisos', 'like', "%$busqueda%")
            ->orWhere('fecha_creacion', 'like', "%$busqueda%")
            ->orWhereHas('usuario', function ($uq) use ($busqueda) {
                $uq->where('nombre', 'like', "%$busqueda%");
            })
            ->orWhereHas('unidad', function ($uq) use ($busqueda) {
                $uq->where('unidad', 'like', "%$busqueda%");
            })
            ->orWhereHas('roles', function ($uq) use ($busqueda) {
                $uq->where('rol', 'like', "%$busqueda%");
            });

        if (!is_null($estado)) {
            $q->orWhere('estado', $estado);
        }

        if (!is_null($seguimiento)) {
            $q->orWhere('seguimiento', $seguimiento);
        }
    });
}
    $query->orderBy('fecha_permiso', 'DESC');

        $datos = $query->paginate(10)->appends($request->all());
        return view('calendario.seguimientoPermisos', ['datos' => $datos]);
    }
public function actualizarSeguimiento(Request $request)
{
    try {
        // Buscar el permiso
        $permiso = Permiso::findOrFail($request->id);

        // Solo permitir actualizar si el seguimiento actual es 0
        if ($permiso->seguimiento != 0) {
            return response()->json([
                'success' => false,
                'message' => 'Este permiso ya fue revisado y no se puede modificar.'
            ]);
        }

        // Actualizar seguimiento si estÃ¡ permitido
        $permiso->seguimiento = $request->seguimiento; // 1 o 2
        $permiso->save();

        return response()->json([
            'success' => true,
            'message' => 'Seguimiento actualizado correctamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el seguimiento.',
            // 'error' => $e->getMessage() // puedes mostrarlo solo en dev
        ]);
    }
}

}
