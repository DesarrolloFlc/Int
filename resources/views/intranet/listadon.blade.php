@extends('layouts.plantilla')

@section('title', 'listado')

@section('content')

    <link rel="stylesheet" href="{{ asset('/css/listado.css') }}">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Listado Novedades</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tabla</a></li>
                    <li class="breadcrumb-item active">Información</li>                
                </ol>
            </nav>
        </div>
        <div class="container">
            <div class="mx-auto">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">                        
                            <div class="col-sm-9 col-xs-12 text-right">
                                <div class="btn_group">
                                    <form>      
                                        <input class="form-control" id="searchTerm" type="text" onkeyup="doSearch()" placeholder="Buscar"/>
                                        {{-- <button class="btn btn-default" title="Decargar en Excel"><i class="bi bi-file-earmark-spreadsheet-fill"></i></button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table" id="datos">
                            <thead>
                                <tr>                                
                                    <th>Fecha</th>
                                    <th>Lugar</th>
                                    <th>Colaborador</th>
                                    <th>Observaciones</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos as $dato )
                                <tr>                            
                                    <td>{{$dato->fecha}}</td>
                                    <td>{{$dato->lugar}}</td>
                                    <td>{{$dato->colaborador}}</td>
                                    <td>{{$dato->observaciones}}</td>
                                </tr>
                                @endforeach                                                                 
                                <tr class='noSearch hide'>
                                    <td colspan="5"></td>                        
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </main>
    <script>
        function doSearch(){

            const tableReg = document.getElementById('datos');
            const searchText = document.getElementById('searchTerm').value.toLowerCase();
            let total = 0;

            for (let i = 1; i < tableReg.rows.length; i++) {

                if (tableReg.rows[i].classList.contains("noSearch")) {
                    continue;
                }

                let found = false;
                const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');

                // Recorre las celdas

                for (let j = 0; j < cellsOfRow.length && !found; j++) {
                    const compareWith = cellsOfRow[j].innerHTML.toLowerCase();

                    if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                        found = true;
                        total++;
                    }
                }

                if (found) {
                    tableReg.rows[i].style.display = '';
                } else {
                    tableReg.rows[i].style.display = 'none';
                }
            }

            // mostrar coincidencias

            const lastTR=tableReg.rows[tableReg.rows.length-1];
            const td=lastTR.querySelector("td");
            lastTR.classList.remove("hide", "red");

            if (searchText == "") {
                lastTR.classList.add("hide");
            } else if (total) {
                td.innerHTML="Se ha encontrado "+total+" coincidencia"+((total>1)?"s":"");
            } else {
                lastTR.classList.add("red");
                td.innerHTML="No se han encontrado coincidencias";
            }
        }
    </script>
@endsection