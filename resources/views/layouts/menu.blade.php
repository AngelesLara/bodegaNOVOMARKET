<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Bienvenido:  {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a id="logoutButton" href="#" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">NOVO MARKET</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @can(['usuarios.index', 'formas-pago.index', 'compania.update'])
                <li
                    class="dropdown {{ Route::is('usuarios.index') || Route::is('formas.index') || Route::is('compania.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-cogs"></i>
                        <span>Administración</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('usuarios.index')
                            <li><a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        @endcan
                        @can('formas-pago.index')
                            <li><a class="nav-link" href="{{ route('formas.index') }}">Forma pagos</a></li>
                        @endcan
                        @can('compania.update')
                            <li><a class="nav-link" href="{{ route('compania.index') }}">Compania</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan


            @can('clientes.index')
                <li class="{{ Route::is('clientes.index') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('clientes.index') }}"><i class="fas fa-users"></i>
                        <span>Clientes</span></a>
                </li>
            @endcan

            @can('proveedores.index')
                <li class="{{ Route::is('proveedores.index') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('proveedores.index') }}"><i class="fas fa-truck"></i>
                        <span>Proveedores</span></a>
                </li>
            @endcan

            @can(['cajas.index', 'movimientos.index', 'gastos.index'])
                <li
                    class="dropdown {{ Route::is('cajas.index') || Route::is('gastos.index') || Route::is('movimientos.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i>
                        <span>Cajas</span></a>
                    <ul class="dropdown-menu">
                        @can('cajas.index')
                            <li><a class="nav-link" href="{{ route('cajas.index') }}">Apertura y Cierre</a></li>
                        @endcan
                        @can('gastos.index')
                            <li><a class="nav-link" href="{{ route('gastos.index') }}">Gastos</a></li>
                        @endcan
                        @can('movimientos.index')
                            <li><a class="nav-link" href="{{ route('movimientos.index') }}">Movimientos</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan


            @can(['categorias.index', 'productos.index'])
                <li class="dropdown {{ Route::is('categorias.index') || Route::is('productos.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                        <span>Artículos</span></a>
                    <ul class="dropdown-menu">
                        @can('categorias.index')
                            <li><a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a></li>
                        @endcan
                        @can('productos.index')
                            <li><a class="nav-link" href="{{ route('productos.index') }}">Productos</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can(['venta.index', 'venta.show', 'creditoventa.index'])
                <li
                    class="dropdown {{ Route::is('venta.index') || Route::is('venta.show') || Route::is('creditoventa.index') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i>
                        <span>Ventas</span></a>
                    <ul class="dropdown-menu">
                        @can('venta.index')
                            <li><a class="nav-link" href="{{ route('venta.index') }}">Nueva venta</a></li>
                        @endcan
                        @can('venta.show')
                            <li><a class="nav-link" href="{{ route('venta.show') }}">Listar ventas</a></li>
                        @endcan
                        @can('creditoventa.index')
                            <li><a class="nav-link" href="{{ route('creditoventa.index') }}">Administrar Créditos</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can(['cotizacion.index', 'cotizacion.show'])
                <li class="dropdown {{ Route::is('cotizacion.index') || Route::is('cotizacion.show') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-list"></i>
                        <span>Cotizaciones</span></a>
                    <ul class="dropdown-menu">
                        @can('cotizacion.index')
                            <li><a href="{{ route('cotizacion.index') }}">Nueva cotización</a></li>
                        @endcan
                        @can('cotizacion.show')
                            <li><a href="{{ route('cotizacion.show') }}">Listar cotizaciones</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can(['compra.index', 'compra.show'])
                <li class="dropdown {{ Route::is('compra.index') || Route::is('compra.show') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i>
                        <span>Compras</span></a>
                    <ul class="dropdown-menu">
                        @can('compra.index')
                            <li><a class="nav-link" href="{{ route('compra.index') }}">Nueva compra</a></li>
                        @endcan
                        @can('compra.show')
                            <li><a class="nav-link" href="{{ route('compra.show') }}">Listar compras</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

        </ul>

    </aside>
</div>
