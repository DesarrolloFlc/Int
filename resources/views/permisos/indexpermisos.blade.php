@extends('layouts.plantilla')

@section('title', 'Gestión de Horarios')

@section('content')

<div class="container mt-4">
    <h1 class="text-center">Gestión de Horarios y Permisos</h1>

    <div id="calendar"></div> <!-- Calendario FullCalendar -->

    <!-- Modal para solicitar permisos -->
    <div class="modal fade" id="modalPermiso" tabindex="-1" aria-labelledby="modalPermisoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPermisoLabel">Solicitar Permiso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('permisos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de fin (opcional)</label>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <textarea class="form-control" name="motivo" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- FullCalendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        selectable: true,
        select: function(info) {
            // Rellenar los campos del formulario con las fechas seleccionadas
            document.getElementById('fecha_inicio').value = info.startStr;
            document.getElementById('fecha_fin').value = info.endStr;
            // Abrir el modal
            $('#modalPermiso').modal('show');
        },
        events: '{{ route("permisos.index") }}' // Cargar permisos aprobados
    });
    calendar.render();
});
</script>
@endsection
