@extends('layouts.plantilla')

@section('title', 'Inicio')

@section('content')

<link rel="stylesheet" href="{{ asset('/css/scroll.css') }}">
<link rel="stylesheet" href="{{ asset('/css/modal.css') }}">
<link rel="stylesheet" href="{{ asset('/css/animacion.css') }}">

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Inicio</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Anuncios</li>
            </ol>
        </nav>
    </div>

    @if (Auth::user()->ingreso == 0)
        <div class="modal" style="display: block;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="my-2">Cambio de contraseña</h4>
                </div>
                <div class="modal-body">
                    <p class="my-2">Cambio de contraseña inicial obligatorio</p>
                    <form action="{{ route('cambio.index', Auth::user()->cedula) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-outline form-light mb-4">
                                <label class="form-label" for="p1">Nueva contraseña</label>
                                <input name="p1" type="password" id="p1" class="form-control form-control-lg" style="border-color: #aaa"/>
                                <span class="text-danger" id="ver1"></span>
                            </div>

                            <div class="form-outline form-light mb-4">
                                <label class="form-label" for="p2">Confirme su nueva contraseña</label>
                                <input name="p2" type="password" id="p2" class="form-control form-control-lg" style="border-color: #aaa"/>
                                <span class="text-danger" id="ver2"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input id="envio" type="submit" class="btn btn-primary" value="Actualizar Contraseña">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-warning alert-dismissible fade show" style="margin-right: 16%; margin-left:16%;" role="alert">
            <h3 class="mt-2"><strong>{{Session::get('success')}}</strong> {{Auth::user()->nombre}}
            <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button></h3>
        </div>
    @endif

    <section class="section dashboard">
        <div id="container" class="row">

            {{-- Sección de Noticias --}}
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">NOTIFINLECO <span>| Importantes del día de hoy</span></h5>

                        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($noticias as $key => $noticia)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                                        <img src="{{ asset($noticia->descripcion) }}" class="d-block mx-auto mw-100" alt="..." style="height: 410px;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev"></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next"></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Imagen Hormiga --}}
            <div id="imagen">
                <img src="{{ asset('storage/logos/HORMIGA.png') }}" alt="Norma" style="max-width: 100%;">
            </div>

            <style>
                #container {
                    position: relative;
                }

                #imagen {
                    position: absolute;
                    bottom: 10px; /* Ajusta según necesites */
                    right: 10px; /* Ajusta según necesites */
                    z-index: 10; /* Asegura que quede sobrepuesta */
                    max-width: 150px; /* Tamaño de la imagen */
                }

                @media only screen and (max-width: 991px) {
                    #imagen {
                        display: none; /* Oculta la imagen en dispositivos pequeños */
                    }
                }
            </style>
        </div>
    </section>


    <section class="section dashboard">
        <div id="container" class="row">

            {{-- Sección de Noticias --}}
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow-sm p-4" style="border-radius: 12px; background-color: #ffffff;">
                    <div class="d-flex">
                        <!-- Texto dinámico -->
                        <div style="flex: 1; padding-right: 20px; text-align: left;">
                            <h4 style="font-weight: bold; color: #333;">Noticias Recientes</h4>
                            <p style="color: #555; font-size: 16px; line-height: 1.2">{!! nl2br(e($notifinleco)) !!}</p>
                            <br>
                            <p style="color: #555; font-size: 16px; line-height: 1.2">{!! nl2br(e($notifinleco2)) !!}</p>
                            <br>
                            <p style="color: #555; font-size: 16px; line-height: 1.2">{!! nl2br(e($notifinleco3)) !!}</p>
                        </div>

                        <!-- Imágenes en vertical -->
                        <div style=" display: flex; flex-direction: column; gap: 15px; align-items: center;">
                            <a href="" target="_blank">
                                <img src="{{ asset('storage/logos/notifinleco1.png') }}" alt="Link 1" style="width: 350px; height: 172px; border-radius: 16px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);">
                            </a>
                            <!-- <a href="" target="_blank">
                                <img src="{{ asset('storage/logos/notifinleco2.png') }}" alt="Link 2" style="width: 350px; height: 172px; border-radius: 16px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);">
                            </a> -->
                            <!-- <a href="" target="_blank">
                                <img src="{{ asset('storage/logos/notifinleco3.png') }}" alt="Link 3" style="width: 350px; height: 172px; border-radius: 16px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);">
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>




            {{-- Sección de Video --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Video <span>| Video</span></h5>
                        <div class="container overflow-auto" style="height: 98%">
                            <video id="video" src="{{asset('/storage/pausas-activas/pausas-activas.mp4')}}" width="100%" height="500px" controls>
                                Tu navegador no admite el elemento <code>video</code>.
                            </video>
                        </div>
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <form>
                            <input id="nombre" value="{{ Auth::user()->nombre }}" hidden>
                            <input id="cedula" value="{{ Auth::user()->cedula }}" hidden>
                            <input id="fecha" value="{{date('d/m/Y')}}" hidden>
                            {{-- <center><button id="repro" onclick="control()" type="submit" class="ver btn btn-primary">Ver video</button></center> --}}
                        </form>
                    </div>
                </div>
            </div>


            {{-- Columna lateral para otras informaciones --}}
            {{-- <div class="col-lg-4 mb-4">
                <div id="imagen">
                    <img src="{{asset('storage/logos/HORMIGA.png')}}" width="220px" alt="Norma">
                </div> --}}

                <style>
                    #container{
                        position: relative;
                    }

                    #imagen{
                        position: absolute;
                        margin-left: 40%;
                        margin-top: 120px;
                        max-width: 200px;
                    }

                    @media only screen and (max-width: 991px){
                        #imagen{
                           display: none;
                        }
                    }
                </style>
            </div>

        </div>
    </section>

    <script src="{{ asset('/js/validacion.js') }}"></script>
    <script>
        // Función de control para pausar y reproducir el video
        function control(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            let video = document.getElementById('video');
            if (video.paused) {
                video.play();
                document.getElementById('repro').innerText = 'Pausar video'; // Cambiar texto del botón
            } else {
                video.pause();
                document.getElementById('repro').innerText = 'Reproducir video'; // Cambiar texto del botón
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".ver").click(function(e) {
            e.preventDefault();

            var nombre = $("#nombre").val();
            var cedula = $("#cedula").val();
            var fecha = $("#fecha").val();

            $.ajax({
                type: "POST",
                url: "{{ route('vista.video') }}",
                data: { nombre: nombre, cedula: cedula, fecha: fecha },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        // No error
                    } else {
                        alert('error');
                    }
                }
            });
        });
    </script>

</main>

@endsection
