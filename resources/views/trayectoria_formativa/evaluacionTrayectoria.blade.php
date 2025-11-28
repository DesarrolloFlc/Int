@extends('layouts.plantilla')

@section('title', 'Evaluación trayectoria')

@section('content')
    @php
        $tema = request('tema');
        $temaNorm = $tema ? strtolower(trim($tema)) : '';
         $temaNormSinTildes = strtr($temaNorm, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
            'ñ' => 'n', 'Ñ' => 'n',
        ]);

        $u = auth()->user();
        $unidadUsuario = null;

        if ($u) {
            $unidadUsuario = $u->unidad
                ?? $u->unidad_id
                ?? $u->id_unidad
                ?? null;
        }

        $esInduccion = $tema && strpos($temaNormSinTildes, 'induccion') !== false;
        $branch = 'sin_tema';

        if ($tema) {
            if ($esInduccion) {
                $branch = 'induccion';
            } else {
                if ((int) $unidadUsuario === 8) {
                    $branch = 'gestion_doc';
                } else {
                    $branch = 'general';
                }
            }
        }
    @endphp


    <main id="main" class="main">
        <div class="pagetitle">
            <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">

                {{-- Título principal --}}


                {{-- ========== CASOS SEGÚN BRANCH ========= --}}

                @if ($branch === 'sin_tema')
                    <div class="alert alert-warning">
                        No se encontró información de tema para esta trayectoria.
                    </div>

                @elseif ($branch === 'induccion')
                    {{-- ============================
                        CONTENEDOR — INDUCCIÓN
                    ============================= --}}



<style>
/* ===== MODAL TIPO QUIZ (SweetAlert2 premium style con SVG) ===== */

.quiz-popup {
    border-radius: 28px !important;
    padding: 34px 38px 32px !important;
    background: #ffffff !important;
    box-shadow: 0 20px 50px rgba(0,0,0,0.25) !important;
    animation: quizPopIn 0.45s ease-out !important;
}

/* Título tipo pastilla azul */
.quiz-title {
    display: inline-block;
    padding: 12px 38px;
    border-radius: 999px;
    background: linear-gradient(135deg, #4a6bff, #2c4deb);
    color: #ffffff !important;
    font-weight: 800 !important;
    font-size: 16px !important;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 24px !important;
    box-shadow: 0 6px 14px rgba(60, 90, 255, 0.35);
}

/* Lista de recomendaciones */
.quiz-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.quiz-list li {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    margin-bottom: 14px;
    font-size: 14px;
    color: #1f2937;
    line-height: 1.5;
}

.quiz-icon {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4B6C8E, #7D9CB8);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 14px rgba(75,108,142,0.30);
}
.quiz-icon svg {
    width: 20px; height: 20px;
    stroke: #ffffff; stroke-width: 2;
    fill: none;
}

/* Botón EMPEZAR */
.quiz-confirm-btn {
    margin-top: 26px;
    border-radius: 999px !important;
    padding: 14px 48px !important;
    font-size: 15px !important;
    background: linear-gradient(135deg, #ff9d4a, #ff7a2a) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.35) !important;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.quiz-confirm-btn:hover {
    filter: brightness(0.97);
    transform: translateY(-2px);
}

/* Animación */
@keyframes quizPopIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}




















.kahoot-section {
    padding: 32px;
    border-radius: 22px;
    background: linear-gradient(135deg, #d7e4ef, #b9cfe0);
    box-shadow: 0 12px 34px rgba(0,0,0,0.14);
}

.kahoot-title {
    font-size: 28px;
    color: #113a66;
    text-align: center;
    margin-bottom: 8px;
}

.kahoot-subtitle {
    text-align: center;
    font-size: 16px;
    color: #2e4563;
    margin-bottom: 22px;
}

.kahoot-progress {
    text-align: center;
    font-size: 15px;
    color: #1f314d;
    margin-bottom: 26px;
}

/* =====================================
   TARJETAS DE PREGUNTA (más color)
===================================== */
.kahoot-question-card {
    background-color: #f8e1ce00;
    border-radius: 20px;
    padding: 28px 26px;
    margin-bottom: 28px;
    transition: .25s ease;
    display: none;
    animation: fadeSlide .35s ease forwards;
}

.kahoot-question-card.active {
    display: block;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.kahoot-question {
    font-size: 21px;
    color: #253b5c;
    margin-bottom: 20px;
}

/* =====================================
   OPCIONES ABC — UN SOLO COLOR
   Profesional, vivo y combinable
===================================== */

.kahoot-options {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
}

@media (max-width: 768px) {
    .kahoot-options {
        grid-template-columns: 1fr;
    }
}

.kahoot-option {
    padding: 18px;
    border-radius: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: .25s ease;
    border:none;
    background: #ffffff;
    color: #1d3254;
}

/* Hover */
.kahoot-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    background: #95cfff96;
}

/* Ocultar radio */
.kahoot-option input[type="radio"] {
    display: none;
}

/* Texto */
.option-label {
    font-size: 16px;
}

/* =====================================
   ESTADO SELECCIONADO (más oscuro)
===================================== */

.kahoot-option.selected {
    background: #95cfff96!important;
    border-color: #95cfff96 !important;
    color: #0d1f3a !important;

    transform: scale(1);
    box-shadow: 0 0 6px rgba(55, 105, 200, 0.35);
}

/* =====================================
   BOTONES
===================================== */

.kahoot-nav {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    margin-top: 25px;
}

.kahoot-nav-btn {
    flex: 1;
    padding: 14px 0;
    border-radius: 999px;
    border: none;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.25s ease;
}

/* Botones deshabilitados */
.kahoot-nav-btn:disabled {
    opacity: 0.5;
    cursor: default;
    box-shadow: none;
    transform: none;
}

/* ANTERIOR */
.kahoot-nav-btn.prev {
    background: linear-gradient(135deg, #c9d8ee, #a7bddc);
    color: #24344f;
    box-shadow: 0 4px 10px rgba(90,110,140,0.25);
}
.kahoot-nav-btn.prev:hover:not(:disabled) {
    background: linear-gradient(135deg, #b9cbe2, #92a8c9);
}

/* SIGUIENTE */
.kahoot-nav-btn.next {
    background: linear-gradient(135deg, #1f7bd1, #145ca3);
    color: #fff;
    box-shadow: 0 6px 14px rgba(31,123,209,0.35);
}
.kahoot-nav-btn.next:hover:not(:disabled) {
    background: linear-gradient(135deg, #166bc0, #0f4f8b);
}

/* ENVIAR */
.kahoot-submit {
    width: 100%;
    padding: 16px 0;
    margin-top: 24px;
    border-radius: 999px;
    border: none;
    font-size: 17px;
    font-weight: 900;
    transition: .25s ease;
    background: linear-gradient(135deg, #1f7bd1, #145ca3);
    color: #fff;
    box-shadow: 0 6px 20px rgba(31,123,209,0.38);
}
.kahoot-submit:hover {
    background: linear-gradient(135deg, #166bc0, #0f4f8b);
    transform: translateY(-2px);
}

























/* ===== GESTIÓN DOCUMENTAL (tono verde premium) ===== */

.kahoot-section-doc {
    padding: 32px;
    border-radius: 22px;
    background: linear-gradient(135deg, #e4f7ef, #c9ecdf);
    box-shadow: 0 12px 34px rgba(0,0,0,0.12);
}

.kahoot-title-doc {
    font-size: 28px;
    color: #0b5345;
    text-align: center;
    margin-bottom: 8px;
    font-weight: 700;
}

.kahoot-subtitle-doc {
    text-align: center;
    font-size: 16px;
    color: #195c4c;
    margin-bottom: 22px;
}

.kahoot-progress-doc {
    text-align: center;
    font-size: 15px;
    color: #0e3e33;
    margin-bottom: 26px;
}

/* tarjetas */
.kahoot-question-card-doc {
    background-color: #ffffff;
    border-radius: 20px;
    padding: 26px;
    margin-bottom: 28px;
    display: none;
    animation: fadeSlide .35s ease forwards;
}

.kahoot-question-card-doc.active {
    display: block;
}

.kahoot-question-doc {
    font-size: 21px;
    color: #0e3e33;
    margin-bottom: 20px;
}

/* opciones */
.kahoot-options-doc {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

@media(max-width:768px){
    .kahoot-options-doc { grid-template-columns:1fr; }
}

.kahoot-option-doc {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    cursor: pointer;
    transition: .25s ease;
    display: flex;
    align-items: center;
    color: #0f4f46;
    border: none;
}

.kahoot-option-doc:hover {
    background: #b8eedd;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.kahoot-option-doc input {
    display:none;
}

.kahoot-option-doc.selected {
    background: #76d7c4 !important;
    color: #083d33 !important;
    box-shadow: 0 0 8px rgba(0,0,0,0.20);
}

/* enviar */
.kahoot-submit-doc {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 999px;
    background: linear-gradient(135deg, #0fa67b, #0b8f6b);
    color: white;
    font-size: 17px;
    font-weight: 800;
    margin-top: 25px;
}


</style>

<section class="kahoot-section mb-4">

    <h2 class="kahoot-title">Evaluación – Inducción</h2>

    <p class="kahoot-subtitle">
        Selecciona una respuesta por cada pregunta.
    </p>

    <div class="kahoot-progress" id="kahootProgress">
        Pregunta 1 de 5
    </div>

    <form action="#" method="POST" class="kahoot-form">
        @csrf

        {{-- Pregunta 1 --}}
        <div class="kahoot-question-card active" data-step="1">
            <h3 class="kahoot-question">1. Pregunta 1</h3>

            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg1" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>

                <label class="kahoot-option">
                    <input type="radio" name="preg1" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>

                <label class="kahoot-option">
                    <input type="radio" name="preg1" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 2 --}}
        <div class="kahoot-question-card" data-step="2">
            <h3 class="kahoot-question">2. Pregunta 2</h3>
            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg2" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg2" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg2" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 3 --}}
        <div class="kahoot-question-card" data-step="3">
            <h3 class="kahoot-question">3. Pregunta 3</h3>
            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg3" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg3" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg3" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 4 --}}
        <div class="kahoot-question-card" data-step="4">
            <h3 class="kahoot-question">4. Pregunta 4</h3>
            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg4" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg4" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg4" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 5 --}}
        <div class="kahoot-question-card" data-step="5">
            <h3 class="kahoot-question">5. Pregunta 5</h3>
            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg5" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg5" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg5" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>


                {{-- Pregunta 6 --}}
        <div class="kahoot-question-card" data-step="6">
            <h3 class="kahoot-question">6. Pregunta 6</h3>
            <div class="kahoot-options">
                <label class="kahoot-option">
                    <input type="radio" name="preg6" value="A">
                    <span class="option-label">A) Opción A</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg6" value="B">
                    <span class="option-label">B) Opción B</span>
                </label>
                <label class="kahoot-option">
                    <input type="radio" name="preg6" value="C">
                    <span class="option-label">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Navegación entre preguntas --}}
        <div class="kahoot-nav">
            <button type="button" class="kahoot-nav-btn prev" id="kahootPrev" disabled>
                ← Anterior
            </button>
            <button type="button" class="kahoot-nav-btn next" id="kahootNext">
                Siguiente →
            </button>
        </div>

        <button type="submit" class="kahoot-submit" id="kahootSubmit" style="display:none;">
            Enviar evaluación
        </button>
    </form>
</section>
























































                @elseif ($branch === 'gestion_doc')
                    {{-- ============================
                        CONTENEDOR — GESTIÓN DOCUMENTAL
                        (solo cuando el usuario tiene unidad 8)--}}










<section class="kahoot-section-doc mb-4">

    <h2 class="kahoot-title-doc">Evaluación – Gestión Documental</h2>

    <p class="kahoot-subtitle-doc">
        Selecciona una respuesta por cada pregunta.
    </p>

    <div class="kahoot-progress-doc" id="kahootProgressDoc">
        Pregunta 1 de 6
    </div>

    <form action="#" method="POST" class="kahoot-form-doc">
        @csrf

        {{-- Pregunta 1 --}}
        <div class="kahoot-question-card-doc active" data-step="1">
            <h3 class="kahoot-question-doc">1. Pregunta 1 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc1" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc1" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc1" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 2 --}}
        <div class="kahoot-question-card-doc" data-step="2">
            <h3 class="kahoot-question-doc">2. Pregunta 2 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc2" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc2" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc2" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 3 --}}
        <div class="kahoot-question-card-doc" data-step="3">
            <h3 class="kahoot-question-doc">3. Pregunta 3 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc3" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc3" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc3" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 4 --}}
        <div class="kahoot-question-card-doc" data-step="4">
            <h3 class="kahoot-question-doc">4. Pregunta 4 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc4" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc4" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc4" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 5 --}}
        <div class="kahoot-question-card-doc" data-step="5">
            <h3 class="kahoot-question-doc">5. Pregunta 5 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc5" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc5" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc5" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 6 --}}
        <div class="kahoot-question-card-doc" data-step="6">
            <h3 class="kahoot-question-doc">6. Pregunta 6 – Gestión documental</h3>

            <div class="kahoot-options-doc">
                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc6" value="A">
                    <span class="option-label-doc">A) Opción A</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc6" value="B">
                    <span class="option-label-doc">B) Opción B</span>
                </label>

                <label class="kahoot-option-doc">
                    <input type="radio" name="pregDoc6" value="C">
                    <span class="option-label-doc">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Navegación entre preguntas --}}
        <div class="kahoot-nav-doc">
            <button type="button"
                    class="kahoot-nav-btn-doc prev-doc"
                    id="kahootPrevDoc"
                    disabled>
                ← Anterior
            </button>
            <button type="button"
                    class="kahoot-nav-btn-doc next-doc"
                    id="kahootNextDoc">
                Siguiente →
            </button>
        </div>

        <button type="submit"
                class="kahoot-submit-doc"
                id="kahootSubmitDoc"
                style="display:none;">
            Enviar evaluación
        </button>
    </form>
</section>


















<style>/* ===== GESTIÓN DOCUMENTAL (mismo diseño, tonos NARANJA SUAVE) ===== */
/* ===========================================
   GESTIÓN DOCUMENTAL – PALETA MORADO GRIS ELEGANTE
   =========================================== */

.kahoot-section-doc {
    padding: 32px;
    border-radius: 22px;
    background: linear-gradient(135deg, #e1d6e6, #c8b8cd); /* fondo lila-gris */
    box-shadow: 0 12px 34px rgba(92, 79, 102, 0.18);
}

/* TÍTULO */
.kahoot-title-doc {
    font-size: 28px;
    color: #4a3e57; /* morado gris profundo */
    text-align: center;
    margin-bottom: 8px;
}

/* SUBTÍTULO */
.kahoot-subtitle-doc {
    text-align: center;
    font-size: 16px;
    color: #6f627a; /* lavanda opaca */
    margin-bottom: 22px;
}

/* PROGRESO */
.kahoot-progress-doc {
    text-align: center;
    font-size: 15px;
    color: #5a4d6a; /* morado gris oscuro */
    margin-bottom: 26px;
}

/* TARJETAS DE PREGUNTA */
.kahoot-question-card-doc {
    border-radius: 20px;
    padding: 28px 26px;
    margin-bottom: 28px;
    display: none;
    background: #c1222200;
    transition: .25s ease;
    animation: fadeSlide .35s ease forwards;
}

.kahoot-question-card-doc.active {
    display: block;
}

.kahoot-question-doc {
    font-size: 21px;
    color: #4a3e57; /* morado gris profundo */
    margin-bottom: 20px;
}

/* OPCIONES */
.kahoot-options-doc {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
}

@media (max-width: 768px) {
    .kahoot-options-doc { grid-template-columns: 1fr; }
}

.kahoot-option-doc {
    padding: 18px;
    border-radius: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: .25s ease;
    border: none;
    background: #ffffff;
    color: #5c4f66; /* gris-morado */
    box-shadow: 0 2px 6px rgba(100, 90, 120, 0.12);
}

/* HOVER */
.kahoot-option-doc:hover {
    transform: translateY(-2px);
    background: #b59fc5; /* lavanda muy suave */
    box-shadow: 0 4px 10px rgba(120, 100, 140, 0.25);
}

/* RADIO HIDDEN */
.kahoot-option-doc input[type="radio"] {
    display: none;
}

/* TEXTO OPCIÓN */
.option-label-doc {
    font-size: 16px;
}

/* SELECCIONADO */
.kahoot-option-doc.selected {
    background: #b59fc5!important; /* morado pastel suave */
    border-color: #b59fc5 !important;
    color: #3f344a !important; /* contraste */
    box-shadow: 0 0 8px rgba(110, 90, 130, 0.35);
}

/* NAVEGACIÓN */
.kahoot-nav-doc {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    margin-top: 25px;
}

.kahoot-nav-btn-doc {
    flex: 1;
    padding: 14px 0;
    border-radius: 999px;
    border: none;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.25s ease;
}

/* Prev – morado gris suave */
.kahoot-nav-btn-doc.prev-doc {
    background: linear-gradient(135deg, #e7dff0, #d4c8e0);
    color: #4a3e57;
    box-shadow: 0 4px 10px rgba(90, 70, 110, 0.20);
}
.kahoot-nav-btn-doc.prev-doc:hover:not(:disabled) {
    background: linear-gradient(135deg, #ded3eb, #c9bdd9);
}

/* Next – morado acentuado */
.kahoot-nav-btn-doc.next-doc {
    background: linear-gradient(135deg, #936eb5, #7d4fa9);
    color: #fff;
    box-shadow: 0 6px 14px rgba(140, 110, 170, 0.35);
}
.kahoot-nav-btn-doc.next-doc:hover:not(:disabled) {
    background: linear-gradient(135deg, #7b5c98, #68408c);
}

/* SUBMIT */
.kahoot-submit-doc {
    width: 100%;
    padding: 16px 0;
    margin-top: 24px;
    border-radius: 999px;
    border: none;
    font-size: 17px;
    font-weight: 900;
    transition: .25s ease;
    background: linear-gradient(135deg, #936eb5, #7d4fa9);
    color: #fff;
    box-shadow: 0 6px 20px rgba(120, 90, 150, 0.38);
}
.kahoot-submit-doc:hover {
    background: linear-gradient(135deg, #7b5c98, #68408c);
    transform: translateY(-2px);
}

</style>














                @elseif ($branch === 'general')
                    {{-- ============================
                        CONTENEDOR — GENERAL
                        (para cualquier otro tema y unidad ≠ 8)
                    ============================= --}}
<section class="kahoot-section-gen mb-4">

    <h2 class="kahoot-title-gen">Evaluación – General</h2>

    <p class="kahoot-subtitle-gen">
        Otros aspectos generales de la trayectoria formativa. Selecciona una respuesta por cada pregunta.
    </p>

    <div class="kahoot-progress-gen" id="kahootProgressGen">
        Pregunta 1 de 6
    </div>

    <form action="#" method="POST" class="kahoot-form-gen">
        @csrf

        {{-- Pregunta 1 --}}
        <div class="kahoot-question-card-gen active" data-step="1">
            <h3 class="kahoot-question-gen">1. Pregunta 1 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen1" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen1" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen1" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 2 --}}
        <div class="kahoot-question-card-gen" data-step="2">
            <h3 class="kahoot-question-gen">2. Pregunta 2 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen2" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen2" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen2" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 3 --}}
        <div class="kahoot-question-card-gen" data-step="3">
            <h3 class="kahoot-question-gen">3. Pregunta 3 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen3" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen3" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen3" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 4 --}}
        <div class="kahoot-question-card-gen" data-step="4">
            <h3 class="kahoot-question-gen">4. Pregunta 4 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen4" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen4" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen4" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 5 --}}
        <div class="kahoot-question-card-gen" data-step="5">
            <h3 class="kahoot-question-gen">5. Pregunta 5 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen5" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen5" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen5" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Pregunta 6 --}}
        <div class="kahoot-question-card-gen" data-step="6">
            <h3 class="kahoot-question-gen">6. Pregunta 6 – General</h3>

            <div class="kahoot-options-gen">
                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen6" value="A">
                    <span class="option-label-gen">A) Opción A</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen6" value="B">
                    <span class="option-label-gen">B) Opción B</span>
                </label>

                <label class="kahoot-option-gen">
                    <input type="radio" name="pregGen6" value="C">
                    <span class="option-label-gen">C) Opción C</span>
                </label>
            </div>
        </div>

        {{-- Navegación entre preguntas --}}
        <div class="kahoot-nav-gen">
            <button type="button"
                    class="kahoot-nav-btn-gen prev-gen"
                    id="kahootPrevGen"
                    disabled>
                ← Anterior
            </button>
            <button type="button"
                    class="kahoot-nav-btn-gen next-gen"
                    id="kahootNextGen">
                Siguiente →
            </button>
        </div>

        <button type="submit"
                class="kahoot-submit-gen"
                id="kahootSubmitGen"
                style="display:none;">
            Enviar evaluación
        </button>
    </form>
</section>






<style>
    /* ===========================================
   GENERAL – DISEÑO BASE (colores neutros provisionales)
   =========================================== */

.kahoot-section-gen {
    padding: 32px;
    border-radius: 22px;
    background: #d7b297;

    box-shadow: 0 12px 34px rgba(90, 90, 90, 0.18);
}

/* TÍTULO */
.kahoot-title-gen {
    font-size: 28px;
    color: #4d4d4d; /* neutro – se reemplazará por un marrón/naranja suave */
    text-align: center;
    margin-bottom: 8px;
}

/* SUBTÍTULO */
.kahoot-subtitle-gen {
    text-align: center;
    font-size: 16px;
    color: #6a6a6a;
    margin-bottom: 22px;
}

/* PROGRESO */
.kahoot-progress-gen {
    text-align: center;
    font-size: 15px;
    color: #5c5c5c;
    margin-bottom: 26px;
}

/* TARJETAS DE PREGUNTA */
.kahoot-question-card-gen {
    border-radius: 20px;
    padding: 28px 26px;
    margin-bottom: 28px;
    display: none;
    background: #00000000;
    transition: .25s ease;
    animation: fadeSlide .35s ease forwards;
}

.kahoot-question-card-gen.active {
    display: block;
}

.kahoot-question-gen {
    font-size: 21px;
    color: #4d4d4d;
    margin-bottom: 20px;
}

/* OPCIONES */
.kahoot-options-gen {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
}

@media (max-width: 768px) {
    .kahoot-options-gen { grid-template-columns: 1fr; }
}

.kahoot-option-gen {
    padding: 18px;
    border-radius: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: .25s ease;
    border: none;
    background: #ffffff;
    color: #595959;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

/* HOVER */
.kahoot-option-gen:hover {
    transform: translateY(-2px);
    background: #e6e6e6;
    box-shadow: 0 4px 10px rgba(0,0,0,0.16);
}

/* Ocultar radio */
.kahoot-option-gen input[type="radio"] {
    display: none;
}

/* Texto opción */
.option-label-gen {
    font-size: 16px;
}

/* SELECCIONADO */
.kahoot-option-gen.selected {
    background: #d2d2d2 !important;
    border-color: #d2d2d2 !important;
    color: #3e3e3e !important;
    box-shadow: 0 0 8px rgba(100,100,100,0.35);
}

/* NAVEGACIÓN */
.kahoot-nav-gen {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    margin-top: 25px;
}

.kahoot-nav-btn-gen {
    flex: 1;
    padding: 14px 0;
    border-radius: 999px;
    border: none;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.25s ease;
}

/* PREV */
.kahoot-nav-btn-gen.prev-gen {
    background: linear-gradient(135deg, #efefef, #dcdcdc);
    color: #4d4d4d;
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}
.kahoot-nav-btn-gen.prev-gen:hover:not(:disabled) {
    background: linear-gradient(135deg, #e3e3e3, #d1d1d1);
}

/* NEXT */
.kahoot-nav-btn-gen.next-gen {
    background: linear-gradient(135deg, #c6c6c6, #b3b3b3);
    color: #fff;
    box-shadow: 0 6px 14px rgba(0,0,0,0.2);
}
.kahoot-nav-btn-gen.next-gen:hover:not(:disabled) {
    background: linear-gradient(135deg, #b8b8b8, #a7a7a7);
}

/* SUBMIT */
.kahoot-submit-gen {
    width: 100%;
    padding: 16px 0;
    margin-top: 24px;
    border-radius: 999px;
    border: none;
    font-size: 17px;
    font-weight: 900;
    transition: .25s ease;
    background: linear-gradient(135deg, #bcbcbc, #a3a3a3);
    color: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.22);
}
.kahoot-submit-gen:hover {
    background: linear-gradient(135deg, #a9a9a9, #949494);
    transform: translateY(-2px);
}

</style>

                @endif

            </div>
        </div>
    </main>








<link rel="stylesheet" href="/intranet/css/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = Array.from(document.querySelectorAll('.kahoot-question-card'));
    const total = cards.length;
    const btnPrev = document.getElementById('kahootPrev');
    const btnNext = document.getElementById('kahootNext');
    const btnSubmit = document.getElementById('kahootSubmit');
    const progress = document.getElementById('kahootProgress');

    let current = 0; // índice de la pregunta actual (0-based)

    function updateView() {
        cards.forEach((card, idx) => {
            card.classList.toggle('active', idx === current);
        });

        // Progreso
        if (progress) {
            progress.textContent = 'Pregunta ' + (current + 1) + ' de ' + total;
        }

        // Prev habilitado sólo si no estamos en la primera
        btnPrev.disabled = current === 0;

        // Si estamos en la última: ocultar "Siguiente" y mostrar "Enviar"
        if (current === total - 1) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'block';
        } else {
            btnNext.style.display = 'inline-block';
            btnSubmit.style.display = 'none';
        }
    }

    btnPrev.addEventListener('click', () => {
        if (current > 0) {
            current--;
            updateView();
        }
    });

    btnNext.addEventListener('click', () => {
        if (current < total - 1) {
            current++;
            updateView();
        }
    });

    // ============================
    // Selección visual de opciones
    // ============================
    const allRadios = document.querySelectorAll('.kahoot-option input[type="radio"]');

    allRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const groupName = this.name;

            // quitar selección previa del grupo (preg1, preg2, etc.)
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                const opt = r.closest('.kahoot-option');
                if (opt) opt.classList.remove('selected');
            });

            // marcar contenedor seleccionado
            const currentOpt = this.closest('.kahoot-option');
            if (currentOpt) currentOpt.classList.add('selected');
        });
    });

    // Inicializa la vista
    updateView();
});
</script>










<script>
document.addEventListener('DOMContentLoaded', function () {
    @if ($branch === 'induccion')
    Swal.fire({
        html: `
            <ul class="quiz-list">

                <!-- LENTES – "Lee con atención" -->
                <li>
                    <div class="quiz-icon">
                        <svg viewBox="0 0 24 24">
                            <!-- patillas -->
                            <path d="M3 12v-1.5" />
                            <path d="M21 12v-1.5" />
                            <!-- puente -->
                            <path d="M10 12h4" />
                            <!-- aros -->
                            <circle cx="8" cy="13" r="2.5" />
                            <circle cx="16" cy="13" r="2.5" />
                        </svg>
                    </div>
                    <span>Lee con atención cada pregunta antes de responder.</span>
                </li>

                <!-- RELOJ – "Administra bien el tiempo" -->
                <li>
                    <div class="quiz-icon">
                        <svg viewBox="0 0 24 24">
                            <!-- contorno reloj -->
                            <circle cx="12" cy="12" r="7" />
                            <!-- manecillas -->
                            <path d="M12 9v4" />
                            <path d="M12 12l2.5 2" />
                        </svg>
                    </div>
                    <span>Administra bien el tiempo durante la evaluación.</span>
                </li>

                <!-- CHECK – "Revisa tus respuestas" -->
                <li>
                    <div class="quiz-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 13.5l3 3 9-9" />
                        </svg>
                    </div>
                    <span>Revisa todas tus respuestas antes de enviar.</span>
                </li>

            </ul>
        `,
        icon: 'info',
        showCancelButton: false,
        confirmButtonText: 'EMPEZAR',
        confirmButtonColor: '#ff9d4a',
        customClass: {
            popup: 'quiz-popup',
            title: 'quiz-title',
            confirmButton: 'quiz-confirm-btn'
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: true
    }).then((result) => {
        // Aquí nos aseguramos de que NO quede nada de SweetAlert bloqueando la pantalla
        // aunque exista algún conflicto de versiones/estilos

        // Cierra explícitamente el popup por si algo falló
        Swal.close();

        // Elimina cualquier contenedor que haya quedado
        document.querySelectorAll('.swal2-container').forEach(el => el.remove());

        // Quita clases que deshabilitan scroll/clics
        document.body.classList.remove('swal2-shown');
        document.documentElement.classList.remove('swal2-shown');
    });
    @endif
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==========================
    // NAVEGACIÓN GESTIÓN DOCUMENTAL
    // ==========================
    const docCards   = Array.from(document.querySelectorAll('.kahoot-question-card-doc'));
    const docTotal   = docCards.length;
    const btnPrevDoc = document.getElementById('kahootPrevDoc');
    const btnNextDoc = document.getElementById('kahootNextDoc');
    const btnSubDoc  = document.getElementById('kahootSubmitDoc');
    const progDoc    = document.getElementById('kahootProgressDoc');

    let currentDoc = 0;

    function updateViewDoc() {
        if (!docCards.length) return;

        docCards.forEach((card, idx) => {
            card.classList.toggle('active', idx === currentDoc);
        });

        if (progDoc) {
            progDoc.textContent = 'Pregunta ' + (currentDoc + 1) + ' de ' + docTotal;
        }

        if (btnPrevDoc) {
            btnPrevDoc.disabled = currentDoc === 0;
        }

        if (btnNextDoc && btnSubDoc) {
            if (currentDoc === docTotal - 1) {
                btnNextDoc.style.display = 'none';
                btnSubDoc.style.display  = 'block';
            } else {
                btnNextDoc.style.display = 'inline-block';
                btnSubDoc.style.display  = 'none';
            }
        }
    }

    if (btnPrevDoc) {
        btnPrevDoc.addEventListener('click', () => {
            if (currentDoc > 0) {
                currentDoc--;
                updateViewDoc();
            }
        });
    }

    if (btnNextDoc) {
        btnNextDoc.addEventListener('click', () => {
            if (currentDoc < docTotal - 1) {
                currentDoc++;
                updateViewDoc();
            }
        });
    }

    // ==========================
    // SELECCIÓN VISUAL OPCIONES DOC
    // ==========================
    const docRadios = document.querySelectorAll('.kahoot-option-doc input[type="radio"]');

    docRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const groupName = this.name;

            // limpiar selección previa del mismo grupo
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                const opt = r.closest('.kahoot-option-doc');
                if (opt) opt.classList.remove('selected');
            });

            const currentOpt = this.closest('.kahoot-option-doc');
            if (currentOpt) currentOpt.classList.add('selected');
        });
    });

    // Inicializar vista
    updateViewDoc();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==========================
    // NAVEGACIÓN – GENERAL
    // ==========================
    const genCards   = Array.from(document.querySelectorAll('.kahoot-question-card-gen'));
    const genTotal   = genCards.length;
    const btnPrevGen = document.getElementById('kahootPrevGen');
    const btnNextGen = document.getElementById('kahootNextGen');
    const btnSubGen  = document.getElementById('kahootSubmitGen');
    const progGen    = document.getElementById('kahootProgressGen');

    let currentGen = 0;

    function updateViewGen() {
        if (!genCards.length) return;

        genCards.forEach((card, idx) => {
            card.classList.toggle('active', idx === currentGen);
        });

        if (progGen) {
            progGen.textContent = 'Pregunta ' + (currentGen + 1) + ' de ' + genTotal;
        }

        if (btnPrevGen) {
            btnPrevGen.disabled = currentGen === 0;
        }

        if (btnNextGen && btnSubGen) {
            if (currentGen === genTotal - 1) {
                btnNextGen.style.display = 'none';
                btnSubGen.style.display  = 'block';
            } else {
                btnNextGen.style.display = 'inline-block';
                btnSubGen.style.display  = 'none';
            }
        }
    }

    if (btnPrevGen) {
        btnPrevGen.addEventListener('click', () => {
            if (currentGen > 0) {
                currentGen--;
                updateViewGen();
            }
        });
    }

    if (btnNextGen) {
        btnNextGen.addEventListener('click', () => {
            if (currentGen < genTotal - 1) {
                currentGen++;
                updateViewGen();
            }
        });
    }

    // ==========================
    // SELECCIÓN VISUAL OPCIONES – GENERAL
    // ==========================
    const genRadios = document.querySelectorAll('.kahoot-option-gen input[type="radio"]');

    genRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const groupName = this.name;

            // limpiar selección previa del mismo grupo (pregGen1, pregGen2, etc.)
            document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                const opt = r.closest('.kahoot-option-gen');
                if (opt) opt.classList.remove('selected');
            });

            const currentOpt = this.closest('.kahoot-option-gen');
            if (currentOpt) currentOpt.classList.add('selected');
        });
    });

    // Inicializar vista
    updateViewGen();
});
</script>


@endsection
