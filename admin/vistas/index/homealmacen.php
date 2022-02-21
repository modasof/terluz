<!-- Content Wrapper. Contains page content -->
  <?php 

error_reporting(E_ALL);
ini_set('display_errors', '0');

$RolSesion = $_SESSION['IdRol'];
$IdSesion = $_SESSION['IdUser'];
   ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard Almacén
        <small>version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard Almacén</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
       
    
        <div class="col-md-12">
         <div class="box">
            
            <div class="box-body">
              <a class="btn btn-app">
                <i class="fa fa-plus-square "></i> Crear RQ
              </a>
              <a class="btn btn-app">
                <i class="fa fa-users"></i> RQ Usuarios
              </a>
              <a class="btn btn-app">
                <i class="fa fa-list"></i> Categorías
              </a>
               <a class="btn btn-app">
                <i class="fa fa-list"></i> Insumos
              </a>
              <a class="btn btn-app">
                <i class="fa fa-wrench"></i> Servicios
              </a>
              <a class="btn btn-app">
                <i class="fa fa-users"></i> Proveedores
              </a>
                <a class="btn btn-app">
                <i class="fa  fa-cart-plus"></i> Compras
              </a>
              <a class="btn btn-app">
                <span class="badge bg-yellow">3</span>
                <i class="fa fa-dollar"></i> RQ Cotización
              </a>
              <a class="btn btn-app">
                <span class="badge bg-green">300</span>
                <i class="fa fa-file-pdf-o"></i> Cotizaciones
              </a>
               <a class="btn btn-app">
                <i class="fa fa-cubes"></i> Inventario
              </a>
              <a class="btn btn-app">
                <i class="fa fa-sign-in"></i> Entregas Proyectos
              </a>
              <a class="btn btn-app">
                <i class="fa fa-search"></i> Disp. Insumos
              </a>
               
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->