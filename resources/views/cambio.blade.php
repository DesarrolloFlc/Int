@include('partials.head')

<section class="vh-100 gradient-custom" style="background-image: url({{ asset('/storage/fondo.png') }}); background-size: 100vw">   
    <div class="container py-2 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-light text-dark" style="height: 500px; background: linear-gradient(white, white) padding-box, linear-gradient(to top, #ff7b00, #0084FF) border-box; border-radius: 1rem; border: 5px solid transparent;">
                    <div class="card-body p-4 text-center">

                        <img src="{{asset('/storage/logos/logo.png')}}" width="50">   
                        <div class="mb-md-5 mt-md-4">

                            <h4 class="fw-bold mb-2 text-uppercase mt-3">Cambio de contraseña</h4>

                            <form action="{{ route('cambio', $cedula) }}" method="POST" class="mt-4 mb-4 p-3">
                                @csrf
                                <div class="form-outline form-light mb-4">
                                    <input name="p1" type="password" id="p1" class="form-control form-control-lg" style="border-color: #aaa"/>
                                    <label class="form-label" for="p1">Nueva contraseña</label><br>
                                    <span class="text-danger" id="ver1"></span>
                                </div>
    
                                <div class="form-outline form-white mb-4">
                                    <input name="p2" type="password" id="p2" class="form-control form-control-lg" style="border-color: #aaa"/>
                                    <label class="form-label" for="p2">Confirme su nueva contraseña</label><br>
                                    <span class="text-danger" id="ver2"></span>
                                </div>
                                
                                <input id="envio" type="submit" class="btn btn-primary" value="Actualizar Contraseña">
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/validacion.js') }}"></script> 

</section>
