@php use App\Models\User; @endphp


@extends('layouts.plantilla')

@section('title', 'listado')

@section('content')

    <link rel="stylesheet" href="{{ asset('/css/Permisos.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <script src="/intranet/js/sweetalert2.min.js"></script>



    <main id="main" class="main">
        <div class="pagetitle">
            <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold" style="color: #012970">Listado Permisos</h2>
                <nav>
                    {{-- Redirige a la vista donde esta el formulario de solicitud de permisos --}}
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vista.calendario') }}">Tabla</a></li>
                        <li class="breadcrumb-item active">Informacion</li>
                    </ol>
                </nav>

                <div class="container">
                    <div class="mx-auto">
                        <div class="panel" style="background: #ffffff; ">
                            <div class="panel-heading" style="background: #e26d2dbd;">
                                <div class="row">
                                    <div class="col-sm-9 col-xs-12 text-right">
                                        <div class="btn_group">
                                            {{-- Formulario de busqueda --}}
                                            <form>
                                                {{-- Estilos para el buscador y el boto de volver --}}

                                                <div class="search-container">
                                                    <div>
                                                        {{-- Boton volver --}}
                                                        <a href="{{ route('vista.calendario') }}">
                                                            <button class="mt-4 border rounded"; style="left: -770px"
                                                                type="button"">
                                                                <span class="btnText  fw-bold">Volver</span>
                                                            </button></a>
                                                    </div>
                                                    {{-- input de busqueda --}}
                                                    <i class="fas fa-search"></i>
                                                    <label for="searchTerm" class="visually-hidden">Buscar permisos</label>
                                                    <input class="form-control w-100 w-md-50" type="text"
                                                        name="busqueda_generall" id="busqueda_generall"
                                                        placeholder="Buscar..." value="{{ request()->busqueda_generall }}">
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive custom-scroll">
                                {{-- Tabla con la informacion que va a mostar --}}
                                <table class="table" id="datos" style="text-align: center">
                                    <thead>
                                        <tr style="background: #e26c2d6e">
                                            <th style="color: #012970">No. Permiso</th>
                                            <th style="color: #012970">Estado</th>
                                            <th style="color: #012970">Nombre</th>
                                            <th style="color: #012970">Unidad</th>
                                            <th style="color: #012970">Descripcion</th>
                                            <th style="color: #012970">Fecha de permiso</th>
                                            <th style="color: #012970">Total de horas</th>
                                            <th style="color: #012970">Fecha desde</th>
                                            <th style="color: #012970">Fecha hasta</th>
                                            <th style="color: #012970">Hora de salida</th>
                                            <th style="color: #012970">Hora de llegada</th>
                                            <th style="color: #012970">Modificar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datos as $dato)
                                            <tr>
                                                <td style="color: #012970">
                                                    {{ $dato->id_permisos }}
                                                </td>
                                                <td {{-- Mostramos el estado con color de fondo --}}
                                                    @if ($dato->estado == 2) style="background-color: #a4e6c888; color: #012970;"
                                                        @elseif ($dato->estado == 3)
                                                            style="background-color: #ffafb988; color: #012970;"
                                                        @elseif ($dato->estado == 1)
                                                            style="background-color: #e8ab0151; color: #012970;"
                                                        @elseif ($dato->estado == 0)
                                                            style="background-color: #fff; color: #012970;" @endif>
                                                    {{-- Nombre del estado --}}
                                                    @if ($dato->estado == 2)
                                                        Aprobado
                                                    @elseif ($dato->estado == 3)
                                                        Rechazado
                                                    @elseif ($dato->estado == 1)
                                                        En proceso
                                                    @else
                                                        Pendiente
                                                    @endif
                                                </td>
                                                {{-- Datos sobre el permiso del usuario autenticado --}}
                                                <td style="color: #012970">
                                                    {{ optional(User::find($dato->usuario_id))->nombre }}</td>
                                                <td style="color: #012970">{{ $dato->unidad->unidad }}</td>
                                                <td style="color: #012970">{{ $dato->descripcion }}</td>
                                                <td style="color: #012970">{{ $dato->fecha_permiso }}</td>
                                                <td style="color: #012970">{{ $dato->total_horas }}</td>
                                                <td style="color: #012970">{{ $dato->fecha_desde }}</td>
                                                <td style="color: #012970">{{ $dato->fecha_hasta }}</td>
                                                <td style="color: #012970">{{ $dato->hora_salida }}</td>
                                                <td style="color: #012970">{{ $dato->hora_llegada }}</td>
                                                <td
                                                    style="display: flex; justify-content: space-evenly; align-items: center">
                                                    {{-- Boton de aprobar --}}
                                                    @if ($dato->estado == 0)
                                                        <button type="button"
                                                            onclick="Modificar({{ $dato->id_permisos }})"
                                                            style="background-color: transparent; border: 0; border-radius: 5px; width: 35px; height: 35px;"
                                                            onmouseover="this.style.backgroundColor='rgba(169, 241, 202, 0)'"
                                                            onmouseout="this.style.backgroundColor='transparent'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
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
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class='noSearch hide'>
                                            <td colspan="10"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Modal para editar permiso -->
                                <div class="modal fade" id="modalEditarPermiso" tabindex="-1"
                                    aria-labelledby="modalEditarPermisoLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #e26d2dbd;">
                                                <h5 class="modal-title text-white">Editar Permiso
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Cerrar"></button>
                                            </div>
                                            <form id="formEditarPermiso" method="POST" action="">
                                                @csrf
                                                <input type="hidden" name="id_permisos" id="id_permisos_editar">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="fecha_permiso_editar" class="form-label">Fecha
                                                            Permiso</label>
                                                        <input type="date" class="form-control" name="fecha_permiso"
                                                            id="fecha_permiso_editar" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion_editar"
                                                            class="form-label">Descripción</label>
                                                        <textarea class="form-control" name="descripcion" id="descripcion_editar" rows="3" required></textarea>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="fecha_desde_editar">Fecha Desde</label>
                                                            <input type="date" class="form-control" name="fecha_desde"
                                                                id="fecha_desde_editar">
                                                        </div>
                                                        <div class="col">
                                                            <label for="fecha_hasta_editar">Fecha Hasta</label>
                                                            <input type="date" class="form-control" name="fecha_hasta"
                                                                id="fecha_hasta_editar">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">

                                                            <label for="hora_salida_editar">Hora de Salida</label>
                                                            <input type="time" class="form-control" name="hora_salida"
                                                                id="hora_salida_editar">

                                                        </div>
                                                        <div class="col">

                                                            <label for="hora_llegada_editar">Hora de Llegada</label>
                                                            <input type="time" class="form-control"
                                                                name="hora_llegada" id="hora_llegada_editar">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="horas_dia_editar">Horas por Día</label>
                                                            <input type="number" step="0.5" class="form-control"
                                                                name="horas_dia" id="horas_dia_editar" readonly>
                                                        </div>
                                                        <div class="col">
                                                            <label for="total_horas_editar">Total de Horas</label>
                                                            <input type="number" step="0.5" class="form-control"
                                                                name="total_horas" id="total_horas_editar" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Guardar
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
        function Modificar(id_permisos) {
            console.log("Consultando permiso con ID:", id_permisos);

            const url = @json(route('permisos.obtener', ['id' => '__ID__'])).replace('__ID__', id_permisos);
            const actualizarUrl = @json(route('permisos.actualizar', ['id' => '__ID__'])).replace('__ID__', id_permisos);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.estado !== 0) {
                        alert("?? Solo se puede editar permisos en estado pendiente.");
                        return;
                    }

                    // Asignar la URL al formulario
                    document.getElementById('formEditarPermiso').action = actualizarUrl;

                    // Llenar los campos del formulario
                    // Convierte '13:00:00' a '13:00'
                    function formatHora(hora) {
                        if (!hora || typeof hora !== 'string') return '';
                        return hora.slice(0, 5); // Solo HH:MM
                    }

                    // En tu .then(data => { ... })
                    document.getElementById('hora_salida_editar').value = formatHora(data.hora_salida);
                    document.getElementById('hora_llegada_editar').value = formatHora(data.hora_llegada);

                    document.getElementById('id_permisos_editar').value = data.id_permisos;
                    document.getElementById('fecha_permiso_editar').value = data.fecha_permiso;
                    document.getElementById('descripcion_editar').value = data.descripcion;
                    document.getElementById('fecha_desde_editar').value = data.fecha_desde;
                    document.getElementById('fecha_hasta_editar').value = data.fecha_hasta;
                    document.getElementById('horas_dia_editar').value = data.horas_dia;
                    document.getElementById('horas_dia_editar').value = data.horas_dia;
                    document.getElementById('total_horas_editar').value = data.total_horas;

                    // Mostrar el modal
                    const modal = new bootstrap.Modal(document.getElementById('modalEditarPermiso'));
                    modal.show();
                })
                .catch(error => {
                    console.error('? Error obteniendo datos del permiso:', error);
                    alert(`No se pudo cargar la información del permiso.\n${error.message}`);
                });
        }
        // Captura los inputs una vez que el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function() {
            const fechaDesdeInput = document.getElementById('fecha_desde_editar');
            const fechaHastaInput = document.getElementById('fecha_hasta_editar');
            const horaSalidaInput = document.getElementById('hora_salida_editar');
            const horaLlegadaInput = document.getElementById('hora_llegada_editar');
            const horasDiaInput = document.getElementById('horas_dia_editar');
            const totalHorasInput = document.getElementById('total_horas_editar');
            document.getElementById('formEditarPermiso').addEventListener('submit', function(e) {
                const totalHoras = parseFloat(document.getElementById('total_horas_editar').value);

                if (!totalHoras || totalHoras === 0) {
                    e.preventDefault(); // evita el envío del formulario
                    Swal.fire({
                        icon: 'warning',
                        title: 'Total de horas en 0',
                        text: "?? El total de horas no puede ser 0",
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#e26d2d'
                    })
                }
            });

            function actualizarHoras() {
                const fechaDesde = new Date(fechaDesdeInput.value);
                const fechaHasta = new Date(fechaHastaInput.value);
                const horaSalida = horaSalidaInput.value;
                const horaLlegada = horaLlegadaInput.value;

                if (
                    isValidDate(fechaDesde) &&
                    isValidDate(fechaHasta) &&
                    horaSalida &&
                    horaLlegada &&
                    /^\d{2}:\d{2}$/.test(horaSalida) &&
                    /^\d{2}:\d{2}$/.test(horaLlegada)
                ) {
                    // Validar días
                    if (fechaDesde.getDay() === 6 || fechaDesde.getDay() === 5) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Día no permitido',
                            text: "?? La fecha 'Desde' no puede ser sábado o domingo.",
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#e26d2d'
                        });
                        limpiarCampos();
                        return;
                    }

                    if (fechaHasta.getDay() === 6 || fechaHasta.getDay() === 5) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Día no permitido',
                            text: "?? La fecha 'Hasta' no puede ser sábado o domingo.",
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#e26d2d'
                        });
                        limpiarCampos();
                        return;
                    }

                    const dias = Math.floor((fechaHasta - fechaDesde) / (1000 * 60 * 60 * 24)) + 1;

                    const [h1, m1] = horaSalida.split(":").map(Number);
                    const [h2, m2] = horaLlegada.split(":").map(Number);

                    let salidaMin = h1 * 60 + m1;
                    let llegadaMin = h2 * 60 + m2;

                    let minutosTotales = llegadaMin - salidaMin;
                    if (minutosTotales < 0) minutosTotales += 24 * 60;

                    const totalHoras = minutosTotales / 60;
                    const horasPorDia = totalHoras / dias;

                    totalHorasInput.value = totalHoras.toFixed(2);
                    horasDiaInput.value = horasPorDia.toFixed(2);
                } else {
                    horasDiaInput.value = '';
                    totalHorasInput.value = '';
                }
            }


            function isValidDate(d) {
                return d instanceof Date && !isNaN(d);
            }

            // Ahora sí, asignamos los eventos
            fechaDesdeInput.addEventListener('change', actualizarHoras);
            fechaHastaInput.addEventListener('change', actualizarHoras);
            horaSalidaInput.addEventListener('change', actualizarHoras);
            horaLlegadaInput.addEventListener('change', actualizarHoras);

            // Ejecutar una vez al cargar
            actualizarHoras();
        });
    </script>


@endsection
