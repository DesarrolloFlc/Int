@extends('layouts.plantilla')

@section('title', 'Mapa de procesos')

@section('content')

<main  id="main" class="main">
    <div class="pagetitle">
        <h1>Mapa de Procesos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Mapa de Procesos</a></li>
                <li class="breadcrumb-item active">Bibilioteca de archivos</li>
            </ol>
        </nav>
    </div>
    <center>
    <div class="w-100 mt-5" id="container">
        <div  class="tab-pane fade shadow rounded bg-white show active p-5 overflow-auto">
            <img id="imagen" src="{{asset('/storage/MAPA2.png')}}" usemap="#mapa">
            <map id="mapa">
                <area style="cursor: pointer;" shape="circle" coords="118,276,74" data-bs-toggle="modal" data-bs-target="#necesidades">             {{-- Necesidades --}}
                @if (Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2 || Auth::user()->id_rol == 3 || Auth::user()->id_rol == 4  || Auth::user()->id_rol == 5)
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 9 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="433,94,46" data-bs-toggle="modal" data-bs-target="#SIG" >                     {{-- SIG --}}                   {{-- Calidad --}}
                        <area style="cursor: pointer;" shape="circle" coords="555,92,46" data-bs-toggle="modal" data-bs-target="#DireccionEstrategica" >    {{-- DIRECCION --}}             {{-- Calidad --}}
                        <area style="cursor: pointer;" shape="circle" coords="500,370,47" data-bs-toggle="modal" data-bs-target="#GestionServicioCliente">  {{-- SERVICIO AL CLIENTE --}}   {{-- Calidad --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 2 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="496,191,42" data-bs-toggle="modal" data-bs-target="#GestionComercial">        {{-- COMERCIAL --}}             {{-- Calidad, Gerencia --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 7 || Auth::user()->id_rol == 3 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="437,278,47" data-bs-toggle="modal" data-bs-target="#GestionOperaciones">      {{-- OPERACIONES --}}           {{-- Calidad, Coordinadores --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 8 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="562,280,47" data-bs-toggle="modal" data-bs-target="#GestionDocumental">       {{-- DOCUMENTAL --}}            {{-- Calidad, Gestion Documental --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 4 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="393,458,44" data-bs-toggle="modal" data-bs-target="#GestionHumana">           {{-- HUMANA --}}                {{-- Calidad, Gestion Humana --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 6 || Auth::user()->id_rol == 5 || Auth::user()->id_unidad == 26)
                        <area style="cursor: pointer;" shape="circle" coords="505,509,44" data-bs-toggle="modal" data-bs-target="#GestionTi">               {{-- TI --}}                    {{-- Calidad, Tecnologia --}}
                    @endif
                    @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_rol == 5)
                        <area style="cursor: pointer;" shape="circle" coords="626,460,45" data-bs-toggle="modal" data-bs-target="#GestionAdministrativaGeneral">
                    @endif
                    @if (Auth::user()->id_unidad == 3 || Auth::user()->id_rol == 5)
                    {{-- @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 3) --}}
                        <area style="cursor: pointer;" shape="circle" coords="626,460,45" data-bs-toggle="modal" data-bs-target="#GestionAdministrativaC">
                    @endif
                    @if (Auth::user()->id_unidad == 5 || Auth::user()->id_rol == 5)
                    {{-- @if (Auth::user()->id_unidad <= 2 || Auth::user()->id_unidad == 5) --}}
                        <area style="cursor: pointer;" shape="circle" coords="626,460,45" data-bs-toggle="modal" data-bs-target="#GestionAdministrativaF">   {{-- ADMINISTRATIVA --}}        {{-- Calidad, Asistente administrativa, Contabilidad --}}
                    @endif
                @endif
                <area style="cursor: pointer;" shape="circle" coords="873,278,77" data-bs-toggle="modal" data-bs-target="#satisfaccion">            {{-- SATISFACCION --}}
            </map>
        </div>

        @include('partials.mapaModal')

    </div>
</main>
<script src="{{ asset('js/modal.js') }}"></script>
</center>
@endsection

