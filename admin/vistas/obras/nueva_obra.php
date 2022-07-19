<?php 
error_reporting(E_ALL);
ini_set('display_errors', '0');

include_once 'controladores/obrasController.php';
include_once 'modelos/obras.php';


$RolSesion = $_SESSION['IdRol'];
$IdSesion = $_SESSION['IdUser'];

 ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
          
            <li class="breadcrumb-item active">Crear Obras</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
    <!-- /.content-header -->
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- CCS Y JS PARA LA CARGA DE IMAGEN -->
<script src="plugins/dropify/dropify.min.js"></script>
<link rel="stylesheet" href="plugins/dropify/dropify.min.css">
<div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Obra
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </h3>

              <div class="box-tools pull-right">
              <!--   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button> -->
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<form role="form" action="?controller=obras&&action=guardarobra" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php  
                date_default_timezone_set("America/Bogota");
                $TiempoActual = date('Y-m-d H:i:s');
                ?>
              
              <input type="hidden" name="marca_temporal" value="<?php echo($TiempoActual); ?>">
              <input type="hidden" name="obra_estado" value="1">
              <input type="hidden" name="creado_por" value="<?php echo($IdSesion); ?>">
              <input type="hidden" name="obra_publicada" value="1">

               
                <div class="card-body">
               
              <div class="row">
                 <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Nombre del Proyecto <small>Máximo 250 carácteres</small></label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="nombre_obra" value="" class="form-control" id="nombre_obra" placeholder="Ingrese el nombre de la obra" maxlength="250" required>
              </div>
                   
                  </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Contrato de Obra Nº</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="contrato_obra" value="" class="form-control" id="contrato_obra" placeholder="Contrato de Obra Nº  172-2021" maxlength="250" required>
              </div>
                   
                  </div>
                  </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Contratante</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="contratante" value="" class="form-control" id="contratante" placeholder="Contratatante" maxlength="250" required>
              </div>
                   
                  </div>
                  </div>

                  <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Interventoria</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="interventoria" value="" class="form-control" id="interventoria" placeholder="Interventoria" maxlength="250" required>
              </div>
                   
                  </div>
                  </div>

                  <div  class="col-md-4">
                        <div class="form-group">
                          <label>Fecha Inicio: <span>*</span></label>
                          <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha" class="form-control required" required>
                        </div>
                </div>
                <div  id="divcajas" class="col-md-4">
                          <div class="form-group">
                              <label for="sel1">Ciudad:<span>*</span></label>
                              <select class="form-control mi-selector"  name="ciudad_id_ciudad" >
                                  <option value="" selected>Seleccionar...</option>
                                <?php
                                  $cajas = Obras::obtenerlistaciudades();
                                  foreach($cajas as $caja){
                                    $id_ciudad = $caja['id_ciudad'];
                                    $nombre_ciudad = $caja['nombre_ciudad'];
                                ?>
                                <option value="<?php echo $id_ciudad; ?>"><?php echo $nombre_ciudad; ?></option>
                                <?php }?>
                              </select>
                          </div>
                  </div>
                   <div  id="divcajas" class="col-md-4">
                          <div class="form-group">
                              <label for="sel1">Proyecto Asignado a: :<span>*</span></label>
                              <select class="form-control mi-selector"  name="usuario_asignado" >
                                  <option value="" selected>Seleccionar...</option>
                                <?php
                                  $cajas = Usuarios::ListaDirectoresObra();
                                  foreach($cajas as $caja){
                                    $id_usuario = $caja['id_usuario'];
                                    $nombre_usuario = $caja['nombre_usuario'];
                                ?>
                                <option value="<?php echo $id_usuario; ?>"><?php echo $nombre_usuario; ?></option>
                                <?php }?>
                              </select>
                          </div>
                        </div>
                 <div class="col-md-12">
                        <div class="form-group">
                          <label for="nombres">Objeto del contrato (Máx 500 Carácteres)</label>
                            <textarea class="form-control" rows="4" name="objeto" id="objeto" placeholder="Ingrese el objeto del contrato" maxlength="500" required></textarea>
                        </div>
                </div>
              </div>
              <div class="card-footer">
                <button name="Submit" type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Siguiente</button>
              </div>
              </div>
              <!-- /.card -->

  </form>
  <hr>
</div>

      </div>
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content-->
</div> <!-- Fin Content-Wrapper -->



