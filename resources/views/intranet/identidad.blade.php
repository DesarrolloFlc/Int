@extends('layouts.plantilla')

@section('title', 'Identidad Corporativa')

<body style="background-image: url({{ asset('/storage/fondo.png') }})">
@section('content')

<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
<style>
   .nav-pills {
        --bs-nav-pills-border-radius: 0.375rem;
        --bs-nav-pills-link-active-color: #fff;
        --bs-nav-pills-link-active-bg: #ff8800;
    }

   .nav-pills .nav-link{
 	background: #f6f9ff;
   }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Identidad Corporativa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Identidad Corporativa</a></li>
                <li class="breadcrumb-item active">Directrices Estratégicas</li>
            </ol>
        </nav>
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-4 p-4 shadow active" id="quienes-tab" data-bs-toggle="pill" href="#quienes" role="tab" aria-controls="quienes" aria-selected="true">
                        <i class="bi bi-people-fill"></i>
                        <span class="font-weight-bold small text-uppercase" style="margin-left: 15px">¿Quiénes Somos?</span>
                    </a>
                    <a class="nav-link mb-4 p-4 shadow" id="mision-tab" data-bs-toggle="pill" href="#mision" role="tab" aria-controls="mision" aria-selected="false">
                        <i class="bi bi-flag"></i>
                        <span class="font-weight-bold small text-uppercase" style="margin-left: 15px">Misión</span>
                    </a>
                    <a class="nav-link mb-4 p-4 shadow" id="vision-tab" data-bs-toggle="pill" href="#vision" role="tab" aria-controls="vision" aria-selected="false">
                        <i class="bi bi-eye"></i>
                        <span class="font-weight-bold small text-uppercase" style="margin-left: 15px">Visión</span>
                    </a>
                    <a class="nav-link mb-4 p-4 shadow" id="proposito-tab" data-bs-toggle="pill" href="#proposito" role="tab" aria-controls="proposito" aria-selected="false">
                        <i class="bi bi-bullseye"></i>
                        <span class="font-weight-bold small text-uppercase" style="margin-left: 15px">Propósito Central</span>
                    </a>
                    <a class="nav-link mb-4 p-4 shadow" id="sig-tab" data-bs-toggle="pill" href="#sig" role="tab" aria-controls="sig" aria-selected="false">
                        <i class="bi bi-bullseye"></i>
                        <span class="font-weight-bold small text-uppercase" style="margin-left: 15px">Política del Sistema Integrado de Gestión</span>
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded bg-white show active p-5 mx-5 overflow-auto" id="quienes" role="tabpanel" aria-labelledby="quienes-tab" style="height: 480px; text-align: justify; text-justify: auto;">
                        <h4 class="font-italic mb-4">¿Quiénes somos?</h4>
                        <p class="font-italic text-muted">{{ $somos }}</p>
                    </div>
                    <div class="tab-pane fade shadow rounded bg-white p-5 mx-5 overflow-auto" id="mision" role="tabpanel" aria-labelledby="mision-tab" style="height: 480px; text-align: justify; text-justify: auto;">
                        <h4 class="font-italic mb-4">Misión</h4>
                        <p class="font-italic text-muted">{{ $mision }}</p>
                    </div>
                    <div class="tab-pane fade shadow rounded bg-white p-5 mx-5 overflow-auto" id="vision" role="tabpanel" aria-labelledby="vision-tab" style="height: 480px; text-align: justify; text-justify: auto">
                        <h4 class="font-italic mb-4">Visión</h4>
                        <p class="font-italic text-muted">{{ $vision }}</p>
                    </div>
                    <div class="tab-pane fade shadow rounded bg-white p-5 mx-5 overflow-auto" id="proposito" role="tabpanel" aria-labelledby="proposito-tab" style="height: 480px; text-align: justify; text-justify: auto">
                        <h4 class="font-italic mb-4">Propósito Central</h4>
                        <p class="font-italix text-muted">{{ $proposito }}</p>
                    </div>
                    <div class="tab-pane fade shadow rounded bg-white p-5 mx-5 overflow-auto" id="sig" role="tabpanel" aria-labelledby="sig-tab" style="height: 480px; text-align: justify; text-justify: auto">
                        <h4 class="font-italic mb-4">Política del Sistema Integrado de Gestión</h4>
                        <p class="font-italix text-muted">{{ $sig }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
</body>
