<?php
ini_set('display_errors', '0');
include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'modelos/rangos.php';
include_once 'controladores/rangosController.php';

include_once 'modelos/listame.php';
include_once 'controladores/listameController.php';

include_once 'modelos/insumos.php';
include_once 'controladores/insumosController.php';

include_once 'modelos/proyeccioneslme.php';
include_once 'controladores/proyeccioneslmeController.php';

include_once 'modelos/proyeccioneslmo.php';
include_once 'controladores/proyeccioneslmoController.php';

include_once 'modelos/proyeccionesins.php';
include_once 'controladores/proyeccionesinsController.php';

include_once 'modelos/proyeccionesadm.php';
include_once 'controladores/proyeccionesadmController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

$getobra     = $_GET['id_obra'];
$nombre_obra = Obras::obtenernombreobra($getobra);
$valororiginal       = Valorinicialobra($getobra);
$valoravance         = Obras::sqlavancesporobra($getobra);
$valormayores        = Obras::sqlvalormayoresporobra($getobra);
$valormenores        = Obras::sqlvalormenoresporobra($getobra);
$valormodificaciones = $valormayores - $valormenores;

$inicioobra = rangominimo($getobra);
$finalobra  = rangomaximo($getobra);

if ($valormodificaciones < 0) {
    $valorfinalobra = $valororiginal + $valormodificaciones;
} else {
    $valorfinalobra = $valororiginal + $valormodificaciones;
}

$comisionlegal = $valorfinalobra * 0.001;

$valorproyecciontotal = Obras::sqlvalorproyectadoporobra($getobra);

$dia_actual=date('Y-m-d');
$anorangoactual=date('Y');
$mesrangoactual=date('m');
$mesanteriorrangoactual=date('m')-1;
$diarangoactual=date('d');

$totaldiasrangoactual = date('t',$mesrangoactual);
$totaldiasmesanterior = date('t',$mesanteriorrangoactual);

$fechainiciorangoactual = ($anorangoactual."-".$mesrangoactual."-01");
$fechafinrangoactual = ($anorangoactual."-".$mesrangoactual."-".$totaldiasrangoactual);


$fechainiciomesanterior = ($anorangoactual."-".$mesanteriorrangoactual."-01");
$fechafinmesanterior = ($anorangoactual."-".$mesanteriorrangoactual."-".$totaldiasmesanterior);

// Consultamos el id del rango del mes actual
$idrangoactual = Obras::sqlidrango($getobra,$fechainiciorangoactual,$fechafinrangoactual);
$valorproyectadorangoactual = Obras::sqlvalorrangoporobra($getobra, $idrangoactual);
$valorpordia = $valorproyectadorangoactual/$totaldiasrangoactual;

$totalproyeccionmes = $valorpordia*$diarangoactual;

?>

<?php
$campos = Rangos::obtenerRangosporfecha($id,$inicioobra,$fechafinmesanterior);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Proyecciones_Fila1_id           = $campo['id'];
    $Proyecciones_Fila1_mes_numero   = $campo['mes_numero'];
    $Proyecciones_Fila1_fecha_inicio = $campo['fecha_inicio'];
    $Proyecciones_Fila1_fecha_fin    = $campo['fecha_fin'];

    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Proyecciones_Fila1_id);
    $sumaproyeccionmesanterior +=$valorproyectadorango;

}

$proyectadoalafecha = $totalproyeccionmes+$sumaproyeccionmesanterior;
$valorejecutadoalafecha  = Valorejecutadoporrango($getobra, $inicioobra, $dia_actual);

if($proyectadoalafecha!=0){

    $porcentajeproyectadoalafecha = formulaporcentaje($proyectadoalafecha,$valorfinalobra);
}else{
    $porcentajeproyectadoalafecha =0;
}

if($valorejecutadoalafecha!=0){

    $porcentajeejecutadoalafecha = formulaporcentaje($valorejecutadoalafecha,$valorfinalobra);
}else{
    $porcentajeejecutadoalafecha =0;
}

if ($porcentajeejecutadoalafecha<$porcentajeproyectadoalafecha){

    $diferencia=$porcentajeproyectadoalafecha-$porcentajeejecutadoalafecha;

    $estadodelaobra="<br>La obra presenta un <strong class='text-danger'>".round($diferencia,2)."% de atrazo</strong> con relación al cronograma";
}else{

     $diferencia=$porcentajeejecutadoalafecha-$porcentajeproyectadoalafecha;

    $estadodelaobra="<br>La obra presenta un <strong class='text-success'>".round($diferencia,2)."% de avance favorable</strong> con relación al cronograma";
}


    ?>



<!-- DataTables -->
  <!-- <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap4.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector0').select2();
    });
});
</script>
<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
     <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=obras&&action=dashboard">Volver a Obras</a>

        </small>
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="col-md-7">

<div class="box box-widget widget-user">

<div class="widget-user-header bg-aqua-active">
<h3 class="widget-user-username"><strong>Obra : <?php echo utf8_decode($nombre_obra); ?></strong></h3>
<h5 class="widget-user-desc">Tiempo proyectado para la ejecución :<strong><?php $totaldias = tiempoTranscurridoFechas($inicioobra,$finalobra); echo($totaldias)?> </strong>, iniciando el <?php echo($inicioobra); ?> terminando el día <?php echo($finalobra); ?> <br>
<?php echo ($estadodelaobra); ?>
</h5>
</div>
<div class="box-footer">
<div class="row">
<div class="col-sm-4 border-right">
<div class="description-block">
<h5 class="description-header"><?php echo ("$".number_format($valorfinalobra,0)) ?></h5>
<span class="description-text"><strong>Valor Total Obra</strong></span>
</div>

</div>

<div class="col-sm-4 border-right">
<div class="description-block">
<h5 class="description-header"><?php echo ("$".number_format($proyectadoalafecha,0)) ?> <span class="pull-right badge bg-red"><?php echo (round($porcentajeproyectadoalafecha,2)); ?>%</span></h5>
<span class="description-text"><strong>Vr. Proyectado al <?php echo($dia_actual); ?></strong></span>
</div>

</div>

<div class="col-sm-4">
<div class="description-block">
<h5 class="description-header"><?php echo ("$".number_format($valorejecutadoalafecha,0)) ?> <span class="pull-right badge bg-red"><?php echo (round($porcentajeejecutadoalafecha,2)) ?>%</span></h5>
<span class="description-text"><strong>Vr. Ejecutado al <?php echo($dia_actual); ?></strong></span>
</div>

</div>

</div>

</div>
</div>

</div>
     <div class="box-header with-border">
<a data-toggle="modal" data-target="#modal-form1" href="#"  class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-square"></i> Agregar Rango</a>
<button id="oculto" class="btn btn-info btn-sm pull-right">Ocultar Rangos</button>
<button id="mostrar" class="btn btn-info btn-sm pull-right" >Mostrar Rangos</button>



    <div class="container-fluid">
      <div class="row">
    <div style="display: none;" id="tablarangos" class="col-md-6">

      <div class="box">
<div class="box-header">
<h3 class="box-title">Tabla de Rangos</h3>
</div>

<div class="box-body no-padding">
<table class="table table-striped">
<tbody>
  <tr>
    <th>#</th>
    <th>Rango</th>
    <th>Fecha Inicio</th>
    <th>Fecha Final</th>
</tr>

 <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id           = $campo['id'];
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
<form role="form" autocomplete="off" action="?controller=rangos&&action=actualizar&id_obra=<?php echo ($getobra); ?>&&id=<?php echo ($id); ?>" method="POST" enctype="multipart/form-data" >
<tr>
   <td>
        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
        <a href="#" onclick="eliminar(<?php echo $id; ?>,<?php echo $getobra; ?>)" class="pull-right tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                <i class="fa fa-trash bigger-110 "></i>
      </a>
    </td>
      <td><?php echo utf8_decode("Rango-" . $mes_numero); ?></td>
      <td>
         <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Final" class="form-control required" required value="<?php echo utf8_decode($fecha_inicio); ?>">
      </td>
      <td>
         <input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final" class="form-control required" required value="<?php echo utf8_decode($fecha_fin); ?>">
      </td>

</tr>
</form>
<?php }?>
</tbody></table>
</div>

</div>


    </div>


    <div class="col-lg-12">

    <div class="card card-default">
      <div class="card-body">


      <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>

                    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table display-compact table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">

          <thead>
            <tr style="background-color: #4f5962;color: white;">

              <th>Proyecciones</th>
          <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id           = $campo['id'];
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];

    echo ("<th>Rango-" . $mes_numero . "</th>");
    echo ("<th>Inc %</th>");
}
?>
            </tr>

          </thead>
          <tbody>

            <tr class="success">
            <td><strong>Ingresos</strong> </td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Proyecciones_Fila1_id           = $campo['id'];
    $Proyecciones_Fila1_mes_numero   = $campo['mes_numero'];
    $Proyecciones_Fila1_fecha_inicio = $campo['fecha_inicio'];
    $Proyecciones_Fila1_fecha_fin    = $campo['fecha_fin'];

    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Proyecciones_Fila1_id);

    ?>
           <td>
             <a href="?controller=obras&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Proyecciones_Fila1_id); ?>">
               <?php echo ("$" . number_format($valorproyectadorango, 0)); ?>
             </a>
           </td>
           <td>
             <?php

    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    echo ($porcentajeproyectado . "%");
    ?>
           </td>
            <?php
}
?>
            </tr>
             <tr>
          <td>Equipos Requeridos</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Fila2_id           = $campo['id'];
    $Fila2_mes_numero   = $campo['mes_numero'];
    $Fila2_fecha_inicio = $campo['fecha_inicio'];
    $Fila2_fecha_fin    = $campo['fecha_fin'];

    $valorequiposproyectado = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $Fila2_id);

    $var1                 = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $var3                 = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $var4                 = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Fila2_id);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $var5                 = ($porcentajeproyectado * $comisionlegal) / 100;
    $sumacantidades       = $var1 + $valorequiposproyectado + $var5 + $var4 + $var3;

    if ($sumacantidades != 0) {
        $incidenciaequipos = formulaporcentaje($valorequiposproyectado, $sumacantidades);
    } else {
        $incidenciaequipos = 0;
    }

    ?>
           <td>
             <a style="color: black;" href="?controller=proyeccioneslme&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Fila2_id); ?>">
               <?php echo ("$" . number_format($valorequiposproyectado, 0)); ?>
             </a>
           </td>
          <td>
              <strong><?php echo (round($incidenciaequipos, 2) . "%"); ?></strong>

          </td>
          <?php
}
?>
            </tr>
             <tr>
              <td>Materiales</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Fila2_id           = $campo['id'];
    $Fila2_mes_numero   = $campo['mes_numero'];
    $Fila2_fecha_inicio = $campo['fecha_inicio'];
    $Fila2_fecha_fin    = $campo['fecha_fin'];

    $valormaterialesproyectado = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $Fila2_id);

    $var2                 = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $var3                 = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $var4                 = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $Fila2_id);
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Fila2_id);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $var5                 = ($porcentajeproyectado * $comisionlegal) / 100;
    $sumacantidades       = $valormaterialesproyectado + $var2 + $var5 + $var4 + $var3;

    if ($sumacantidades != 0) {
        $incidenciamaterial = formulaporcentaje($valormaterialesproyectado, $sumacantidades);
    } else {
        $incidenciamaterial = 0;
    }

    ?>
           <td>
             <a style="color: black;" href="?controller=proyeccionesins&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Fila2_id); ?>">
               <?php echo ("$" . number_format($valormaterialesproyectado, 0)); ?>
             </a>
           </td>
          <td>
               <strong><?php echo (round($incidenciamaterial, 2) . "%"); ?></strong>

          </td>
          <?php
}
?>
            </tr>
              <tr>
              <td>Mano de Obra</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Fila3_id           = $campo['id'];
    $Fila3_mes_numero   = $campo['mes_numero'];
    $Fila3_fecha_inicio = $campo['fecha_inicio'];
    $Fila3_fecha_fin    = $campo['fecha_fin'];

    $valorlmoproyectado = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $Fila3_id);

    $var1                 = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $Fila3_id);
    $var2                 = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $Fila3_id);
    $var4                 = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $Fila3_id);
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Fila3_id);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $var5                 = ($porcentajeproyectado * $comisionlegal) / 100;
    $sumacantidades       = $var1 + $var2 + $var5 + $var4 + $valorlmoproyectado;

    if ($sumacantidades != 0) {
        $incidenciamanoobra = formulaporcentaje($valorlmoproyectado, $sumacantidades);
    } else {
        $incidenciamanoobra = 0;
    }

    ?>
           <td>
             <a style="color: black;" href="?controller=proyeccioneslmo&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Fila3_id); ?>">
               <?php echo ("$" . number_format($valorlmoproyectado, 0)); ?>
             </a>
           </td>
          <td>
               <strong><?php echo (round($incidenciamanoobra, 2) . "%"); ?></strong>

          </td>
          <?php
}
?>
            </tr>
            <tr>
              <td>Administración</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {

    $Fila4_id           = $campo['id'];
    $Fila4_mes_numero   = $campo['mes_numero'];
    $Fila4_fecha_inicio = $campo['fecha_inicio'];
    $Fila4_fecha_fin    = $campo['fecha_fin'];

    $valorladmproyectado = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $Fila4_id);

    $var3                 = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $Fila4_id);
    $var1                 = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $Fila4_id);
    $var2                 = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $Fila4_id);
    $var4                 = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $Fila4_id);
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $Fila4_id);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $var5                 = ($porcentajeproyectado * $comisionlegal) / 100;
    $sumacantidades       = $var1 + $var2 + $var5 + $var3 + $valorladmproyectado;

    if ($sumacantidades != 0) {

        $incidenciaadmin = formulaporcentaje($valorladmproyectado, $sumacantidades);
    } else {
        $incidenciaadmin = 0;
    }

    ?>
           <td>
             <a style="color: black;" href="?controller=proyeccionesadm&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Fila4_id); ?>">
               <?php echo ("$" . number_format($valorladmproyectado, 0)); ?>
             </a>
           </td>
          <td>
             <strong><?php echo (round($incidenciaadmin, 2) . "%"); ?></strong>
          </td>
          <?php
}
?>
            </tr>
             <tr>
              <td>R. Legal</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_legal = $campo['id'];

    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $id_legal);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $var4                 = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $id_legal);
    $var3                 = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $id_legal);
    $var1                 = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $id_legal);
    $var2                 = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $id_legal);
    $var5                 = ($porcentajeproyectado * $comisionlegal) / 100;
    $sumacantidades       = $var1 + $var2 + $var4 + $var3 + $var5;

    if ($sumacantidades != 0) {
        $incidencialegal = formulaporcentaje($var5, $sumacantidades);
    } else {
        $incidencialegal = 0;
    }

    ?>
           <td>
            <?php

    echo ("$" . number_format($var5, 0));
    ?>

           </td>
           <td>
              <strong><?php echo (round($incidencialegal, 2) . "%"); ?></strong>
           </td>
           <?php
}
?>
            </tr>
             <tr style="font-style: italic;" class="danger">
              <td><strong>Total Gastos</strong></td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_total = $campo['id'];

    $v1                   = Proyeccionesins::sqlvalorrangoequiposporobra($getobra, $id_total);
    $v2                   = Proyeccioneslme::sqlvalorrangoequiposporobra($getobra, $id_total);
    $v3                   = Proyeccioneslmo::sqlvalorrangoequiposporobra($getobra, $id_total);
    $v4                   = Proyeccionesadm::sqlvalorrangoequiposporobra($getobra, $id_total);
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $id_total);
    $porcentajeproyectado = formulaporcentaje($valorproyectadorango, $valorfinalobra);
    $v5                   = ($porcentajeproyectado * $comisionlegal) / 100;

    $sumacantidades = $v1 + $v2 + $v5 + $v4 + $v3;

    echo ("<td><strong>$" . number_format($sumacantidades, 0) . "</strong></td>");
    echo ("<td></td>");
}
?>
            </tr>
             <tr>
              <td>EBIPTA</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id = $campo['id'];

    echo ("<td></td>");
    echo ("<td></td>");
}
?>
            </tr>

          </tbody>
          </table>
        </div> <!-- Fin Row -->
      </div> <!-- Fin card -->
    </div>
    </div>

    <div class="col-lg-12">
    <div class="card card-default">
      <div class="card-body">

       <div class="col-sm-12">

        </div><!-- /.col -->
      <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>

                    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table display-compact table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">

          <thead>
            <tr style="background-color: #4f5962;color: white;">

              <th>Ejecutado</th>
          <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id           = $campo['id'];
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];

    echo ("<th>Rango-" . $mes_numero);
    echo ("<th>Inc %</th>");
}
?>
            </tr>

          </thead>
          <tbody>

            <tr class="success">
            <td><strong>Ingresos</strong> </td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $Fila1_id           = $campo['id'];
    $Fila1_mes_numero   = $campo['mes_numero'];
    $Fila1_fecha_inicio = $campo['fecha_inicio'];
    $Fila1_fecha_fin    = $campo['fecha_fin'];

    $valorejecutado  = Valorejecutadoporrango($getobra, $Fila1_fecha_inicio, $Fila1_fecha_fin);
    $valorproyeccion = Obras::sqlvalorrangoporobra($getobra, $Fila1_id);

    if ($valorejecutado != 0) {
        $porcentajeavance = ($valorejecutado / $valorproyeccion) * 100;
        $labelporcentaje  = round($porcentajeavance, 2) . " %";

    } elseif ($valorejecutado != 0 and $valorproyeccion == 0) {
        $labelporcentaje = "<small class='text-danger'>SP</small>";

    } elseif ($valorejecutado == 0 and $valorproyeccion != 0) {
        $labelporcentaje = "0.00 %";
    }

    ?>
           <td>
            <a href="?controller=obras&&action=proyeccionesrango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($Fila1_id); ?>">
              <strong><?php echo ("$" . number_format($valorejecutado, 0)) ?></strong>
             </a>
           </td>
           <td>
            <strong><?php echo ($labelporcentaje); ?></strong>
           </td>
            <?php
}
?>
            </tr>
    <?php 


     ?>
             <tr>
              <td>Gastos Equipos</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_eq = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];

    # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;

if ($totalgastosporrango==0) {
    $incidenciaequipos =0;
}else{
    $incidenciaequipos =($totaleq/$totalgastosporrango)*100;
}
 
    ?>

    <td>
         <a style="color: black;" href="?controller=proyeccioneslme&&action=ejecutadorango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($id_eq); ?>&&getrubro=<?php echo($rubroeq) ?>">
              $<?php echo number_format($totaleq,2); ?>
             </a>
        
    </td>
    <td>
        <strong>
             <?php echo round($incidenciaequipos,2) ?>%
        </strong>
       
    </td>
    <?php
}
?>
            </tr>
           <tr>
              <td>Materiales y Suministros</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_mat = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];
       # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;

if ($totalgastosporrango==0) {
    $incidenciamateriales =0;
}else{
    $incidenciamateriales =($totalmat/$totalgastosporrango)*100;
}
    ?>
    <td>
        <a style="color: black;" href="?controller=proyeccioneslme&&action=ejecutadorango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($id_mat); ?>&&getrubro=<?php echo($rubromat) ?>">
              $<?php echo number_format($totalmat,2); ?>
        </a>
        
    </td>
    <td>
        <strong>
             <?php echo round($incidenciamateriales,2) ?>%
        </strong>
       
    </td>
    <?php
}
?>
</tr>
            
             <tr>
              <td>Mano de Obra / Sum e Inst</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_sumin = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];
    
      # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;

if ($totalgastosporrango==0) {
    $incidenciasumin =0;
}else{
    $incidenciasumin =($totalmat/$totalgastosporrango)*100;
}

    ?>
    <td>
        <a style="color: black;" href="?controller=proyeccioneslme&&action=ejecutadorango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($id_sumin); ?>&&getrubro=<?php echo($rubrosumin) ?>">
               $<?php echo number_format($totalsum,2); ?>
        </a>
       
    </td>
     <td>
        <strong>
             <?php echo round($incidenciasumin,2) ?>%
        </strong>
       
    </td>
    <?php
}
?>
</tr>
             <tr>
              <td>Gastos Administración</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_admin = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];
   

    # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;

if ($totalgastosporrango==0) {
    $incidencia_admin =0;
}else{
    $incidencia_admin =($totaladmin/$totalgastosporrango)*100;
}


    ?>
    <td>
         <a style="color: black;" href="?controller=proyeccioneslme&&action=ejecutadorango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($id_admin); ?>&&getrubro=<?php echo($rubrosadmin) ?>">
               $<?php echo number_format($totaladmin,2); ?>
        </a>
        
    </td>
    <td>
        <strong>
             <?php echo round($incidencia_admin,2) ?>%
        </strong>
       
    </td>
    <?php
}
?>
            </tr>


 <tr>
              <td>Gastos Gerenciales</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id_gerencia = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];
   

    # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;

if ($totalgastosporrango==0) {
    $incidencia_obra =0;
}else{
    $incidencia_obra =($totalobra/$totalgastosporrango)*100;
}

    ?>
    <td>
         <a style="color: black;" href="?controller=proyeccioneslme&&action=ejecutadorango&&id=<?php echo ($getobra); ?>&&rangoid=<?php echo ($id_gerencia); ?>&&getrubro=<?php echo($rubroobras) ?>">
               $<?php echo number_format($totalobra,2); ?>
        </a>
        
    </td>
    <td>
        <strong>
             <?php echo round($incidencia_obra,2) ?>%
        </strong>
       
    </td>
    <?php
}
?>
            </tr>
             <tr class="danger">
              <td>Total Gastos</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
   $id = $campo['id'];
    $B_mes_numero   = $campo['mes_numero'];
    $B_fecha_inicio = $campo['fecha_inicio'];
    $B_fecha_fin    = $campo['fecha_fin'];
   

    # -----------  Sacamos el valor total  -----------
$rubroeq= 8;
$cxp1 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$inv1 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroeq);
$totaleq=$cxp1+$inv1;

$rubromat= 13;
$cxp2 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$inv2 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubromat);
$totalmat=$cxp2+$inv2;

$rubrosumin= 14;
$cxp3 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$inv3 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosumin);
$totalsum=$cxp3+$inv3;

$rubrosadmin= 4;
$cxp4 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$inv4 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubrosadmin);
$totaladmin=$cxp4+$inv4;

$rubroobras= 3;
$cxp5 = Proyeccionesadm::sqlvalorgastoporrubro($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$inv5 = Proyeccionesadm::sqlvalorinventario($getobra,$B_fecha_inicio,$B_fecha_fin,$rubroobras);
$totalobra=$cxp5+$inv5;

$totalgastosporrango = $totaleq+$totalmat+$totalsum+$totaladmin+$totalobra;


    ?>
     <td>
        <strong>
            $<?php echo number_format($totalgastosporrango,2); ?>
        </strong>
        
    </td>
    <td></td>
    <?php
}
?>
            </tr>
             <tr>
              <td>EBIPTA</td>
               <?php
$campos = Rangos::obtenerPagina($getobra);
$campos = $campos->getCampos();
foreach ($campos as $campo) {
    $id = $campo['id'];

    echo ("<td></td>");
    echo ("<td></td>");
}
?>
            </tr>

          </tbody>
          </table>
        </div> <!-- Fin Row -->
      </div> <!-- Fin card -->
    </div>
    </div>












<div style="background-color: white;" class="col-md-12">


   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
    <br>



              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
             <tfoot style="display: table-header-group;">

                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>



                                      <?php

$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $id_rango_th          = $campo['id'];
    $mes_numero           = $campo['mes_numero'];
    $fecha_inicio         = $campo['fecha_inicio'];
    $fecha_fin            = $campo['fecha_fin'];
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $id_rango_th);
    ?>
    <th style="background-color: #fcf8e3" class="success"></th>
    
<?php
}

?>

                            </tfoot>
          <thead>
              <tr style="background-color: #4f5962;color: white;">

             <th>Equipos</th>
            <th>Unidad</th>


             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
   
    <th><?php echo ("Rango-" . $mes_numero); ?></th>
<?php
}

?>


            </tr>
             <tr>

            <th>Equipos</th>
            <th>Unidad</th>

             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
   
     <th><?php echo ("Rango-" . $mes_numero); ?></th>
<?php
}

?>


            </tr>
          </thead>
       <tbody>

  <?php
# ===============================================
# =           Inicio de  Actividades            =
# ===============================================

$res = Proyeccioneslme::obtenerPagina($getobra);
    $campos = $res->getCampos();

foreach ($campos as $campo) {

    $id_proyeccionlme = $campo['id_proyeccionlme'];
    $lme_id_lme       = $campo['lme_id_lme'];
    $nomequipo = Listame::obtenerNombre($lme_id_lme);
    $unidadmedidaequipo=Listame::obtenerUnidadmedida($lme_id_lme);
    $nomunidad=Unidadesmed::obtenerNombre($unidadmedidaequipo);

?>

 <tr>
          <td>

            <?php echo utf8_decode($nomequipo); ?>
        </td>
        <td>

            <?php echo utf8_decode($nomunidad); ?>
        </td>


       

<?php
$rangos       = Obras::rangosporobra($getobra);
    $campos_rango = $rangos->getcampos();

    foreach ($campos_rango as $campo) {

        $id_rango_act     = $campo['id'];
        $mes_numero_act   = $campo['mes_numero'];
        $fecha_inicio_act = $campo['fecha_inicio'];
        $fecha_fin_act    = $campo['fecha_fin'];

        $sqlcantidades= Proyeccioneslme::sqlcantidades($getobra,$id_rango_act,$lme_id_lme);
        $sqlreportado =Proyeccioneslme::sqlcantidadesreportadas($getobra,$fecha_inicio_act,$fecha_fin_act,$lme_id_lme);

        $sqlvalorunitario= Proyeccioneslme::sqlvalorunitario($getobra,$id_rango_act,$lme_id_lme);
        $sqlvalortotal= Proyeccioneslme::sqlvalortotal($getobra,$id_rango_act,$lme_id_lme);

        ?>

 <td>
     <?php
             echo ("<span class='text-danger'>".round($sqlreportado,2)."</span> de ".round($sqlcantidades,2));
        ?>
 </td>
 

<?php
}

    ?>

        </tr>
<?php // Final Segundo Bucle

} // Final del primer Bucle

?>


       </tbody>
     </table>
   </div>

</div>












<div style="background-color: white;" class="col-md-12">
   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
    <br>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
             <tfoot style="display: table-header-group;">

                    <th style="background-color: #fcf8e3" class="success"></th>
                    <th style="background-color: #fcf8e3" class="success"></th>



                                      <?php

$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $id_rango_th          = $campo['id'];
    $mes_numero           = $campo['mes_numero'];
    $fecha_inicio         = $campo['fecha_inicio'];
    $fecha_fin            = $campo['fecha_fin'];
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra, $id_rango_th);
    ?>
    <th style="background-color: #fcf8e3" class="success"></th>
    
<?php
}

?>

                            </tfoot>
          <thead>
              <tr style="background-color: #4f5962;color: white;">

            <th>Materiales</th>
            <th>Unidad</th>


             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
   
    <th><?php echo ("Rango-" . $mes_numero); ?></th>
<?php
}

?>


            </tr>
             <tr>

            <th>Materiales</th>
            <th>Unidad</th>

             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
   
     <th><?php echo ("Rango-" . $mes_numero); ?></th>
<?php
}

?>


            </tr>
          </thead>
       <tbody>

  <?php
# ===============================================
# =           Inicio de  Actividades            =
# ===============================================

$res = Proyeccionesins::obtenerPagina($getobra);
    $campos = $res->getCampos();

foreach ($campos as $campo) {

    $id_proyeccionins = $campo['id_proyeccionins'];
    $insumo_id_insumo       = $campo['insumo_id_insumo'];
    $nominsumo = Insumos::obtenerNombreInsumo($insumo_id_insumo);
    $unidadmedida=Insumos::obtenerUnidadmed($insumo_id_insumo);
    $nomunidad=Unidadesmed::obtenerNombre($unidadmedida);

?>

 <tr>
          <td>

            <?php echo utf8_decode($nominsumo); ?>
        </td>
        <td>

            <?php echo utf8_decode($nomunidad); ?>
        </td>


       

<?php
$rangos       = Obras::rangosporobra($getobra);
    $campos_rango = $rangos->getcampos();

    foreach ($campos_rango as $campo) {

        $id_rango_act     = $campo['id'];
        $mes_numero_act   = $campo['mes_numero'];
        $fecha_inicio_act = $campo['fecha_inicio'];
        $fecha_fin_act    = $campo['fecha_fin'];

        $sqlcantidades= Proyeccionesins::sqlcantidades($getobra,$id_rango_act,$insumo_id_insumo);
        $sqlreportado =Proyeccionesins::sqlcantidadesreportadas($getobra,$fecha_inicio_act,$fecha_fin_act,$insumo_id_insumo);

$sqlvalorunitario= Proyeccionesins::sqlvalorunitario($getobra,$id_rango_act,$insumo_id_insumo);
$sqlvalortotal= Proyeccionesins::sqlvalortotal($getobra,$id_rango_act,$insumo_id_insumo);

        ?>

 <td>
    <a target="_blank" href="?controller=agregadosobra&&action=agregados&&id_obra=<?php echo($getobra); ?>">
     <?php
            echo ("<span class='text-danger'>".round($sqlreportado,2)."</span>");
        ?>
    </a>
    <?php echo ("de ".round($sqlcantidades,2)); ?>
 </td>
 

<?php
}

    ?>

        </tr>
<?php // Final Segundo Bucle

} // Final del primer Bucle

?>


       </tbody>
     </table>
   </div>

</div>



      </div> <!-- Fin Row -->
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content -->
</div> <!-- Fin Content-Wrapper -->



<!-- Inicio Modal Clientes -->
    <div id="modal-form1" class="modal" tabindex="-1">
               <!-- Inicio Modal -->
    <div>

 <form role="form" autocomplete="off" action="?controller=rangos&&action=guardar&id_obra=<?php echo ($getobra); ?>" method="POST" enctype="multipart/form-data" >
                            <?php
date_default_timezone_set("America/Bogota");
$TiempoActual = date('Y-m-d H:i:s');
?>
                <input type="hidden" name="obra_id_obra" value="<?php echo ($getobra); ?>">
                <input type="hidden" name="estado_rango" value="1">
                <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">
                <input type="hidden" name="rango_publicado" value="1">
                <input type="hidden" name="creado_por" value="<?php echo ($IdSesion); ?>">

                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a href="#" type="button" class="close" data-dismiss="modal">&times;</a>
                        <h4 class="black bigger">Agregar Rango:</h4>
                      </div>
                           <div class="col-md-12">
                                                <div class="form-group">
                          <label>Nombre Rango: <span>*</span></label>
                    <select class="form-control mi-selector" name="mes_numero" id="">
                      <option value="">Seleccionar</option>
                  <?php

for ($i = 0; $i < 50; $i++) {

    echo ("<option value='" . $i . "'>Rango-" . $i . "</option>");
}

?>

                    </select>
                              </div>
                                    </div>

                     <div  class="col-md-12">
                        <div class="form-group">
                          <label>Fecha Inicio: <span>*</span></label>
                          <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicial" class="form-control required" required >
                        </div>
                      </div>

                       <div  class="col-md-12">
                        <div class="form-group">
                          <label>Fecha Fin: <span>*</span></label>
                          <input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final" class="form-control required" required >
                        </div>
                      </div>

                      <div class="modal-footer">
                        <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">
                          <i class="ace-icon fa fa-times"></i>
                          Cancelar
                        </a>

                        <button class="btn btn-sm btn-success">
                          <i class="ace-icon fa fa-check"></i>
                          Confirmar
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
                </div><!-- PAGE CONTENT ENDS -->
 </div>
 <!-- FINAL MODAL -->

<script>
  $(document).ready(function(){
    $("#mostrar").on( "click", function() {
      $('#tablarangos').show(); //muestro mediante id
     });
    $("#oculto").on( "click", function() {
      $('#tablarangos').hide(); //oculto mediante id
    });
  });
</script>

<script>
function eliminar(id,$getobra){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
window.location.href="?controller=rangos&&action=eliminar&&rangoid="+id+"&&id_obra="+$getobra+"";
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>



<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
          <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
         <script src="dist/js/buttons.colVis.min.js"></script>
          <script src="dist/js/buttons.print.min.js"></script>
           <script src="dist/js/dataTables.select.min.js"></script>
           <script src="dist/js/buttons.flash.min.js"></script>


<!-- page script -->

<script type="text/javascript">
      jQuery(function($) {

$('#cotizaciones thead tr:eq(1) th').each( function () {
        var title = $('#cotizaciones thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input style="width:100%;border:black solid 1px;" type="text" placeholder="Buscar '+title+'" />' );
    } );

    var table = $('#cotizaciones').DataTable({
       responsive:false,
      "order": false,
       "ordering": false,
       // "order": [[ 0, "desc" ]],
        //orderCellsTop: true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se ha encontrado nada - Lo sentimos",
            "info": "Mostrar página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
           },

    "lengthMenu": [[5000, 7000, 10000, -1], [5000, 7000, 10000, "All"]],

          select: {
            style: 'multi'
          },
           "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };


        },

    });

    // Apply the search
    table.columns().every(function (index) {
        $('#cotizaciones thead tr:eq(1) th:eq(' + index + ') input').on('keyup change', function () {
            table.column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });
    });

        var myTable =
        $('#cotizaciones')
        //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
        .DataTable( {
retrieve: true,


          "aoColumns": [
            { "bSortable": false },
            null, null,null, null,null,null,null,null, null,null, null,null,null,null,null, null,null, null,null,null,null,
            { "bSortable": false }
          ],
          "aaSorting": [],
          "scrollX": true,

          //"bProcessing": true,
              //"bServerSide": true,
              //"sAjaxSource": "http://127.0.0.1/table.php" ,

          //,

          //"sScrollXInner": "120%",
          //"bScrollCollapse": true,
          //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
          //you may want to wrap the table inside a "div.dataTables_borderWrap" element

          //"iDisplayLength": 50


          } );





        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

        new $.fn.dataTable.Buttons( myTable, {
         buttons: [


            {
            "extend": "csv",
            "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'></span>",
            "className": "btn btn-white btn-primary btn-bold"
            },
            {

            "extend": "excelHtml5",
            "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'></span>",
            "className": "btn btn-white btn-primary btn-bold"

            },
            {

            "extend": "pdf",
            "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'></span>",
            "className": "btn btn-white btn-primary btn-bold",
            orientation: 'landscape',
                     pageSize: 'LEGAL',
            },
            {
            "extend": "print",
            "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'></span>",
            "className": "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'Está impresión se produjo desde la App'
            }
          ]
        } );
        myTable.buttons().container().appendTo( $('.tableTools-container') );

        // style the message box
        // var defaultCopyAction = myTable.button(1).action();
        // myTable.button(1).action(function (e, dt, button, config) {
        //   defaultCopyAction(e, dt, button, config);
        //   $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        // });




        // var defaultColvisAction = myTable.button(0).action();
        // myTable.button(0).action(function (e, dt, button, config) {

        //   defaultColvisAction(e, dt, button, config);


        //   if($('.dt-button-collection > .dropdown-menu').length == 0) {
        //     $('.dt-button-collection')
        //     .wrapInner('<ul class="dropdown-menu dropdown-light " />')
        //     .find('a').attr('href', '#').wrap("<li />")
        //   }
        //   $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
        // });

        //

        setTimeout(function() {
          $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);





        myTable.on( 'select', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
          }
        } );
        myTable.on( 'deselect', function ( e, dt, type, index ) {
          if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
          }
        } );






        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

        //select/deselect all rows according to table header checkbox
        $('#cotizaciones > thead > tr > th input[type=checkbox], #cotizaciones_wrapper input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header

          $('#cotizaciones').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
          });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#cotizaciones').on('click', 'td input[type=checkbox]' , function(){
          var row = $(this).closest('tr').get(0);
          if(this.checked) myTable.row(row).deselect();
          else myTable.row(row).select();
        });



        $(document).on('click', '#cotizaciones .dropdown-toggle', function(e) {
          e.stopImmediatePropagation();
          e.stopPropagation();
          e.preventDefault();
        });



        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
        var active_class = 'active';
        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
          var th_checked = this.checked;//checkbox inside "TH" table header

          $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
          });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
          var $row = $(this).closest('tr');
          if($row.is('.detail-row ')) return;
          if(this.checked) $row.addClass(active_class);
          else $row.removeClass(active_class);
        });



        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
          var $source = $(source);
          var $parent = $source.closest('table')
          var off1 = $parent.offset();
          var w1 = $parent.width();

          var off2 = $source.offset();
          //var w2 = $source.width();

          if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
          return 'left';
        }




        /***************/
        $('.show-details-btn').on('click', function(e) {
          e.preventDefault();
          $(this).closest('tr').next().toggleClass('open');
          $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        /***************/


      })
    </script>