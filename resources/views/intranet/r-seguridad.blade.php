@extends('layouts.plantilla')

@section('title', 'seguridad')

@section('content')

<link rel="stylesheet" href="{{asset('/css/forms.css')}}">

<main id="main" class="main">
    <div class="container mx-auto tab-pane fade shadow rounded bg-white show active p-5">      
        <h2 class="head fw-bold">Reporte de Seguridad</h2>       
        <form class="formulario" action="{{ route('formulario') }}" method="POST">
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
                
                <button class="sumbit mt-4  border rounded" type="submit">
                    <span class="btnText text-light fw-bold">Reportar</span>                    
                </button>
            </div>                                                                
        </form>
    </div>   
</main>
@endsection