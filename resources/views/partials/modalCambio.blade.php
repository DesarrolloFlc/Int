@if (session('error'))
    <script src="/intranet/js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de validacion',
            text: '{{ session('error') }}',
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
<style>
/* Ocultar flechas en Chrome, Edge, Safari, Opera */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Ocultar flechas en Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cambio de contraseña</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('validacion') }}" method="POST">
                <div class="modal-body">
                    @csrf

                    <div class="form-outline form-light mb-4">
                        <label class="form-label" for="cedula">Cédula</label>
                        <input name="cedula" type="number" id="cedula" class="form-control form-control-lg" style="border-color: #aaa"/>
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="rand">{{ $preguntas[0]->pregunta }}</label>
                        <input name={{ $preguntas[0]->name }} type="text" id="rand" class="form-control form-control-lg" style="border-color: #aaa" placeholder="DD / MM / YYYY"/>
                    </div>

                    <input type="text" name="name" value="{{ $preguntas[0]->name }}" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Validar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/date.js') }}"></script>
</div>
