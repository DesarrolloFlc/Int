@extends('layouts.plantilla')

@section('title', 'Perfil')
    
@section('content')
    
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Perfil</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Perfil</a></li>
                    <li class="breadcrumb-item active">Datos</li>
                </ol>
            </nav>
    
        </div>


        <section class="section dashboard">
            <div id="container" class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
    
                        <div class="card">
                            <div class="card-body">
                                <div class="card m-5 mx-auto" style="width: 18rem;">
                                    <div class="card-body text-center my-4">
                                        <img src="
                                        @if(Auth::user()->foto == null)
                                            {{ asset('storage/usuarios/usuario.png') }}
                                        @else
                                            {{ asset(Auth::user()->foto) }}
                                        @endif
                                    " width="150" height="150" class="rounded-circle">
                                        <h5 class="card-title">{{ Auth::user()->nombre }}</h5>
                                        <p class="card-text">{{ Auth::user()->cedula }}</p>
                                        <p class="card-text">{{ $unidad }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection