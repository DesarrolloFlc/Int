@extends('layout.plantilla')

@section('title', 'Requerimientos')

@section('content')

    {{-- <link rel="stylesheet" href="{{asset('css/categorias.css')}}"> --}}

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .button-container {
            display: flex;
            gap: 20px;
            justify-content: space-between;
        }

        .eliminar:hover {
            background-color: #135eb4 !important;
            cursor: pointer;
            transform: scale(1.05);
        }

        .input-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .input-field {
            flex: 1;
            min-width: calc(50% - 10px);
        }

        .table {
            margin-top: 20px;
        }

        .btnText {
            width: 150px;
        }

        .title.head {
            border-bottom: 2px solid #d76f28;
            padding-bottom: 5px;
        }

        button {
            background-color: #d76f28;
            border: 0;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        button:hover {
            background-color: #ff8738 !important;
            transform: scale(1.1);
        }

        /*-------PAGINA RESPOSIVA ESTILOS------*/
        /* Estilos para evitar la barra de desplazamiento horizontal */
        .table-container {
            width: 100%;
            overflow-x: auto;
            /* Permite desplazamiento solo si es necesario */
            -webkit-overflow-scrolling: touch;
            /* Mejorar el desplazamiento en dispositivos táctiles */
        }

        table {
            width: 100%;
            /* Asegura que la tabla ocupe todo el espacio disponible */
            table-layout: fixed;
            /* Establece un layout fijo para que la tabla no crezca más allá de su contenedor */
        }

        th,
        td {
            word-wrap: break-word;
            /* Evita el desbordamiento de texto en las celdas */
        }

        /* Media Queries para hacer el diseño responsive */
        @media (max-width: 1200px) {
            .input-container {
                flex-direction: column;
            }

            .input-field {
                min-width: 100%;
                /* Los campos de entrada ocuparán el 100% del ancho */
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .btnText {
                width: auto;
            }
        }

        @media (max-width: 768px) {
            .details {
                margin-left: 0;
                margin-right: 0;
            }

            .fields {
                width: 100%;
                /* La sección de campos ocupa el 100% del ancho en pantallas pequeñas */
            }

            .table-container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .table {
                font-size: 0.9rem;
                /* Reducir el tamaño de la fuente en las tablas */
            }

            .title.head {
                font-size: 1.2rem;
                /* Reducir el tamaño del título */
            }

            .button-container button {
                width: 100%;
                /* Los botones ocupan el 100% del ancho en pantallas pequeñas */
                margin: 5px 0;
            }

            .input-field input {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            h2.title {
                font-size: 1.5rem;
                /* Reducir aún más el tamaño de los títulos en pantallas pequeñas */
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                /* Reducir tamaño de texto en las celdas */
            }

            .input-container {
                gap: 15px;
                /* Reducir espacio entre campos en pantallas muy pequeñas */
            }

            .search-container {
                flex-direction: column;
            }

            .search-container select,
            .search-container input {
                width: 100%;
            }

            .table {
                font-size: 0.8rem;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <body>
        <div class="container-fluid-100%">
            <div class="container-fluid">
                <form id="form-papeleria" class="formulario"  method="POST">
                    @csrf
                    <div class="details personal mt-4 ">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; align-items: center; width: 100%;">
                            <h4 class="title head"
                                style="border-bottom: 3px solid #0f3f76; padding-bottom: 5px; margin-left: 20px; display: inline-block;">
                                Información sobre Adquisicion
                            </h4>
                            <h4 class="title head"
                                style="border-bottom: 3px solid #d76f28; padding-bottom: 5px; margin-right: 20px; text-align: right; display: inline-block;">
                                Control de Adquisicion
                            </h4>
                        </div>

                        <div class="d-flex">
                            <div class="fields w-50 me-3" style="margin-left: 20px;">

                                <div class="input-container">
                                        <div class="input-field">
                                            <label for="id_proceso">Proceso:</label>
                                            <select name="id_proceso" id="id_proceso" style="width: 100%; max-width: 500px;">
                                                <option value="">Seleccione</option>
                                                {{-- @foreach ($proceso as $item)
                                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    <div class="input-field">
                                        <label>Fecha de Recepción:</label>
                                        <input type="date" name="fecha_recepcion" id="fecha_recepcion" value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <div class="input-field">
                                        <label>N° de Cédula</label>
                                        <div class="search-input-container">
                                            <input autocomplete="nope" type="text" id="searchInputUser"
                                                class="form-control searchREsults"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); limitarLongitud(this, 15)"
                                                placeholder="N° de Cédula..." name="searchInputUser">
                                            <div id="searchResultsUser" class="searchResults"></div>
                                        </div>
                                    </div>

                                    <div class="input-field">
                                        <label>Nombre del Usuario</label>
                                        <input type="text" id="selectedUserName" name="selectedUserName"
                                            class="selectedItem form-control" readonly>
                                    </div>
                                </div><br>
                                <div class="input-field">
                                    <label>Cargo del Usuario</label>
                                    <input type="text" id="selectedUserRole" class="selectedItem form-control" readonly
                                        name="cargo">
                                </div>

                                <div style="display: block; margin-top: 15px; width: 100%;">
                                    <input type="text" id="concepto" name="concepto" style="width: 100%; height: 70px;" placeholder="CONCEPTO" maxlength="150" oninput="contador()">
                                    <div>
                                        <span id="contar">0</span> / 150 caracteres
                                    </div>
                                </div>

                                <table class="table table-bordered mt-3">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th>DESCRIPCIÓN</th>
                                            <th>UNIDAD DE MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla">
                                        <tr>
                                            <td><input type="text" name="descripcion[]" class="form-control" maxlength="100"></td>
                                            <td><input type="text" name="unidad_medida[]" class="form-control"></td>
                                            <td><input type="text" name="cantidad[]" class="form-control" min="1"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"></td>
                                            <td style="text-align: center"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="button-container" style="margin-left:20px;">
                                    <button class="submit mt-5 mb-4 border rounded" type="button"
                                        onclick="return lineanueva()">
                                        <span class="btnText text-light fw-bold">+ Agregar Línea</span>
                                    </button>
                                    <button class="submit mt-5 mb-4 border rounded" type="submit"
                                        style="margin-left:10px ;">
                                        <span class="btnText text-light fw-bold">Enviar</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                <div class="w-50" style="margin-right:20px;">
                    <div style=" width: 95%; padding-top: 20px; margin-left:25px;">
                        <form method="GET">
                            <div class="search-container mb-05" style="display: flex; gap: 10px;">
                                <select id="search-fecha" name="fecha" class="form-control mb-2" style="height:44px; margin-top:6px;">
                                    {{-- <option value="">Selecciona una Fecha</option>
                                    @foreach ($requerimientos->pluck('fecha_recepcion')->unique() as $fecha)
                                        <option value="{{ $fecha }}">
                                            {{ $fecha }}
                                        </option>
                                    @endforeach --}}
                                </select>


                                <select id="search-reque" name="reque" class="form-control mb-2" style="height:44px; margin-top:6px;">
                                    <option value="">Selecciona un Requerimiento</option>
                                    {{-- @foreach ($requerimientos as $requerimiento)
                                        @if ($requerimiento->usuario_solicita_id == Auth::id()) <!-- Filtrar solo los requerimientos del usuario autenticado -->
                                            <option value="{{ $requerimiento->no_requerimiento }}">
                                                {{ $requerimiento->no_requerimiento }}
                                            </option>
                                        @endif
                                    @endforeach --}}
                                </select>

                                <button type="submit" class="btn" style="background-color: #0f3f76; color: white; transition: background-color 0.3s, transform 0.2s;">
                                    <i class="bi bi-search" style="color: white;"></i>
                                </button>

                            </div>
                        </form>
                    </div>


                    <!-- Tabla con los datos -->
                    <table class="table table-bordered mt-3" style="text-align: center; font-size:13px;">
                        <thead>
                            <tr>
                                <th>N° DE REQUERIMIENTO</th>
                                <th>FECHA DE RECEPCIÓN</th>
                                <th>ESTADO</th>
                                <th>FECHA DE ENTREGA</th>
                            </tr>
                        </thead>
                        <tbody id="tabla2">
                            {{-- @foreach ($adquisicion as $adquisi)
                                @if ($adquisi->usuario_solicita_id == Auth::id()) <!-- Asegura que solo el usuario autenticado vea sus datos -->
                                    <tr>
                                        <td>{{ $adquisi->no_requerimiento }}</td>
                                        <td>{{ $adquisi->fecha_recepcion }}</td>
                                        <td>
                                            @switch($adquisi->estado_r)
                                                @case(1) ENVIADO @break
                                                @case(2) APROBADO @break
                                                @case(3) CANCELADO @break
                                                @case(4) EN PROCESO @break
                                                @case(5) COTIZACIÓN @break
                                                @default DESCONOCIDO
                                            @endswitch
                                        </td>
                                        <td>{{ $adquisi->entrega_cierre ?? 'Sin entregar' }}</td>
                                    </tr>
                                @endif
                            @endforeach --}}
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $adquisicion->links() }}  <!-- Paginación generada por Laravel -->
                    </div>
                </div>

                            </div>
                        </div>
                    </div>
            </div>

        </div>
        </div>
    </body>

@endsection

