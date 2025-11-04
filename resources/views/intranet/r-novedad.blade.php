@extends('layouts.plantilla')

@section('title', 'novedad')

@section('content')

<link rel="stylesheet" href="{{asset('/css/forms.css')}}">

<main id="main" class="main">
    <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">      
        <h2 class="head fw-bold">Reporte de Novedad</h2>       
        <form class="formulario" action="{{ route('novedad') }}" method="POST">
            @csrf
            <input name="creador" type="text" value="{{ Auth::user()->nombre }}" hidden>
            <div class="details personal mt-4">
                <span class="title fw-bold">Información</span>
                <div class="fields">
                    <div class="input-field">
                        <label>Fecha</label>
                        <input name="fecha" type="date" placeholder="Ingrese la fecha" required>
                    </div>                    
                    <div class="input-field">
                        <label>Lugar</label>
                        <input name="lugar" type="text" placeholder="Ingrese el lugar" required>
                    </div>
                    <div class="input-field">
                        <label>Colaborador</label>
                        <input name="colaborador" type="text" placeholder="Ingrese el colaborador" required>
                    </div>                   
                </div>
                <div class="details ID">
                    <span class="title fw-bold">Detalles</span>
                    <div class="fields">                                                
                        <div class="input-field">
                            <label>Observaciones</label>
                            <textarea name="observacion" type="number" placeholder="Observación aqui" required></textarea>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-10">
                        <button class="sumbit mt-4 border rounded" type="submit">
                            <span class="btnText text-light fw-bold">Reportar</span>                    
                        </button>
                    </div>
                    <div class="col">
                        <a href="{{ route('listado.novedad') }}"><button class="mt-4 border rounded" type="button" style="background-color: #3379FF">
                            <span class="btnText text-light fw-bold">Ver listado</span>
                        </button></a>
                    </div>
                </div>
            </div>                                                                
        </form>
    </div>   
</main>
@endsection