@extends('layouts.plantilla')

@section('title', 'Organigrama')

@section('content')
<link type=text/css href="{{ asset('css/zoomy.css') }}" rel=stylesheet />
<script src="{{ asset('js/zoomy.js') }}"></script>
<main  id="main" class="main">
    <div class="pagetitle">
        <h1>Organigrama</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Organigrama</a></li>
                <li class="breadcrumb-item active">Finleco BPO</li>
            </ol>
        </nav>
    </div>
    <center>
    <div class="w-100 mt-5" id="container">
        <div  class="tab-pane fade shadow rounded bg-white show active p-5 overflow-auto">
            <a href="{{ asset('storage/organigrama.png') }}" class="zoom" ><img src="{{ asset('storage/organigrama.png') }}" style="width: 70vw"></a>
        </div>
    </div>
</main>
</center>
<script defer>
	$(function(){
		$('.zoom').zoomy({
			zoomSize: 300,
			round: true,
			border:'6px solid #fff'
		});
	});
</script>


@endsection

