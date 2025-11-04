@extends('layouts.plantilla')

@section('title', 'Cambio de horario')

@section('content')

    <link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('/css/horarios.css') }}">
    <main id="main" class="main no-anim" style="position:relative; z-index:0;">
        <div class="pagetitle">
            <div class="container mx-auto tab-pane shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold" style="color: #012970">Solcitud Cambio de Horario</h2>
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
                <form method="POST" action="{{ route('horarios.store') }}" id="formHorario">
                    @csrf
                    <div class="details personal m-4">
                        <div class="fields">
                            <div class="input-field">
                                <label for>Fecha de diligenciamiento</label>
                                @php
                                    $fechaHora = \Carbon\Carbon::now('America/Bogota')->format('Y-m-d\TH:i');
                                @endphp
                                <input name="fecha_creacion" type="datetime-local" value="{{ $fechaHora }}"
                                    class="form-control" readonly wire: required>
                            </div>
                            <div class="input-field">
                                <label for>Fecha a solicitar</label>
                                <input id="fecha_solicitar" name="fecha_solicitar" type="date" required
                                    data-rol="{{ Auth::user()->id_rol ?? 0 }}"
                                    min="{{ \Carbon\Carbon::now('America/Bogota')->format('Y-m-d') }}">
                            </div>
                            <div class="input-field">
                            </div>
                        </div>
                        <span class="title fw-bold">Informacion Sobre el Permiso</span>
                        <div class="fields">
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
                                <input type="hidden" name="unidad_id" value="{{ Auth::user()->id_unidad }}"
                                    id="unidadInput">
                            </div>

                            <div class="input-field">
                                <label for>Jefe inmediato</label>
                                <select name="jefe_id" class="form-control" required style=" border: 1px solid #012970;">
                                    <option value="">Seleccione su jefe inmediato</option>
                                    @foreach ($usuario as $jefe)
                                        <option value="{{ $jefe->id }}">{{ $jefe->nombre }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden">
                            </div>

                        </div>
                        <span class="title fw-bold">Motivo Cambio de Horario</span>
                        <div class="fields">
                            <div class="fields">
                                <div class="input-field">
                                    <label for>Descripcion detallada.</label><br>
                                    <textarea id="descripcion" name="descripcion" required maxlength="500" style="width: 925px"
                                        oninput="actualizaContador()"></textarea>
                                    <small><span id="contador">0</span>/500 caracteres</small>
                                </div>
                            </div>
                        </div>

                        <span class="title fw-bold">MARQUE SI SU HORARIO ES PARA UN DIA O INDEFINIDO</span>
                        <div class="input-field">
                            <select id="tipoHorario" name="tipo_horario" class="form-control" required
                                style="border:1px solid #012970;">
                                <option value="">Seleccione</option>
                                <option value="indefinido">Indefinido</option>
                                <option value="un_dia">Un Dia</option>
                            </select>
                        </div>
                        <div id="bloqueIndefinido" style="display:none; margin-top:12px;">

                            {{-- HORARIO ACTUAL --}}
                            <div class="horario-row">
                                <div class="horario-tag">HORARIO ACTUAL</div>
                                <table class="horario-table">
                                    <thead>
                                        <tr>
                                            <th style="width:35%;">DÍA</th>
                                            <th>HORA INGRESO</th>
                                            <th>HORA SALIDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $dias = $dias ?? ['LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO']; @endphp
                                        @foreach ($dias as $d)
                                            <tr>
                                                <td>{{ $d }}</td>
                                                {{-- Si tienes horas actuales desde backend, pon value="HH:MM" --}}
                                                <td><input type="time"
                                                        name="horario_actual[{{ strtolower($d) }}][ingreso]"></td>
                                                <td><input type="time"
                                                        name="horario_actual[{{ strtolower($d) }}][salida]"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- HORARIO SOLICITADO --}}
                            <div class="horario-row">
                                <div class="horario-tag">HORARIO SOLICITADO</div>
                                <table class="horario-table">
                                    <thead>
                                        <tr>
                                            <th style="width:35%;">día</th>
                                            <th>HORA INGRESO</th>
                                            <th>HORA SALIDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dias as $d)
                                            <tr>
                                                <td>{{ $d }}</td>
                                                <td><input type="time"
                                                        name="horario_solicitado[{{ strtolower($d) }}][ingreso]"></td>
                                                <td><input type="time"
                                                        name="horario_solicitado[{{ strtolower($d) }}][salida]"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="bloqueUnDia" style="display:none; margin-top:12px;">
                            <div class="input-field" style="max-width:340px; margin-bottom:10px">
                                <label for>Seleccione el dia</label>
                                <select id="diaUnico" class="form-control" style="border:1px solid #012970;">
                                    <option value="">Seleccione</option>
                                    <option value="lunes">LUNES</option>
                                    <option value="martes">MARTES</option>
                                    <option value="miercoles">MIERCOLES</option>
                                    <option value="jueves">JUEVES</option>
                                    <option value="viernes">VIERNES</option>
                                    <option value="sabado">SÁBADO</option>
                                </select>
                            </div>

                            {{-- HORARIO ACTUAL (solo 1 día) --}}
                            <div class="horario-row">
                                <div class="horario-tag">HORARIO ACTUAL</div>
                                <table class="horario-table">
                                    <thead>
                                        <tr>
                                            <th style="width:35%;">DÍA</th>
                                            <th>HORA INGRESO</th>
                                            <th>HORA SALIDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="diaActualLabel">--</td>
                                            <td><input type="time" id="horaIngresoActualUnDia"></td>
                                            <td><input type="time" id="horaSalidaActualUnDia"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- HORARIO SOLICITADO (solo 1 dÍa) --}}
                            <div class="horario-row">
                                <div class="horario-tag">HORARIO SOLICITADO</div>
                                <table class="horario-table">
                                    <thead>
                                        <tr>
                                            <th style="width:35%;">DÍA</th>
                                            <th>HORA INGRESO</th>
                                            <th>HORA SALIDA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="diaSolicitadoLabel">--</td>
                                            <td><input type="time" id="horaIngresoUnDia"></td>
                                            <td><input type="time" id="horaSalidaUnDia"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Guarda el dia elegido para el backend --}}
                            <input type="hidden" name="dia_unico" id="diaUnicoHidden" required>
                        </div>

                        <div class="row">
                            <div class="col-10">
                                <button class="sumbit mt-4 border rounded" type="submit" disabled>
                                    <span class="btnText text-light fw-bold">Guardar</span>
                                </button>
                            </div>
                            <div class="col">
                                <a href="{{ route('listado.horarios') }}">
                                    <button class="mt-4 border rounded" type="button" style="background-color:#3379FF">
                                        <span class="btnText text-light fw-bold">Mis solicitudes</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        function actualizaContador() {
            const textarea = document.getElementById('descripcion');
            const contador = document.getElementById('contador');
            const max = 500;

            if (textarea.value.length > max) {
                console.warn(`Se intentó ingresar más de ${max} caracteres.`);
                textarea.value = textarea.value.substring(0, max);
            }
            console.log(`Caracteres actuales: ${textarea.value.length}`);
            contador.textContent = textarea.value.length;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Si por alg�n motivo quitas el id, el querySelector de respaldo igual funciona
            const sel = document.getElementById('tipoHorario') || document.querySelector(
                'select[name="tipo_horario"]');
            const bloqueIndef = document.getElementById('bloqueIndefinido');
            if (!sel || !bloqueIndef) return;

            function toggleBloques() {
                bloqueIndef.style.display = (sel.value === 'indefinido') ? '' : 'none';
            }

            sel.addEventListener('change', toggleBloques);
            toggleBloques(); // estado inicial
        });

        document.addEventListener('DOMContentLoaded', () => {
            const selTipo = document.getElementById('tipoHorario') || document.querySelector(
                'select[name="tipo_horario"]');
            const bloqueIndef = document.getElementById('bloqueIndefinido');
            const bloqueUnDia = document.getElementById('bloqueUnDia');

            const diaUnico = document.getElementById('diaUnico');
            const diaActualLabel = document.getElementById('diaActualLabel');
            const diaSolicitadoLabel = document.getElementById('diaSolicitadoLabel');

            // ACTUAL (Un día)
            const horaIngresoActualUnDia = document.getElementById('horaIngresoActualUnDia');
            const horaSalidaActualUnDia = document.getElementById('horaSalidaActualUnDia');

            // SOLICITADO (Un día)
            const horaIngresoUnDia = document.getElementById('horaIngresoUnDia');
            const horaSalidaUnDia = document.getElementById('horaSalidaUnDia');

            const diaHidden = document.getElementById('diaUnicoHidden');

            const labelDia = {
                lunes: 'LUNES',
                martes: 'MARTES',
                miercoles: 'MIERCOLES',
                jueves: 'JUEVES',
                viernes: 'VIERNES',
                sabado: 'SÁBADO'
            };

            function toggleBloques() {
                const v = selTipo?.value || '';
                console.log('Tipo de horario seleccionado:', v);
                if (bloqueIndef) bloqueIndef.style.display = (v === 'indefinido') ? '' : 'none';
                if (bloqueUnDia) bloqueUnDia.style.display = (v === 'un_dia') ? '' : 'none';
            }

            function onDiaChange() {
                const d = diaUnico?.value || ''; // ej: 'martes'
                const lbl = labelDia[d] || '--';
                console.log('Día seleccionado:', d);
                if (diaActualLabel) diaActualLabel.textContent = lbl;
                if (diaSolicitadoLabel) diaSolicitadoLabel.textContent = lbl;
                if (diaHidden) diaHidden.value = d;

                // Asigna NOMBRES correctos cuando hay día elegido
                if (d) {
                     console.log(`Asignando name para horario_actual[${d}] y horario_solicitado[${d}]`);
                    // ACTUAL (A)
                    if (horaIngresoActualUnDia) horaIngresoActualUnDia.name = `horario_actual[${d}][ingreso]`;
                    if (horaSalidaActualUnDia) horaSalidaActualUnDia.name = `horario_actual[${d}][salida]`;

                    // SOLICITADO (C)
                    if (horaIngresoUnDia) horaIngresoUnDia.name = `horario_solicitado[${d}][ingreso]`;
                    if (horaSalidaUnDia) horaSalidaUnDia.name = `horario_solicitado[${d}][salida]`;
                } else {
                    console.warn('No se seleccionó día. Eliminando names de inputs.');
                    // Sin día => no enviar nada
                    [horaIngresoActualUnDia, horaSalidaActualUnDia, horaIngresoUnDia, horaSalidaUnDia]
                    .filter(Boolean)
                        .forEach(i => i.removeAttribute('name'));
                }
            }

            selTipo?.addEventListener('change', toggleBloques);
            diaUnico?.addEventListener('change', onDiaChange);

            // Estado inicial
            toggleBloques();
            onDiaChange();
        });

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formHorario');
            if (!form) return;

            const submitBtn = form.querySelector('button[type="submit"]');
            const selTipo = document.getElementById('tipoHorario');
            const bloqueInd = document.getElementById('bloqueIndefinido');
            const bloque1D = document.getElementById('bloqueUnDia');

            const diaSelect = document.getElementById('diaUnico');
            const diaHidden = document.getElementById('diaUnicoHidden'); // ya lo usas para guardar el día

            // helpers
            const setReqIn = (container, on) => {
                if (!container) return;
                container.querySelectorAll('input[type="time"]').forEach(i => i.required = !!on);
            };
            const updateRequirements = () => {
                const modo = selTipo?.value || '';
                if (modo === 'indefinido') {
                    setReqIn(bloqueInd, true);
                    setReqIn(bloque1D, false);
                    if (diaHidden) diaHidden.required = false;
                } else if (modo === 'un_dia') {
                    setReqIn(bloqueInd, false);
                    // día es obligatorio en este modo
                    if (diaHidden) diaHidden.required = true;
                    const hasDay = !!(diaHidden?.value);
                    // Las horas de un día s�lo son obligatorias si ya eligieron el día
                    if (bloque1D) {
                        bloque1D.querySelectorAll('input[type="time"]').forEach(i => i.required = hasDay);
                    }
                } else {
                    // sin selecci�n
                    setReqIn(bloqueInd, false);
                    setReqIn(bloque1D, false);
                    if (diaHidden) diaHidden.required = false;
                }
            };
            const toggleSubmit = () => {
                // deshabilita si el form no es v�lido
                submitBtn.disabled = !form.checkValidity();
            };

            // Reaccionar a cambios en todo el form
            ['input', 'change'].forEach(ev => {
                form.addEventListener(ev, () => {
                    updateRequirements();
                    toggleSubmit();
                });
            });

            // Si ya tienes otros scripts que cambian nombres/valores (onDiaChange), este bloque se adapta
            // Estado inicial
            updateRequirements();
            toggleSubmit();

            // Evita env�o si alguien fuerza el submit (sin mostrar alertas)
            form.addEventListener('submit', (e) => {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    // opcional: enfocar primer inv�lido sin alertas
                    const firstInvalid = form.querySelector(':invalid');
                      console.error('Formulario inválido. Campo fallando:', firstInvalid?.name || 'desconocido');
                    firstInvalid?.focus();
                } else {
        console.log('Formulario enviado correctamente.');
    }
            });
        });
    </script>

@endsection
