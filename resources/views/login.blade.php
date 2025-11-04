<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- ICON --}}
    <link rel="icon" href="{{ asset('/storage/logos/logo.png') }}">

    {{-- TITLE --}}
    <title>Inicio de sesion</title>

    {{-- SCROLL --}}
    <link rel="stylesheet" href="{{ asset('css/scroll.css') }}">

    {{-- CSS --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> --}}
    <link href="{{ asset("css/login/bootstrap.min.css") }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}"> --}}

    {{-- SCRIPTS --}}
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> --}}
    <script src="{{ asset("js/login/code.jquery.com_jquery-3.3.1.slim.min.js") }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> --}}
    <script src="{{ asset("js/login/bootstrap.bundle.min.js") }}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> --}}
    <script src="{{ asset("js/login/ajax.googleapis.com_ajax_libs_jquery_1.10.2_jquery.min.js") }}"></script>

</head>

<link rel="stylesheet" href="{{ asset('css/btn.css') }}">


<section class="vh-100 gradient-custom" style="background-image: url({{ asset('/storage/fondo.png') }}); background-size: 100vw">
    <div class="container py-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-light text-dark" style="height: 500px; background: linear-gradient(white, white) padding-box, linear-gradient(to top, #ff7b00, #0084FF) border-box; border-radius: 1rem; border: 5px solid transparent;">
                    <div class="card-body p-4 text-center">

                        <img src="{{asset('/storage/logos/logo.png')}}" width="50">
                        <div class="mb-md-5 mt-md-4">

                            <h4 class="fw-bold mb-2 text-uppercase">Bienvenido a la intranet</h4>
                            <p class="text-dark-50 mb-3">Por favor ingrese su <b>Cédula</b> y <b>Contraseña</b></p>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-outline form-light mb-4">
                                    <input name="cedula" type="text" id="cedula" class="form-control form-control-lg" style="border-color: #aaa" autocomplete="off"/>
                                    <label class="form-label" for="cedula">Cédula</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input name="password" type="password" id="password" class="form-control form-control-lg" style="border-color: #aaa" />
                                    <label class="form-label" for="password">Contraseña</label>
                                    <button type="button" id="togglePassword" class="btn position-absolute" style="right: 20px; top: 62%; transform: translateY(-50%); background: none; border: none;">
                                        👁️
                                    </button>
                                </div>


                                {{-- <input type="button" id="acceder" class="btn btn-warning" value="Acceder"> --}}
                                <button id="acceder" class="btn btn-warning">Acceder</button>
                            </form>

                            <p class="small mb-5 pb-lg-2"><a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">¿Olvidaste tu contraseña?</a></p>
                            @include('partials.modalCambio')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function (e) {
            // Alternar entre 'password' y 'text'
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
        });
    </script>

@if(Session::has('fail'))
    <div style="font-size: 20px; width:350px;" class="toast align-items-center text-bg-danger bg-opacity-75 border-0 fade show fixed-bottom mb-5 mx-5" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <button type="button" class="btn-close btn-close-white ms-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar" _mstaria-label="76414"></button>
            <div class="toast-body">{{Session::get('fail')}}</div>
        </div>
    </div>
@endif

</section>
