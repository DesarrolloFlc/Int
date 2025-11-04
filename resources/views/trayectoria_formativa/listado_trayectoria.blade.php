@extends('layouts.plantilla')

@section('title', 'Calificacion trayectoria')

@section('content')
    <main id="main" class="main">
        {{-- CSRF meta (necesario para fetch POST en web.php) --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/trayectoriaa.css') }}?v={{ time() }}">
        @php
            // URL absoluta a la ruta (si no existe el name, fallback a /trayectoria/calificar/guardar)
            $postURL = \Illuminate\Support\Facades\Route::has('trayectoria.calificar.guardar')
                ? route('trayectoria.calificar.guardar')
                : url('/trayectoria/calificar/guardar');
        @endphp
        <script>
            const POST_URL = @json($postURL);
        </script>
        <div class="pagetitle">
            <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
                <h2 class="head fw-bold tf-title">Califica Trayectoria Formativa</h2>
                <!-- Filtros -->
                <form class="tf-filtros" method="GET" action="{{ url()->current() }}">
                    <div class="tf-field">
                        <label for="tema_reforzado" class="tf-label">Seleccione el tema reforzado</label>
                        @php $t = request('tema_reforzado'); @endphp
                        <select id="tema_reforzado" name="tema_reforzado" class="tf-input">
                            <option value="">Seleccione</option>
                            <option {{ $t === 'Productividad' ? 'selected' : '' }}>Productividad</option>
                            <option {{ $t === 'Efectividad' ? 'selected' : '' }}>Efectividad</option>
                            <option {{ $t === 'Modelo Gana' ? 'selected' : '' }}>Modelo Gana</option>
                            <option {{ $t === 'Gestión de Tiempos' ? 'selected' : '' }}>Gestión de Tiempos</option>
                            <option {{ $t === 'Cierre' ? 'selected' : '' }}>Cierre</option>
                            <option {{ $t === 'Efectividad en cumplimiento de promesas' ? 'selected' : '' }}>
                                Efectividad en cumplimiento de promesas
                            </option>
                            <option {{ $t === 'Puesto de trabajo' ? 'selected' : '' }}>Puesto de trabajo</option>
                            <option {{ $t === 'Indicadores generales' ? 'selected' : '' }}>Indicadores generales</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label for="fecha_permiso" class="tf-label">Fecha</label>
                        <input id="fecha_permiso" name="fecha_permiso" type="date" class="tf-input"
                            value="{{ request('fecha_permiso') }}">
                    </div>

                    <div class="tf-actions">
                        <button type="submit" class="btn-buscar">Buscar</button>
                        <a href="{{ url()->current() }}?per_page={{ request('per_page', 10) }}"
                            class="btn-limpiar">Limpiar</a>
                    </div>
                </form>
                <!-- Tabla -->
                <div class="panel-body table-responsive custom-scroll mt-3">
                    <table class="tf-table" id="datos" style="border-radius: 15px">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tema</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trayectorias as $t)
                                @php
                                    $fmt = function ($v, $f) {
                                        if (empty($v)) {
                                            return '';
                                        }
                                        try {
                                            return \Carbon\Carbon::parse($v)->format($f);
                                        } catch (\Throwable $e) {
                                            return (string) $v;
                                        }
                                    };
                                    $id =
                                        data_get($t, 'id') ??
                                        (data_get($t, 'idPrimaria') ?? (data_get($t, 'id_trayectoria') ?? ''));
                                    $tema =
                                        data_get($t, 'tema') ??
                                        (data_get($t, 'temaÍndice') ?? (data_get($t, 'tema_indice') ?? ''));
                                    $desc = data_get($t, 'descripcion') ?? '';
                                    $fechaRaw =
                                        data_get($t, 'fecha_creacion') ??
                                        (data_get($t, 'fechaÍndice') ?? data_get($t, 'fecha_indice'));
                                    $fecha = $fmt($fechaRaw, 'Y-m-d');
                                @endphp
                                <tr>
                                    <td>{{ $id ?: '—' }}</td>
                                    <td>{{ $tema ?: '—' }}</td>
                                    <td data-label="Descripción">
                                        <span class="td-desc">{{ $desc ?: '—' }}</span>
                                    </td>

                                    <td>{{ $fecha ?: '—' }}</td>
                                    <td>
                                        <a href="{{ route('trayectoria.calificar.vista', ['id' => (int) $id, 'paso' => 1]) }}"
                                            class="btn-calificarprueba">
                                            Calificar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Sin Registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @php
                        // Valores seguros (si no vienen en $pager)
                        $page = max(1, (int) ($pager['page'] ?? 1));
                        $pages = max(1, (int) ($pager['pages'] ?? 1));
                        $per = (int) request('per_page', $pager['per_page'] ?? 5);

                        // Generador de URLs preservando el query
                        $mk = function (int $p) use ($per) {
                            return request()->fullUrlWithQuery(['page' => $p, 'per_page' => $per]);
                        };
                        $hasPrev = $page > 1;
                        $hasNext = $page < $pages;
                        $firstUrl = $pager['first_url'] ?? $mk(1);
                        $prevUrl = $pager['prev_url'] ?? ($hasPrev ? $mk($page - 1) : $mk(1));
                        $nextUrl = $pager['next_url'] ?? ($hasNext ? $mk($page + 1) : $mk($pages));
                        $lastUrl = $pager['last_url'] ?? $mk($pages);
                        $links = $pager['page_links'] ?? [];
                        if (empty($links)) {
                            $start = max(1, $page - 2);
                            $end = min($pages, $page + 2);
                            for ($p = $start; $p <= $end; $p++) {
                                $links[$p] = $mk($p);
                            }
                        }
                    @endphp
                    <nav class="tf-pagination tf-center" aria-label="Paginación">
                        <div class="tf-group-left">
                            <a href="{{ $firstUrl }}" class="tf-btn {{ $hasPrev ? '' : 'is-disabled' }}"
                                aria-label="Primera">«</a>
                            <a href="{{ $prevUrl }}" class="tf-btn {{ $hasPrev ? '' : 'is-disabled' }}"
                                aria-label="Anterior">‹</a>

                            @foreach ($links as $num => $url)
                                <a href="{{ $url }}"
                                    class="tf-btn {{ (int) $num === $page ? 'is-active' : '' }}">{{ $num }}</a>
                            @endforeach
                        </div>
                        <div class="tf-group-right">
                            <a href="{{ $nextUrl }}" class="tf-btn {{ $hasNext ? '' : 'is-disabled' }}"
                                aria-label="Siguiente">›</a>
                            <a href="{{ $lastUrl }}" class="tf-btn {{ $hasNext ? '' : 'is-disabled' }}"
                                aria-label="Última">»</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function() {
            console.log('[TF] script cargado, POST_URL=', POST_URL);

            // Helpers <dialog> (fallback si no hay soporte nativo)
            function openDialog(id) {
                const d = document.getElementById(id);
                if (!d) return console.warn('[TF] dialog no encontrado', id);
                if (typeof d.showModal === 'function') d.showModal();
                else {
                    d.setAttribute('open', 'open');
                    d.style.display = 'block';
                }
            }

            function closeDialog(el) {
                const d = el.closest('dialog');
                if (!d) return;
                if (typeof d.close === 'function') d.close();
                else {
                    d.removeAttribute('open');
                    d.style.display = 'none';
                }
            }
            let registroId = null;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Abre P1 desde "Calificar"
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-calificar');
                if (btn) {
                    registroId = parseInt(btn.dataset.id || '0', 10) || null;
                    console.log('[TF] abrir modal 1, registroId=', registroId);
                    openDialog('modalPreg1');
                }
            });
            // Cerrar modales
            document.addEventListener('click', (e) => {
                if (e.target.matches('[data-close]')) {
                    closeDialog(e.target);
                }
            });
            // Guardar vía fetch
            async function guardarCalificacion({
                id,
                numero,
                pregunta,
                calificacion
            }) {
                try {
                    const resp = await fetch(POST_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf // válido si la ruta está en web.php
                        },
                        credentials: 'same-origin', // envía cookie de sesión
                        body: JSON.stringify({
                            id,
                            numero,
                            pregunta,
                            calificacion
                        })
                    });

                    if (!resp.ok) {
                        const txt = await resp.text();
                        alert('Error al guardar (' + resp.status + '): ' + txt.slice(0, 200));
                        console.error('[TF] !ok', resp.status, txt);
                        return {
                            ok: false
                        };
                    }

                    let data = {};
                    try {
                        data = await resp.json();
                    } catch (e) {}
                    if (!data?.success) {
                        alert(data?.message || 'No se pudo guardar');
                        return {
                            ok: false
                        };
                    }

                    return {
                        ok: true,
                        updated: !!data.updated
                    };
                } catch (err) {
                    console.error('[TF] error fetch', err);
                    alert('Error de red al guardar');
                    return {
                        ok: false
                    };
                }
            }
            // Click en estrellas
            document.addEventListener('click', async (e) => {
                if (!e.target.classList.contains('star')) return;

                const modal = e.target.closest('dialog');
                if (!modal) return;

                const m = (modal.id || '').match(/modalPreg(\d+)/);
                const numero = m ? parseInt(m[1], 10) : 0;

                const pregunta = (modal.querySelector('.texto-preg')?.textContent || '').trim();
                const calificacion = parseInt(e.target.value || '0', 10);

                if (!registroId || !numero) {
                    console.warn('[TF] Falta registroId/numero');
                    return;
                }

                const res = await guardarCalificacion({
                    id: registroId,
                    numero,
                    pregunta,
                    calificacion
                });
                if (!res.ok) return;

                // cerrar modal actual
                closeDialog(modal);

                // >>> aquí estaba el problema: no llamabas la alerta para la 2da pregunta
                if (numero === 1) {
                    openDialog('modalPreg2');
                } else if (numero === 2) {
                    // usa la función global que definiste en el segundo <script>
                    if (typeof showCongrats === 'function') {
                        showCongrats();
                    } else {
                        // fallback por si la función no está cargada
                        openDialog('modalCongrats');
                    }
                }
            });

        })();

        function openDialog(id) {
            const d = document.getElementById(id);
            if (!d) return;
            if (typeof d.showModal === 'function') d.showModal();
            else {
                d.setAttribute('open', 'open');
                d.style.display = 'block';
            }
        }

        function closeDialog(el) {
            const d = el.closest('dialog');
            if (!d) return;
            if (typeof d.close === 'function') d.close();
            else {
                d.removeAttribute('open');
                d.style.display = 'none';
            }
        }

        // Timer global para poder cancelarlo si el usuario cierra manualmente
        let congratsTimer = null;

        function showCongrats() {
            const dlg = document.getElementById('modalCongrats');
            const star = dlg?.querySelector('.star-anim');

            // Reinicia animación de la estrella
            if (star) {
                star.style.animation = 'none';
                void star.offsetWidth; // reflow
                star.style.animation = '';
            }

            // Limpia timer previo si existiera
            if (congratsTimer) {
                clearTimeout(congratsTimer);
                congratsTimer = null;
            }

            openDialog('modalCongrats');

            // Autocierre en 6s con fade opcional
            congratsTimer = setTimeout(() => {
                dlg.classList.add('will-close'); // activa animación de salida
                setTimeout(() => {
                    if (dlg.open) dlg.close(); // cierra realmente
                    dlg.classList.remove('will-close'); // limpia clase
                }, 400); // duración del fade (debe coincidir con el CSS)
                congratsTimer = null;
            }, 6000);
        }
        // Si el usuario pulsa "OK", cancelar el timer y cerrar ya
        document.addEventListener('click', (e) => {
            if (e.target.matches('#modalCongrats [data-close]')) {
                if (congratsTimer) {
                    clearTimeout(congratsTimer);
                    congratsTimer = null;
                }
                closeDialog(e.target);
            }
        });
        // Ejemplo integrado en tu flujo:
        async function despuesDeGuardar(numero) {
            if (numero === 1) {
                openDialog('modalPreg2');
            } else if (numero === 2) {
                showCongrats();
            }
        }
    </script>
@endsection
