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
                <form id="formPermiso" class="formulario" action="{{ route('solicitud') }}" method="post">
                      @csrf

                        {{-- Placeholders vacíos: SIEMPRE viajan al backend --}}
                        <input type="hidden" name="horas_dia_1" value="">
                        <input type="hidden" name="horas_dia_2" value="">
                        <input type="hidden" name="horas_dia_3" value="">
                        <input type="hidden" name="horas_dia_4" value="">
                        <input type="hidden" name="horas_dia_5" value="">
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
                                <input type="hidden" name="unidad_id" value="{{ Auth::user()->id_unidad }}"  id="unidadInput">
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
                                <input type="hidden" name="horas_dia" id="total_horas_repos" value="">

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
                                   {{-- <div class="input-field">
                                    <label for="horas_dia">Horas por dia</label>
                                    <input name="horas_dia" type="text" class="form-control" required onsubmit="">
                                </div> --}}
                                <div class="input-field">
                                <label for="total_horas">Total horas del permiso</label>
                                <input type="text"  id="total_horas"
                                        class="form-control" inputmode="numeric"
                                        placeholder="00:00" pattern="^\d{1,3}:[0-5]\d$"
                                        readonly required>
                                </div>

                                <div class="input-field">
                                <label for="horas-por-dia">Horas por día</label>
                                <div id="horas-por-dia" class="grid gap-2"></div>
                                <!-- opcional: total -->
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

// Lee rol y unidad (ajusta los selectores a tu HTML)
const rolUsuario = parseInt(inputFecha.dataset.rol || "0", 10);
const unidad = parseInt(document.getElementById("unidadInput").value || "0", 10);

console.log("Rol detectado:", rolUsuario);
console.log("Unidad detectada:", unidad);

// Función: convierte 'YYYY-MM-DD' a Date en zona local
function parseLocalDate(yyyyMMdd) {
  if (!yyyyMMdd) return null;
  const [y, m, d] = yyyyMMdd.split("-").map(Number);
  if (!y || !m || !d) return null;
  return new Date(y, m - 1, d); // <-- Local time, no UTC
}

// Listener único para evitar duplicados
function onFechaChange(e) {
  const fechaSeleccionada = parseLocalDate(e.target.value);
  if (!fechaSeleccionada) return;

  const dia = fechaSeleccionada.getDay(); // 0=Dom, 1=Lun, ..., 6=Sáb
  console.log("Día seleccionado:", dia);

  if (dia === 6) { // sábado
    alert("🚫 No puedes seleccionar el día sábado.");
    e.target.value = "";
  }
}

// Aplica la restricción solo si rol ≠ 4 y unidad ≠ 7
if (rolUsuario !== 4 && unidad !== 7) {
  inputFecha.removeEventListener("change", onFechaChange);
  inputFecha.addEventListener("change", onFechaChange);
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
    const totalHorasInput = document.getElementById('total_horas_repos');
    const rolUsuario = parseInt(document.getElementById("fecha_permiso")?.dataset.rol || "0");
    const unidad = parseInt(document.getElementById("fecha_permiso")?.dataset.rol || "0");

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
if (rolUsuario !== 4 && unidad !== 7) {
    if (diaDesde === 6) {
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

    if (diaHasta === 6 ) {
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
                if (dia !== 6) { // lunes a viernes
                    diasHabiles++;
                }
                actual.setDate(actual.getDate() + 1);
            }

            if (diasHabiles > 0) {
                // Calcular minutos por día
                 const minutosPorDia = Math.floor(diferencia / diasHabiles);
                   const LIMITE_MINUTOS = 8 * 60;
            if (minutosPorDia > LIMITE_MINUTOS) {
                alert("⛔ No puede exceder 8:00 horas por día.");
                totalHorasInput.value = "";
                return; // evita seguir y mostrar un valor inválido
            }
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

(function() {
  const MAX_DIAS = 5;
  const MAX_MIN_DIA = 8 * 60; // 8:00
  const MS_DIA = 86400000;

  const inputDesde = document.querySelector('input[name="fecha_desde"]');
  const inputHasta = document.querySelector('input[name="fecha_hasta"]');
  const contenedor = document.getElementById('horas-por-dia');
  const totalInput = document.getElementById('total_horas') || document.getElementById('horas_total');

  // ===== Helpers =====
  const parseYMD = (ymd) => { const [y,m,d]=ymd.split('-').map(Number); return new Date(y, m-1, d); };
  const fmtYMD   = (d) => [d.getFullYear(), String(d.getMonth()+1).padStart(2,'0'), String(d.getDate()).padStart(2,'0')].join('-');
  const isSunday = (d) => d.getDay() === 0;
  const notify   = (msg) => (window.Swal?.fire) ? Swal.fire({icon:'warning',title:'Aviso',text:msg}) : alert(msg);

  // fecha hasta máxima para tener N días válidos (sin domingos), inclusiva
  function endDateForValidDays(start, n) {
    const d = new Date(start); let valid = 0; let current = new Date(d);
    while (valid < n) { if (!isSunday(current)) valid++; if (valid < n) current.setDate(current.getDate()+1); }
    return current;
  }
  function countValidDays(d1, d2){
    let c=0, cur=new Date(d1);
    while(cur<=d2){ if(!isSunday(cur)) c++; cur.setDate(cur.getDate()+1); }
    return c;
  }
  function validarNoDomingo(campo){
    if (!campo?.value) return true;
    const d = parseYMD(campo.value);
    if (isSunday(d)) { campo.setCustomValidity('No se permiten domingos.'); campo.reportValidity(); campo.value=''; return false; }
    campo.setCustomValidity(''); return true;
  }
  function aplicarLimitesHasta(){
    if (!inputDesde?.value || !inputHasta) return;
    if (!validarNoDomingo(inputDesde)) return;
    inputHasta.min = inputDesde.value;
    const d1 = parseYMD(inputDesde.value);
    const maxDate = endDateForValidDays(d1, MAX_DIAS);
    inputHasta.max = fmtYMD(maxDate);
    if (inputHasta.value && inputHasta.value > inputHasta.max) inputHasta.value = inputHasta.max;
  }

  function minutesToHHMM(mins){ const h=Math.floor(mins/60), m=mins%60; return String(h).padStart(2,'0')+':'+String(m).padStart(2,'0'); }
  function parseToMinutes(raw){
    const v=(raw||'').trim(); if(!v) return NaN;
    const m=v.match(/^(\d{1,3}):([0-5]\d)$/); if(m) return (+m[1])*60+(+m[2]);
    const n=parseFloat(v.replace(',','.')); if(!isNaN(n)) return Math.round(n*60);
    return NaN;
  }
  function updateTotal(){
    if (!totalInput) return;
    let totalMin = 0;
    contenedor.querySelectorAll('.horas-dia-item').forEach(inp => {
      const mins = parseToMinutes(inp.value);
      if (!isNaN(mins)) totalMin += mins;
    });
    totalInput.value = minutesToHHMM(totalMin);
  }

  // ===== Aquí la función pedida (slot 1..5) =====
  function generarInputs() {
    if (!contenedor) { console.error('No se encontró el contenedor #horas-por-dia'); return; }

    contenedor.innerHTML = '';
    if (totalInput) totalInput.value = '';

    const vDesde = inputDesde?.value, vHasta = inputHasta?.value;
    if (!vDesde || !vHasta) return;

    if (!validarNoDomingo(inputDesde) || !validarNoDomingo(inputHasta)) return;

    const d1 = parseYMD(vDesde), d2 = parseYMD(vHasta);
    if (isNaN(d1) || isNaN(d2)) { console.error('Fechas inválidas'); return; }
    if (d2 < d1) { contenedor.innerHTML = '<div class="text-danger">"Fecha hasta" no puede ser menor a "Fecha desde".</div>'; return; }

    const validos = countValidDays(d1, d2);
    if (validos === 0) { contenedor.innerHTML = '<div class="text-warning">El rango no contiene días válidos (no se cuentan los domingos).</div>'; return; }
    if (validos > MAX_DIAS) { contenedor.innerHTML = `<div class="text-warning">Máximo ${MAX_DIAS} días válidos (excluyendo domingos).</div>`; return; }

    let slot = 1;
    const cur = new Date(d1);
    while (cur <= d2 && slot <= MAX_DIAS) {
      if (!isSunday(cur)) {
        const etiqueta = cur.toLocaleDateString('es-CO', { weekday: 'short', year: 'numeric', month: '2-digit', day: '2-digit' });
        const wrapper = document.createElement('div');
        wrapper.className = 'mt-2';
        wrapper.innerHTML = `
          <label class="form-label">${etiqueta}</label>
          <input name="horas_dia_${slot}" type="text"
                 inputmode="numeric"
                 placeholder="00:00"
                 class="form-control horas-dia-item"
                 pattern="^(?:\\d{1,2}:[0-5]\\d|\\d{1,2}(?:[\\.,]\\d{1,2})?)$"
                 title="Use HH:MM o decimal (p.ej. 7.5)">
        `;
        contenedor.appendChild(wrapper);
        slot++;
      }
      cur.setDate(cur.getDate()+1);
    }

    // Prefill desde old() (Blade)
    @if (old('horas_dia_1') || old('horas_dia_2') || old('horas_dia_3') || old('horas_dia_4') || old('horas_dia_5'))
      const oldSlots = {
        1: @json(old('horas_dia_1')),
        2: @json(old('horas_dia_2')),
        3: @json(old('horas_dia_3')),
        4: @json(old('horas_dia_4')),
        5: @json(old('horas_dia_5')),
      };
      for (let i=1;i<=MAX_DIAS;i++){
        const el = contenedor.querySelector(`input[name="horas_dia_${i}"]`);
        if (el && oldSlots[i] != null) el.value = oldSlots[i];
      }
    @endif

    updateTotal();
  }

  // ===== Listeners =====
  contenedor?.addEventListener('input', (e) => {
    if (!e.target.classList.contains('horas-dia-item')) return;
    const mins = parseToMinutes(e.target.value);
    if (!isNaN(mins) && mins > MAX_MIN_DIA) {
      // una alerta por "sesión" de campo
      if (!e.target.dataset.alerted) {
        notify('No puedes registrar más de 8:00 horas por día');
        e.target.dataset.alerted = '1';
      }
      e.target.value = '08:00';
    } else {
      delete e.target.dataset.alerted;
    }
    updateTotal();
  });

  contenedor?.addEventListener('blur', (e) => {
    if (!e.target.classList.contains('horas-dia-item')) return;
    let mins = parseToMinutes(e.target.value);
    if (isNaN(mins)) {
      e.target.setCustomValidity('Use HH:MM o decimal (p. ej. 7.5)');
      e.target.reportValidity();
      return;
    }
    mins = Math.max(0, Math.min(mins, MAX_MIN_DIA)); // clamp 0..480
    e.target.setCustomValidity('');
    e.target.value = minutesToHHMM(mins);
    updateTotal();
  }, true);

  inputDesde?.addEventListener('change', () => { aplicarLimitesHasta(); generarInputs(); });
  inputHasta?.addEventListener('change', () => { if (!validarNoDomingo(inputHasta)) return; generarInputs(); });

  // Precarga inicial
  if (inputDesde?.value) aplicarLimitesHasta();
  if (inputDesde?.value && inputHasta?.value) {
    generarInputs();
    updateTotal();
  }

  // Exponer si lo necesitas en otro script
  window.generarInputs = generarInputs;

})();

document.addEventListener('DOMContentLoaded', () => {
  const $ = s => document.querySelector(s);
  const cont = $('#horas-por-dia');               // contenedor de los inputs por día
  const totalMain  = $('#total_horas');           // el que se guarda
  const totalRepos = $('#total_horas_repos');     // solo visual

  const inpSalida = $('input[name="hora_salida"]');
  const inpLlegada= $('input[name="hora_llegada"]');
  const form      = $('#formPermiso');

  const minutesToHHMM = mins => {
    const h = Math.floor(mins/60), m = mins%60;
    return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
  };
  const parseToMinutes = raw => {
    const v=(raw||'').trim(); if(!v) return NaN;
    const m=v.match(/^(\d{1,3}):([0-5]\d)$/); if(m) return (+m[1])*60+(+m[2]);
    const n=parseFloat(v.replace(',','.')); if(!isNaN(n)) return Math.round(n*60);
    return NaN;
  };

  // 1) Total del permiso (entre salida y llegada)
  function calcTotalPermiso() {
    if (!inpSalida?.value || !inpLlegada?.value) return;
    const [h1,m1] = inpSalida.value.split(':').map(Number);
    const [h2,m2] = inpLlegada.value.split(':').map(Number);
    let diff = (h2*60 + m2) - (h1*60 + m1);
    if (diff < 0) diff += 24*60; // cruza medianoche
    if (totalMain) totalMain.value = minutesToHHMM(diff);
  }

  // 2) Suma de horas por día (visual)
  function calcTotalRepos() {
    if (!cont || !totalRepos) return;
    let totalMin = 0;
    cont.querySelectorAll('.horas-dia-item').forEach(inp => {
      const m = parseToMinutes(inp.value);
      if (!isNaN(m)) totalMin += m;
    });
    totalRepos.value = minutesToHHMM(totalMin);
  }

  // 3) Validar que coincidan al enviar
  form?.addEventListener('submit', (e) => {
    const mMain  = parseToMinutes(totalMain?.value);
    const mRepos = parseToMinutes(totalRepos?.value);
    // si ambos existen, deben coincidir
    if (!isNaN(mMain) && !isNaN(mRepos) && mMain !== mRepos) {
      e.preventDefault();
      if (window.Swal?.fire) {
        Swal.fire({icon:'warning', title:'Totales no coinciden',
                   text:`El total de reposición (${totalRepos.value}) debe igualar el total del permiso (${totalMain.value}).`});
      } else {
        alert(`El total de reposición (${totalRepos.value}) debe igualar el total del permiso (${totalMain.value}).`);
      }
    }
  });

  // Eventos
  inpSalida?.addEventListener('change', calcTotalPermiso);
  inpLlegada?.addEventListener('change', calcTotalPermiso);
  cont?.addEventListener('input', (e) => {
    if (!e.target.classList.contains('horas-dia-item')) return;
    calcTotalRepos();
  });
  // inicial
  calcTotalPermiso();
  calcTotalRepos();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formPermiso');

  // --- helpers ---
  const parseToMinutes = (raw) => {
    const v = String(raw || '').trim();
    if (!v) return 0;
    const m = v.match(/^(\d{1,3}):([0-5]\d)$/);
    if (m) return (+m[1]) * 60 + (+m[2]);
    const n = parseFloat(v.replace(',', '.'));
    return isNaN(n) ? 0 : Math.round(n * 60);
  };
  const minutesToHHMM = (mins) => {
    const h = Math.floor(mins / 60), m = mins % 60;
    return String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0');
  };

  const getTotalPermisoMins = () => {
    const el = document.querySelector('input[name="total_horas"]'); // tu total del permiso
    return parseToMinutes(el?.value);
  };

  const getSumaHorasPorDiaMins = () => {
    // suma lo que el usuario escribió en los inputs dinámicos
    let total = 0;
    // si tus inputs tienen la clase .horas-dia-item (como en tu script), úsala:
    const inputs = document.querySelectorAll('.horas-dia-item');

    // si prefieres por nombre: input[name^="horas_dia_"]
    // const inputs = document.querySelectorAll('input[name^="horas_dia_"]');

    inputs.forEach(inp => total += parseToMinutes(inp.value));
    return total;
  };

  // Validar al enviar
  form?.addEventListener('submit', (e) => {
    const permiso = getTotalPermisoMins();
    const repos   = getSumaHorasPorDiaMins();

    // Solo validamos si existen ambos valores
    if (!isNaN(permiso) && !isNaN(repos) && permiso !== repos) {
      e.preventDefault();
      const msg = `El total de reposición (${minutesToHHMM(repos)}) debe igualar el total del permiso (${minutesToHHMM(permiso)}).`;
      if (window.Swal?.fire) {
        Swal.fire({ icon: 'warning', title: 'Totales no coinciden', text: msg, confirmButtonColor: '#e26d2d' });
      } else {
        alert(msg);
      }
    }
  });

  // (Opcional) feedback en vivo cada vez que el usuario escriba horas por día
  document.getElementById('horas-por-dia')?.addEventListener('input', (e) => {
    if (!e.target.classList.contains('horas-dia-item')) return;
    // acá podrías mostrar un total parcial si tienes un input “total reposición” visual
    const totalRepos = document.getElementById('total_horas_repos');
    if (totalRepos) totalRepos.value = minutesToHHMM(getSumaHorasPorDiaMins());
  });
});
</script>

    </body>

    </html>

@endsection
