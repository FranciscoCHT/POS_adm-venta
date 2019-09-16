
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VendeYaPOS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    <!-- Bootstrap select  complemento   -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('inicio') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>VY</b>P</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>VendeYAPOS</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">{{Auth::user()->nombre}}        {{Auth::user()->apellido }}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="{{url('logout')}}" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <li>
              <a href="{{url('venta/nuevo')}}">
                <i class="fa fa-circle-o text-red">
                </i>
                <span>Punto Venta
                </span>
              </a>
            <li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Caja</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/caja_inicio_cierre/create') }}"><i class="fa fa-plus"></i>Apertura Caja</a></li>
                <li><a href="{{ url('local/caja_inicio_cierre') }}"><i class="fa fa-check"></i>Lista Aperturas</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Negocio</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/categoria') }}"><i class="fa fa-sitemap"></i>Categorías</a></li>
                <li><a href="{{ url('local/producto') }}"><i class="fa fa-cube"></i>Productos</a></li>
                <li><a href="{{ url('local/estadistica/importar') }}"><i class="fa fa-search"></i>Importar Productos</a></li>
                <li><a href="{{ url('local/estadistica/importar_categoria') }}"><i class="fa fa-search"></i>Importar Categorias</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/compra') }}"><i class="fa fa-truck"></i> Insumo</a></li>
                <li><a href="{{ url('local/proveedor') }}"><i class="fa fa-group"></i> Proveedores</a></li>
                <li><a href="{{ url('local/detalle_compra') }}"><i class="fa fa-search"></i> Consultar Producto</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/venta')}}"><i class="fa fa-circle-o"></i> Ventas</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Estadistica</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               
                <li><a href="{{ url('local/estadistica/compra') }}"><i class="fa fa-search"></i> Compras</a></li>
                <!--
                <li><a href="{{ url('local/estadistica/venta') }}"><i class="fa fa-search"></i> Ventas</a></li>
                -->
              </ul>
            </li>      
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sign-in"></i> <span>Empresa</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/usuario') }}"><i class="fa fa-user"></i> Usuarios</a></li>
                <li><a href="{{ url('local/empresa') }}"><i class="fa fa-user"></i> Datos Empresa</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Ingreso - Egreso Agil</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ url('local/add-stock')}}"><i class="fa fa-circle-o"></i> Agregar Stock</a></li>
                <li><a href="{{ url('local/egreso')}}"><i class="fa fa-circle-o"></i> Egresos</a></li>
              </ul>
            </li>
             <!--<li>
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Reportes</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>-->            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Administración</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  	<div class="row">
	                  	<div class="col-md-12">
		                          <!--Contenido-->
                              @yield('contenido')
		                          <!--Fin Contenido-->
                           </div>
                        </div>
                  		</div>
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright @Waliex 2019 <a href="www.waliex.cl">Waliex</a>.</strong>
      </footer>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    @stack('scripts')
    @stack('scriptsForm')

    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="{{asset('plugins/chartjs/Chart.min.js')}}"></script>
    
  </body>
</html>
