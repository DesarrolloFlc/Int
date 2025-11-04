{{-- Inicio Modal Gesion Humana --}}
<div class="modal fade" id="GestionHumana" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestión Humana</h1>
                <button id="GestionHumanaclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/ultrabikes/GestionHumana';
                    $listas = array_diff(scandir($dir), ['.', '..']);
                @endphp
                @foreach ($listas as $folder)

                    <a type="button" id="{{$folder}}" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>{{ $folder }}</h5>
                            <p>{{ count(array_diff(scandir($dir.'/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                        </div>
                    </a>

                    <div id="GestionHumana{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GestionHumanaclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/ultrabikes/GestionHumana/'.$folder;
                                $ruta = '../public/'.$link;
                                $rutas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($rutas as $r)
                                @php
                                    $ext = pathinfo($link.'/'.$r, PATHINFO_EXTENSION);
                                @endphp
                                <div class="row border my-3 text-center" style="height: 130px">
                                    <div class="col-3">
                                        @if ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlx' || $ext == 'xlsm')
                                            <img src="{{asset('/storage/xlsx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pdf')
                                            <img src="{{asset('/storage/pdf.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pptx')
                                            <img src="{{asset('/storage/pptx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'docx' || $ext == 'doc')
                                            <img src="{{asset('/storage/docx.png')}}" class="my-4" style="height: 80px">
					@elseif($ext == 'png')
					    <img src="{{asset('/storage/png.png')}}" class="my-4" style="height: 80px">
                                        @endif
                                    </div>
                                    <div class="col my-4">
                                        <h5>{{ $r }}</h5>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" target="_blank"><button class="btn"><i class="bi bi-search text-primary-emphasis fs-3"></i></button></a>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" download><button class="btn"><i class="bi bi-download text-success-emphasis fs-3"></i></button></a>
                                        @if (Auth::user()->id_unidad == 1)
                                            <form action="{{ route('eliminar.carpeta', $r) }}" method="POST" class="btn">
                                                @csrf
                                                <a href="#" onclick="this.closest('form').submit"><button class="btn"><i class="bi bi-trash text-danger fs-3"></i></button></a>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
{{-- Final Modal Gestion Humana --}}

{{-- Inicio Modal Compras --}}
<div class="modal fade" id="Compras" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Compras</h1>
                <button id="Comprasclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/ultrabikes/Compras';
                    $listas = array_diff(scandir($dir), ['.', '..']);
                @endphp
                @foreach ($listas as $folder)

                    <a type="button" id="{{$folder}}" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>{{ $folder }}</h5>
                            <p>{{ count(array_diff(scandir($dir.'/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                        </div>
                    </a>

                    <div id="Compras{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="Comprasclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/ultrabikes/Compras/'.$folder;
                                $ruta = '../public/'.$link;
                                $rutas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($rutas as $r)
                                @php
                                    $ext = pathinfo($link.'/'.$r, PATHINFO_EXTENSION);
                                @endphp
                                <div class="row border my-3 text-center" style="height: 130px">
                                    <div class="col-3">
                                        @if ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlx' || $ext == 'xlsm')
                                            <img src="{{asset('/storage/xlsx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pdf')
                                            <img src="{{asset('/storage/pdf.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pptx')
                                            <img src="{{asset('/storage/pptx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'docx' || $ext == 'doc')
                                            <img src="{{asset('/storage/docx.png')}}" class="my-4" style="height: 80px">
                                        @endif
                                    </div>
                                    <div class="col my-4">
                                        <h5>{{ $r }}</h5>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" target="_blank"><button class="btn"><i class="bi bi-search text-primary-emphasis fs-3"></i></button></a>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" download><button class="btn"><i class="bi bi-download text-success-emphasis fs-3"></i></button></a>
                                        @if (Auth::user()->id_unidad == 1)
                                            <form action="{{ route('eliminar.carpeta', $r) }}" method="POST" class="btn">
                                                @csrf
                                                <a href="#" onclick="this.closest('form').submit"><button class="btn"><i class="bi bi-trash text-danger fs-3"></i></button></a>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
{{-- Final Modal Compras --}}

{{-- Inicio Modal Ventas --}}
<div class="modal fade" id="Ventas" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Ventas</h1>
                <button id="Ventasclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/ultrabikes/Ventas';
                    $listas = array_diff(scandir($dir), ['.', '..']);
                @endphp
                @foreach ($listas as $folder)

                    <a type="button" id="{{$folder}}" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>{{ $folder }}</h5>
                            <p>{{ count(array_diff(scandir($dir.'/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                        </div>
                    </a>

                    <div id="Ventas{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="Ventasclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/ultrabikes/Ventas/'.$folder;
                                $ruta = '../public/'.$link;
                                $rutas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($rutas as $r)
                                @php
                                    $ext = pathinfo($link.'/'.$r, PATHINFO_EXTENSION);
                                @endphp
                                <div class="row border my-3 text-center" style="height: 130px">
                                    <div class="col-3">
                                        @if ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlx' || $ext == 'xlsm')
                                            <img src="{{asset('/storage/xlsx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pdf')
                                            <img src="{{asset('/storage/pdf.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pptx')
                                            <img src="{{asset('/storage/pptx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'docx' || $ext == 'doc')
                                            <img src="{{asset('/storage/docx.png')}}" class="my-4" style="height: 80px">
                                        @endif
                                    </div>
                                    <div class="col my-4">
                                        <h5>{{ $r }}</h5>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" target="_blank"><button class="btn"><i class="bi bi-search text-primary-emphasis fs-3"></i></button></a>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" download><button class="btn"><i class="bi bi-download text-success-emphasis fs-3"></i></button></a>
                                        @if (Auth::user()->id_unidad == 1)
                                            <form action="{{ route('eliminar.carpeta', $r) }}" method="POST" class="btn">
                                                @csrf
                                                <a href="#" onclick="this.closest('form').submit"><button class="btn"><i class="bi bi-trash text-danger fs-3"></i></button></a>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
{{-- Final Modal Ventas --}}

{{-- Inicio Modal Calidad--}}
<div class="modal fade" id="Calidad" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Calidad</h1>
                <button id="Calidadclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/ultrabikes/Calidad';
                    $listas = array_diff(scandir($dir), ['.', '..']);
                @endphp
                @foreach ($listas as $folder)

                    <a type="button" id="{{$folder}}" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>{{ $folder }}</h5>
                            <p>{{ count(array_diff(scandir($dir.'/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                        </div>
                    </a>

                    <div id="Calidad{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="Calidadclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/ultrabikes/Calidad/'.$folder;
                                $ruta = '../public/'.$link;
                                $rutas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($rutas as $r)
                                @php
                                    $ext = pathinfo($link.'/'.$r, PATHINFO_EXTENSION);
                                @endphp
                                <div class="row border my-3 text-center" style="height: 130px">
                                    <div class="col-3">
                                        @if ($ext == 'xlsx' || $ext == 'xls' || $ext == 'xlx' || $ext == 'xlsm')
                                            <img src="{{asset('/storage/xlsx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pdf')
                                            <img src="{{asset('/storage/pdf.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'pptx')
                                            <img src="{{asset('/storage/pptx.png')}}" class="my-4" style="height: 80px">
                                        @elseif($ext == 'docx' || $ext == 'doc')
                                            <img src="{{asset('/storage/docx.png')}}" class="my-4" style="height: 80px">
					@elseif($ext == 'png')
					    <img src="{{asset('/storage/png.png')}}" class="my-4" style="height: 80px">
                                        @endif
                                    </div>
                                    <div class="col my-4">
                                        <h5>{{ $r }}</h5>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" target="_blank"><button class="btn"><i class="bi bi-search text-primary-emphasis fs-3"></i></button></a>
                                        <a class="btn" href="{{asset($link.'/'.$r)}}" download><button class="btn"><i class="bi bi-download text-success-emphasis fs-3"></i></button></a>
                                        @if (Auth::user()->id_unidad == 1)
                                            <form action="{{ route('eliminar.carpeta', $r) }}" method="POST" class="btn">
                                                @csrf
                                                <a href="#" onclick="this.closest('form').submit"><button class="btn"><i class="bi bi-trash text-danger fs-3"></i></button></a>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
{{-- Final Modal Calidad --}}
