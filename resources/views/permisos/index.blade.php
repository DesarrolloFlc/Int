@extends('layouts.plantilla')

@section('title', 'Solicitud de Permisos')

@section('content')
    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <script src="/intranet/js/sweetalert2.min.js"></script>


    <link rel="stylesheet" href="{{ asset('/css/forms.css') }}">

    <main id="main" class="main">
        <section class="section dashboard">

            <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold">Solicitud de permisos</h2>
                {{-- Mensaje de éxito (si existe en sesión) --}}
                @if (session('success'))
                    <div class="alert alert-success" id="alert-success">
                        {{ session('success') }}
                    </div>

                    <script>
                        //duracion de la alerta 3 segundos
                        setTimeout(() => {
                            const alert = document.getElementById('alert-success');
                            if (alert) {
                                alert.style.display = 'none';
                            }
                        }, 3000);
                    </script>
                @endif
                {{-- Formulario de solicitud de permiso --}}
                <form class="formulario" action="{{ route('solicitud') }}" method="post">
                    @csrf
                    <div class="details personal m-4">
                        <span class="title fw-bold">Imformación sobre el permiso</span>
                        <div class="fields">
                            <div class="input-field">
                                <label>Fecha de diligenciamiento</label>
                                @php
                                    $fechaHora = \Carbon\Carbon::now('America/Bogota')->format('Y-m-d\TH:i');
                                @endphp
                                <input name="fecha_creacion" type="datetime-local" value="{{ $fechaHora }}"
                                    class="form-control" readonly wire: required>
                            </div>
                            <div class="input-field">
                                <label for="usuario_id">Nombre del empleado</label>
                                <input type="text" value="{{ Auth::user()->nombre }}" class="form-control" readonly>
                                <input type="hidden" name="usuario_id" value="{{ Auth::id() }}">

                            </div>
                            <div class="input-field">
                                <label for="roles">Cargo</label>
                                <input type="text" value="{{ $roles }}" class="form-control" readonly>

                            </div>
                            <div class="input-field">
                                <label for="unidad">Proceso al que pertenece</label>
                                <input type="text" value="{{ $unidad }}" class="form-control" readonly>
                                <input type="hidden" name="unidad_id" value="{{ Auth::user()->id_unidad }}">
                            </div>

                            <div class="input-field">
                                <label>Jefe inmediato</label>
                                <select name="jefe_id" class="form-control" required style=" border: 1px solid #012970;">
                                    <option value="">Seleccione su jefe inmediato</option>
                                    @foreach ($usuario as $jefe)
                                        <option value="{{ $jefe->id }}">{{ $jefe->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-field">
                                <label>Fecha de permiso</label>
                                <input id="fecha_permiso" name="fecha_permiso" type="date" required data-rol="{{ Auth::user()->id_rol ?? 0}}"
                                 min="{{ \Carbon\Carbon::now('America/Bogota')->format('Y-m-d') }}">
                            </div>
                            <div class="input-field">

                            </div>
                        </div>
                        <span class="title fw-bold">Tipo de permiso solicitado</span>
                        <div class="fields">
                            <div class="fields">
                                <div class="input-field">
                                    <label>Descripción detallada.</label>
                                    <textarea name="descripcion" required style="width: 925px "></textarea>
                                </div>
                            </div>

                            <div class="input-field">
                                <label " for="hora_salida">Hora de salida</label>
                                <input name="hora_salida" type="time" class="form-control" required>

                            </div>
                            <div class="input-field">
                                <label  for="hora_llegada">Hora de llegada</label>
                                <input name="hora_llegada" type="time" class="form-control" required>
                            </div>
                            <div class="input-field">
                                <label for="horas_dia">Total horas de permiso</label>
                                <input name="total_horas" type="text" readonly required>
                            </div>

                        </div>
                        <span class="title fw-bold">Tiempo de reposición</span>
                        <div class="fields">
                            <div class="fields">

                                <div class="input-field">
                                    <label for="fecha_desde">Fecha desde</label>
                                    <input name="fecha_desde" type="date" class="form-control" required
                                    min="{{ \Carbon\Carbon::now('America/Bogota')->format('Y-m-d') }}">

                                </div>
                                <div class="input-field">
                                    <label for="fecha_hasta">Fecha hasta</label>
                                    <input name="fecha_hasta" type="date" class="form-control" required onsubmit="">
                                </div>
                                <div class="input-field">
                                    <label for="horas_total">Horas por día</label>
                                    <input name="horas_dia" type="text" readonly required>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-10">
                                {{-- Boton de guardar --}}

                                <button class="sumbit mt-4 border rounded" type="submit">
                                    <span class="btnText text-light fw-bold">Guardar</span>
                                </button>
                            </div>
                            <div class="col">
                                {{-- Boton que redirigue a la vista de listados donde vera solo sus solicitudes --}}
                                <a href="{{ route('listado.permisos') }}"><button class="mt-4 border rounded"
                                        type="button" style="background-color: #3379FF">
                                        <span class="btnText text-light fw-bold">Mis solicitudes</span>
                                    </button></a>
                            </div>
                        </div>
                    </div>


            </div>
            </form>

            </form>
        </section>

    </main>
    <script>
    window.addEventListener('DOMContentLoaded', function () {
        console.log("JS cargado");

        const inputFecha = document.getElementById("fecha_permiso");
        if (!inputFecha) {
            console.warn("No se encontró el campo de fecha.");
            return;
        }

        const rolUsuario = parseInt(inputFecha.dataset.rol || "0");
        console.log("Rol detectado:", rolUsuario);

        if (rolUsuario !== 4) {
            inputFecha.addEventListener("change", function () {
                const fechaSeleccionada = new Date(this.value);
                const dia = fechaSeleccionada.getDay();

                console.log("Día seleccionado:", dia);

                if (dia === 5 ) {
                    alert("🚫 No puedes seleccionar el dia sábados.");
                    this.value = "";
                }
            });
        }
    });
</script>

    <script>
        //Funcion para calcular horas, cuanto tiempo ahi entre la hora de salida y la hora de llegada,cuantas horas debe hacer por dia segun las fechas que escoja para reporner dichas horas de permiso
function calcularHoras() {
    const horaSalida = document.querySelector('input[name="hora_salida"]').value;
    const horaLlegada = document.querySelector('input[name="hora_llegada"]').value;
    const inputHoras = document.querySelector('input[name="total_horas"]');
    const fechaDesde = document.querySelector('input[name="fecha_desde"]').value;
    const fechaHasta = document.querySelector('input[name="fecha_hasta"]').value;
    const totalHorasInput = document.querySelector('input[name="horas_dia"]');
    const rolUsuario = parseInt(document.getElementById("fecha_permiso")?.dataset.rol || "0");
    if (horaSalida && horaLlegada) {
        const [h1, m1] = horaSalida.split(":").map(Number);
        const [h2, m2] = horaLlegada.split(":").map(Number);

        const minutosSalida = h1 * 60 + m1;
        const minutosLlegada = h2 * 60 + m2;
        let diferencia = minutosLlegada - minutosSalida;
        if (diferencia < 0) {
            diferencia += 24 * 60; // Si pasa de la medianoche
        }

        // Calcular horas y minutos totales
        const horas = Math.floor(diferencia / 60);
        const minutos = diferencia % 60;

        // Mostrar total horas en formato HH:MM
        inputHoras.value = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}`;

        if (fechaDesde && fechaHasta) {
            const desde = new Date(fechaDesde);
            const hasta = new Date(fechaHasta);

            const diaDesde = desde.getDay(); // 0 = domingo, 6 = sábado
            const diaHasta = hasta.getDay();

// Validar si el usuario no es rol 4
if (rolUsuario !== 4) {
    if (diaDesde === 6 || diaDesde === 5) {
        Swal.fire({
            icon: 'warning',
            title: 'Día no permitido',
            text: "⚠️ La fecha de reposición debe iniciar un día entre semana.",
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#e26d2d'
        });
        limpiarCampos();
        return;
    }

    if (diaHasta === 6 || diaHasta === 5) {
        Swal.fire({
            icon: 'warning',
            title: 'Día no permitido',
            text: "⚠️ La fecha de reposición debe finalizar un día entre semana.",
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#e26d2d'
        });
        limpiarCampos();
        return;
    }
}
            // Contar días hábiles
            let diasHabiles = 0;
            const actual = new Date(desde);

            while (actual <= hasta) {
                const dia = actual.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado
                if (dia !== 6 && dia !== 5) { // lunes a viernes
                    diasHabiles++;
                }
                actual.setDate(actual.getDate() + 1);
            }

            if (diasHabiles > 0) {
                // Calcular minutos por día
                const minutosPorDia = Math.floor(diferencia / diasHabiles);
                const horasPorDia = Math.floor(minutosPorDia / 60);
                const minutosRestantes = minutosPorDia % 60;

                // Mostrar horas por día en formato HH:MM
                totalHorasInput.value = `${horasPorDia.toString().padStart(2, '0')}:${minutosRestantes.toString().padStart(2, '0')}`;
            } else {
                alert("⚠️ El rango seleccionado no contiene días hábiles.");
                totalHorasInput.value = "";
            }
        } else {
            totalHorasInput.value = "";
        }
    }
}

        // Ejecuta la función al cambiar cualquier campo relevante
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('input[name="hora_salida"]').addEventListener('change', calcularHoras);
            document.querySelector('input[name="hora_llegada"]').addEventListener('change', calcularHoras);
            document.querySelector('input[name="fecha_desde"]').addEventListener('change', calcularHoras);
            document.querySelector('input[name="fecha_hasta"]').addEventListener('change', calcularHoras);
        });

    </script>

    </body>

    </html>

@endsection
