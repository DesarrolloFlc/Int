<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
    .btn-outline-light:hover {
        background-color: #f3f3f3;
        border-color: #f3f3f3;
    }
</style>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('index') }}" class=" d-flex align-items-center">
            <img src="{{asset('/storage/logos/logo.png')}}" alt="" style="height: 40px">
            <span class="d-none d-lg-block ms-2"><img src="{{ asset('/storage/logos/name.png') }}" style="height: 35px"></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="
                        @if(Auth::user()->foto == null)
                            {{ asset('storage/usuarios/usuario.png') }}
                        @else
                            {{ asset(Auth::user()->foto) }}
                        @endif
                    " width="35" height="35" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nombre  }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->nombre }}</h6>
                        {{-- <span>{{ $unidad }}</span> --}}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('perfil') }}">
                            <i class="bi bi-person"></i>
                            <span>Perfil</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="dropdown-item d-flex align-items-center" href="#" onclick="this.closest('form').submit()" name="cerrarSesion">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}">
                <i class="bi bi-grid fs-6"></i>
                <span class="fs-6">Inicio</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-check-square fs-6"></i><span class="fs-6">SIG</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{route('identidad')}}">
                        <i class="bi bi-circle"></i>
                        <span>Identidad Corporativa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mapa') }}">
                        <i class="bi bi-circle"></i>
                        <span>Mapa de Procesos</span>
                    </a>
                </li>
                @if (Auth::user()->id_rol != 4 || Auth::user()->id_unidad == 26)
                    {{-- <li>
                        <a href="{{route('reporte-seguridad')}}">
                            <i class="bi bi-circle"></i>
                            <span>Reporte de Seguridad</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{route('reporte-accidentes')}}">
                            <i class="bi bi-circle"></i>
                            <span>Reporte de Accidentes / Incidentes</span>
                        </a>
                    </li>
                @endif
                    @if (Auth::user()->id_unidad >= 7 && Auth::user()->id_unidad < 18)
                        <li>
                            <a href="{{route('links')}}">
                                <i class="bi bi-circle"></i>
                                <span>Links</span>
                            </a>
                        </li>
                    @elseif(Auth::user()->id_unidad == 1 || Auth::user()->id_unidad == 4)
                        <li>
                            <a href="{{route('links')}}">
                                <i class="bi bi-circle"></i>
                                <span>Links</span>
                            </a>
                        </li>
		    @elseif(Auth::user()->id_unidad == 2 || Auth::user()->id_unidad == 3)
			<li>
			    <a href="{{route('links')}}">
				<i class="bi bi-circle"></i>
				<span>Links</span>
			    </a>
			</li>
                    @elseif(Auth::user()->id_rol == 1)
                        <li>
                            <a href="{{route('links')}}">
                                <i class="bi bi-circle"></i>
                                <span>Links</span>
                            </a>
                        </li>
		    @endif

            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#gh" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people fs-6"></i><span class="fs-6">Gestión Humana</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
        </li>
        <ul id="gh" class="nav-content collapse " data-bs-parent="#sidebar-nav">
	    <li>
		<a href="{{ route('organigrama') }}">
		    <i class="bi bi-circle"></i>
		    <span>Organigrama</span>
		</a>
	    </li>
            <li>
                <a href="{{ route('vista.calendario') }}">
                    <i class="bi bi-circle"></i>
                    <span>Horarios</span>
                </a>
            </li>
            @if (Auth::user()->id_rol != 4)
                @if (Auth::user()->id_unidad == 4 || Auth::user()->id_unidad == 1 || Auth::user()->id_unidad == 2)
                    <li>
                        <a href="{{route('reporte-novedad')}}">
                            <i class="bi bi-circle"></i>
                            <span>Reporte de Novedad</span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
        @if (Auth::user()->id_rol != 4)
            @if (Auth::user()->id_unidad == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administrar-mapa') }}">
                        <i class="bi bi-upload"></i>
                        <span class="fs-6">Cargue de Archivos</span>
                    </a>
                </li>
            @endif
        @endif
        @if (Auth::user()->id_unidad == 4|| Auth::user()->id_rol == 1 )
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrar-mapa') }}">
                    <i class="bi bi-upload"></i>
                    <span class="fs-6">Registro de Usuarios</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->id_rol == 3 || Auth::user()->id_unidad == 7)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrar-mapa') }}">
                    <i class="bi bi-upload"></i>
                    <span class="fs-6">Registro de Links</span>
                </a>
            </li>
        @endif
	    @if(Auth::user()->id_rol == 2 && Auth::user()->id_unidad == 2)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('administrar-mapa') }}">
                    <i class="bi bi-upload"></i>
                    <span class="fs-6">Registro de Links</span>
                </a>
            </li>
        @endif
        {{-- @if(Auth::user()->id_rol == 2 && Auth::user()->id_unidad == 1 || Auth::user()->id_unidad == 4 || Auth::user()->id_unidad == 5 || Auth::user()->id_rol == 1 || Auth::user()->id_unidad == 2 || Auth::user()->id_unidad == 3)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ultrabikes') }}">
                    <i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><style>svg{fill:#0e43a0}</style><path d="M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24h57.7l16.4 30.3L256 192l-45.3-45.3c-12-12-28.3-18.7-45.3-18.7H64c-17.7 0-32 14.3-32 32v32h96c88.4 0 160 71.6 160 160c0 11-1.1 21.7-3.2 32h70.4c-2.1-10.3-3.2-21-3.2-32c0-52.2 25-98.6 63.7-127.8l15.4 28.6C402.4 276.3 384 312 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L418.2 128H480c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32H459.6c-7.5 0-14.7 2.6-20.5 7.4L391.7 78.9l-14-26c-7-12.9-20.5-21-35.2-21H280zM462.7 311.2l28.2 52.2c6.3 11.7 20.9 16 32.5 9.7s16-20.9 9.7-32.5l-28.2-52.2c2.3-.3 4.7-.4 7.1-.4c35.3 0 64 28.7 64 64s-28.7 64-64 64s-64-28.7-64-64c0-15.5 5.5-29.7 14.7-40.8zM187.3 376c-9.5 23.5-32.5 40-59.3 40c-35.3 0-64-28.7-64-64s28.7-64 64-64c26.9 0 49.9 16.5 59.3 40h66.4C242.5 268.8 190.5 224 128 224C57.3 224 0 281.3 0 352s57.3 128 128 128c62.5 0 114.5-44.8 125.8-104H187.3zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg></i>
                    <span class="ml-10 fs-6">Ultrabikes</span>
                </a>
            </li>
        @endif --}}

        {{-- @if(Auth::user()->id_rol == 3 && Auth::user()->id_unidad == 17 || Auth::user()->id_rol == 4 && Auth::user()->id_unidad == 17 || Auth::user()->id_rol == 1 )
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#unne" data-bs-toggle="collapse" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suitcase-lg" viewBox="0 0 16 16">
                        <path d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3zM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5m-3 .5V3H4v10z"/>
                      </svg><span class="ml-10 fs-6">&nbsp;&nbsp;&nbsp;Unidades de negocios</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
            </li>
            <ul id="unne" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
            <a href="{{ route('mintic') }}">
                <i class="bi bi-circle"></i>
                <span>Mintic</span>
            </a>
            </li>

        @endif --}}
    </ul>
</aside>
