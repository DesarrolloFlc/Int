@extends('layouts.plantilla')

@section('title', 'links')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Links Aplicativos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Links</a></li>
                <li class="breadcrumb-item active">Accesos directos</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-5">
        <div class="row">
            @foreach ($campañas as $campaña)
                @if ($unidad == 'Calidad' && Auth::user()->id_rol == 2 || $unidad == 'Gerencia' || $unidad == 'Tecnologia' || $unidad == 'Coordinadores'
                || $unidad == 'Calidad' && Auth::user()->id_rol == 1 || Auth::user()->id_unidad == 26 )
                    <div class="col-md-4 mb-4">
                        <div class="card bg-c-blue order-card">
                            <div class="card-body">
                                <h2 class="text-center"><img src="{{ asset($campaña->image) }}" style="height: 40px"></h2>
                                <h6 class="m-b-20 mt-3 fw-bold">Enlaces</h6>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Selecciona Enlace
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($links as $link)
                                            @if ($link->campaña_id == $campaña->id)
                                                <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">{{$link->nombre}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::user()->id_rol == 3 && $campaña->id == 17 || Auth::user()->id_rol == 2 && $campaña->id == 17 || Auth::user()->id_unidad == 26 || Auth::user()->id_unidad == 22 && $campaña->id == 15)
                    <div class="col-md-4 mb-4">
                        <div class="card bg-c-blue order-card">
                            <div class="card-body">
                                <h2 class="text-center"><img src="{{ asset($campaña->image) }}" style="height: 40px"></h2>
                                <h6 class="m-b-20 mt-3 fw-bold">Enlaces</h6>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Selecciona Enlace
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($links as $link)
                                            @if ($link->campaña_id == $campaña->id)
                                                <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">{{$link->nombre}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($unidad == 'Asistente Administrativa' && $campaña->id == 11 )
                    <div class="col-md-4 mb-4">
                        <div class="card bg-c-blue order-card">
                            <div class="card-body">
                                <h2 class="text-center"><img src="{{ asset($campaña->image) }}" style="height: 40px"></h2>
                                <h6 class="m-b-20 mt-3 fw-bold">Enlaces</h6>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Selecciona Enlace
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($links as $link)
                                            @if ($link->campaña_id == $campaña->id)
                                                <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">{{$link->nombre}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($unidad == 'Formacion' && $campaña->id != 7)
                    <div class="col-md-4 mb-4">
                        <div class="card bg-c-blue order-card">
                            <div class="card-body">
                                <h2 class="text-center"><img src="{{ asset($campaña->image) }}" style="height: 40px"></h2>
                                <h6 class="m-b-20 mt-3 fw-bold">Enlaces</h6>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Selecciona Enlace
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($links as $link)
                                            @if($link->campaña_id == $campaña->id)
                                                <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">{{$link->nombre}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if ($unidad == $campaña->campaña)
                        <div class="col-md-4 mb-4">
                            <div class="card bg-c-blue order-card">
                                <div class="card-body">
                                    <h2 class="text-center"><img src="{{ asset($campaña->image) }}" style="height: 40px"></h2>
                                    <h6 class="m-b-20 mt-3 fw-bold">Enlaces</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Selecciona Enlace
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach ($links as $link)
                                                @if ($link->campaña_id == $campaña->id)
                                                    <li><a class="dropdown-item" href="{{$link->url}}" target="_blank">{{$link->nombre}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</main>

<style>
    body {
        margin-top: 20px;
        background: #FAFAFA;
    }

    .dropdown-menu {
        max-height: 300px;
        overflow-y: auto;
    }

    .dropdown-toggle {
        background-color: #fff;
        color: #4099ff;
        text-align: left;
        border: none;
    }

    .dropdown-item {
        padding: 8px 12px;
    }

    .dropdown-item:hover {
        background-color: #73b4ff;
    }

    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        border: none;
        margin-bottom: 30px;
    }

    .card-body {
        padding: 25px;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .order-card i {
        font-size: 26px;
    }
</style>

@endsection
