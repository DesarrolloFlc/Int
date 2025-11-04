@extends('layouts.plantilla')

@section('title', 'accidentes / incidentes')

@section('content')

<link rel="stylesheet" href="{{asset('/css/forms.css')}}">

<main id="main" class="main">
    <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">
        <h2 class="head fw-bold">Reporte de Accidentes / Incidentes</h2>
        <form class="formulario" action="{{ route('formulario') }}" method="POST">
            @csrf
            <div class="details personal mt-4">
                <span class="title fw-bold">Información</span>
                <div class="fields">
                    <div class="input-field">
                        <label>¿Cuando ocurrió el incidente?</label>
                        <input name="fecha" type="date" placeholder="Ingrese la fecha" required>
                    </div>
                    <div class="input-field">
                        <label>¿Dónde ocurrió el incidente / accidente?</label>
                        <input name="lugar" type="text" placeholder="Ingrese el lugar" required>
                    </div>
                    <div class="input-field">
                        <label>Nombre de la persona que presentó el evento.</label>
                        <input name="colaborador" type="text" placeholder="Ingrese el colaborador" required>
                    </div>
                    <div class="input-field">
                        <label>Cédula de la persona que presentó el evento.</label>
                        <input name="cedula" type="texto" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ingrese la cedula" required>
                    </div>
                    <div class="input-field">
                        <label>Cargo de la persona que presentó el evento.</label>
                        <input name="cargo" type="text" placeholder="Ingrese el cargo" required>
                    </div>
                    <div class="input-field">
                        <input name="creador" type="text" value="{{ Auth::user()->nombre }}" hidden>
                    </div>
                </div>
                <div class="details ID">
                    <span class="title fw-bold">Detalles</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Descripción detallada.</label>
                            <textarea name="descripcion" placeholder="Descripción..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10">
                        <button class="sumbit mt-4 me-0 border rounded" type="submit">
                            <span class="btnText text-light fw-bold">Reportar</span>
                        </button>
                    </div>
                    @if(Auth::user()->id_rol == 2 && Auth::user()->id_unidad == 1 || Auth::user()->id_unidad == 6 || Auth::user()->id_unidad === 26)
                    <div class="col">
                        <a href="{{ route('listado') }}"><button class="mt-4 me-0 border rounded" type="button" style="background-color: #3379FF" href='a'>
                            <span class="btnText text-light fw-bold">Ver listado</span>
                        </button></a>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
