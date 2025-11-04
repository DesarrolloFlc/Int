<!-- Modals -->


{{-- Modals SIG --}}
<div class="modal fade" id="SIG" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Sistema Integrado de Gestión</h1>
                <button id="SIGclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/SIG';
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

                    <div id="SIG{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="SIGclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/SIG/'.$folder;
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
{{-- Fin Modals SIG --}}

{{-- Modals DireccionEstrategica --}}
<div class="modal fade" id="DireccionEstrategica" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Direccion Estrategica</h1>
                <button id="DEclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/DireccionEstrategica';
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

                    <div id="DE{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="DEclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/DireccionEstrategica/'.$folder;
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
{{-- Fin Modals DireccionEstrategica --}}

{{-- Modals GestionComercial --}}
<div class="modal fade" id="GestionComercial" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Comercial</h1>
                <button id="GCclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionComercial';
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

                    <div id="GC{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GCclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionComercial/'.$folder;
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
{{-- Fin Modals GestionComercial --}}

{{-- Modals GestionOperaciones --}}
<div class="modal fade" id="GestionOperaciones" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion de Operaciones</h1>
                <button id="GOclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionOperaciones';
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

                    <div id="GO{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GOclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionOperaciones/'.$folder;
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
{{-- Fin Modals GestionOperaciones --}}

{{-- Modals GestionDocumental --}}
<div class="modal fade" id="GestionDocumental" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Documental</h1>
                <button id="GDclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionDocumental';
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

                    <div id="GD{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GDclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionDocumental/'.$folder;
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
{{-- Fin Modals GestionDocumental --}}

{{-- Modals GestionServicioCliente --}}
<div class="modal fade" id="GestionServicioCliente" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Servicio al Cliente</h1>
                <button id="GSCclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionServicioCliente';
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

                    <div id="GSC{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GSCclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionServicioCliente/'.$folder;
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
{{-- Fin Modals GestionServicioCliente --}}

{{-- Modals GestionHumana --}}
<div class="modal fade" id="GestionHumana" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Humana</h1>
                <button id="GHclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionHumana';
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


                    <div id="GH{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 900px" class="card pt-4">
                        <div class="card-body">
                            <a id="GHclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionHumana/'.$folder;
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
{{-- Fin Modals GestionHumana --}}

{{-- Modals GestionTi --}}
<div class="modal fade" id="GestionTi" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion TI</h1>
                <button id="GTclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionTi';
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

                    <div id="GT{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GTclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionTi/'.$folder;
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
{{-- Fin Modals GestionTi --}}

{{-- Modals GestionAdministrativa - Asistente Administrativa --}}
<div class="modal fade" id="GestionAdministrativaC" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Administrativa - Compras</h1>
                <button id="GACclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionAdministrativa/Compras';
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

                    <div id="GAC{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GACclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionAdministrativa/Compras/'.$folder;
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
{{-- Fin Modals GestionAdministrativa - Asistente Administrativa --}}

{{-- Modals GestionAdministrativa - Compras  --}}
<div class="modal fade" id="GestionAdministrativaF" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Administrativa - Financiera</h1>
                <button id="GAFclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">
                @php
                    $dir = '../public/storage/mapa/GestionAdministrativa/Financiera';
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

                    <div id="GAF{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GAFclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionAdministrativa/Financiera/'.$folder;
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
{{-- Fin Modals GestionAdministrativa - Compras --}}

{{-- Modals GestionAdministrativa - General  --}}
<div class="modal fade" id="GestionAdministrativaGeneral" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Gestion Administrativa</h1>
                <button id="GAGclose" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto position-relative" style="height: 560px">

                    <a type="button" id="Compras" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>Compras</h5>
                        </div>
                    </a>

                    <div id="GAGCCompras" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GAGCclose" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionAdministrativa/Compras';
                                $ruta = '../public/'.$link;
                                $listas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($listas as $folder)
                                <a type="button" id="{{$folder}}" class="container border row my-3">
                                    <div class="col-4">
                                        <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                                    </div>
                                    <div class="col-8 mt-4">
                                        <h5>{{ $folder }}</h5>
                                        <p>{{ count(array_diff(scandir('../public/storage/mapa/GestionAdministrativa/Compras/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                                    </div>
                                </a>

                                <div id="GAGC{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                                    <div class="card-body">
                                        <a id="GAGCclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                                        @php
                                            $link = 'storage/mapa/GestionAdministrativa/Compras/'.$folder;
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

                    <a type="button" id="Financiera" class="container border row my-3">
                        <div class="col-4">
                            <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                        </div>
                        <div class="col-8 mt-4">
                            <h5>Financiera</h5>
                        </div>
                    </a>

                    <div id="GAGFFinanciera" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                        <div class="card-body">
                            <a id="GAGFclose" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                            @php
                                $link = 'storage/mapa/GestionAdministrativa/Financiera';
                                $ruta = '../public/'.$link;
                                $listas = array_diff(scandir($ruta), ['.', '..']);
                            @endphp
                            @foreach ($listas as $folder)
                                <a type="button" id="{{$folder}}" class="container border row my-3">
                                    <div class="col-4">
                                        <img src="{{asset('/storage/carpeta.png')}}" style="width: 100px">
                                    </div>
                                    <div class="col-8 mt-4">
                                        <h5>{{ $folder }}</h5>
                                        <p>{{ count(array_diff(scandir('../public/storage/mapa/GestionAdministrativa/Financiera/'.$folder), ['.', '..'])) }} Archivo(s)</p>
                                    </div>
                                </a>

                                <div id="GAGF{{$folder}}" style="display: none; position: absolute; background-color: white; top: 0; left: 0; right: 0; margin: 0 auto; width: 780px; height: 800px" class="card pt-4">
                                    <div class="card-body">
                                        <a id="GAGFclose{{$folder}}" class="ms-2 fs-5 position-absolute top-0 start-0" href="#"><i class="bi bi-arrow-left-circle-fill"></i> Volver</a>
                                        @php
                                            $link = 'storage/mapa/GestionAdministrativa/Financiera/'.$folder;
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

                {{-- @endforeach                            --}}

            </div>
        </div>
    </div>
</div>
{{-- Fin Modals GestionAdministrativa - General --}}

<!-- Fin Modals -->
