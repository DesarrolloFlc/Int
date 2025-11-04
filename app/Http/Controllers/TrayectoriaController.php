<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TrayectoriaController extends Controller
{
public function index(Request $request)
{
    $u = auth()->user();
    $cedula = $u->cedula ?? $u->documento ?? $u->dni ?? session('cedula') ?? null;

    // Paginación
    $perPage = max(1, min(50, (int)$request->input('per_page', 10)));
    $page    = max(1, (int)$request->input('page', 1));

    // Filtros
    $tema  = trim((string)$request->input('tema_reforzado', ''));
    $fecha = $request->input('fecha_permiso'); // yyyy-mm-dd

    $trayectorias = collect();
    $pager = [
        'page'=>$page,'per_page'=>$perPage,'total'=>0,'pages'=>0,
        'has_prev'=>false,'has_next'=>false,'first_url'=>null,'prev_url'=>null,
        'next_url'=>null,'last_url'=>null,'page_links'=>[],
    ];
    if (!$cedula) {
    return view('trayectoria_formativa.listado_trayectoria', compact('trayectorias', 'pager'));
}

    try {
        $pdo = new \PDO(
            "mysql:host=192.168.6.118;dbname=administrativa;charset=utf8mb4",
            "intranet2","Finleco2025*-+",
            [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC,
             \PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8mb4"]
        );

        // WHERE dinámico
       $whereParts = [
    "t.cedula_asesor = :cedula",
    "(t.calificacion_1 IS NULL OR t.calificacion_2 IS NULL)",
    "t.estado = 0"
];

        $params = [':cedula'=>(string)$cedula];

        if ($tema !== '') {
            // Usamos LIKE para tolerar mayúsculas/acentos o espacios distintos
            $whereParts[] = "t.tema LIKE :tema";
            $params[':tema'] = "%{$tema}%";
        }
        if (!empty($fecha)) {
            $whereParts[] = "DATE(t.fecha_creacion) = :fecha";
            $params[':fecha'] = $fecha; // yyyy-mm-dd
        }

        $where = implode(' AND ', $whereParts);

        // TOTAL
        $countSql = "SELECT COUNT(*) FROM trayectoria t WHERE {$where}";
        $stc = $pdo->prepare($countSql);
        foreach ($params as $k=>$v) {
            $stc->bindValue($k, $v, is_int($v)?\PDO::PARAM_INT:\PDO::PARAM_STR);
        }
        $stc->execute();
        $total = (int)$stc->fetchColumn();

        // Página/offset
        $pages  = max(1, (int)ceil($total / $perPage));
       if ($page > $pages) {
    $page = $pages;
}
        $offset = ($page - 1) * $perPage;

        // DATOS
        $dataSql = "
            SELECT t.id,t.id_solicitante,t.tema,t.tiempo_formacion,t.descripcion,t.acciones,
                   t.fecha_creacion,t.calificacion_1,t.pregunta_1,t.calificacion_2,t.pregunta_2,
                   t.cedula_asesor,t.unidad,t.nombre_asesor,t.cedula_formador,t.cargo,t.nombre_cargo,t.estado
            FROM trayectoria t
            WHERE {$where}
            ORDER BY t.id DESC
            LIMIT :limit OFFSET :offset";
        $std = $pdo->prepare($dataSql);
        foreach ($params as $k=>$v) {
            $std->bindValue($k, $v, is_int($v)?\PDO::PARAM_INT:\PDO::PARAM_STR);
        }
        $std->bindValue(':limit',  $perPage, \PDO::PARAM_INT);
        $std->bindValue(':offset', $offset,  \PDO::PARAM_INT);
        $std->execute();
        $trayectorias = collect($std->fetchAll());

        // PAGER (preserva filtros)
        $makeUrl = function (int $p) use ($request, $perPage) {
            return $request->fullUrlWithQuery(['page'=>$p,'per_page'=>$perPage]);
        };
        $pager['total']=$total; $pager['pages']=$pages; $pager['page']=$page;
        $pager['has_prev']=$page>1; $pager['has_next']=$page<$pages;
        $pager['first_url']=$pages?$makeUrl(1):null;
        $pager['prev_url']=$pager['has_prev']?$makeUrl($page-1):null;
        $pager['next_url']=$pager['has_next']?$makeUrl($page+1):null;
        $pager['last_url']=$pages?$makeUrl($pages):null;

        // Números visibles (ventana alrededor de la actual)
        $window = 2; $start=max(1,$page-$window); $end=min($pages,$page+$window);
        for ($p = $start; $p <= $end; $p++) {
    $pager['page_links'][$p] = $makeUrl($p);
}

    } catch (\Throwable $e) {
        Log::error('[Trayectoria@index] ERROR', ['msg'=>$e->getMessage()]);
    }

    return view('trayectoria_formativa.listado_trayectoria', compact('trayectorias','pager'));
}


// app/Http/Controllers/TrayectoriaController.php
public function modalCalificarPartial()
{
    // Devuelve SOLO el <dialog> del modal (vista sin @extends)
    return view('trayectoria_formativa.modal_calificar');
}
    /** Ping: prueba conexión a la BD administrativa */
    public function pingDb()
    {
        try {
            $pdo = $this->pdoAdmin();
            $one = $pdo->query("SELECT 1 AS ok")->fetch();
            return response()->json(['ok' => true, 'db' => $one['ok'] ?? null]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** Guarda pregunta/calificación en trayectoria (administrativa.trayectoria) */
public function guardarCalificacion(Request $r)
{
    Log::info('➡️ [guardarCalificacion] Inicio', $r->all());

    $numero = (int) $r->input('numero', 0);

    // Reglas de validación
    $rules = [
        'id'       => 'required|integer',
        'numero'   => 'required|integer|in:1,2,3',
        'pregunta' => 'required|string|max:1000',
    ];

    if ($numero === 3) {
        $rules['calificacion'] = 'nullable|string|max:200';
    } else {
        $rules['calificacion'] = 'required|integer|min:0|max:5';
    }

    try {
        $v = validator($r->all(), $rules)->validate();
        Log::info('✅ [guardarCalificacion] Validación exitosa', $v);
    } catch (\Throwable $e) {
        Log::error('❌ [guardarCalificacion] Error en validación: '.$e->getMessage(), ['input'=>$r->all()]);
        throw $e;
    }

    $mapP = [1 => 'pregunta_1', 2 => 'pregunta_2', 3 => 'pregunta_3'];
    $mapC = [1 => 'calificacion_1', 2 => 'calificacion_2', 3 => 'calificacion_3'];
    $colP = $mapP[$numero];
    $colC = $mapC[$numero];
    $preg = mb_substr($v['pregunta'], 0, 250);

    try {
        $pdo = $this->pdoAdmin();
        Log::info('🔗 [guardarCalificacion] Conexión PDO creada');

        $sql = "UPDATE trayectoria
                SET {$colP} = :preg,
                    {$colC} = :calif,
                    estado_action = 1
                WHERE id = :id
                LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':preg', $preg, \PDO::PARAM_STR);
        $stmt->bindValue(':id', (int) $v['id'], \PDO::PARAM_INT);

        if ($numero === 3) {
        $txt = trim((string)($v['calificacion'] ?? ''));
        if ($txt === '') {
            $stmt->bindValue(':calif', null, \PDO::PARAM_NULL);
            Log::info('🟡 [guardarCalificacion] Guardando calificación texto vacía (NULL)', ['numero'=>$numero]);
        } else {
                $stmt->bindValue(':calif', $txt, \PDO::PARAM_STR);
                Log::info('🟡 [guardarCalificacion] Guardando calificación texto', ['numero'=>$numero,'valor'=>$txt]);
            }
        } else {
            $stmt->bindValue(':calif', (int)$v['calificacion'], \PDO::PARAM_INT);
            Log::info('🟢 [guardarCalificacion] Guardando calificación numérica', ['numero'=>$numero,'valor'=>$v['calificacion']]);
        }



        $stmt->execute();
        $filas = $stmt->rowCount();

        Log::info('✅ [guardarCalificacion] Ejecución completada', ['filas_afectadas'=>$filas]);

        return response()->json([
            'success' => true,
            'updated' => $filas > 0,
        ]);

    } catch (\Throwable $e) {
        Log::error('💥 [guardarCalificacion] Error al ejecutar SQL: '.$e->getMessage(), [
            'sql' => $sql ?? '',
            'params' => $v ?? []
        ]);
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

/** Helper: crea PDO hacia la BD administrativa */
private function pdoAdmin(): \PDO
{
    Log::info('🔧 [pdoAdmin] Creando conexión PDO administrativa');

    $host = env('EXT_ADMIN_HOST', '192.168.6.118');
    $db   = env('EXT_ADMIN_DB', 'administrativa');
    $user = env('EXT_ADMIN_USER', 'intranet2');
    $pass = env('EXT_ADMIN_PASS', 'Finleco2025*-+');

    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

    return new \PDO($dsn, $user, $pass, [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ]);
}

public function calificar(Request $req)
{
    Log::info('➡️ [calificar] Inicio', $req->all());

    $id   = (int) $req->query('id');
    $paso = (string) $req->query('paso', '1');

    if (!$id) {
        Log::warning('⚠️ [calificar] ID inválido', ['id'=>$id]);
        return response('ID inválido', 400);
    }

    $config = [
        '1' => [
            'titulo'        => 'Pregunta 1',
            'texto'         => 'En una escala de 0 a 5, ¿qué tan claro te quedó el tema reforzado?',
            'numero'        => 1,
            'tieneSiguiente'=> true,
        ],
        '2' => [
            'titulo'        => 'Pregunta 2',
            'texto'         => 'En una escala de 0 a 5, ¿qué tan útil fue para tu gestión diaria?',
            'numero'        => 2,
            'tieneSiguiente'=> false,
        ],
    ];

    if (!isset($config[$paso])) {
        Log::warning('⚠️ [calificar] Paso inválido', ['paso'=>$paso]);
        return response('Paso inválido', 400);
    }

    Log::info('✅ [calificar] Mostrando vista', ['paso'=>$paso,'id'=>$id]);

    return view('trayectoria_formativa.calificarTrayectoria', [
        'registroId'     => $id,
        'titulo'         => $config[$paso]['titulo'],
        'texto'          => $config[$paso]['texto'],
        'numero'         => $config[$paso]['numero'],
        'tieneSiguiente' => $config[$paso]['tieneSiguiente'],
    ]);
}

}

