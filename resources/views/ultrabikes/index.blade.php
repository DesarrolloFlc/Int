
@extends('layouts.plantilla')

@section('title', 'Ultrabikes')

@section('content')

<main id="main" class="main" >
    <div class="pagetitle">
        <h1>Gestor de Archivos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Gestor de Archivos</a></li>
                <li class="breadcrumb-item active">Ultrabikes</li>
            </ol>
        </nav>
    </div>

    <div  class="tab-pane fade shadow rounded bg-white show active p-5">
        <div class="container mt-5">
            <div class="row">

                <div class="col-md-4 col-xl-3" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#GestionHumana">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block overflow-auto">
                            <h2 class="text-center"><img src="{{ asset('storage/clientes/GestionHumana.png') }}" style="height: 40px"></h2>
                            <h6 class="m-b-20 mt-3 fw-bold text-center">Gestión Humana</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Compras">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block overflow-auto">
                            <h2 class="text-center"><img src="{{ asset('storage/clientes/compras.png') }}" style="height: 40px"></h2>
                            <h6 class="m-b-20 mt-3 fw-bold text-center">Compras</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#Ventas">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block overflow-auto">
                            <h2 class="text-center"><img src="{{ asset('storage/clientes/ventas.png') }}" style="height: 40px"></h2>
                            <h6 class="m-b-20 mt-3 fw-bold text-center">Ventas</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#Calidad">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block overflow-auto">
                            <h2 class="text-center"><img src="{{ asset('storage/clientes/calidad.png') }}" style="height: 40px"></h2>
                            <h6 class="m-b-20 mt-3 fw-bold text-center">Calidad</h6>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    @include('partials.modalUltrabikes')

</main>

<script src="{{ asset('js/ultrabikes.js') }}"></script>

<style>
    body{
    margin-top:20px;
    background:#FAFAFA;
    }
    .order-card {
        color: #fff;
    }

    .bg-c-blue {
        background: linear-gradient(45deg, #4099ff,#73b4ff);
    }

    .bg-c-green {
        background: linear-gradient(45deg,#4099ff,#73b4ff);
    }

    .bg-c-yellow {
        background: linear-gradient(45deg,#4099ff,#73b4ff);
    }

    .bg-c-pink {
        background: linear-gradient(45deg,#4099ff,#73b4ff);
    }


    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
        border: none;
        margin-bottom: 30px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .card .card-block {
        padding: 25px;
    }

    .order-card i {
        font-size: 26px;
    }

    .f-left {
        float: left;
    }

    .f-right {
        float: right;
    }
</style>

@endsection
