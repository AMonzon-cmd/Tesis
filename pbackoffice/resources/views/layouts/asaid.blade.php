@php
    $permisosUsuario = Auth::user()->listarPermisos()->toArray();
@endphp

<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <!-- INICIO BARRA USUARIO -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="{{asset('img\images\avatar')}}" alt="" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        {{auth()->user()->nombre}}
                        <small>{{auth()->user()->Rol->nombre}}</small>
                    </div>
                </a>
            </li>
            <li>
                <form action="{{route('CerrarSesion')}}" method="POST">
                    @csrf
                    <ul class="nav nav-profile"> 
                        <li>
                            <a href="javascript:;"><i class="fa fa-question-circle"></i> Ayuda</a>
                        </li>
                        <li>
                            <a onclick="$(this).closest('form').submit();" href="javascript:;"><i class="fas fa-sign-out-alt"></i> Cerrar Sesion</a>
                        </li>                       
                    </ul>
                </form>
            </li>
        </ul>
        <!-- Fin Barra usuario -->

        <ul class="nav"><li class="nav-header">Panel de Administración {{Auth::user()->listarPermisos()}}</li>
            <li class="@yield('menu-dashboard')">
                <a href="{{route('Dashboard')}}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (in_array('alta_empleado', $permisosUsuario) || in_array('listado_empleado', $permisosUsuario) || in_array('listado_clientes', $permisosUsuario))
                <li class="has-sub @yield('menu-usuarios')">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                    <ul class="sub-menu">
                            @if(in_array('alta_empleado', $permisosUsuario))
                                <li class="@yield('link-usuarios-generar')"><a href="{{route('AltaEmpleado')}}">Alta Empleado</a></li>  
                            @endif
                                <li class="@yield('link-usuarios-equipo')"><a href="{{route('ListadoEmpleados')}}">Listado Equipo</a></li>  

                                <li class="@yield('link-usuarios-clientes')"><a href="{{route('ListadoClientes')}}">Listado Clientes</a></li>  
                    </ul>
                </li>
            @endif
                

                
                <li class="has-sub @yield('menu-servicios')">
                    <a href="{{route('ListadoServicios')}}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Servicios</span>
                    </a>
                </li>

                <li class="has-sub @yield('menu-catalogo')">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-book"></i>
                        <span>Productos Catalogo</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@yield('link-catalogo-generar')"><a href="{{route('vistaAltaProducto')}}">Nuevo Producto Catalogo</a></li>              
                        <li class="@yield('link-catalogo-listado')"><a href="{{route('vistaListadoProductos')}}">Listado Catalogo</a></li>     
                    </ul>
                </li>
                {{-- 
                <li class="@yield('menu-mediosDePago')">
                    <a href="">
                        <i class="fas fa-credit-card"></i>
                        <span>Medios de pago</span>
                    </a>
                </li> --}}

                {{-- <li class="@yield('menu-monedas')">
                    <a href="">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Monedas</span>
                    </a>
                </li> --}}


                <li class="@yield('menu-pagos')">
                    <a href="{{route('ListadoPagos')}}">
                        <i class="fas fa-handshake"></i>
                        <span>Pagos realizados</span>
                    </a>
                </li>

                <li class="@yield('menu-configuracion')">
                    <a href="">
                        <i class="fas fa-cogs"></i>
                        <span>Configuracion</span>
                    </a>
                </li>
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>

<div class="sidebar-bg"></div>

<!-- end #sidebar -->