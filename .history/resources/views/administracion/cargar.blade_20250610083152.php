@extends('layouts.plantilla')

@section('title', 'Cargar Archivos')

@section('content')

<link rel="stylesheet" href="{{asset('/css/forms.css')}}">

<main id="main" class="main">
    {{-- <div >
        <h1 class="text-center">Actualizar y Cargar</h1>
        <nav class="text-center">
            <ol class="breadcrumb d-inline-block">
                <li class="breadcrumb-item d-inline-block" id="1"><a href="?id=1">Inicio</a></li>
                <li class="breadcrumb-item d-inline-block" id="2"><a href="?id=2">Guía y Estructura</a></li>
                <li class="breadcrumb-item d-inline-block" id="3"><a href="?id=3">Prerrequisitos</a></li>
                <li class="breadcrumb-item d-inline-block" id="4"><a href="?id=4">Léeme</a></li>
            </ol>
        </nav>
    </div> --}}
    @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Hay un error con el archivo.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    {{-- @if (Auth::user()->id_rol == 1)
        <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
            <h2 class="head fw-bold mb-5">Cargar Usuarios Base de Datos</h2>
            <div class="row">
                <form action="{{ route('registro.ex') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="fields">
                        <input type="submit" value="probar">
                    </div>
                </form>
            </div>
        </div>
    @endif --}}

    @if (Auth::user()->id_unidad == 1 )
    <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5 mt-4">
        <h2 class="head fw-bold mb-5">Cargar archivos mapa de procesos</h2>
        <form class="formulario" action="{{route('cargar')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <span class="title fw-bold">Subir archivos</span>
                <div class="fields">
                    <div class="input-field">
                        <label class="fw-bold">Carpeta principal</label>
                        <select id="carpeta1" name="carpeta1" required>
                            <option disabled selected value="">Seleccione la carpeta</option>
                            <option value="SIG">SIG</option>
                            <option value="DireccionEstrategica">Dirección Estrategica</option>
                            <option value="GestionComercial">Gestión Comercial</option>
                            <option value="GestionOperaciones">Gestión de Operaciones</option>
                            <option value="GestionDocumental">Gestión Documental</option>
                            <option value="GestionServicioCliente">Gestión Servicio al Cliente</option>
                            <option value="GestionHumana">Gestión Humana</option>
                            <option value="GestionTi">Gestion TI</option>
                            <option value="Compras">Compras</option>
                            <option value="Financiera">Financiera</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label class="fw-bold">Carpeta secundaria</label>
                        <select id="carpeta2" name="carpeta2" required>
                            <option disabled selected value="">Seleccione la carpeta</option>
                            <option value="Caracterizacion">Caracterización</option>
                            <option value="Formatos">Formatos</option>
                            <option value="Instructivo">Instructivo</option>
                            <option value="Manuales">Manuales</option>
                            <option value="Matriz">Matriz</option>
                            <option value="Políticas">Políticas</option>
                            <option value="Procedimientos">Procedimientos</option>
                        </select>
                    </div>

                    <script>
                        function filter(){
                            if ($("#carpeta1").val() == "GestionHumana") {
                                var carpeta = $('#carpeta2');
                                carpeta.append('<option id="Perfiles" value="Perfiles">Perfiles</option>');
                            }
                            else{
                                $('#Perfiles').remove();
                            }
                        }

                        $(function () {
                            filter();

                            $("#carpeta1").change(function () {
                                filter();
                            });

                        });
                    </script>

                    <div class="input-field">
                        <input type="file" name="file[]" id="file" class="file" data-multiple-caption="{count} archivos seleccionados" multiple>
                        <label for="file" class="file text-light fs-6 mt-3"><span class="iborrainputfile">Seleccionar archivo</span></label>
                    </div>
                </div>
                <button type="submit" name="submit" class=" btn-block mt-4">
                    Subir
                </button>
            </form>
        </div>


        <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5 mt-4">
            <h2 class="head fw-bold mb-5">
                <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><style>svg{fill:#0e43a0}</style><path d="M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24h57.7l16.4 30.3L256 192l-45.3-45.3c-12-12-28.3-18.7-45.3-18.7H64c-17.7 0-32 14.3-32 32v32h96c88.4 0 160 71.6 160 160c0 11-1.1 21.7-3.2 32h70.4c-2.1-10.3-3.2-21-3.2-32c0-52.2 25-98.6 63.7-127.8l15.4 28.6C402.4 276.3 384 312 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L418.2 128H480c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32H459.6c-7.5 0-14.7 2.6-20.5 7.4L391.7 78.9l-14-26c-7-12.9-20.5-21-35.2-21H280zM462.7 311.2l28.2 52.2c6.3 11.7 20.9 16 32.5 9.7s16-20.9 9.7-32.5l-28.2-52.2c2.3-.3 4.7-.4 7.1-.4c35.3 0 64 28.7 64 64s-28.7 64-64 64s-64-28.7-64-64c0-15.5 5.5-29.7 14.7-40.8zM187.3 376c-9.5 23.5-32.5 40-59.3 40c-35.3 0-64-28.7-64-64s28.7-64 64-64c26.9 0 49.9 16.5 59.3 40h66.4C242.5 268.8 190.5 224 128 224C57.3 224 0 281.3 0 352s57.3 128 128 128c62.5 0 114.5-44.8 125.8-104H187.3zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg></i>
                 Cargar archivos ultrabikes</h2>
                <form class="formulario" action="{{ route('cargar.ultrabikes') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($message = Session::get('successUltra'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <span class="title fw-bold">Subir archivos</span>
                    <div class="fields">
                        <div class="input-field">
                            <label class="fw-bold">Carpeta principal</label>
                            <select id="carpeta1" name="carpeta1" required>
                                <option disabled selected value="">Seleccione la carpeta</option>
                                <option value="GestionHumana">Gestion Humana</option>
                                <option value="Compras">Compras</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Calidad">Calidad</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label class="fw-bold">Carpeta secundaria</label>
                            <select id="carpeta2" name="carpeta2" required>
                                <option disabled selected value="">Seleccione la carpeta</option>
                                <option value="Caracterizacion">Caracterización</option>
                                <option value="Formatos">Formatos</option>
                                <option value="Instructivo">Instructivo</option>
                                <option value="Manuales">Manuales</option>
                                <option value="Matriz">Matriz</option>
                                <option value="Procedimientos">Procedimientos</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <input type="file" name="file[]" id="fileultrabikes" class="file" data-multiple-caption="{count} archivos seleccionados" multiple>
                            <label for="fileultrabikes" class="file text-light fs-6 mt-3"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                    </div>
                    <button type="submit" name="submit" class=" btn-block mt-4">
                        Subir
                    </button>
                </form>
            </div>


        <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
            <h2 class="head fw-bold mb-5">Editar identidad corporativa</h2>
            @if ($alerta = Session::get('success-identidad'))
            <div class="alert alert-success alert-dismissible">
                <strong>{{ $alerta }}</strong>
                <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button></h3>

            </div>
            @endif
            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3"  style="height: 620px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Noticias Recientes</h4>
                <form class="formulario" action="{{route('iden', 'notifinleco')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <p>Texto 1</p>
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $notifinleco }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
                <form class="formulario" action="{{route('iden', 'notifinleco2')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <p>Texto 2</p>
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $notifinleco2 }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
                <form class="formulario" action="{{route('iden', 'notifinleco3')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <p>Texto 3</p>
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $notifinleco3 }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3"  style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Noticias Recientes/Texto 2</h4>
                <form class="formulario" action="{{route('iden', 'notifinleco2')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $notifinleco2 }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3"  style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Noticias Recientes/Texto 3</h4>
                <form class="formulario" action="{{route('iden', 'notifinleco3')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $notifinleco3 }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div> --}}
            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3" style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">¿Quiénes somos?</h4>
                <form class="formulario" action="{{route('iden', 'somos')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $somos }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3" style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Misión</h4>
                <form class="formulario" action="{{route('iden', 'mision')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $mision }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3" style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Visión</h4>
                <form class="formulario" action="{{route('iden', 'vision')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $vision }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3"  style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Propósito Central</h4>
                <form class="formulario" action="{{route('iden', 'proposito')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $proposito }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane shadow-lg rounded bg-white p-5 mt-3"  style="height: 270px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <h4 class="mb-4" style="color: #012970">Política del Sistema Integrado de Gestión</h4>
                <form class="formulario" action="{{route('iden', 'sig')}}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-10">
                            <textarea name="descripcion" class="text-muted mb-2" style="height: 95px; width: 100%">{{ $sig }}</textarea>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
            <h2 class="head fw-bold mb-5">Actualizar Video</h2>
            @if ($message = Session::get('video-success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <form class="formulario" action="{{route('cargarvideo')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5 mt-2">
                        <strong>Recuerde que el archivo debe tener un peso inferior a 64MB.</strong>
                    </div>
                    <div class="col-3 ">
                        <div class="input-field">
                            <input type="file" name="video" id="video" class="file" data-multiple-caption="{count} archivos seleccionados" />
                            <label for="video" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                    </div>
                    <div class="col-3" onmouseover="sizeValidation()">
                        <button type="submit" name="submit" class=" border rounded" id="btn-video">
                            <span class="btnText text-light fw-bold">Subir</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- actualizar noticias --}}
        <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
            <h2 class="head fw-bold mb-5">Actualizar Noticias</h2>
            @if ($message = Session::get('noticias-success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <div class="tab-pane shadow-lg rounded bg-white p-5" style="height: 330px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <form class="formulario" action="{{route('datosn', 1)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center input-field">
                        <label class="fw-bold">Imagen Actual:</label>
                        <div class="col-6">
                            <img src="{{ asset($descripcion1) }}" style="height: 20vh">
                        </div>
                        <div class="col">
                            <input type="file" name="img" id="foto1" class="file"/>
                            <label for="foto1" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5" style="height: 330px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <form class="formulario" action="{{route('datosn', 2)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center input-field">
                        <label class="fw-bold">Imagen Actual:</label>
                        <div class="col-6">
                            <img src="{{ asset($descripcion2) }}" style="height: 20vh">
                        </div>
                        <div class="col">
                            <input type="file" name="img" id="foto2" class="file"/>
                            <label for="foto2" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5" style="height: 345px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <form class="formulario" action="{{route('datosn', 3)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center input-field">
                        <label class="fw-bold">Imagen Actual:</label>
                        <div class="col-6">
                            <img src="{{ asset($descripcion3) }}" style="height: 20vh">
                        </div>
                        <div class="col">
                            <input type="file" name="img" id="foto3" class="file"/>
                            <label for="foto3" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane shadow-lg rounded bg-white p-5" style="height: 345px; text-align: justify; text-justify: auto; border:2px solid #f37531b4">
                <form class="formulario" action="{{route('datosn', 4)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center input-field">
                        <label class="fw-bold">Imagen Actual:</label>
                        <div class="col-6">
                            <img src="{{ asset($descripcion4) }}" style="height: 20vh">
                        </div>
                        <div class="col">
                            <input type="file" name="img" id="foto4" class="file"/>
                            <label for="foto4" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>
                        <div class="col">
                            <button class="border rounded" type="submit">
                                <span class="btnText text-light fw-bold">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

    @if (Auth::user()->id_unidad == 1 || Auth::user()->id_rol == 3 || Auth::user()->id_unidad == 7)

        {{-- agregar links --}}
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
            <h2 class="head fw-bold mb-5">Agregar Links</h2>
            <p hidden>Clicks: <a id="clicks">0</a></p>
            <a class="text-primary text-decoration-none" id="nuevo-link" onClick="countClick()">
                <i class="bi bi-plus-circle text-primary fs-4"></i> Agregar Fila
            </a>
            <form class="formulario">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña1' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                @foreach ($campañas as $campaña)
                                    <option value='{{ $campaña->id }}'>{{ $campaña->campaña }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url1' placeholder='Ingrese el link' required>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text'  id='nombre1' placeholder='Ingrese el nombre' required>
                        </div>
                        <div class='input-field'>
                            <button class="btn-submit sumbit mt-4 border rounded" type="submit" onclick="clearInputF()">
                                <span class="text-light">Guardar</span>
                            </button>

                        </div>
                    </div>
                </div>
            </form>
            <form class="formulario" id="form2" style="display:none;">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <a type='button' id='delete2' class='text-danger mt-3 fs-4'><i class='bi bi-x-circle'></i></a>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña2' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                <option value='claro'>Claro</option>
                                <option value='colsub'>Colsubsidio</option>
                                <option value='credi'>CrediValores</option>
                                <option value='vanti'>Vanti</option>
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url2' placeholder='Ingrese el link'>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text' id='nombre2' placeholder='Ingrese el nombre' >
                        </div>
                        <div class='input-field'>
                            <button class="btn-submitt sumbit mt-4 border rounded" type="submit" onclick="clearInputFF()">
                                <span class="text-light">Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form class="formulario" id="form3" style="display:none;">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <a type='button' id='delete3' class='text-danger mt-3 fs-4'><i class='bi bi-x-circle'></i></a>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña3' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                <option value='claro'>Claro</option>
                                <option value='colsub'>Colsubsidio</option>
                                <option value='credi'>CrediValores</option>
                                <option value='vanti'>Vanti</option>
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url3' placeholder='Ingrese el link'>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text' id='nombre3' placeholder='Ingrese el nombre' >
                        </div>
                        <div class='input-field'>
                            <button class="btn-submittt sumbit mt-4 border rounded" type="submit" onclick="clearInputFFF()">
                                <span class="text-light">Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- @foreach ($links as $link)
            <tr>
                <td>{{ $link->url }}</td>
                <td>
                    @if($link->estado == 0) <!-- Solo mostrar el botón si el enlace está activo -->
                        <form action="{{ route('intranet.disableLink', $link->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">
                                Deshabilitar
                            </button>
                        </form>
                    @else
                        <span class="text-muted">Deshabilitado</span> <!-- Muestra un texto si el enlace está inactivo -->
                    @endif
                </td>
            </tr>
        @endforeach --}}
    @elseif(Auth::user()->id_unidad == 2)
        <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
            <h2 class="head fw-bold mb-5">Agregar Links</h2>
            <p hidden>Clicks: <a id="clicks">0</a></p>
            <a class="text-primary text-decoration-none" id="nuevo-link" onClick="countClick()">
                <i class="bi bi-plus-circle text-primary fs-4"></i> Agregar Fila
            </a>
            <form class="formulario">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña1' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                @foreach ($campañas as $campaña)
                                    @if ($campaña->campaña == 'Gestion Administrativa')
                                        <option value='{{ $campaña->id }}'>{{ $campaña->campaña }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url1' placeholder='Ingrese el link' required>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text'  id='nombre1' placeholder='Ingrese el nombre' required>
                        </div>
                        <div class='input-field'>
                            <button class="btn-submit sumbit mt-4 border rounded" type="submit" onclick="clearInputF()">
                                <span class="text-light">Guardar</span>
                            </button>

                        </div>
                    </div>
                </div>
            </form>
            <form class="formulario" id="form2" style="display:none;">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <a type='button' id='delete2' class='text-danger mt-3 fs-4'><i class='bi bi-x-circle'></i></a>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña2' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                <option value='1'>Claro</option>
                                <option value='2'>Colsubsidio</option>
                                <option value='3'>CrediValores</option>
                                <option value='4'>Vanti</option>
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url2' placeholder='Ingrese el link'>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text' id='nombre2' placeholder='Ingrese el nombre' >
                        </div>
                        <div class='input-field'>
                            <button class="btn-submitt sumbit mt-4 border rounded" type="submit" onclick="clearInputFF()">
                                <span class="text-light">Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form class="formulario" id="form3" style="display:none;">
                <div class="details personal mt-4">
                    <div class='fields mt-2'>
                        <a type='button' id='delete3' class='text-danger mt-3 fs-4'><i class='bi bi-x-circle'></i></a>
                        <div class='input-field'>
                            <label class="fw-bold">Campaña</label>
                            <select  id='campaña3' required>
                                <option disabled selected value=''>Seleccione la campaña</option>
                                <option value='1'>Claro</option>
                                <option value='2'>Colsubsidio</option>
                                <option value='3'>CrediValores</option>
                                <option value='4'>Vanti</option>
                            </select>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">URL o Link</label>
                            <input type='text' id='url3' placeholder='Ingrese el link'>
                        </div>
                        <div class='input-field'>
                            <label class="fw-bold">Nombre</label>
                            <input type='text' id='nombre3' placeholder='Ingrese el nombre' >
                        </div>
                        <div class='input-field'>
                            <button class="btn-submittt sumbit mt-4 border rounded" type="submit" onclick="clearInputFFF()">
                                <span class="text-light">Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif



    @if (Auth::user()->id_unidad == 1 || Auth::user()->id_rol == 3 || Auth::user()->id_unidad == 7)
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
        <h2 class="head fw-bold mb-5">Eliminar Link</h2>

        <form method="POST" action="{{ route('links.eliminar') }}">
            @csrf
            <div class="details personal mt-4">
                <div class='fields mt-2'>

                    {{-- Selección de campaña --}}
                    <div class='input-field'>
                        <label class="fw-bold">Campaña</label>
                      <select id="campañaSelect" class="form-select" required>
                        <option disabled selected value=''>Seleccione la campaña</option>
                        @foreach ($campañas as $campaña)
                            <option value="{{ $campaña->id }}">{{ $campaña->campaña }}</option>
                        @endforeach
                    </select>
                    </div>

                    {{-- Selección de link dinámico --}}
                    <div class='input-field'>
                        <div class='input-field'>
                            <label class="fw-bold">Link Asociado</label>
                            <select id="linkSelect" class="form-select" style="width:300px;" name="link_id" required>
                                <option disabled selected value=''>Seleccione un link</option>
                            </select>
                        </div>

                    </div>

                    {{-- Botón de eliminar --}}
                    <div class='input-field mt-3'>
                        <button type="submit" class="btn btn-danger">Eliminar Link</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    @endif



    {{-- registro de usuarios nuevos --}}
        @if (Auth::user()->id_unidad == 4 || Auth::user()->id_unidad == 1)

            <div class="container mx-auto tab-pane shadow rounded bg-white p-5 mt-4">
                <h2 class="text-center fw-bold" style="color: #012970">Registrar/Eliminar usuarios</h2>
                @if ($message = Session::get('NoUser'))
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if ($message = Session::get('User'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form class="formulario mt-4" action="{{route('registrar.usuario')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="fields mt-3">
                        <div class="input-field">
                            <label class="fw-bold">Nombre y Apellidos</label>
                            <input type="text" name="nombre">
                        </div>

                        <div class="input-field">
                            <label class="fw-bold ">Numero de Documento</label>
                            <input type="text" name="cedula" id="cedula">
                        </div>

                        <div class="input-field">
                            <label class="fw-bold ">Fecha de Expedición Documento</label>
                            <input type="text" name="expedicion" id="expedicion"  placeholder="DD / MM / YYYY">
                            <script>
                                var date = document.getElementById('expedicion');

                                function checkValue(str, max) {
                                    if (str.charAt(0) !== '0' || str == '00') {
                                        var num = parseInt(str);
                                        if (isNaN(num) || num <= 0 || num > max) num = 1;
                                        str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
                                    };
                                    return str;
                                };

                                date.addEventListener('input', function(e) {
                                    this.type = 'text';
                                    var input = this.value;
                                    // if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
                                    var values = input.split('/').map(function(v) {
                                        return v.replace(/\D/g, '')
                                    });
                                    if (values[0]) values[0] = checkValue(values[0], 31);
                                    if (values[1]) values[1] = checkValue(values[1], 31);
                                    var output = values.map(function(v, i) {
                                        return v.length == 2 && i < 2 ? v + '/' : v;
                                    });
                                    this.value = output.join('').substr(0, 10);
                                });

                                date.addEventListener('blur', function(e) {
                                    this.type = 'text';
                                    var input = this.value;
                                    var values = input.split('/').map(function(v, i) {
                                        return v.replace(/\D/g, '')
                                    });
                                    var output = '';

                                    if (values.length == 3) {
                                        var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
                                        var month = parseInt(values[0]) - 1;
                                        var day = parseInt(values[1]);
                                        var d = new Date(year, month, day);
                                        if (!isNaN(d)) {
                                            document.getElementById('result').innerText = d.toString();
                                            var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
                                            output = dates.map(function(v) {
                                            v = v.toString();
                                            return v.length == 1 ? '0' + v : v;
                                            }).join(' / ');
                                        };
                                    };
                                    this.value = output;
                                });
                            </script>
                        </div>

                    </div>

                    <div class="fields">
                        <div class="input-field">
                            <label class="fw-bold">Fecha de nacimiento</label>
                            <input type="text" name="nacimiento" id="nacimiento" placeholder="DD / MM / YYYY">
                        </div>
                        <script>
                            var date = document.getElementById('nacimiento');

                            function checkValue(str, max) {
                                if (str.charAt(0) !== '0' || str == '00') {
                                    var num = parseInt(str);
                                    if (isNaN(num) || num <= 0 || num > max) num = 1;
                                    str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
                                };
                                return str;
                            };

                            date.addEventListener('input', function(e) {
                                this.type = 'text';
                                var input = this.value;
                                // if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
                                var values = input.split('/').map(function(v) {
                                    return v.replace(/\D/g, '')
                                });
                                if (values[0]) values[0] = checkValue(values[0], 31);
                                if (values[1]) values[1] = checkValue(values[1], 31);
                                var output = values.map(function(v, i) {
                                    return v.length == 2 && i < 2 ? v + '/' : v;
                                });
                                this.value = output.join('').substr(0, 10);
                            });

                            date.addEventListener('blur', function(e) {
                                this.type = 'text';
                                var input = this.value;
                                var values = input.split('/').map(function(v, i) {
                                    return v.replace(/\D/g, '')
                                });
                                var output = '';

                                if (values.length == 3) {
                                    var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
                                    var month = parseInt(values[0]) - 1;
                                    var day = parseInt(values[1]);
                                    var d = new Date(year, month, day);
                                    if (!isNaN(d)) {
                                        document.getElementById('result').innerText = d.toString();
                                        var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
                                        output = dates.map(function(v) {
                                        v = v.toString();
                                        return v.length == 1 ? '0' + v : v;
                                        }).join(' / ');
                                    };
                                };
                                this.value = output;
                            });
                        </script>

                        <div class="input-field">
                            <label class="fw-bold">Area</label>
                            <select name="id_rol" id="choice1">
                                <option disabled selected value=''>Seleccione el area</option>
                                @foreach ($roles as $rol)
                                    @if ($rol->id != 1)
                                        <option value="{{$rol->id}}">{{$rol->rol}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="input-field">
                            <label class="fw-bold">Unidad</label>
                            <select name="id_unidad" id="choice2">
                                <option disabled selected value=''>Seleccione la unidad</option>
                                @foreach ($unidades as $unidad)
                                    @if ($unidad->id >= 1 && $unidad->id <= 7)
                                        <option data-option="2" value="{{$unidad->id}}">{{$unidad->unidad}}</option>
                                    @endif
                                    @if ($unidad->id == 8 || $unidad->id <= 10 && $unidad->id < 17)
                                        <option data-option="3" value="{{$unidad->id}}">{{$unidad->unidad}}</option>
                                    @endif
                                    @if ($unidad->id == 8 || $unidad->id >= 10 && $unidad->id <= 18 || $unidad->id == 22 || $unidad->id == 23 || $unidad->id == 25)
                                        <option data-option="4" value="{{$unidad->id}}">{{$unidad->unidad}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="input-field mb-3">
                            <label class="fw-bold">Foto de usuario</label>
                            <input type="file" name="foto" id="foto" class="file" data-multiple-caption="{count} archivos seleccionados" />
                            <label for="foto" class="file text-light fs-6"><span class="iborrainputfile">Seleccionar archivo</span></label>
                        </div>

                        <script>
                            function filter_options(){
                                if (typeof $("#choice1").data('options') === "undefined") {
                                $("#choice1").data('options', $('#choice2 option').clone());
                            }
                                var id = $("#choice1").val();
                                var options = $("#choice1").data('options').filter('[data-option=' + id + ']');
                                $('#choice2').html(options);
                            }

                            $(function () {
                                filter_options();

                                $("#choice1").change(function () {
                                    filter_options();
                                });

                            });
                        </script>

                    </div>

                    <div class="row mt-4">
                        <div class="col-10">
                            <button class="text-light rounded" type="submit">Registrar</button>
                        </div>
                        <div class="col">
                            <button class="text-light rounded" type="button" data-bs-toggle="modal" data-bs-target="#eliminarUsuarios" style="background-color: #dc3545">Eliminar usuarios</button>
                        </div>
                    </div>
                </form>

                <div class="modal fade" id="eliminarUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Usuario</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; width: 40px"></button>
                            </div>
                            <form action="{{ route('eliminar.usuarios') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="cedula" class="form-label">Cédula</label>
                                        <input name="cedula" type="text" class="form-control border-dark" id="cedulael" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #6c757d">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" style="background-color: #dc3545">Eliminar Usuario</button>
                                </div>
                            </form>
                        </div>
                        <script>
                            $(document).ready(function(){

                                $('#cedulael').on('keyup', function(){
                                    $(this).val(validarTexto($('#cedulael').val()));
                                });

                                function validarTexto(texto) {
                                    return texto.toLowerCase().replace(/[^0-9\-]+/g, "");
                                }

                                $('#cedula').on('keyup', function(){
                                    $(this).val(validarTexto($('#cedula').val()));
                                });

                                function validarTexto(texto) {
                                    return texto.toLowerCase().replace(/[^0-9\-]+/g, "");
                                }

                            })
                        </script>
                    </div>
                </div>

            </div>
        @endif



</main>

<script>

//borrar el contenido de los inputs de cada uno de los forms.

function clearInputF(){

    var getUrl1 = document.getElementById('url1');
    var getNombre1 = document.getElementById('nombre1');

    if (getUrl1.value != "") {
           setTimeout(() => {getUrl1.value = ""}, 1000);
    }
    if (getNombre1.value != "") {
        setTimeout(() => {getNombre1.value = ""}, 1000);
    }
}

function clearInputFF(){

    var getUrl2 = document.getElementById('url2');
    var getNombre2 = document.getElementById('nombre2');

    if (getUrl2.value != "") {
        setTimeout(() => {getUrl2.value = ""}, 1000);
    }
    if (getNombre2.value != "") {
        setTimeout(() => {getNombre2.value = ""}, 1000);
    }
}

function clearInputFFF(){

    var getUrl3 = document.getElementById('url3');
    var getNombre3 = document.getElementById('nombre3');

    if (getUrl3.value != "") {
        setTimeout(() => {getUrl3.value = ""}, 1000);
    }
    if (getNombre3.value != "") {
        setTimeout(() => {getNombre3.value = ""}, 1000);
}

}

//envio de datos de los forms
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".btn-submit").click(function(e){
    e.preventDefault();

    var campaña1 = $("#campaña1").val();
    var url1 = $("#url1").val();
    var nombre1 = $("#nombre1").val();

    $.ajax({
        type: "POST",
        url: "{{ route('datos.link') }}",
        data: {campaña:campaña1, url:url1, nombre:nombre1},
        success: function (data) {
            if($.isEmptyObject(data.error)){
                alert('link guardado exitosamente');
            }else{
                alert('error');
            }

        }
    });
});

$(".btn-submitt").click(function(e){
    e.preventDefault();

    var campaña2 = $("#campaña2").val();
    var url2 = $("#url2").val();
    var nombre2 = $("#nombre2").val();

    $.ajax({
        type: "POST",
        url: "{{ route('datos.link') }}",
        data: {campaña:campaña2, url:url2, nombre:nombre2},
        success: function (data) {
            if($.isEmptyObject(data.error)){
                alert('link guardado exitosamente');
            }else{
                alert('error');
            }

        }
    });
});

$(".btn-submittt").click(function(e){
    e.preventDefault();

    var campaña3 = $("#campaña3").val();
    var url3 = $("#url3").val();
    var nombre3 = $("#nombre3").val();

    $.ajax({
        type: "POST",
        url: "{{ route('datos.link') }}",
        data: {campaña:campaña3, url:url3, nombre:nombre3},
        success: function (data) {
            if($.isEmptyObject(data.error)){
                alert('link guardado exitosamente');
            }else{
                alert('error');
            }

        }
    });
});

//inserta un nuevo form en la vista

var clicks = 0;

function countClick() {
    clicks+=1;
    document.getElementById("clicks").innerHTML = clicks;

    if(clicks == 1){
        $("#form2").show(800);

    }else if( clicks == 2){
        $("#form3").show(800);
    }

}

$(document).on('click', '#delete2', function(){
    if(confirm('¿Esta seguro de eliminar la fila?') == true){
        $("#form2").hide(750);
    }
});

$(document).on('click', '#delete3', function(){
    if(confirm('¿Esta seguro de eliminar la fila?') == true){
        $("#form3").hide(750);
    }
});


// funcion verificar tamaño del archivo adjunto para las pausas activas
function sizeValidation() {
       var input = document.getElementById('video');
       var file = input.files;
       var fileSize = Math.round((file[0].size / 1024));

       if (fileSize >= 64*1024) {
           alert("Error! El archivo excede el limite de 64MB");
        }
   }

// coloca el nombre del archivo adjunto que se subirá en el label
( function ( document, window, index ){

    // boton del mapa de procesos
	var inputs = document.querySelectorAll( '#file' );
	Array.prototype.forEach.call( inputs, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});

	var inputs = document.querySelectorAll( '#fileultrabikes' );
	Array.prototype.forEach.call( inputs, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});

    // boton del video de las pausas activas
    var videos = document.querySelectorAll( '#video' );
    Array.prototype.forEach.call( videos, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});

    var videos = document.querySelectorAll( '#foto' );
    Array.prototype.forEach.call( videos, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});

    // boton del video de las pausas activas
    var videos = document.querySelectorAll( '#excel' );
    Array.prototype.forEach.call( videos, function( input ){
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function(e){
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});
}( document, window, 0 ));
</script>

<script>
    $(document).ready(function(){

        $('#cedula').on('keyup', function(){
            $(this).val(validarTexto($('#cedula').val()));
        });

        function validarTexto(texto) {
            return texto.toLowerCase().replace(/[^0-9\-]+/g, "");
        }

    })
</script>

@endsection
