@php use App\Models\User; @endphp
@extends('layouts.plantilla')

@section('title', 'listado horarios')

@section('content')
    <link rel="stylesheet" href="{{ asset('/css/Permisos.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <script src="/intranet/js/sweetalert2.min.js"></script>

    <main id="main" class="main">
        <div class="pagetitle">
            <div class="container mx-auto tab-pane shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold" style="color:#012970">Listado Horarios</h2>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('horarios.index') }}">Tabla</a></li>
                        <li class="breadcrumb-item active">Información</li>
                    </ol>
                </nav>

                <div class="container">
                    <div class="mx-auto">
                        <div class="panel" style="background:#ffffff;">
                            <div class="panel-heading" style="background:#e26d2dbd;">
                                <div class="row">
                                    <div class="col-sm-9 col-xs-12 text-right">
                                        <div class="btn_group">
                                            {{-- Formulario de búsqueda --}}
                                            <form method="GET" action="{{ route('listado.horarios') }}">
                                                <div class="search-container">
                                                    <div>
                                                        {{-- Botón volver --}}
                                                        <a href="{{ route('horarios.index') }}">
                                                            <button class="mt-4 border rounded"; style="left: -770px"
                                                                type="button"">
                                                                <span class="btnText  fw-bold">Volver</span>
                                                            </button></a>
                                                        </a>
                                                    </div>
                                                    <label for="busqueda_gen" class="visually-hidden">Buscar
                                                        horarios</label>
                                                    <input class="form-control  w-100 w-md-80 " type="text"
                                                        name="busqueda_gen" id="busqueda_gen" placeholder="Buscar..."
                                                        value="{{ request('busqueda_gen') }}">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body table-responsive custom-scroll">
                                {{-- Tabla --}}
                                <table class="table" id="datos" style="text-align:center">
                                    <thead>
                                        <tr style="background:#e26c2d6e">
                                            <th style="color:#012970">N° Solicitud</th>
                                            <th style="color:#012970">Estado</th>
                                            <th style="color:#012970">Nombre</th>
                                            <th style="color:#012970">Unidad</th>
                                            <th style="color:#012970">Descripción</th>
                                            <th style="color:#012970">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $dato)
                                            @php
                                                $estadoTxt =
                                                    $dato->estado == 2
                                                        ? 'Aprobado'
                                                        : ($dato->estado == 1
                                                            ? 'Rechazado'
                                                            : ($dato->estado == 4
                                                                ? 'Parcialmente Aprobado'
                                                                : ($dato->estado == 3
                                                                    ? 'En proceso'
                                                                    : 'Pendiente')));

                                                $estadoStyle =
                                                    $dato->estado == 2
                                                        ? 'background-color:#a4e6c888; color:#012970;'
                                                        : ($dato->estado == 1
                                                            ? 'background-color:#ffafb988; color:#012970;'
                                                            : ($dato->estado == 4
                                                                ? 'background-color:#f5cdb6; color:#012970;'
                                                                : ($dato->estado == 3
                                                                    ? 'background-color:#e8ab0151; color:#012970;'
                                                                    : 'background-color:#fff; color:#012970;')));
                                            @endphp

                                            {{-- Fila visible --}}
                                            <tr>
                                                <td style="color:#012970">{{ $dato->id }}</td>
                                                <td style="{{ $estadoStyle }}">{{ $estadoTxt }}</td>
                                                <td style="color:#012970">
                                                    {{ $dato->usuario->nombre ?? (optional(User::find($dato->usuario_id))->nombre ?? '—') }}
                                                </td>
                                                <td style="color:#012970">{{ $dato->unidad->unidad ?? '—' }}</td>
                                                <td style="color: #012970">
                                                    <textarea name="descripcion[]" rows="3"
                                                        style="width:100%; border:1px solid #ccc; border-radius:5px; color:#012970;">
                                                        {{ $dato->descripcion }}
                                                    </textarea>
                                                </td>
                                                <td style="display:flex; justify-content:space-evenly; align-items:center">
                                                    @if ($dato->estado == 0)
                                                        <button type="button" title="Editar" onclick="Modificar(this)"
                                                            data-id="{{ $dato->id }}"
                                                            data-descripcion="{{ $dato->descripcion }}"
                                                            data-tipo="{{ $dato->tipo_horario ?? 'indefinido' }}"
                                                            data-horario-actual='@json($dato->horario_actual ?? [])'
                                                            data-horario-solicitado='@json($dato->horario_solicitado ?? [])'
                                                            style="background-color:transparent; border:0; border-radius:5px; width:35px; height:35px;">
                                                            {{-- icono editar --}}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    <button title="Ver" type="button"
                                                        onclick="verPermiso({{ $dato->id }})"
                                                        style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                            <path
                                                                d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                                            <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"
                                                                style="color: #0a4679" />
                                                            <path d="M18.5 19.5l2.5 2.5" style="color: #0a4679" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                // Formatea "YYYY-mm-dd HH:ii:ss" (o similares) a "dd/mm/YYYY hh:mm AM/PM"
                                                $fmtFecha = function ($f) {
                                                    if (!$f) {
                                                        return '';
                                                    }
                                                    try {
                                                        // Acepta string o instancia DateTime/Carbon
                                                        if ($f instanceof DateTimeInterface) {
                                                            $dt = new DateTime($f->format('Y-m-d H:i:s'));
                                                        } else {
                                                            $dt = new DateTime((string) $f);
                                                        }
                                                        $dt->setTimezone(new DateTimeZone('America/Bogota'));
                                                        return $dt->format('d/m/Y h:i A');
                                                    } catch (Throwable $e) {
                                                        return (string) $f;
                                                    }
                                                };

                                                // Formatea horas "H:i" o "H:i:s" a "hh:mm AM/PM"
                                                $fmtHora = function ($h) {
                                                    if (!$h) {
                                                        return '';
                                                    }
                                                    try {
                                                        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $h)) {
                                                            $dt = DateTime::createFromFormat('H:i:s', $h);
                                                        } elseif (preg_match('/^\d{1,2}:\d{2}$/', $h)) {
                                                            $dt = DateTime::createFromFormat('H:i', $h);
                                                        } else {
                                                            return $h; // deja tal cual si no coincide
                                                        }
                                                        return $dt ? $dt->format('h:i A') : $h;
                                                    } catch (Throwable $e) {
                                                        return $h;
                                                    }
                                                };
                                            @endphp

                                            <template id="permiso-doc-{{ $dato->id }}">
                                                <div class="doc-wrapper"
                                                    data-fecha="{{ $fmtFecha($dato->fecha_creacion ?? $dato->created_at) }}"
                                                    data-lunesactual="{{ $fmtHora($dato->lunesActual ?? '') }}"
                                                    data-martesactual="{{ $fmtHora($dato->martesActual ?? '') }}"
                                                    data-miercolesactual="{{ $fmtHora($dato->miercolesActual ?? '') }}"
                                                    data-juevesactual="{{ $fmtHora($dato->juevesActual ?? '') }}"
                                                    data-viernesactual="{{ $fmtHora($dato->viernesActual ?? '') }}"
                                                    data-sabadoactual="{{ $fmtHora($dato->sabadoActual ?? '') }}"
                                                    data-lunescambio="{{ $fmtHora($dato->lunesCambio ?? '') }}"
                                                    data-martescambio="{{ $fmtHora($dato->martesCambio ?? '') }}"
                                                    data-miercolescambio="{{ $fmtHora($dato->miercolesCambio ?? '') }}"
                                                    data-juevescambio="{{ $fmtHora($dato->juevesCambio ?? '') }}"
                                                    data-viernescambio="{{ $fmtHora($dato->viernesCambio ?? '') }}"
                                                    data-sabadocambio="{{ $fmtHora($dato->sabadoCambio ?? '') }}">
                                                    <table class="doc">
                                                        <colgroup>
                                                            <col style="width:25%">
                                                            <col style="width:25%">
                                                            <col style="width:25%">
                                                            <col style="width:25%">
                                                        </colgroup>
                                                        <tbody>
                                                            <tr class="title">
                                                                <td colspan="4" class="center bold">SOLICITUD CAMBIO DE
                                                                    HORARIO</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">FECHA DILIGENCIAMIENTO</td>
                                                                <td>{{ $fmtFecha($dato->created_at) }}</td>
                                                                <td class="label">FECHA A SOICITAR</td>
                                                                <td>{{ $dato->fecha_solicitar }}</td>
                                                            </tr>
                                                            </tr>
                                                            <tr class="section">
                                                                <td colspan="4" class="center bold">INFORMACIÓN SOBRE
                                                                    EL PERMISO</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">NOMBRE DEL EMPLEADO</td>
                                                                <td colspan="3">
                                                                    {{ $dato->usuario->nombre ?? (optional(User::find($dato->usuario_id))->nombre ?? '—') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">CARGO</td>
                                                                <td>{{ optional(DB::table('roles')->where('id', $dato->id_rol)->first())->rol ?? 'Rol no encontrado' }}
                                                                </td>
                                                                <td class="label">PROCESO AL QUE PERTENECE</td>
                                                                <td>{{ $dato->unidad->unidad ?? '—' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">JEFE INMEDIATO</td>
                                                                <td colspan="3">
                                                                    {{ optional(User::find($dato->jefe_id))->nombre ?? '—' }}
                                                                </td>
                                                            </tr>
                                                            <tr class="section">
                                                                <td colspan="4" class="center bold">MOTIVO CAMBIO DE
                                                                    HORARIO</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="descripcion">
                                                                    {{ $dato->descripcion ?? 'Sin descripción' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">SOLICITUD DEL HORARIO</td>
                                                                <td colspan="3"><!--RESUMEN_SOLICITUD--></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </template>
                                        @endforeach

                                        <tr class="noSearch hide">
                                            <td colspan="10"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Modal para editar permiso -->
                                <div class="modal fade" id="modalEditarHorario" tabindex="-1"
                                    aria-labelledby="modalEditarHorarioLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#e26d2dbd;">
                                                <h5 class="modal-title text-white" id="modalEditarHorarioLabel">Editar
                                                    solicitud de cambio de horario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>

                                            <form id="formEditarHorario" method="POST" action="#">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="fecha_solicitar_h_edit">Fecha a
                                                            Solicitar</label>
                                                        <input type="date" class="form-control" name="fecha_solicitar"
                                                            id="fecha_solicitar_h_edit" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="descripcion_h_edit">Descripción</label>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_h_edit" rows="3" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="tipoHorarioEdit">Tipo de
                                                            horario</label>
                                                        <select id="tipoHorarioEdit" name="tipo_horario"
                                                            class="form-control" required>
                                                            <option value="indefinido">Indefinido</option>
                                                            <option value="un_dia">Un Día</option>
                                                        </select>
                                                    </div>

                                                    {{-- INDEFINIDO --}}
                                                    <div id="bloqueIndefinidoEdit" style="display:none; margin-top:12px;">
                                                        @php
                                                            $diasMap = [
                                                                'LUNES' => 'lunes',
                                                                'MARTES' => 'martes',
                                                                'MIERCOLES' => 'miercoles',
                                                                'JUEVES' => 'jueves',
                                                                'VIERNES' => 'viernes',
                                                                'SABADO' => 'sabado',
                                                            ];
                                                        @endphp

                                                        <div class="horario-row">
                                                            <div class="horario-tag">HORARIO ACTUAL</div>
                                                            <table class="horario-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:35%;">DÍA</th>
                                                                        <th>HORA INGRESO</th>
                                                                        <th>HORA SALIDA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($diasMap as $label => $key)
                                                                        <tr>
                                                                            <td>{{ $label }}</td>
                                                                            <td>
                                                                                <input type="time"
                                                                                    name="horario_actual[{{ $key }}][ingreso]"
                                                                                    id="a_{{ $key }}_ing"
                                                                                    class="form-control">
                                                                            </td>
                                                                            <td>
                                                                                <input type="time"
                                                                                    name="horario_actual[{{ $key }}][salida]"
                                                                                    id="a_{{ $key }}_sal"
                                                                                    class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="horario-row">
                                                            <div class="horario-tag">HORARIO SOLICITADO</div>
                                                            <table class="horario-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:35%;">DÍA</th>
                                                                        <th>HORA INGRESO</th>
                                                                        <th>HORA SALIDA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($diasMap as $label => $key)
                                                                        <tr>
                                                                            <td>{{ $label }}</td>
                                                                            <td>
                                                                                <input type="time"
                                                                                    name="horario_solicitado[{{ $key }}][ingreso]"
                                                                                    id="c_{{ $key }}_ing"
                                                                                    class="form-control">
                                                                            </td>
                                                                            <td>
                                                                                <input type="time"
                                                                                    name="horario_solicitado[{{ $key }}][salida]"
                                                                                    id="c_{{ $key }}_sal"
                                                                                    class="form-control">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- UN DÍA --}}
                                                    <div id="bloqueUnDiaEdit" style="display:none; margin-top:12px;">
                                                        <div class="input-field"
                                                            style="max-width:340px; margin-bottom:10px">
                                                            <label for="diaUnicoEdit">Día</label>
                                                            <select id="diaUnicoEdit" class="form-control">
                                                                <option value="">Seleccione</option>
                                                                <option value="lunes">LUNES</option>
                                                                <option value="martes">MARTES</option>
                                                                <option value="miercoles">MIERCOLES</option>
                                                                <option value="jueves">JUEVES</option>
                                                                <option value="viernes">VIERNES</option>
                                                                <option value="sabado">SÁBADO</option>
                                                            </select>
                                                        </div>

                                                        <div class="horario-row">
                                                            <div class="horario-tag">HORARIO ACTUAL</div>
                                                            <table class="horario-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:35%;">DÍA</th>
                                                                        <th>HORA INGRESO</th>
                                                                        <th>HORA SALIDA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="diaActualLabelEdit">--</td>
                                                                        <td><input type="time" id="a_unico_ing"></td>
                                                                        <td><input type="time" id="a_unico_sal"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="horario-row">
                                                            <div class="horario-tag">HORARIO SOLICITADO</div>
                                                            <table class="horario-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:35%;">DÍA</th>
                                                                        <th>HORA INGRESO</th>
                                                                        <th>HORA SALIDA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="diaSolicitadoLabelEdit">--</td>
                                                                        <td><input type="time" id="c_unico_ing"></td>
                                                                        <td><input type="time" id="c_unico_sal"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <input type="hidden" name="dia_unico" id="diaUnicoHiddenEdit">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnGuardarEditar">Guardar
                                                        cambios</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="pagination justify-content-center mt-4 mb-4">
                                    <nav>
                                        <ul class="pagination" style="">
                                            {{-- Botón Anterior --}}
                                            <li class="page-item {{ $datos->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" style="color: #012970"
                                                    href="{{ $datos->previousPageUrl() }}" rel="prev"
                                                    aria-label="« Previous">&lt;</a>
                                            </li>

                                            {{-- Números de página generados dinámicamente --}}
                                            @for ($i = 1; $i <= $datos->lastPage(); $i++)
                                                <li class="page-item {{ $datos->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        style="
                                                          border-radius: 3px;
                                                   {{ $datos->currentPage() == $i ? 'color: #012970; pointer-events: none; cursor: default; background-color: #e9ecef;' : 'color: #012970;' }}"
                                                        href="{{ $datos->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            {{-- Botón Siguiente --}}
                                            <li class="page-item {{ $datos->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" style="color: #012970"
                                                    href="{{ $datos->nextPageUrl() }}" rel="next"
                                                    aria-label="Next »">&gt;
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

            const modalEl = document.getElementById('modalEditarHorario');
            const form = document.getElementById('formEditarHorario');

            const descripcion = document.getElementById('descripcion_h_edit');
            const tipoSelect = document.getElementById('tipoHorarioEdit');
            // Convierte "YYYY-mm-dd ..." → "YYYY-mm-dd" (para <input type="date">)
            const toYmd = (s) => {
                if (!s) return '';
                const m = String(s).match(/^(\d{4})-(\d{2})-(\d{2})/);
                return m ? `${m[1]}-${m[2]}-${m[3]}` : '';
            };


            const bloqueInd = document.getElementById('bloqueIndefinidoEdit');
            const bloqueUnDia = document.getElementById('bloqueUnDiaEdit');

            const diaUnicoSel = document.getElementById('diaUnicoEdit');
            const diaUnicoHidden = document.getElementById('diaUnicoHiddenEdit');
            const diaActualLabel = document.getElementById('diaActualLabelEdit');
            const diaSolicitadoLabel = document.getElementById('diaSolicitadoLabelEdit');

            // Campos "un día" (sin name)
            const a_unico_ing = document.getElementById('a_unico_ing');
            const a_unico_sal = document.getElementById('a_unico_sal');
            const c_unico_ing = document.getElementById('c_unico_ing');
            const c_unico_sal = document.getElementById('c_unico_sal');

            function toggleBloques(tipo) {
                if (tipo === 'indefinido') {
                    bloqueInd.style.display = 'block';
                    bloqueUnDia.style.display = 'none';
                } else {
                    bloqueInd.style.display = 'none';
                    bloqueUnDia.style.display = 'block';
                }
            }

            tipoSelect.addEventListener('change', () => {
                toggleBloques(tipoSelect.value);
            });

            diaUnicoSel.addEventListener('change', () => {
                const d = diaUnicoSel.value;
                diaUnicoHidden.value = d || '';
                const label = d ? d.toUpperCase() : '--';
                diaActualLabel.textContent = label;
                diaSolicitadoLabel.textContent = label;
            });

            // -------- helpers para pintar ----------
            function setValById(id, val) {
                const el = document.getElementById(id);
                if (!el) return;
                el.value = (val ?? '').toString();
            }

            function fillFormWithData(data) {
                // 1) Siempre pinta el GRID semanal (Actual / Cambio)
                dias.forEach(d => {
                    const A = data.Actual?.[d] || {};
                    const C = data.Cambio?.[d] || {};
                    setValById(`a_${d}_ing`, A.ingreso || '');
                    setValById(`a_${d}_sal`, A.salida || '');
                    setValById(`c_${d}_ing`, C.ingreso || '');
                    setValById(`c_${d}_sal`, C.salida || '');
                });

                // 2) Si es UN DÍA, pinta también los 4 campos únicos (FIX: definir d)
                if (data.tipo_horario === 'un_dia') {
                    const d = data.dia_unico || '';
                    const A = data.Actual?.[d] || {};
                    const C = data.Cambio?.[d] || {};
                    setValById('a_unico_ing', A.ingreso || '');
                    setValById('a_unico_sal', A.salida || '');
                    setValById('c_unico_ing', C.ingreso || '');
                    setValById('c_unico_sal', C.salida || '');
                }
            }

            // -------- abrir modal desde los botones --------
            document.querySelectorAll('.btn-editar-horario').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.getAttribute('data-id');
                    if (!id) return;

                    form.reset();
                    form.setAttribute('action', `{{ url('/horarios') }}/${id}`);

                    try {
                        const url = `{{ url('/horarios') }}/${id}/json`;
                        const res = await fetch(url, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        if (!res.ok) throw new Error('No se pudo cargar el horario');
                        const data = await res.json();

                        // Básicos
                        descripcion.value = data.descripcion || '';
                        tipoSelect.value = data.tipo_horario || 'indefinido';
                        toggleBloques(tipoSelect.value);

                        // Fecha a solicitar → input date
                        // helper local para normalizar string a Y-m-d
                        const toYmd = (s) => {
                            if (!s) return '';
                            const str = String(s).trim();
                            let m = str.match(/^(\d{4})-(\d{2})-(\d{2})/); // Y-m-d
                            if (m) return `${m[1]}-${m[2]}-${m[3]}`;
                            m = str.match(/^(\d{2})\/(\d{2})\/(\d{4})$/); // d/m/Y
                            if (m) return `${m[3]}-${m[2]}-${m[1]}`;
                            return '';
                        };

                      document.getElementById('fecha_solicitar_h_edit').value =
  toYmd(data.fecha_solicitar || data.fecha || data.fechaSolicitar || '');

                        if (data.tipo_horario === 'un_dia') {
                            const d = data.dia_unico || '';
                            diaUnicoSel.value = d;
                            diaUnicoHidden.value = d;
                            const label = d ? d.toUpperCase() : '--';
                            diaActualLabel.textContent = label;
                            diaSolicitadoLabel.textContent = label;
                        }

                        // Pintar inmediatamente
                        fillFormWithData(data);

                        // Volver a pintar cuando el modal ya esté visible (evita re-render que borre valores)
                        const onceShown = () => {
                            fillFormWithData(data);
                            modalEl.removeEventListener('shown.bs.modal', onceShown);
                        };
                        modalEl.addEventListener('shown.bs.modal', onceShown);

                        new bootstrap.Modal(modalEl).show();

                    } catch (e) {
                        console.error(e);
                        alert('Hubo un error cargando la información del horario.');
                    }
                });
            });

            // -------- submit: confirm SweetAlert2 + genera hiddens para "un_dia" --------
            form.addEventListener('submit', async (e) => {
                e.preventDefault(); // detenemos por ahora

                const {
                    isConfirmed
                } = await Swal.fire({
                    title: '¿Guardar cambios?',
                    text: 'Esta seguro de actualizar esta solicitud.', // tu mensaje
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Cancelar'
                });

                if (!isConfirmed) return;

                // limpia previos autogenerados
                form.querySelectorAll('input[type="hidden"]._autoGen').forEach(n => n.remove());

                if (tipoSelect.value === 'un_dia') {
                    const d = diaUnicoHidden.value;
                    if (d) {
                        const addHidden = (name, value) => {
                            const i = document.createElement('input');
                            i.type = 'hidden';
                            i.className = '_autoGen';
                            i.name = name;
                            i.value = value || '';
                            form.appendChild(i);
                        };

                        // Solicitado (Cambio)
                        addHidden(`horario_solicitado[${d}][ingreso]`, c_unico_ing.value);
                        addHidden(`horario_solicitado[${d}][salida]`, c_unico_sal.value);

                        // Actual
                        addHidden(`horario_actual[${d}][ingreso]`, a_unico_ing.value);
                        addHidden(`horario_actual[${d}][salida]`, a_unico_sal.value);
                    }
                }

                // opcional: bloquear botón para evitar doble envío
                const btn = e.submitter;
                if (btn) {
                    btn.disabled = true;
                    btn.dataset.originalText = btn.innerHTML;
                    btn.innerHTML = 'Guardando...';
                }

                // enviar ahora sí
                form.submit();
            });
        });

        async function Modificar(btn) {

            const id = btn.getAttribute('data-id');
            if (!id) return;

            const modalEl = document.getElementById('modalEditarHorario');
            const form = document.getElementById('formEditarHorario');

            const descripcion = document.getElementById('descripcion_h_edit');
            const tipoSelect = document.getElementById('tipoHorarioEdit');

            const bloqueInd = document.getElementById('bloqueIndefinidoEdit');
            const bloqueUnDia = document.getElementById('bloqueUnDiaEdit');

            const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

            const diaUnicoSel = document.getElementById('diaUnicoEdit');
            const diaUnicoHidden = document.getElementById('diaUnicoHiddenEdit');
            const diaActualLabel = document.getElementById('diaActualLabelEdit');
            const diaSolicitadoLabel = document.getElementById('diaSolicitadoLabelEdit');

            const a_unico_ing = document.getElementById('a_unico_ing');
            const a_unico_sal = document.getElementById('a_unico_sal');
            const c_unico_ing = document.getElementById('c_unico_ing');
            const c_unico_sal = document.getElementById('c_unico_sal');

            function toggleBloques(tipo) {
                if (tipo === 'indefinido') {
                    bloqueInd.style.display = 'block';
                    bloqueUnDia.style.display = 'none';
                } else {
                    bloqueInd.style.display = 'none';
                    bloqueUnDia.style.display = 'block';
                }
            }


            // 1) Reset y set action
            form.reset();
            form.setAttribute('action', `{{ url('/horarios') }}/${id}`);

            // 2) Traer JSON
            try {
                const url = `{{ url('/horarios') }}/${id}/json`;
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) {
                    // Si aquí obtienes 403, recuerda que tu showJson bloquea a quien no es el dueño.
                    throw new Error('No se pudo cargar la información (¿403/404?)');
                }
                const data = await res.json();
                (function setFechaYmd() {
  const inFecha = document.getElementById('fecha_solicitar_h_edit');
  const toYmd = (s) => {
    if (!s) return '';
    const str = String(s).trim();
    let m = str.match(/^(\d{4})-(\d{2})-(\d{2})/);         // Y-m-d
    if (m) return `${m[1]}-${m[2]}-${m[3]}`;
    m = str.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);          // d/m/Y
    if (m) return `${m[3]}-${m[2]}-${m[1]}`;
    return '';
  };
  inFecha.value = toYmd(data.fecha_solicitar || data.fecha || data.fechaSolicitar || '');
})();
                console.log('JSON recibido:', data);
                console.log('Actual lunes:', data.Actual?.lunes);
                console.log('Cambio lunes:', data.Cambio?.lunes);


                // 3) Llenar campos
                descripcion.value = data.descripcion || '';
                tipoSelect.value = data.tipo_horario || 'indefinido';
                toggleBloques(tipoSelect.value);

                if (data.tipo_horario === 'indefinido') {
                    const set = (id, name, val) => {
                        let el = document.getElementById(id);
                        if (el) {
                            el.value = (val ?? '').toString();
                            return;
                        }
                        el = form.querySelector(`[name="${name}"]`);
                        if (el) {
                            el.value = (val ?? '').toString();
                            return;
                        }
                        console.warn('Falta input en el DOM → id:', id, ' name:', name);
                    };

                    dias.forEach(d => {
                        const A = data.Actual?.[d] || {};
                        const C = data.Cambio?.[d] || {};

                        // ACTUAL (grid)
                        set(`a_${d}_ing`, `horario_actual[${d}][ingreso]`, A.ingreso);
                        set(`a_${d}_sal`, `horario_actual[${d}][salida]`, A.salida);

                        // CAMBIO / SOLICITADO (grid)
                        set(`c_${d}_ing`, `horario_solicitado[${d}][ingreso]`, C.ingreso);
                        set(`c_${d}_sal`, `horario_solicitado[${d}][salida]`, C.salida);
                    });
                } else {
                    const d = data.dia_unico || '';
                    diaUnicoSel.value = d;
                    diaUnicoHidden.value = d;
                    const label = d ? d.toUpperCase() : '--';
                    diaActualLabel.textContent = label;
                    diaSolicitadoLabel.textContent = label;

                    const A = data.Actual?.[d] || {};
                    const C = data.Cambio?.[d] || {};
                    if (a_unico_ing) a_unico_ing.value = A.ingreso || '';
                    if (a_unico_sal) a_unico_sal.value = A.salida || '';
                    if (c_unico_ing) c_unico_ing.value = C.ingreso || '';
                    if (c_unico_sal) c_unico_sal.value = C.salida || '';
                }

                // 4) Abrir modal
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

            } catch (err) {
                console.error(err);
                alert('No se pudo cargar el horario. Revisa consola y permisos.');
            }
        }

        function verPermiso(id) {
            let contenido = '';
            let ds = {};
            const tpl = document.getElementById('permiso-doc-' + id);

            if (tpl && 'content' in tpl) {
                const node = tpl.content.cloneNode(true);
                const wrap = node.querySelector('.doc-wrapper') || node.firstElementChild;
                if (!wrap) {
                    alert('No se encontró el contenido del permiso (template).');
                    return;
                }
                ds = {
                    ...wrap.dataset
                };
                contenido = wrap.innerHTML;
            } else {
                const wrap = document.getElementById('permiso-info-' + id);
                if (!wrap) {
                    alert('No se encontró el contenido del permiso.');
                    return;
                }
                ds = {
                    ...wrap.dataset
                };
                contenido = wrap.innerHTML;
            }

            // ===== Conversión 24h -> 12h (soporta rangos) =====
            const toAmPmSingle = (v) => {
                if (!v) return '';
                if (/\b(am|pm)\b/i.test(v)) return v; // ya viene formateado
                const m = /^\s*(\d{1,2})[:.](\d{2})(?::?(\d{2}))?\s*$/.exec(v);
                if (!m) return v;
                const H = parseInt(m[1], 10),
                    M = parseInt(m[2], 10);
                if (Number.isNaN(H) || Number.isNaN(M)) return v;
                const d = new Date();
                d.setHours(H, M, 0, 0);
                return d.toLocaleTimeString('es-CO', {
                    hour12: true,
                    hour: 'numeric',
                    minute: '2-digit'
                });
            };

            // separadores comunes de rango: '-', '–', '—', ' a ', '/', ' - '
            const RANGE_SEP_RE = /\s*(?:-|–|—|\/| a )\s*/i;

            const toAmPmSmart = (val) => {
                if (!val) return '';
                // Si es un rango "HH:MM-HH:MM" u otros separadores
                if (RANGE_SEP_RE.test(val)) {
                    const parts = val.split(RANGE_SEP_RE).filter(Boolean);
                    if (parts.length === 2) {
                        return `${toAmPmSingle(parts[0])} - ${toAmPmSingle(parts[1])}`;
                    }
                    // Si hay más de 2, convierte cada uno y únelos con ' - '
                    if (parts.length > 2) {
                        return parts.map(toAmPmSingle).join(' - ');
                    }
                }
                // Hora suelta
                return toAmPmSingle(val);
            };

            const hourKeys = [
                'lunesactual', 'martesactual', 'miercolesactual', 'juevesactual', 'viernesactual', 'sabadoactual',
                'lunescambio', 'martescambio', 'miercolescambio', 'juevescambio', 'viernescambio', 'sabadocambio'
            ];
            hourKeys.forEach(k => {
                if (ds[k]) ds[k] = toAmPmSmart(ds[k]);
            });

            if (ds.fecha) {
                const dt = new Date(ds.fecha);
                if (!isNaN(dt)) {
                    ds.fecha = dt.toLocaleString('es-CO', {
                        year: '2-digit',
                        month: '2-digit',
                        day: '2-digit',
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                }
            }
            // ===== Fin conversión =====

            // Días
            const dias = [{
                    label: 'Lunes',
                    a: 'lunesactual',
                    c: 'lunescambio'
                },
                {
                    label: 'Martes',
                    a: 'martesactual',
                    c: 'martescambio'
                },
                {
                    label: 'Miércoles',
                    a: 'miercolesactual',
                    c: 'miercolescambio'
                },
                {
                    label: 'Jueves',
                    a: 'juevesactual',
                    c: 'juevescambio'
                },
                {
                    label: 'Viernes',
                    a: 'viernesactual',
                    c: 'viernescambio'
                },
                {
                    label: 'Sábado',
                    a: 'sabadoactual',
                    c: 'sabadocambio'
                },
            ];

            const esc = (t) => (t ?? '').toString().replace(/[&<>"]/g, s => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;'
            } [s]));
            const normalize = (s) => (s ?? '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();

            const filas = [];
            let hayIndefinido = false;
            for (const d of dias) {
                const valA = (ds[d.a] || '').trim();
                const valC = (ds[d.c] || '').trim();
                if (normalize(valA).includes('indefinid') || normalize(valC).includes('indefinid')) hayIndefinido = true;
                if (valA || valC) {
                    filas.push(`<tr><td>${d.label}</td><td>${esc(valA) || '—'}</td><td>${esc(valC) || '—'}</td></tr>`);
                }
            }

            const nDias = filas.length;
            let sufijo;
            if (hayIndefinido || nDias === 0) {
                sufijo = '----';
            } else if (nDias === 1) {
                sufijo = '1 DÍA';
            } else {
                sufijo = 'INDEFINIDO';
            }

            contenido = contenido.replace('<!--RESUMEN_SOLICITUD-->', esc(sufijo));

            const bloqueHorario = `
    <table class="doc" style="margin-top:12px">
      <tbody>
        <tr>
          <td class="label">DÍA</td>
          <td class="label">HORARIO ANTERIOR</td>
          <td class="label">HORARIO CON CAMBIO</td>
        </tr>
        ${filas.length ? filas.join('') : `<tr><td colspan="3" class="center">Sin información de cambios</td></tr>`}
      </tbody>
    </table>`;
            contenido = contenido.replace('</tbody>', `${bloqueHorario}</tbody>`);

            const headerBlock = `
    <table style="width:100%; border-collapse:collapse; margin:10mm 0 6mm 0;">
      <tr>
        <td style="border:none; text-align:left; padding:4px 0;">
          <img src="{{ asset('/storage/logos/logo.png') }}" alt="Logo Empresa" style="height:50px; margin-right:12px;">
          <img src="{{ asset('/storage/logos/name.png') }}" alt="Logo" style="height:32px;">
        </td>
        <td style="border:none; text-align:right; font-size:12px; color:#012970; padding:4px 0;">
          <div style="margin-bottom:2px;"><b>CÓDIGO:</b> ${ds.codigo || 'GH-F-100'}</div>
          <div style="margin-bottom:2px;"><b>VERSIÓN:</b> ${ds.version || '001'}</div>
          <div><b>FECHA:</b> ${ds.fechaversion || '9/172025'}</div>
        </td>
      </tr>
    </table>`;

            const html = `
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="utf-8" />
      <title>Solicitud_${id}</title>
      <style>
        @page { size: A4; margin: 12mm; }
        body { font-family: Arial, Helvetica, sans-serif; color:#012970; margin:80px; }
        .doc { width:100%; border-collapse:collapse; table-layout:fixed; }
        .doc td { border:1px solid #000; padding:8px 10px; font-size:13px; vertical-align:middle; color:#012970; }
        .center { text-align:center; } .bold { font-weight:700; }
        .title td, .section td { background:#fabf8f; }
        .label { background:#538cd5; color:#fff; font-weight:700; width:25%; }
        .doc tr td { line-height:1.25; word-wrap:break-word; }
        .print-actions { position: fixed; top: 8px; right: 12px; z-index: 9999; }
        @media print { .print-actions { display:none; } }
      </style>
    </head>
    <body>
      ${headerBlock}
      ${contenido}
    </body>
    </html>`;

            const w = window.open('', '_blank', 'width=850,height=900');
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.document.title = 'Solicitud_' + id;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- refs que ya usas ---
            const form = document.getElementById('formEditarHorario');
            const saveBtn = document.getElementById('btnGuardarEditar');
            const tipoSelect = document.getElementById('tipoHorarioEdit');
            const descripcion = document.getElementById('descripcion_h_edit');
            const fechaSolicitar = document.getElementById('fecha_solicitar_h_edit');

            // Para "un día"
            const diaUnicoSel = document.getElementById('diaUnicoEdit');
            const a_unico_ing = document.getElementById('a_unico_ing');
            const a_unico_sal = document.getElementById('a_unico_sal');
            const c_unico_ing = document.getElementById('c_unico_ing');
            const c_unico_sal = document.getElementById('c_unico_sal');

            // Para "indefinido" (las tablas semanales)
            const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];

            // Valida "HH:MM" o "HH:MM:SS" (los <input type="time"> envían HH:MM)
            const isTime = (v) => /^\d{1,2}:\d{2}(:\d{2})?$/.test(String(v || '').trim());

            function validateEditar() {
                // campos siempre requeridos
                let ok =
                    String(descripcion?.value || '').trim().length > 0 &&
                    String(fechaSolicitar?.value || '').trim().length > 0 &&
                    String(tipoSelect?.value || '').trim().length > 0;

                if (!ok) {
                    saveBtn.disabled = true;
                    return;
                }

                if (tipoSelect.value === 'indefinido') {
                    // Requiere TODOS los tiempos (ingreso/salida) para cada día en Actual y Solicitado
                    for (const d of dias) {
                        const aIng = document.getElementById(`a_${d}_ing`)?.value;
                        const aSal = document.getElementById(`a_${d}_sal`)?.value;
                        const cIng = document.getElementById(`c_${d}_ing`)?.value;
                        const cSal = document.getElementById(`c_${d}_sal`)?.value;

                        if (!isTime(aIng) || !isTime(aSal) || !isTime(cIng) || !isTime(cSal)) {
                            ok = false;
                            break;
                        }
                    }
                } else if (tipoSelect.value === 'un_dia') {
                    // Requiere selección de día y los 4 campos de hora
                    ok =
                        String(diaUnicoSel?.value || '').trim().length > 0 &&
                        isTime(a_unico_ing?.value) &&
                        isTime(a_unico_sal?.value) &&
                        isTime(c_unico_ing?.value) &&
                        isTime(c_unico_sal?.value);
                }

                saveBtn.disabled = !ok;
            }

            // Revalidar ante cualquier cambio en el form
            form?.addEventListener('input', validateEditar);
            form?.addEventListener('change', validateEditar);

            // Revalidar cuando cambias el tipo (tu código ya hace toggle de bloques)
            tipoSelect?.addEventListener('change', validateEditar);

            // Llamada inicial al abrir la página (por si el modal arranca con datos)
            validateEditar();

            // Si en tu flujo llenas datos por fetch al abrir el modal, vuelve a validar después:
            // (Si ya tienes un listener a 'shown.bs.modal', puedes llamar validateEditar() ahí también.)
            const modalEl = document.getElementById('modalEditarHorario');
            modalEl?.addEventListener('shown.bs.modal', validateEditar);
        });
    </script>
@endsection
