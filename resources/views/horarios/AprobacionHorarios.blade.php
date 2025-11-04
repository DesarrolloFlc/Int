@extends('layouts.plantilla')

@section('title', 'Aprobacion de horarios')

@section('content')

    <link rel="stylesheet" href="{{ asset('/css/aprobacionHorario.css') }}?v={{ time() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main id="main" class="main no-anim">
        <div class="pagetitle ">
            <div class="container mx-auto tab-pane shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold" style="color: #012970">Aprobación de horarios</h2>
                <div class="panel" style="background:#ffffff;">
                    <div class="panel-heading"
                        style="background:#e26d2dbd; border-top-left-radius:12px; border-top-right-radius:12px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="form-busqueda" method="GET" action="{{ route('aprobacion.horarios') }}"
                                    class="mb-3">
                                    <input class="form-control" type="text" name="busqueda_gen" id="busqueda_gen"
                                        placeholder="Buscar..." value="{{ request('busqueda_gen') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="fields">
                            <div class="panel" style="background:#ffffff;">
                                <div class="panel-body table-responsive custom-scroll"
                                    style="border-bottom-left-radius:12px; border-bottom-right-radius:12px;">
                                    <table class="table table-borderless table-sm table-compact"
                                        style="text-align:center; margin:0;">
                                        @php
                                            $u = Auth::user();
                                            $authId = (int) (Auth::id() ?? 0);
                                            $rol = (int) ($rolIdActual ?? ($u->id_rol ?? ($u->rol_id ?? 0)));
                                            $unidad = (int) ($u->id_unidad ?? ($u->unidad_id ?? 0));
                                            $esR2U7 = $rol === 2 && $unidad === 7;
                                            $esR2U4 = $rol === 2 && $unidad === 4;
                                            $hayEstado2 = collect($rows ?? [])->contains(
                                                fn($r) => (int) ($r->estado ?? 0) === 2,
                                            );
                                            $mostrarColSoporte = $mostrarColSoporte =
                                                $esR2U4 || $authId === 25 || ($esR2U7 && $hayEstado2); //id se�ora ivonee
                                        @endphp
                                        <thead>
                                            <tr style="background:#e26c2d6e;">
                                                <th style="color:#012970;">No. SOLICITUD</th>
                                                <th style="color:#012970;">ESTADO</th>
                                                <th style="color:#012970;">NOMBRE DEL EMPLEADO</th>
                                                <th style="color:#012970;">CARGO</th>
                                                <th style="color:#012970;">PROCESO AL QUE PERTENECE</th>
                                                <th style="color:#012970;">JEFE INMEDIATO</th>
                                                <th style="color:#012970;">MOTIVO DE CAMBIO DE HORARIO</th>
                                                <th style="color:#012970;">FECHA DE<br>DILIGENCIAMIENTO</th>
                                                @if ($esR2U4)
                                                    <th style="color:#012970;">SOPORTE</th>
                                                @endif
                                                <th style="color:#012970;"> DESCARGAR</th>
                                                <th style="color:#012970;">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(($rows ?? []) as $h)
                                                <tr @if (isset($idSeleccionado) && $h->id === $idSeleccionado) style="background:#ffe8d9" @endif>
                                                    <td style="color:#012970;">{{ $h->id }}</td>
                                                    <td
                                                        style="
                                                    @if ($h->estado == 2) background-color:#a4e6c888;
                                                    @elseif($h->estado == 1) background-color:#ffafb988;
                                                    @elseif($h->estado == 3) background-color:#e8ab0150;
                                                    @elseif($h->estado == 4) background-color:#f5cdb6;
                                                    @else background-color:#ffffff; @endif color:#012970;">
                                                        @if ($h->estado == 2)
                                                            Aprobado
                                                        @elseif($h->estado == 3)
                                                            En proceso
                                                        @elseif($h->estado == 1)
                                                            Rechazado
                                                        @elseif($h->estado == 4)
                                                            Parcialmente Aprobado
                                                        @else
                                                            Pendiente
                                                        @endif
                                                    </td>
                                                    <td style="color:#012970;">{{ $h->usuario_nombre ?? '—' }}</td>
                                                    <td style="color:#012970;">{{ $h->cargo ?? '—' }}</td>
                                                    <td style="color:#012970;">{{ $h->unidad ?? '—' }}</td>
                                                    <td style="color:#012970;">{{ $h->jefe_nombre ?? '—' }}</td>
                                                    <td style="color:#012970; min-width:260px;">
                                                        <textarea class="form-control form-control-sm" rows="3" readonly maxlength="255" style="resize:vertical;">{{ $h->descripcion ?? '' }}</textarea>
                                                        @if (empty($h->descripcion))
                                                            <small class="text-muted">— Sin descripción —</small>
                                                        @endif
                                                    </td>
                                                    <td style="color:#012970;">
                                                        {{ $h->created_at ? \Carbon\Carbon::parse($h->created_at)->format('d/m/Y') : '—' }}
                                                    </td>
                                                    @php
                                                        $estado = (int) ($h->estado ?? 0);
                                                        // Detecta si existe algún soporte guardado (ajusta a tus columnas reales)
                                                        $tieneSoporte = !empty(
                                                            $h->soporte ??
                                                                ($h->soporte_path ??
                                                                    ($h->adjunto ?? ($h->archivo ?? $h->ruta_soporte)))
                                                        );
                                                    @endphp
                                                    @if ($esR2U4)
                                                        <td>
                                                            @if ($estado === 3)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    data-id="{{ $h->id }}"
                                                                    data-tiene="{{ $tieneSoporte ? '1' : '0' }}"
                                                                    onclick="subirSoporte(this)"
                                                                    title="{{ $tieneSoporte ? 'Reemplazar soporte' : 'Subir soporte' }}">
                                                                    {{ $tieneSoporte ? 'Reemplazar soporte' : 'Subir soporte' }}
                                                                </button>
                                                            @else
                                                                <span class="text-muted"></span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    @php
                                                        $u = Auth::user();
                                                        $rol =
                                                            (int) ($rolIdActual ?? ($u->id_rol ?? ($u->rol_id ?? 0)));
                                                        $unidad = (int) ($u->id_unidad ?? ($u->unidad_id ?? 0));
                                                        $esR2U7 = $rol === 2 && $unidad === 7;
                                                        // ¿Existe algún soporte?
                                                        $tieneSoporte =
                                                            !empty($h->soporte ?? null) ||
                                                            !empty($h->soporte_path ?? null) ||
                                                            !empty($h->adjunto ?? null) ||
                                                            !empty($h->archivo ?? null) ||
                                                            !empty($h->ruta_soporte ?? null);
                                                        // Descargar solo si hay soporte, y si es R2U7 además exigir estado=2
                                                        $puedeDescargar =
                                                            $tieneSoporte &&
                                                            (!$esR2U7 || (int) ($h->estado ?? 0) === 2);
                                                        // URL de descarga
                                                        $hrefDesc = \Illuminate\Support\Facades\Route::has(
                                                            'descargarsoporte',
                                                        )
                                                            ? route('descargarsoporte', ['id' => $h->id])
                                                            : url('/intranet/versoporte/' . $h->id . '/descargar');
                                                    @endphp
                                                    <td class="text-nowrap">
                                                        @if ($puedeDescargar)
                                                            <a class="btn btn-sm btn-outline-secondary"
                                                                href="{{ $hrefDesc }}">Descargar</a>
                                                        @else
                                                            <span class="text-muted"></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap">
                                                        @php
                                                            $esIdEsp = $authId === 25;
                                                            $estado = (int) ($h->estado ?? 0);
                                                            $estadoAction = (int) ($h->estado_action ?? 0);
                                                            // Reglas iguales a tu controlador:
                                                            $puedeAprobar =
                                                                ($esR2U7 && $estado === 0) ||
                                                                ($esR2U4 && $estado === 3) ||
                                                                ($esIdEsp && $estado === 4);
                                                            $puedeRechazar =
                                                                ($esR2U7 && $estado === 0) ||
                                                                ($esIdEsp && $estado === 4);
                                                            $puedeEliminar = $estado === 0 && $estadoAction === 0; // solo pendiente y no “eliminado”
                                                        @endphp
                                                        <form action="{{ route('horarios.aprobar', $h->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="accion" value="aprobar">
                                                            <button type="submit" class="btn btn-link p-0 mx-1 btn-accion"
                                                                data-accion="aprobar" aria-label="Aprobar"
                                                                title="{{ $puedeAprobar ? 'Aprobar' : 'No puedes aprobar este estado con tu rol/unidad' }}"
                                                                @disabled(!$puedeAprobar)
                                                                aria-disabled="{{ $puedeAprobar ? 'false' : 'true' }}"
                                                                style="width:35px;height:35px;background:none;border:0;{{ $puedeAprobar ? '' : 'opacity:.35;cursor:not-allowed;pointer-events:none;' }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-check"
                                                                    style="color: black">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                                    <path d="M15 19l2 2l4 -4" style="color: green" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('horarios.aprobar', $h->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="accion" value="rechazar">
                                                            <button type="submit"
                                                                class="btn btn-link p-0 mx-1 btn-accion"
                                                                data-accion="rechazar" aria-label="Rechazar"
                                                                title="{{ $puedeRechazar ? 'Rechazar' : 'No puedes rechazar este estado con tu rol/unidad' }}"
                                                                @disabled(!$puedeRechazar)
                                                                aria-disabled="{{ $puedeRechazar ? 'false' : 'true' }}"
                                                                style="width:35px;height:35px;background:none;border:0;{{ $puedeRechazar ? '' : 'opacity:.35;cursor:not-allowed;pointer-events:none;' }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-x"
                                                                    style="color: black">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                                    <path d="M22 22l-5 -5" style="color: red" />
                                                                    <path d="M17 22l5 -5" style="color: red" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <button title="Ver" type="button"
                                                            onclick="verPermiso({{ $h->id }})"
                                                            style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                <path
                                                                    d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                                                <path
                                                                    d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"
                                                                    style="color: #0a4679" />
                                                                <path d="M18.5 19.5l2.5 2.5" style="color: #0a4679" />
                                                            </svg>
                                                        </button>
                                                        <form id="f-{{ $h->id }}" method="POST"
                                                            action="{{ route('horarios.eliminar', $h->id) }}" hidden>
                                                            @csrf
                                                        </form>
                                                        <button type="submit" class="btn btn-link p-0 mx-1 btn-accion"
                                                            data-accion="eliminar" name="eliminar" value="1"
                                                            form="f-{{ $h->id }}"
                                                            title="{{ $puedeEliminar ? 'Eliminar' : 'Solo se puede eliminar si el estado es 0 y no ha sido eliminado' }}"
                                                            @disabled(!$puedeEliminar)
                                                            aria-disabled="{{ $puedeEliminar ? 'false' : 'true' }}"
                                                            style="width:35px;height:35px;background:none;border:0;{{ $puedeEliminar ? '' : 'opacity:.35;cursor:not-allowed;pointer-events:none;' }}">
                                                            <i class="bi bi-trash"
                                                                style="font-size:1.2rem;color:black;"></i>
                                                        </button>
                                                        @if ($h->estado == 2)
                                                            {{-- Boton de descargar solo si esta aprobado Estado = 2 --}}
                                                            <button title="Descargar"
                                                                style=" font-size: 10px; border: 0; border-radius: 5px; top: 5px;  background-color: #a4e6c888;"
                                                                onclick="descargarPermiso({{ $h->id }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                    <path d="M7 11l5 5l5 -5" />
                                                                    <path d="M12 4l0 12" />
                                                                </svg>
                                                            </button>
                                                        @else
                                                            {{-- Boton de descargar desactivado  --}}
                                                            <button title="No disponible"
                                                                style=" font-size: 10px; border: 0; border-radius: 5px; color: rgb(73, 69, 69);"
                                                                disabled>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    style=" align-items: center;" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                    <path d="M7 11l5 5l5 -5" />
                                                                    <path d="M12 4l0 12" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap" hidden>
                                                        @php
                                                            $fmtHoras = function ($valor) {
                                                                if (!$valor) {
                                                                    return '';
                                                                }
                                                                $partes = explode('-', $valor); // "19:03-14:03"
                                                                $out = [];
                                                                foreach ($partes as $hora) {
                                                                    $hora = trim($hora);
                                                                    if ($hora === '') {
                                                                        continue;
                                                                    }

                                                                    // Soporta "HH:MM" o "HH:MM:SS"
                                                                    if (strlen($hora) === 5) {
                                                                        $hora .= ':00';
                                                                    }
                                                                    $ts = strtotime($hora);
                                                                    if ($ts !== false) {
                                                                        $out[] = date('h:i A', $ts);
                                                                    }
                                                                }
                                                                return implode(' - ', $out); // "07:03 PM - 02:03 PM"
                                                            };
                                                        @endphp

                                                        <div id="permiso-info-{{ $h->id }}"
                                                            data-jefe="{{$h->jefe_nombre ?? ''}}"
                                                            data-lunesactual="{{ $fmtHoras($h->lunesActual ?? '') }}"
                                                            data-martesactual="{{ $fmtHoras($h->martesActual ?? '') }}"
                                                            data-miercolesactual="{{ $fmtHoras($h->miercolesActual ?? '') }}"
                                                            data-juevesactual="{{ $fmtHoras($h->juevesActual ?? '') }}"
                                                            data-viernesactual="{{ $fmtHoras($h->viernesActual ?? '') }}"
                                                            data-sabadoactual="{{ $fmtHoras($h->sabadoActual ?? '') }}"
                                                            data-lunescambio="{{ $fmtHoras($h->lunesCambio ?? '') }}"
                                                            data-martescambio="{{ $fmtHoras($h->martesCambio ?? '') }}"
                                                            data-miercolescambio="{{ $fmtHoras($h->miercolesCambio ?? '') }}"
                                                            data-juevescambio="{{ $fmtHoras($h->juevesCambio ?? '') }}"
                                                            data-viernescambio="{{ $fmtHoras($h->viernesCambio ?? '') }}"
                                                            data-sabadocambio="{{ $fmtHoras($h->sabadoCambio ?? '') }}"
                                                            style="display:none">
                                                            <table class="doc">
                                                                <colgroup>
                                                                    <col style="width:25%">
                                                                    <col style="width:25%">
                                                                    <col style="width:25%">
                                                                    <col style="width:25%">
                                                                </colgroup>
                                                                <tbody>
                                                                    {{-- Título dentro de la tabla --}}
                                                                    <tr class="title">
                                                                        <td colspan="4" class="center bold">SOLICITUD
                                                                            CAMBIO DE HORARIO</td>
                                                                    </tr>
                                                                    {{-- Fila: adjunto + fecha --}}
                                                                    <tr>
                                                                        <td class="label">FECHA DILIGENCIAMIENTO</td>
                                                                        <td>
                                                                            {{ $h->fecha_creacion_fmt ?? '00/00/0000' }}
                                                                        </td>
                                                                        <td class="label">FECHA A SOLICITAR</td>
                                                                        <td >
                                                                            {{ $h->fecha_solicitar ?? '00/00/0000' }}
                                                                        </td>

                                                                    </tr>
                                                                    {{-- Sección --}}
                                                                    <tr class="section">
                                                                        <td colspan="4" class="center bold">
                                                                            INFORMACIÓN&nbsp;SOBRE&nbsp;EL&nbsp;PERMISO</td>
                                                                    </tr>
                                                                    {{-- Nombre --}}
                                                                    <tr>
                                                                        <td class="label">NOMBRE DEL EMPLEADO</td>
                                                                        <td colspan="3">
                                                                            {{ $h->usuario_nombre ?? '—' }}
                                                                        </td>
                                                                    </tr>
                                                                    {{-- Cargo | Proceso --}}
                                                                    <tr>
                                                                        <td class="label">CARGO</td>
                                                                        <td>{{ $h->cargo ?? '—' }}</td>
                                                                        <td class="label">PROCESO AL QUE PERTENECE</td>
                                                                        <td>{{ $h->unidad ?? '—' }}</td>
                                                                    </tr>
                                                                    {{-- Jefe inmediato --}}
                                                                    <tr>
                                                                        <td class="label">JEFE INMEDIATO</td>
                                                                        <td colspan="3">{{ $h->jefe_nombre ?? '—' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="section">
                                                                        <td colspan="4" class="center bold">MOTIVO
                                                                            CAMBIO
                                                                            DE HORARIO</td>
                                                                    </tr>
                                                                    <td colspan="4" class="descripcion">
                                                                        {{ $h->descripcion ?? 'Sin descripción' }}</td>
                                                                    <tr>
                                                                        <td class="label">SOLICITUD DEL HORARIO</td>
                                                                        <td colspan="3"><!--RESUMEN_SOLICITUD--></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">Sin resultados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        // Construir sufijo con todos los parámetros GET excepto "page"
                        $resto = request()->except('page');
                        $suffix = $resto ? '&' . http_build_query($resto) : '';

                        $prevUrl = $datos->previousPageUrl() ? $datos->previousPageUrl() . $suffix : null;
                        $nextUrl = $datos->nextPageUrl() ? $datos->nextPageUrl() . $suffix : null;
                    @endphp
                    <div class="pagination justify-content-center mt-4 mb-4">
                        <nav>
                            <ul class="pagination">
                                {{-- Anterior --}}
                                <li class="page-item {{ $datos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" style="color:#012970" href="{{ $prevUrl ?? '#' }}"
                                        rel="prev" aria-label="« Previous">&lt;</a>
                                </li>
                                {{-- Números --}}
                                @for ($i = 1; $i <= $datos->lastPage(); $i++)
                                    @php $urlI = $datos->url($i) . $suffix; @endphp
                                    <li class="page-item {{ $datos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            style="border-radius:3px; {{ $datos->currentPage() == $i ? 'color:#012970; pointer-events:none; cursor:default; background-color:#e9ecef;' : 'color:#012970;' }}"
                                            href="{{ $urlI }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                {{-- Siguiente --}}
                                <li class="page-item {{ $datos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" style="color:#012970" href="{{ $nextUrl ?? '#' }}"
                                        rel="next" aria-label="Next »">&gt;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    {{-- FORM GLOBAL OCULTO PARA SUBIR SOPORTES (fuera de la tabla) --}}
                    <form id="form-soporte-global" action="{{ route('horarios.subirSoporte', 0) }}"
                        data-base="{{ route('horarios.subirSoporte', 0) }}" method="POST" enctype="multipart/form-data"
                        style="display:none">
                        @csrf
                        <input type="hidden" name="replace" id="replace-flag" value="0">
                        <input type="file" id="file-soporte-global" name="soporte" accept="application/pdf,image/*">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <script src="/intranet/js/sweetalert2.min.js"></script>
    @if (session('success') || session('error'))
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal === 'undefined') {
                    console.warn('SweetAlert2 no cargado');
                    return;
                }
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '¡Listo!',
                        text: @json(session('success')),
                        timer: 2000,
                        showConfirmButton: false
                    });
                @endif
                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Opss',
                        text: @json(session('error'))
                    });
                @endif
            });
        </script>
    @endif

    <script>
        function estadoDesdeFila(btn) {
            // 1) Si el propio botón trae data-estado, úsalo
            const ds = btn.dataset.estado;
            if (typeof ds !== 'undefined') {
                const n = Number(ds);
                if (!Number.isNaN(n)) return n;
            }

            // 2) Buscar en la misma fila otro elemento con data-estado (por ej. Aprobar/Rechazar ya lo traen)
            const tr = btn.closest('tr');
            if (tr) {
                const el = tr.querySelector('[data-estado]');
                if (el) {
                    const n = Number(el.getAttribute('data-estado'));
                    if (!Number.isNaN(n)) return n;
                }

                // 3) Último recurso: mapear por el texto de la 2ª columna ("ESTADO")
                const estadoCell = tr.children[1]; // N° SOLICITUD es 1ª col, ESTADO es 2ª
                if (estadoCell) {
                    const t = estadoCell.textContent.trim().toLowerCase();
                    if (t.includes('parcialmente')) return 4; // "Parcialmente Aprobado"
                    if (t.includes('aprobado')) return 2; // "Aprobado"
                    if (t.includes('rechazado')) return 1; // "Rechazado"
                    if (t.includes('en proceso')) return 3; // "En proceso"
                    if (t.includes('pendiente')) return 0; // "Pendiente"
                }
            }
            return NaN;
        }

        async function subirSoporte(btn) {
            const id = btn.dataset.id;
            const yaTiene = btn.dataset.tiene === '1';

            const form = document.getElementById('form-soporte-global');
            const input = document.getElementById('file-soporte-global');
            const replace = document.getElementById('replace-flag');
            if (!form || !input) return false;

            // Base viene precargada como .../horarios/0/soporte
            const base = form.dataset.base || form.action;
            form.action = base.replace(/\/0\/soporte$/, `/${id}/soporte`);

            if (replace) replace.value = yaTiene ? '1' : '0';

            // Abre el selector y deja que el listener haga el submit
            input.value = '';
            input.click();
            return false;
        }

        // Auto-submit al elegir archivo (tu código existente)
        document.getElementById('file-soporte-global').addEventListener('change', function() {
            if (this.files && this.files.length) {
                document.getElementById('form-soporte-global').submit();
            }
        });

        // Auto-submit al elegir archivo (igual que ya tenías)
        document.getElementById('file-soporte-global').addEventListener('change', function() {
            if (this.files && this.files.length) {
                document.getElementById('form-soporte-global').submit();
            }
        });

        function formatearFechaES(fechaRaw) {
            if (!fechaRaw) return '';
            const meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE",
                "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
            ];
            const d = new Date(fechaRaw.replace(' ', 'T'));
            if (isNaN(d)) return fechaRaw;
            const dia = String(d.getDate()).padStart(2, '0');
            return `${dia}/${meses[d.getMonth()]}/${d.getFullYear()}`;
        }

function verPermiso(id) {
    const wrap = document.getElementById('permiso-info-' + id);
    if (!wrap) { alert('No se encontró el contenido del permiso.'); return; }

    const ds = wrap.dataset;

    // ⬇️ Tomamos el JEFE de la misma fila (columna JEFE INMEDIATO)
    // Índices: 0=No.Sol, 1=Estado, 2=Empleado, 3=Cargo, 4=Proceso, 5=Jefe
    let jefe = '';
    try {
        const tr = wrap.closest('tr');
        if (tr && tr.children && tr.children[5]) {
            jefe = tr.children[5].textContent.trim();
        }
    } catch (_) {}

    const dias = [
        {label:'Lunes',     a:'lunesactual',     c:'lunescambio'},
        {label:'Martes',    a:'martesactual',    c:'martescambio'},
        {label:'Miércoles', a:'miercolesactual', c:'miercolescambio'},
        {label:'Jueves',    a:'juevesactual',    c:'juevescambio'},
        {label:'Viernes',   a:'viernesactual',   c:'viernescambio'},
        {label:'Sábado',    a:'sabadoactual',    c:'sabadocambio'},
    ];

    const esc = (t) => (t ?? '').toString().replace(/[&<>"]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[s]));
    const normalize = (s) => (s ?? '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();

    // Construir filas y detectar "indefinido"
    const filas = [];
    let hayIndefinido = false;

    for (const d of dias) {
        const valA = (ds[d.a] || '').trim();
        const valC = (ds[d.c] || '').trim();

        if (normalize(valA).includes('indefinid') || normalize(valC).includes('indefinid')) {
            hayIndefinido = true;
        }
        if (valA || valC) {
            filas.push(
                `<tr>
                    <td>${esc(d.label)}</td>
                    <td>${esc(valA) || '—'}</td>
                    <td>${esc(valC) || '—'}</td>
                </tr>`
            );
        }
    }

    const nDias = filas.length;
    let sufijo;
    if (hayIndefinido || nDias === 0) sufijo = 'NO HAY CAMBIOS EN LA SOLICITUD DEL HORARIO';
    else if (nDias === 1)          sufijo = '1 DÍA';
    else                           sufijo = 'INDEFINIDO';

    let contenido = wrap.innerHTML;
    contenido = contenido.replace('<!--RESUMEN_SOLICITUD-->', esc(sufijo));

    const bloqueHorario = `
        <table class="doc tabla-horarios" style="margin-top:12px; width:100%; border-collapse:collapse; text-align:center; table-layout:fixed;">
            <tbody>
                <tr>
                    <td class="label">DÍA</td>
                    <td class="label">HORARIO ANTERIOR</td>
                    <td class="label">HORARIO CON CAMBIO</td>
                </tr>
                ${filas.length ? filas.join('') : `<tr><td colspan="3" class="center">Sin información de cambios</td></tr>`}
            </tbody>
        </table>

        <div class="bloque-separador"></div>

        <table class="doc tabla-firmas">
            <tbody>
                <tr>
                    <td class="campo-valor nombre" colspan="1">${esc(jefe) || '—'}</td>
                    <td class="campo-valor nombre" colspan="1">IVONNE ANGELICA CLAROS VERGARA</td>
                </tr>
                <tr>
                    <td class="campo-label">FIRMA COORDINADOR</td>
                    <td class="campo-label">FIRMA DE GERENCIA ADMINISTRATIVA</td>
                </tr>
            </tbody>
        </table>
    `;

    contenido = contenido.replace('</tbody>', `${bloqueHorario}</tbody>`);
    const html = `
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf-8" />
            <title>Solicitud_${id}</title>
            <style>
                body { font-family: Arial, sans-serif; background:#fff; color:#012970; padding:24px; }
                .doc { width:100%; border-collapse:collapse; table-layout:fixed; }
                .doc td { border:1px solid #000; padding:10px; font-size:13px; vertical-align:middle; color:#012970; }
                .center { text-align:center; } .bold { font-weight:700; }
                .title td, .title .center { font-size:15px; font-weight:700; background:#fabf8f }
                .section td { background:#fabf8f; color:#17355d; font-weight:700; border:1px solid #000; }
                .label { background:#538cd5; color:#fff; font-weight:700; }
                .doc tr td { line-height:1.25; }
                .campo-label { background-color:#538cd5; color:#fff; font-weight:bold; font-size:12px; }
                .campo-valor { background-color:#fff; color:#012970; font-size:14px; }
                .header { display:flex; justify-content:space-between; align-items:center; border-bottom:3px solid #0011; padding-bottom:10px; margin-bottom:20px; }
                .header-left { display:flex; flex-direction:column; align-items:center; }
                .header-left img { height:28px; object-fit:contain; margin-bottom:5px; }
                .header-center { flex-grow:1; text-align:center; }
                .header-center h1 { margin:0; font-size:20px; color:#000080; }
                .header-right { font-size:12px; text-align:right; color:#000080; }
                .header-right div { margin-bottom:2px; }
                .bloque-separador { height: 14px; }
            </style>
        </head>
        <div class="header">
            <div class="header-left">
                <img src="{{ asset('/storage/logos/logo.png') }}" alt="Logo Empresa">
                <img src="{{ asset('/storage/logos/name.png') }}" alt="Logo">
            </div>
            <div class="header-center">
                <h1>SOLICITUD CAMBIO DE HORARIO</h1>
            </div>
            <div class="header-right">
                <div><strong>CÓDIGO:</strong> GH-F-100</div>
                <div><strong>VERSIÓN:</strong> 001</div>
                <div><strong></strong> 9/17/2025</div>
            </div>
        </div>
        <body>
            ${contenido}
        </body>
        </html>`;

    const w = window.open('', '_blank', 'width=800,height=700');
    w.document.open();
    w.document.write(html);
    w.document.close();
    w.document.title = 'Solicitud_' + id;
}
        function confirmarSweet({
            icon,
            title,
            confirmText
        }) {
            if (!window.Swal) {
                return Promise.resolve(confirm(title.replace(/\?$/, '')));
            }
            return Swal.fire({
                icon,
                title,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancelar'
            }).then(r => !!r.isConfirmed);
        }

        function enviarFormulario(btn) {
            let form = btn.form;
            if (!form) {
                const formId = btn.getAttribute('form');
                if (formId) form = document.getElementById(formId);
            }
            if (!form) form = document.querySelector('form');
            if (!form) return;

            if (form.requestSubmit) {
                form.requestSubmit(btn);
            } else {
                if (btn.name && btn.value) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = btn.name;
                    hidden.value = btn.value;
                    form.appendChild(hidden);
                }
                const fa = btn.getAttribute('formaction');
                const fm = btn.getAttribute('formmethod');
                if (fa) form.action = fa;
                if (fm) form.method = fm || 'POST';
                form.submit();
            }
        }

        window.AUTH_ID = {{ $authId }};
        window.AUTH_ROL = {{ $rol }};
        window.AUTH_UNIDAD = {{ $unidad }};
        //reglas de aprobar o rechazar

        function descargarPermiso(id) {
            const wrap = document.getElementById('permiso-info-' + id);
            if (!wrap) {
                alert('No se encontró el contenido del permiso.');
                return;
            }

            const ds = wrap.dataset;

            // === Utilidades ===
            const esc = (t) => (t ?? '').toString().replace(/[&<>"]/g, s => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;'
            } [s]));
            const normalize = (s) => (s ?? '').toString().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();

            // === Formateo de fecha del dataset (si viene) ===
            const rawFecha = ds.fecha || '';
            let fechaFormateada = '';
            try {
                const fechaObj = new Date(rawFecha);
                const meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE",
                    "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"
                ];
                const dia = ("0" + fechaObj.getDate()).slice(-2);
                const mes = meses[fechaObj.getMonth()] || '';
                const anio = fechaObj.getFullYear();
                if (!isNaN(fechaObj.getTime())) {
                    fechaFormateada = `${dia}/${mes}/${anio}`;
                }
            } catch (e) {
                /* no-op */
            }

            // === Construcción de filas de horario como en verPermiso ===
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

            const filas = [];
            let hayIndefinido = false;

            for (const d of dias) {
                const valA = (ds[d.a] || '').trim();
                const valC = (ds[d.c] || '').trim();

                if (normalize(valA).includes('indefinid') || normalize(valC).includes('indefinid')) {
                    hayIndefinido = true;
                }
                if (valA || valC) {
                    filas.push(
                        `<tr>
          <td class="label">${esc(d.label)}</td>
          <td>${esc(valA) || '—'}</td>
          <td>${esc(valC) || '—'}</td>
        </tr>`
                    );
                }
            }

            const nDias = filas.length;
            let sufijo;
            if (hayIndefinido || nDias === 0) {
                sufijo = 'NO HAY CAMBIOS EN LA SOLICITUD DEL HORARIO';
            } else if (nDias === 1) {
                sufijo = '1 DÍA';
            } else {
                // Mantengo tu lógica/paridad con verPermiso
                sufijo = `INDEFINIDO`;
            }

            // Tomamos el contenido base oculto y reemplazamos el resumen
            let contenido = wrap.innerHTML;
            contenido = contenido.replace('<!--RESUMEN_SOLICITUD-->', esc(sufijo));

            // Bloque de tabla de horarios + firmas (idéntico estilo al de verPermiso)
            const bloqueHorario = `
                <table class="doc tabla-horarios" style="margin-top:12px; width:100%; border-collapse:collapse; text-align:center; table-layout:fixed;">
                <tbody>
                    <tr>
                    <td class="label">DÍA</td>
                    <td class="label">HORARIO ANTERIOR</td>
                    <td class="label">HORARIO CON CAMBIO</td>
                    </tr>
                    ${filas.length ? filas.join('') : `<tr><td colspan="3" class="center">Sin información de cambios</td></tr>`}
                </tbody>
                </table>

                <div class="bloque-separador"></div>

                <table class="doc tabla-firmas" style="width:100%; border-collapse:collapse; table-layout:fixed;">
                <tbody>
                    <tr>
                    <td class="campo-valor nombre" colspan="1">{{ $h->jefe_nombre ?? '—' }}</td>
                    <td class="campo-valor nombre" colspan="1">IVONNE ANGELICA CLAROS VERGARA</td>
                    </tr>
                    <tr>
                    <td class="campo-label">FIRMA COORDINADOR</td>
                    <td class="campo-label">FIRMA DE GERENCIA ADMINISTRATIVA</td>
                    </tr>
                </tbody>
                </table>
                `;

            // Insertar el bloque justo antes de cerrar el primer </tbody> que aparezca
            contenido = contenido.replace('</tbody>', `${bloqueHorario}</tbody>`);

            // === HTML completo: encabezado + estilos alineados con verPermiso ===
            const html = `
                <!DOCTYPE html>
                <html lang="es">
                <head>
                <meta charset="utf-8" />
                <title>Solicitud_${id}</title>
                <style>
                @page { size: A4; margin: 18mm; }
                body { font-family: Arial, sans-serif; background:#fff; color:#012970; padding:0; }
                .doc { width:100%; border-collapse:collapse; table-layout:fixed; }
                .doc td { border:1px solid #000; padding:10px; font-size:13px; vertical-align:middle; color:#012970; }
                .center { text-align:center; } .bold { font-weight:700; } .muted { color:#9aa0a6; }
                .title td, .title .center { font-size:15px; font-weight:700; background:#fabf8f }
                .section td { background:#fabf8f; color:#17355d; font-weight:700; border:1px solid #000; }
                .label { background:#538cd5; color:#fff; font-weight:700; }
                .doc tr td { line-height:1.25; }
                .campo-label { background-color:#538cd5; color:#fff; font-weight:bold; font-size:12px; text-align:center; }
                .campo-valor { background-color:#fff; color:#012970; font-size:14px; text-align:center; }
                .bloque-separador { height:14px; }

                /* Encabezado similar al tuyo original, conservando logos y metadatos */
                .header {
                    display:flex; justify-content:space-between; align-items:center;
                    border-bottom:3px solid #0011; padding-bottom:10px; margin-bottom:20px;
                }
                .header-left { display:flex; flex-direction:column; align-items:center; }
                .header-left img { height:28px; object-fit:contain; margin-bottom:5px; }
                .header-center { flex-grow:1; text-align:center; }
                .header-center h1 { margin:0; font-size:20px; color:#000080; }
                .header-right { font-size:12px; text-align:right; color:#000080; }
                .header-right div { margin-bottom:2px; }

                /* Evitar cortes feos en impresión */
                table, tr, td { page-break-inside: avoid; }
                </style>
                </head>
                <body>

                <div class="header">
                    <div class="header-left">
                    <img src="{{ asset('/storage/logos/logo.png') }}" alt="Logo Empresa">
                    <img src="{{ asset('/storage/logos/name.png') }}" alt="Logo">
                    </div>
                    <div class="header-center">
                    <h1>SOLICITUD CAMBIO DE HORARIO</h1>
                    </div>
                    <div class="header-right">
                    <div><strong>CÓDIGO:</strong> GH-F-100</div>
                    <div><strong>VERSIÓN:</strong> 001</div>
                    <div><strong></strong> 9/17/2025</div>
                    </div>
                </div>

                ${contenido}

                </body>
                </html>`;

            // === Abrir ventana, escribir, imprimir (descargar como PDF) ===
            const w = window.open('', '_blank', 'width=1000,height=700');
            if (!w) {
                alert('Por favor habilita las ventanas emergentes para descargar el permiso.');
                return;
            }
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.focus();

            // Dar un pequeño tiempo para que carguen los logos antes de imprimir
            setTimeout(() => {
                w.print();
                // Si deseas cerrar la pestaña automáticamente después de imprimir, descomenta:
                // w.close();
            }, 350);
        }

        (function() {
            // Normaliza texto
            const norm = s => (s || '').replace(/\s+/g, ' ').trim().toUpperCase();

            // Detecta vista R2U4 sin tocar Blade: existe TH "SOPORTE"
            function esR2U4(btn) {
                const table = btn.closest('table');
                if (!table) return false;
                return Array.from(table.querySelectorAll('thead th'))
                    .some(th => norm(th.textContent) === 'SOPORTE');
            }

            function filaTieneSoporte(row) {
                const btnSoporte = row.querySelector('button[onclick^="subirSoporte"]');
                if (btnSoporte && /REEMPLAZAR/i.test(btnSoporte.textContent)) return true;

                const linkDesc = row.querySelector(
                    'a[href*="descargarsoporte"], a[href*="/versoporte/"][href*="/descargar"]');
                if (linkDesc) return true;

                return false;
            }

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-accion');
                if (!btn) return;
                if (btn.disabled || btn.getAttribute('aria-disabled') === 'true') return;

                const form = document.getElementById(btn.getAttribute('form')) || btn.closest('form');
                if (!form) return;

                const accion = (btn.dataset.accion || 'aprobar').toLowerCase();
                const row = btn.closest('tr');

                // ——— CASO BLOQUEANTE: R2U4 intenta APROBAR sin soporte -> mostrar UNA alerta (OK) y NO enviar ———
                function todosLosDiasLlenos(row) {
                // Col 0 = N° SOLICITUD
                const id = row?.children?.[0]?.textContent?.trim();
                if (!id) return false;
                const wrap = document.getElementById('permiso-info-' + id);
                if (!wrap) return false;

                const campos = [
                    'lunescambio','martescambio','miercolescambio',
                    'juevescambio','viernescambio','sabadocambio','domingocambio'
                ].filter(k => k in wrap.dataset);

                if (campos.length === 0) return false; // sin datos -> no forzar alerta

                // true si NINGUNO está vacío
                return campos.every(k => (wrap.dataset[k] || '').trim() !== '');
                }

                // ——— NUEVA LÓGICA: R2U4 al APROBAR ———
                if (accion === 'aprobar' && esR2U4(btn) && row) {
                const sinNulls      = todosLosDiasLlenos(row);
                const tieneSoporte  = filaTieneSoporte(row);

                if (sinNulls && !tieneSoporte) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    if (window.Swal?.fire) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Falta soporte',
                        text: 'Sube el soporte antes de aprobar.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    });
                    } else {
                    alert('Sube el soporte antes de aprobar.');
                    }
                    return; // No confirm, no submit
                }
                }



                e.preventDefault();

                const map = {
                    eliminar: {
                        icon: 'warning',
                        title: '¿Estás seguro de eliminar la solicitud?',
                        confirm: 'Eliminar',
                        cancel: 'Cancelar'
                    },
                    rechazar: {
                        icon: 'warning',
                        title: '¿Estás seguro de rechazar la solicitud?',
                        confirm: 'Rechazar',
                        cancel: 'Cancelar'
                    },
                    aprobar: {
                        icon: 'question',
                        title: '¿Estás seguro de aprobar la solicitud?',
                        confirm: 'Aprobar',
                        cancel: 'Cancelar'
                    },
                };
                const cfg = map[accion] || map.aprobar;

                const doSubmit = () => {
                    // Asegura que viajen name/value del botón si el navegador no soporta requestSubmit
                    if (!form.requestSubmit) {
                        const name = btn.getAttribute('name');
                        if (name && !form.querySelector(`[name="${name}"]`)) {
                            const h = document.createElement('input');
                            h.type = 'hidden';
                            h.name = name;
                            h.value = btn.getAttribute('value') ?? '1';
                            form.appendChild(h);
                        }
                    }
                    btn.disabled = true;
                    if (form.requestSubmit) form.requestSubmit(btn);
                    else form.submit();
                };

                if (window.Swal && Swal.fire) {
                    Swal.fire({
                        icon: cfg.icon,
                        title: cfg.title,
                        showCancelButton: true,
                        confirmButtonText: cfg.confirm,
                        cancelButtonText: cfg.cancel,
                        reverseButtons: true,
                        focusCancel: true,
                        allowOutsideClick: false
                    }).then(r => {
                        if (r.isConfirmed) doSubmit();
                    });
                } else {
                    if (confirm(cfg.title)) doSubmit();
                }
            });
        })();
    </script>
