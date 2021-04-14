    <li class="nav-header">
        <div class="dropdown profile-element">
            @auth 
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              
                <span class="block m-t-xs font-bold">  <img src="{{asset('img/e.png')}}" alt="" width="40">{{auth()->user()->usuario}}</span>
            </a>
            @endauth
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a class="dropdown-item" href="{{route('logout')}}">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="logo-element">
            <img src="{{asset('img/e.png')}}" height="45" width="45">
        </div>
    </li>
    @can('haveaccess','mapaclientedispositivo.index')
    <li>
        <a href="{{route('mapa.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">MAPAS</span></a>
    </li>
    @endcan
    @can('haveaccess','mapacliente.index')
    <li>
        <a href="{{route('mapapp.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Mapa app</span></a>
    </li>
    @endcan
    @can('haveaccess','modulo.gps')
    <li class="@yield('gps-active')">
        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">GPS</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="@yield('clientes-active')"><a href="{{ route('cliente.index') }}">Clientes</a></li>
            <li class="@yield('empresas-active')"><a href="{{ route('empresas.index')}}">Empresas</a></li>
            <li class="@yield('tipodispositivo-active')"><a href="{{ route('tipodispositivo.index')}}">Tipos Dispositivos</a></li>
            <li class="@yield('dispositivo-active')"><a href="{{ route('dispositivo.index')}}">Dispositivos</a></li>
            <li class="@yield('contrato-active')"><a href="{{ route('contrato.index')}}">Contratos</a></li>
            <li class="@yield('reportes-active')"><a href="{{ route('reportes.index')}}">Reportes</a></li>
            <li class="@yield('rango-active')"><a href="{{ route('mapas.rango')}}">Rango Mapa</a></li>
        </ul>
    </li>
    @endcan
    @can('haveaccess','modulo.aplicativo')
        <li class="@yield('aplicativo-active')">
        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Aplicativo</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="@yield('conductores-active')"><a href="{{ route('conductor.index') }}">Conductores</a></li>
            <li class="@yield('vehiculos-active')"><a href="{{ route('vehiculo.index') }}">Vehiculos</a></li>
            <li class="@yield('carreras-active')"><a href="{{ route('carrera.index') }}">Carreras</a></li>
            <li class="@yield('consulta-active')"><a href="{{ route('carrera.consulta') }}">Consulta de Carreras</a></li>
        </ul>
    </li>
    @endcan
    @can('haveaccess','modulo.mantenimiento')
    <li class="@yield('mantenimiento-active')">
        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Mantenimiento</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="@yield('tablas-active')"><a href="{{route('mantenimiento.tabla.general.index')}}">Tablas Generales</a></li>
            <li class="@yield('colaboradores-active')"><a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a></li>
            <li class="@yield('empresa-active')"><a href="{{ route('empresa.index')}}">Empresa Personal</a></li>
            <li class="@yield('mensaje-active')"><a href="{{ route('mensaje.index')}}">Mensaje Personalizado</a></li>
            <li class="@yield('roles-active')"><a href="{{ route('roles.index')}}">Roles</a></li>
            <li class="@yield('usuarios-active')"><a href="{{ route('usuarios.index')}}">Usuario</a></li>
        </ul>
    </li>
    @endcan
    