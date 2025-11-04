@extends('layouts.plantilla')

@section('title', 'Calificación trayectoria')

@section('content')
    <main id="main" class="main">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/calificarTrayectoria.css') }}?v={{ time() }}">

        @php
            $postURL = \Illuminate\Support\Facades\Route::has('trayectoria.calificar.guardar')
                ? route('trayectoria.calificar.guardar')
                : url('/trayectoria/calificar/guardar');
        @endphp
        <script>
            const POST_URL = @json($postURL);
        </script>

        <div class="pagetitle">

            <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
                <div class="volver-wrapper hidden">
                    @if (Route::has('trayectoria.lista'))
                        <a href="{{ route('trayectoria.lista') }}" class="btn volver-btn" aria-label="Salir">
                            <svg class="icon-back" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19 8 12 15 5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="volver-text">Salir</span>
                        </a>
                    @else
                        <button type="button" class="btn volver-btn" onclick="history.back()" aria-label="Salir">
                            <svg class="icon-back" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19 8 12 15 5" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="volver-text">Salir</span>
                        </button>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-center mb-3">
                </div>
                <div id="tf-wizard" class="tf-card"
                    style="border-radius:14px;overflow:hidden;max-width:950px;margin:0 auto;">
                    @php
                        $valorPregunta1 = isset($valorPregunta1) ? (int) $valorPregunta1 : null;
                        $opciones = [[0, 1], [2, 3], [4, 5]];
                    @endphp
                    @php
                        $valorPregunta1 = isset($valorPregunta1) ? (int) $valorPregunta1 : null;
                    @endphp
                    <section id="paso1" data-numero="1">
                        <div class="preg-card">
                            <h2 class="head fw-bold tf-title m-0">Califica Trayectoria Formativa</h2>
                            <div class="contenedor-central">
                                <div class="texto-preg">
                                    ¿Qué tan satisfecho/a estás con la formación recibida?
                                </div>

                                <div class="rating-grid">
                                    @for ($i = 0; $i <= 5; $i++)
                                        <button type="button"
                                            class="rating__btn {{ $valorPregunta1 === $i ? 'is-selected' : '' }}"
                                            data-value="{{ $i }}" aria-label="{{ $i }} estrellas">
                                            @for ($j = 1; $j <= 5; $j++)
                                                <span class="rating__star {{ $j <= $i ? 'is-filled' : '' }}">★</span>
                                            @endfor
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="paso2" data-numero="2" style="padding:30px; display:none;">
                        <div class="preg-card">
                            <h2 class="head fw-bold tf-title m-0">Califica Trayectoria Formativa</h2>
                            <div class="contenedor-central">
                                <p class="texto-preg" style="margin-top: 1%">
                                    ¿Consideras que la formación recibida fue clara y que comprendiste adecuadamente los
                                    temas
                                    abordados?
                                </p>

                                <div class="options-grid">
                                    <button type="button" class="option-btn" data-value="si">Sí</button>
                                    <button type="button" class="option-btn" data-value="no">No</button>
                                    <button type="button" class="option-btn" data-value="parcial">Parcialmente</button>
                                </div>
                            </div>

                        </div>
                    </section>
                    {{-- Paso 3 (inicia oculto) --}}
                    <section id="paso3" data-numero="3" style="padding:30px; display:none;">
                        <div class="preg-card">
                            <h2 class="head fw-bold tf-title m-0">Califica Trayectoria Formativa</h2>
                            <p class="texto-preg" style="margin-top: 1%"style="margin-top: 1%">
                                ¿Deseas compartir alguna observación final sobre la formación y/o algún compromiso personal
                                que asumes a partir de lo aprendido?
                            </p>

                            <div class="obs-wrapper">
                                <textarea id="obsFinal" class="comentario" name="comentario_p3" rows="4" maxlength="200"
                                    placeholder="Escribe tu observación (máx. 200 caracteres)..."></textarea>

                                <div class="obs-counter">
                                    <span id="obsCount">0</span>/200
                                </div>
                            </div>

                            <div class="mt-3" style="text-align:center;">
                                <button type="button" class="btn btn-primary btn-submit-text"
                                    style="background-color: #5ca7ee;border:none;">Guardar y continuar</button>
                            </div>
                        </div>
                    </section>
                    {{-- Final (inicia oculto) --}}
                    <section id="final" class="final-section" style="display:none; text-align:center;">
                        <h2 class="head fw-bold tf-title m-0">Califica Trayectoria Formativa</h2>
                        <p class="final-text" style="margin-top: 3%">Aplica lo aprendido con actitud y logra grandes cosas.
                        </p>
                        <p class="final-text"><strong>¡Muchos éxitos!</strong></p>
                        <div class="contenedor-estrella">
                            <div class="star-wrapper">
                                <!-- Estrella (con gradiente suave amarillo + naranja) -->
                                <svg class="final-star-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                                    aria-hidden="true">
                                    <defs>
                                        <linearGradient id="brightGold" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" stop-color="#FFF176" />
                                            <stop offset="50%" stop-color="#FFD54F" />
                                            <stop offset="100%" stop-color="#FFB74D" />
                                        </linearGradient>
                                        <filter id="softGlow" x="-50%" y="-50%" width="200%" height="200%">
                                            <feGaussianBlur in="SourceGraphic" stdDeviation="1.2" result="blur" />
                                            <feMerge>
                                                <feMergeNode in="blur" />
                                                <feMergeNode in="SourceGraphic" />
                                            </feMerge>
                                        </filter>
                                    </defs>
                                    <path fill="url(#brightGold)" stroke="#FBC02D" stroke-width="2"
                                        filter="url(#softGlow)"
                                        d="M32 2 L39 22 L60 24 L44 38 L48 58 L32 48 L16 58 L20 38 L4 24 L25 22 Z" />
                                </svg>

                                <!-- Chispitas -->
                                <!-- Chispitas -->
                                <div class="sparks">
                                    <!-- radios más cortos (30–45px en vez de 60–80px) -->
                                    <span style="--a:0deg;   --r:30px; --d:0s;   --s:6px;"></span>
                                    <span style="--a:60deg;  --r:35px; --d:.08s; --s:5px;"></span>
                                    <span style="--a:120deg; --r:32px; --d:.16s; --s:6px;"></span>
                                    <span style="--a:180deg; --r:38px; --d:.24s; --s:5px;"></span>
                                    <span style="--a:240deg; --r:34px; --d:.32s; --s:6px;"></span>
                                    <span style="--a:300deg; --r:40px; --d:.40s; --s:5px;"></span>

                                    <!-- anillo exterior (un poco más lejos, pero igual reducido) -->
                                    <span style="--a:30deg;  --r:45px; --d:.12s; --s:5px;"></span>
                                    <span style="--a:90deg;  --r:42px; --d:.20s; --s:5px;"></span>
                                    <span style="--a:150deg; --r:46px; --d:.28s; --s:5px;"></span>
                                    <span style="--a:210deg; --r:44px; --d:.36s; --s:5px;"></span>
                                    <span style="--a:270deg; --r:48px; --d:.44s; --s:5px;"></span>
                                    <span style="--a:330deg; --r:45px; --d:.52s; --s:5px;"></span>
                                </div>


                            </div>
                        </div>
                        <div class="mt-3">
                            @if (Route::has('trayectoria.lista'))
                                <a href="{{ route('trayectoria.lista') }}" class="btn btn-primary mt-3">Volver a la
                                    lista</a>
                            @else
                                <button type="button" class="btn btn-primary mt-3"
                                    style="background-color: #5ca7ee;border:none;"
                                    onclick="history.back()">Volver</button>
                            @endif
                        </div>
                    </section>

                </div>
                <div class="mt-3 small text-muted">Registro No. <code>{{ $registroId ?? '—' }}</code></div>
            </div>
            {{-- Debug opcional --}}

        </div>
    </main>
    <script>
        (function() {
            const registroId = parseInt(@json($registroId ?? 0), 10) || null;
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
            if (!registroId) console.warn('[TF] Falta registroId en la vista de calificar');

            async function guardar({
                id,
                numero,
                pregunta,
                calificacion
            }) {
                try {
                    const r = await fetch(POST_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            id,
                            numero,
                            pregunta,
                            calificacion
                        })
                    });
                    if (!r.ok) {
                        const t = await r.text();
                        console.error('[TF] guardar !ok', r.status, t);
                        alert('Error al guardar (' + r.status + '): ' + t.slice(0, 200));
                        return false;
                    }
                    const data = await r.json().catch(() => ({}));
                    if (!data?.success) {
                        alert(data?.message || 'No se pudo guardar');
                        return false;
                    }
                    return true;
                } catch (e) {
                    console.error('[TF] guardar error', e);
                    alert('Error de red al guardar');
                    return false;
                }
            }

            function show(id) {
                const el = document.getElementById(id);
                if (el) el.style.display = '';
            }

            function hide(id) {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            }

            function textOf(el) {
                return (el?.textContent || '').trim();
            }

            // --- Contador en vivo para P3 ---
            const obs = document.getElementById('obsFinal');
            const obsCount = document.getElementById('obsCount');
            if (obs && obsCount) {
                const updateCount = () => {
                    obsCount.textContent = String(obs.value.length);
                };
                obs.addEventListener('input', updateCount);
                updateCount(); // inicial
            }

            // ✅ Handler unificado: P1 (.rating__btn), P2 (.option-btn) y P3 (.btn-submit-text)
            document.addEventListener('click', async (e) => {
                // P3: botón guardar texto
                if (e.target.classList.contains('btn-submit-text')) {
                    const section = e.target.closest('section');
                    const numero = 3;
                    const pregunta = textOf(section.querySelector('.texto-preg'));
                    const calif = (document.getElementById('obsFinal')?.value || '').trim();

                    // Si quieres forzar a que no exceda (maxlength ya lo hace), también podrías cortar:
                    // const calif = raw.slice(0, 200);

                    if (!registroId) return;
                    const ok = await guardar({
                        id: registroId,
                        numero,
                        pregunta,
                        calificacion: calif
                    });
                    if (!ok) return;

                    hide('paso3');
                    show('final');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    return;
                }

                // P1 / P2
                const btn = e.target.closest('.rating__btn, .option-btn');
                if (!btn) return;

                const section = btn.closest('section');
                if (!section) return;

                const numero = parseInt(section.dataset.numero || '0', 10);
                const pregunta = textOf(section.querySelector('.texto-preg'));

                let calif;

                if (btn.classList.contains('rating__btn')) {
                    // P1: 0..5 tal cual
                    calif = parseInt(btn.dataset.value || '0', 10);
                    section.querySelectorAll('.rating__btn').forEach(b => b.classList.remove(
                    'is-selected'));
                    btn.classList.add('is-selected');

                } else {
                    // P2: mapear a número: no=0, si=5, parcial=3
                    const raw = (btn.dataset.value || '').toLowerCase();
                    const mapa = {
                        'no': 0,
                        'si': 5,
                        'parcial': 3,
                        'parcialmente': 3
                    };
                    calif = mapa[raw];
                    if (typeof calif !== 'number') {
                        console.warn('Valor P2 inválido:', raw);
                        return;
                    }

                    section.querySelectorAll('.option-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                }

                if (!registroId || !numero) return;

                const ok = await guardar({
                    id: registroId,
                    numero,
                    pregunta,
                    calificacion: calif
                });
                if (!ok) return;

                // Avance de pasos
                if (numero === 1) {
                    hide('paso1');
                    show('paso2');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } else if (numero === 2) {
                    hide('paso2');
                    show('paso3'); // 👈 ahora va al paso 3
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        })();

        function toggleVolver() {
            const volver = document.querySelector('.volver-wrapper');
            const paso1 = document.getElementById('paso1');
            if (!volver || !paso1) return;

            const visible = paso1.style.display !== 'none';
            volver.classList.toggle('hidden', !visible);
        }

        // Llamar cada vez que cambies de paso
        toggleVolver();
    </script>
@endsection
