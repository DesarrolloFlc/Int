@php use App\Models\User; @endphp


@extends('layouts.plantilla')

@section('title', 'Consultar')

@section('content')

    <link rel="stylesheet" href="{{ asset('/css/Permisos.css') }}?v={{ time() }}">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <main id="main" class="main">
       <div class="container-fluid tab-pane fade shadow bg-white show active px-2 py-4" style="width: 100%;">
           <div class="table-responsive">
            <div class="pagetitle">
                <h2 class="head fw-bold" style="color: #012970">Listado de Solicitudes de Permisos</h2>

                <div class="container">
                    <div class="mx-auto">
                        <div class="panel" style="background: #ffffff;">
                            <div class="panel-heading" style="background: #e26d2dbd">
                                <div class="row">
                                    <div class="col-sm-9 col-xs-12 text-right">
                                        <div class="btn_group">
                                            {{-- Formulario de busqueda --}}
                                            <form>
                                                <style>
                                                    /* Estilos del buscador y el scroll*/
                                                    .search-container {
                                                        position: relative;
                                                        width: 80%;
                                                    }

                                                    .custom-scroll::-webkit-scrollbar {
                                                        height: 2px;
                                                        /* Altura del scrollbar horizontal */
                                                    }

                                                    .custom-scroll::-webkit-scrollbar-track {
                                                        background: #ccc;
                                                        /* Color de fondo */
                                                        border-radius: 10px;
                                                    }

                                                    .custom-scroll::-webkit-scrollbar-thumb {
                                                        background: #e26d2d;
                                                        /* Color de la barra que se mueve */
                                                        border-radius: 10px;
                                                    }

                                                    .custom-scroll::-webkit-scrollbar-thumb:hover {
                                                        background: #c5531f;
                                                    }

                                                    /* Firefox */
                                                    .custom-scroll {
                                                        scrollbar-width: thin;
                                                        scrollbar-color: #e26d2d #ccc;
                                                    }
                                                </style>

                                                <div class="search-container">
                                                    <i class="fas fa-search"></i>
                                                    <label for="searchTerm" class="visually-hidden">Buscar permisos</label>
                                                    <input class="form-control mr-2" type="text" name="busqueda_general"
                                                        id="busqueda_general" placeholder="Buscar..."
                                                        value="{{ request()->busqueda_general }}">
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="panel-body table-responsive custom-scroll">
                                {{-- Tabla con el contenido de permiso --}}
                                <table class="table table-bordered" id="datos" style="text-align: center">
                                    <thead>
                                        <tr style="background: #e26c2d6e">
                                            <th style="color: #012970">N° Permiso</th>
                                            <th style="color: #012970">Estado</th>
                                            <th style="color: #012970">Nombre</th>
                                            <th style="color: #012970">Unidad</th>
                                            <th style="color: #012970">Cargo</th>
                                            <th style="color: #012970">Descripcion</th>
                                            <th style="color: #012970">Fecha de permiso</th>
                                            <th style="color: #012970">Total de horas</th>
                                            <th style="color: #012970">Fecha desde</th>
                                            <th style="color: #012970">Fecha hasta</th>
                                            <th style="color: #012970">Hora de salida</th>
                                            <th style="color: #012970">Hora de llegada</th>
                                            <th style="color: #012970">Jefe</th>
                                            <th style="color: #012970">Fecha de creacion</th>
                                            <th style="color:#012970">Acciones</th>
                                            <th style="color:#012970">Descargar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $dato)
                                            <tr>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                <td style="color: #012970">
                                                   {{ $dato->id_permisos}}
                                                </td>
                                                <td {{-- Mostramos el estado con color de fondo --}}
                                                    @if ($dato->estado == 2) style="background-color: #a4e6c888; color: #012970;"
                                                    @elseif ($dato->estado == 3)
                                                        style="background-color: #ffafb988; color: #012970;"
                                                    @elseif ($dato->estado == 6)
                                                        style="background-color: #f5cdb6; color: #012970;"
                                                    @elseif ($dato->estado == 1)
                                                        style="background-color: #e8ab0150; color: #012970;"
                                                    @elseif ($dato->estado == 0)
                                                        style="background-color: #fff; color: #012970;" @endif>
                                                    {{-- Nombre del estado --}}
                                                    @if ($dato->estado == 2)
                                                        Aprobado
                                                    @elseif ($dato->estado == 3)
                                                        Rechazado
                                                    @elseif ($dato->estado == 6)
                                                        En proceso
                                                    @elseif ($dato->estado == 1)
                                                       Parcialmente Aceptado
                                                    @else
                                                        Pendiente
                                                    @endif
                                            </div>
                                                </td>
                                                {{-- Datos traidos de la base de datos --}}
                                                <td style="color: #012970">
                                                    {{ optional(User::find($dato->usuario_id))->nombre }}
                                                </td>

                                                <td style="color: #012970">{{ $dato->unidad->unidad }}</td>

                                                <td style="color: #012970">
                                                    {{ optional(DB::table('roles')->where('id', $dato->id_rol)->first())->rol ?? 'Rol no encontrado' }}
                                                </td>
                                                {{-- //desarrollo --}}
                                                <td style="color: #012970">
                                                    <textarea name="descripcion[]" rows="3" style="width:100%; border:1px solid #ccc; border-radius:5px; color:#012970;">
                                                        {{ $dato->descripcion }}
                                                    </textarea>
                                                </td>
                                                <td style="color: #012970">{{ $dato->fecha_permiso }}</td>
                                                <td style="color: #012970">{{ $dato->total_horas }}</td>
                                                <td style="color: #012970">{{ $dato->fecha_desde }}</td>
                                                <td style="color: #012970">{{ $dato->fecha_hasta }}</td>
                                                <td style="color: #012970">
                                                    {{ \Carbon\Carbon::parse($dato->hora_salida)->format('H:i') }}
                                                <td style="color: #012970">
                                                    {{ \Carbon\Carbon::parse($dato->hora_llegada)->format('H:i') }}
                                                <td style="color: #012970">
                                                    {{ optional(User::find($dato->jefe_id))->nombre }}
                                                </td>
                                                <td style="color: #012970">{{ $dato->fecha_creacion }}</td>
                                                {{-- Botones de acciones --}}
                                                <td
                                                    style="display: flex; justify-content: space-evenly; align-items: center">
                                                    {{-- Botón especial para usuario cuando el estado es 6 --}}
                                                    @if(Auth::user()->id == 27 && $dato->estado == 6)
                                                    <button title="Pasar a En Proceso"
                                                        onclick="modificarEstado({{ $dato->id_permisos       }}, 'aprobar')"
                                                        style="background-color: transparent; border:0; border-radius:5px; width:35px; height:35px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                            <path d="M15 19l2 2l4 -4" style="color: green" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                    {{-- Boton de aprobar --}}
                                                    @if(Auth::user()->id != 27)
                                                    <button title="Aprobar" type="button"
                                                        onclick="confirmarAccion({{ $dato->id_permisos }}, 'aprobar', {{ $dato->estado }})"
                                                        style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;"
                                                        onmouseover="this.style.backgroundColor='rgba(169, 241, 202, 0)'"
                                                        onmouseout="this.style.backgroundColor='transparent'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                                            <path d="M15 19l2 2l4 -4" style="color: green" />
                                                        </svg>
                                                    </button>
                                                         @endif

                                                        {{-- Boton de rechazar --}}
                                                        <button title="Rechazar"type="button"
                                                            onclick="confirmarAccion({{ $dato->id_permisos }}, 'rechazar', {{ $dato->estado }})"
                                                            style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;"
                                                            onmouseover="this.style.backgroundColor='rgba(169, 241, 202, 0)'"
                                                            onmouseout="this.style.backgroundColor='transparent'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                                <path d="M22 22l-5 -5" style="color: red" />
                                                                <path d="M17 22l5 -5" style="color: red" />
                                                            </svg>
                                                            {{-- Boton de ver --}}
                                                            <button title="Ver" type="button"
                                                                onclick="verPermiso({{ $dato->id_permisos }})"
                                                                style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;"
                                                                onmouseover="this.style.backgroundColor='rgba(169, 241, 202, 0)'"
                                                                onmouseout="this.style.backgroundColor='transparent'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                    <path
                                                                        d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                                                    <path
                                                                        d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0"
                                                                        style="color: #0a4679" />
                                                                    <path d="M18.5 19.5l2.5 2.5" style="color: #0a4679" />
                                                                </svg>
                                                                 <button title="Eliminar"type="button"
                                                                 @if ($dato->estado != 0) disabled @endif
                                                            onclick="confirmarAccion({{ $dato->id_permisos }}, 'inactivar', {{ $dato->estado }})"
                                                            style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;"
                                                            onmouseover="this.style.backgroundColor='rgba(169, 241, 202, 0)'"
                                                            onmouseout="this.style.backgroundColor='transparent'">
                                                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path d="M4 7l16 0" />
                                                            <path d="M10 11l0 6" />
                                                            <path d="M14 11l0 6" />
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                <td>
                                                    @if ($dato->estado == 2)
                                                        {{-- Boton de descargar solo si esta aprobado Estado = 2 --}}
                                                        <button title="Descargar"
                                                            style=" font-size: 10px; border: 0; border-radius: 5px; top: 5px;  background-color: #a4e6c888;"
                                                            onclick="descargarPermiso({{ $dato->id_permisos }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                <path d="M7 11l5 5l5 -5" />
                                                                <path d="M12 4l0 12" />
                                                            </svg> </button>
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
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                <path d="M7 11l5 5l5 -5" />
                                                                <path d="M12 4l0 12" />
                                                            </svg> </button>
                                                    @endif
                                                </td>
                                                {{-- Datos para la impresion o descarga del permiso --}}
                                                <td style="display:none;">
                                                    <div id="permiso-info-{{ $dato->id_permisos }}">
                                                        <div
                                                            class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
                                                            <div class="seccion">
                                                                <div class="fila">
                                                                    <div class="campo-label">FECHA DE DILIGNCIAMIENTO</div>
                                                                    <div class="campo-valor">{{ $dato->fecha_creacion }}
                                                                    </div>
                                                                </div>
                                                                <div class="panel-titulo">1. INFORMACIÓN SOBRE EL PERMISO
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">NOMBRE DEL EMPLEADO</div>
                                                                    <div class="campo-valor">
                                                                        {{ optional(User::find($dato->usuario_id))->nombre }}
                                                                    </div>
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">CARGO</div>
                                                                    <div class="campo-valor">
                                                                        {{ optional(DB::table('roles')->where('id', $dato->id_rol)->first())->rol ?? 'Rol no encontrado' }}
                                                                    </div>
                                                                    <div class="campo-label">UNIDAD</div>
                                                                    <div class="campo-valor">{{ $dato->unidad->unidad }}
                                                                    </div>
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">JEFE INMEDIATO</div>
                                                                    <div class="campo-valor">
                                                                        {{ optional(User::find($dato->jefe_id))->nombre }}
                                                                    </div>
                                                                    <div class="campo-label">FECHA DE PERMISO</div>
                                                                    <div class="campo-valor">{{ $dato->fecha_permiso }}
                                                                    </div>
                                                                </div>
                                                                <div class="panel-titulo">2. TIPO DE PERMISO SOLICITADO
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">DESCRIPCIÓN</div>
                                                                    <div class="campo-valor">{{ $dato->descripcion }}
                                                                    </div>
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">HORA DE SALIDA</div>
                                                                    <div class="campo-valor">{{ $dato->hora_salida }}
                                                                    </div>
                                                                    <div class="campo-label">HORA DE LLEGADA</div>
                                                                    <div class="campo-valor">{{ $dato->hora_llegada }}
                                                                    </div>
                                                                    <div class="campo-label">TOTAL HORAS DE PERMISO</div>
                                                                    <div class="campo-valor">{{ $dato->total_horas }}
                                                                    </div>
                                                                </div>
                                                                <div class="panel-titulo">3. TIEMPO DE REPOSICIÓN</div>
                                                                <div class="fila">
                                                                    <div class="campo-label">FECHA DESDE</div>
                                                                    <div class="campo-valor">{{ $dato->fecha_desde }}</div>
                                                                    <div class="campo-label">HORAS POR DIA 1</div>
                                                                    <div class="campo-valor">{{ $dato->hora_dia_1 }}</div>
                                                                    <div class="campo-label">HORAS POR DIA 2</div>
                                                                    <div class="campo-valor">{{ $dato->hora_dia_2 }}</div>
                                                                    <div class="campo-label">HORAS POR DIA 3</div>
                                                                    <div class="campo-valor">{{ $dato->hora_dia_3 }}</div>
                                                                    <div class="campo-label">HORAS POR DIA 4</div>
                                                                    <div class="campo-valor">{{ $dato->hora_dia_4 }}</div>
                                                                    <div class="campo-label">HORAS POR DIA 5</div>
                                                                    <div class="campo-valor">{{ $dato->hora_dia_5 }}</div>
                                                                    <div class="campo-label">FECHA HASTA</div>
                                                                    <div class="campo-valor">{{ $dato->fecha_hasta }}
                                                                    </div>
                                                                </div>
                                                                <div class="panel-titulo">4. APROBACIÓN (Personal operativo Firma 1 y 2 y personl administrativo y/o directivofirman 2 y3)</div>
                                                                <div class="fila">
                                                                    <div class="campo-valor">
                                                                        {{ optional(User::find($dato->jefe_id))->nombre }}
                                                                    </div>
                                                                    <div class="campo-valor">IVONNE ANGELICA CLAROS VERGARA
                                                                    </div>
                                                                    <div class="campo-valor">
                                                                    </div>
                                                                </div>
                                                                <div class="fila">
                                                                    <div class="campo-label">JEFE INMEDIATO Y/O DIRECTOR
                                                                    </div>
                                                                    <div class="campo-label">RECURSOS HUMANOS</div>
                                                                    <div class="campo-label">GERENCIA</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class='noSearch hide'>
                                            <td colspan="10"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                {{-- Paginacion --}}
                                <div class="pagination justify-content-center mt-4 mb-4">
                                    <nav>
                                        <ul class="pagination">
                                            {{-- Boton de anterior --}}
                                            <li class="page-item {{ $datos->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" style="color: #012970; border-radius:3px"
                                                    href="{{ $datos->previousPageUrl() }}" rel="prev"
                                                    aria-label="« Previous">&lt;</a>
                                            </li>
                                            {{-- Números de página generados dinámicamente --}}
                                            @for ($i = 1; $i <= $datos->lastPage(); $i++)
                                                <li class="page-item {{ $datos->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        style="border-radius: 3px; {{ $datos->currentPage() == $i ? 'color: #012970; pointer-events: none; cursor: default; background-color: #e9ecef;' : 'color: #012970;' }}"
                                                        href="{{ $datos->appends(request()->query())->url($i) }}">
                                                        {{ $i }}
                                                    </a>
                                                </li>
                                            @endfor
                                            {{-- Boton de siguiente --}}
                                            <li class="page-item {{ $datos->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" style="color: #012970; border-radius:3px"
                                                    href="{{ $datos->nextPageUrl() }}" rel="next"
                                                    aria-label="Next »">&gt;</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
    </main>
    {{-- Libreria de alertas --}}
    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <script src="/intranet/js/sweetalert2.min.js"></script>


    <script>
    function descargarPermiso(id) {
        let contenido = document.getElementById('permiso-info-' + id).innerHTML;
        let rawFecha = document.getElementById('permiso-info-' + id).dataset.fecha;
        let fechaObj = new Date(rawFecha);
        let meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        let dia = ("0" + fechaObj.getDate()).slice(-2);
        let mes = meses[fechaObj.getMonth()];
        let anio = fechaObj.getFullYear();
        let fechaFormateada = `${dia}/${mes}/${anio}`;

        let ventana = window.open('', '', 'height=700,width=1000');

        ventana.document.write('<html><head><title>Permiso</title>');
        ventana.document.write('<style>');
        ventana.document.write(`
            body {
                font-family: Arial, sans-serif;
                background-color: #fff;
                color: #012970;
                padding: 40px;
            }
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 3px solid #0011;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }
            .header-left {
                display: flex;
                flex-direction: column;
                align-items: center; /* Centra ambos logos horizontalmente */
            }

            .header-left img {
                height: 28px;
                object-fit: contain;
                margin-bottom: 5px;
            }

            .header-center {
                flex-grow: 1;
                text-align: center;
            }
            .header-center h1 {
                margin: 0;
                font-size: 20px;
                color: #000080;
            }
            .header-right {
                font-size: 12px;
                text-align: right;
                color: #000080;
            }
            .header-right div {
                margin-bottom: 2px;
            }
            .panel-titulo {
                background-color: #fabf8f;
                color: #17355d;
                font-weight: bold;
                padding: 5px 10px;
                margin-top: 15px;
                border: 1px solid black;
            }
            .fila {
                display: flex;
                border: 1px solid black;
            }
            .campo-label {
                background-color: #538cd5;
                color: #fff;
                width: 33%;
                padding: 5px 10px;
                font-weight: bold;
                text-align: center;
                font-size: 12px;
            }
            .campo-valor {
                background-color: #fff;
                color: #012970;
                width: 33%;
                padding: 5px 10px;
                text-align: center;
                font-size: 14px;
            }
            .campo-valor-double {
                width: 66%;
            }
        `);
        ventana.document.write('</style></head><body>');

        // Encabezado con logos y fecha holisuwu
        ventana.document.write(`
            <div class="header">
                <div class="header-left">
                    <img src="{{ asset('/storage/logos/logo.png') }}" alt="Logo Empresa">
                    <img src="{{ asset('/storage/logos/name.png') }}" alt="Logo">
                </div>
                <div class="header-center">
                    <h1>SOLICITUD DE PERMISO</h1>
                </div>
                <div class="header-right">
                    <div><strong>CÓDIGO:</strong> GH-F-014</div>
                    <div><strong>VERSIÓN:</strong> 003</div>
                    <div><strong>PÁGINA:</strong> 1 DE 1</div>
                    <div><strong>FECHA:</strong> 04/MAYO/2023 </div>
                </div>
            </div>
        `);

        // Cuerpo del permiso (HTML oculto)
        ventana.document.write(contenido);

        ventana.document.write('</body></html>');
        ventana.document.close();
        ventana.print();
    }




        // Funcion para ver el permiso en la pestaña emergente
        function verPermiso(id) {
            let contenido = document.getElementById('permiso-info-' + id).innerHTML;
            let ventana = window.open('', '', 'height=700,width=900');

            ventana.document.write('<html><head><title>Permiso</title>');
            ventana.document.write('<style>');
            ventana.document.write(`
                body {
                font-family: Arial, sans-serif;
                background-color: #fff;
                color: #012970;
                padding: 40px;
            }
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 3px solid #0011;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }
            .header-left {
                display: flex;
                flex-direction: column;
                align-items: center; /* Centra ambos logos horizontalmente */
            }

            .header-left img {
                height: 28px;
                object-fit: contain;
                margin-bottom: 5px;
            }

            .header-center {
                flex-grow: 1;
                text-align: center;
            }
            .header-center h1 {
                margin: 0;
                font-size: 20px;
                color: #000080;
            }
            .header-right {
                font-size: 12px;
                text-align: right;
                color: #000080;
            }
            .header-right div {
                margin-bottom: 2px;
            }
            .panel-titulo {
                background-color: #fabf8f;
                color: #17355d;
                font-weight: bold;
                padding: 5px 10px;
                margin-top: 15px;
                border: 1px solid black;
            }
            .fila {
                display: flex;
                border: 1px solid black;
            }
            .campo-label {
                background-color: #538cd5;
                color: #fff;
                width: 33%;
                padding: 5px 10px;
                font-weight: bold;
                text-align: center;
                font-size: 12px;
            }
            .campo-valor {
                background-color: #fff;
                color: #012970;
                width: 33%;
                padding: 5px 10px;
                text-align: center;
                font-size: 14px;
            }
            .campo-valor-double {
                width: 66%;
            }
        `);
        ventana.document.write('</style></head><body>');

        // Encabezado con logos y fecha
        ventana.document.write(`
            <div class="header">
                <div class="header-left">
                    <img src="{{ asset('/storage/logos/logo.png') }}" alt="Logo Empresa">
                    <img src="{{ asset('/storage/logos/name.png') }}" alt="Logo">
                </div>
                <div class="header-center">
                    <h1>SOLICITUD DE PERMISO</h1>
                </div>
                <div class="header-right">
                    <div><strong>CÓDIGO:</strong> GH-F-014</div>
                    <div><strong>VERSIÓN:</strong> 003</div>
                    <div><strong>PÁGINA:</strong> 1 DE 1</div>
                    <div><strong>FECHA:</strong> 04/MAYO/2023 </div>
                </div>
            </div>
        `);

            ventana.document.write(contenido);
            ventana.document.write('</body></html>');
            ventana.document.close();
        }
        // funcion para aceptar o rechazar
        function modificarEstado(id_permisos, accion) {
            console.log('ID enviado:', id_permisos, accion);

            fetch('modificar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_permiso: id_permisos,
                        accion
                    })

                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualizado',
                            text: data.message
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        text: 'No se pudo actualizar el permiso.'
                    });
                    console.error(error);
                });
        }
        // funcion para hacer la confirmación de la accion
function confirmarAccion(id_permiso, accion, estado) {
    if (accion === 'inactivar' && estado === 0) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este permiso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffafb9',
            cancelButtonColor: '#01291251',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                modificarEstado(id_permiso, accion);
            }
        });
    } else if (estado === 1) {
        const mensaje = accion === 'aprobar' ?
            '¿Estás seguro de aprobar este permiso?' :
            '¿Estás seguro de rechazar este permiso?';
        const textoBoton = accion === 'aprobar' ? 'Sí, aprobar' : 'Sí, rechazar';
        Swal.fire({
            title: mensaje,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: accion === 'aprobar' ? '#a4e6e9' : '#ffafb9',
            cancelButtonColor: '#01291251',
            confirmButtonText: textoBoton,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                modificarEstado(id_permiso, accion);
            }
        });
    } else {
        modificarEstado(id_permiso, accion);
    }
}
document.querySelectorAll('.btn-aprobar').forEach(btn => {
    btn.addEventListener('click', function() {
        const idPermiso = this.dataset.id; // Suponiendo que el botón tiene data-id

        fetch('/intranet/permisos/modificar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id_permiso: idPermiso,
                accion: 'aprobar'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Ejemplo: actualizar visualmente el estado del permiso
                document.getElementById('estado_'+idPermiso).textContent = data.nuevo_estado;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Hubo un problema al actualizar el permiso.'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la conexión con el servidor.'
            });
        });
    });
});

    </script>
@endsection
