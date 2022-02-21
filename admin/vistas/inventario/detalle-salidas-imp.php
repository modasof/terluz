<?php
ini_set('display_errors', '0');
include_once 'controladores/usuariosController.php';
include_once 'modelos/usuarios.php';

include_once 'controladores/insumosController.php';
include_once 'modelos/insumos.php';

include_once 'controladores/unidadesmedController.php';
include_once 'modelos/unidadesmed.php';

include_once 'controladores/proveedoresController.php';
include_once 'modelos/proveedores.php';

include_once 'controladores/proyectosController.php';
include_once 'modelos/proyectos.php';

include_once 'controladores/requisicionesController.php';
include_once 'modelos/requisiciones.php';

include_once 'controladores/inventarioController.php';
include_once 'modelos/inventario.php';

include_once 'controladores/comprasController.php';
include_once 'modelos/compras.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

require_once 'vistas/index/header-formdate.php';

$Getsalida = $_GET['id'];

$res    = Inventario::verentradasdetalle($Getsalida);
$campos = $res->getCampos();
foreach ($campos as $campo) {
    $fecha_reporte        = $campo['fecha_reporte'];
    $proyecto_id_proyecto = $campo['proyecto_id_proyecto'];
    $requisicion_id       = $campo['requisicion_id'];
    $creado_por           = $campo['creado_por'];
    $recibido_por         = $campo['recibido_por'];
    $observaciones        = $campo['observaciones'];
    $tipo_salida          = $campo['tipo_salida'];
    $estado_salida        = $campo['estado_salida'];
    $fecha_recepcion      = $campo['fecha_recepcion'];
    $nomdespacha          = Usuarios::obtenerNombreUsuario($creado_por);
    $nomrecibe          = Usuarios::obtenerNombreUsuario($recibido_por);
    $nombreproyecto       = Proyectos::obtenerNombreProyecto($proyecto_id_proyecto);
}

?>

<!-- CCS Y JS PARA LA CARGA DE IMAGEN -->
<script src="plugins/dropify/dropify.min.js"></script>
<link rel="stylesheet" href="plugins/dropify/dropify.min.css">
 <!-- CCS Y JS DATERANGE -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Content Wrapper. Contains page content -->



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Detalle Salida</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
            <li class="breadcrumb-item"><a href="?controller=inventario&&action=totalsalidas">Ver Salidas</a></li>
            <!--<li class="breadcrumb-item active"><a href="?controller=equipos&&action=todos">Equipos</a></li>-->
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

            <div class="col-md-12">
                <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="">
              <img width="150px" height="50px" src="../Login/logonomadas.png" >
            </i> Comprobante de Entrega
            <small class="pull-right">Fecha: <?php
$imprfechalarga = fechalarga($MarcaTemporal);
echo ($imprfechalarga);
?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
          Entregado a:
          <address>
            <strong><?php echo($nomrecibe); ?></strong><br>
            Proyecto:<small><?php echo($nombreproyecto); ?></small><br>
            Fecha Entrega: <?php echo($fecha_reporte); ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-5 invoice-col">
          Despachado por:
          <address>
            <strong><?php echo ($nomdespacha) ?></strong><br>
            Total Items: 2<br>
            Fecha y hora Entrega: <?php echo ($marca_temporal); ?><br>
            Tipo Salida: <?php echo ($tipo_salida); ?><br>
          </address>

        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          <b>Comprobante Entrega #N-ENT<?php echo ($Getsalida); ?></b><br>
          <br>

          <b>Valor Entregado:</b>
          <?php
echo ("234.000");
?>
          <br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <form action="?controller=requisicionesitems&action=guardarocompra" method="post" id="formularioppal">


          <table class="table table-striped" style="font-size:13px;">
            <thead>
            <tr>
              <th style="width: 2%;">RQ-IT</th>
              <th>Insumo</th>
              <th>Cantidad Solicitada</th>
              <th>Cantidad Entregada</th>
              <th>Unidad</th>
              <th>Valor Total</th>
            </tr>
            </thead>
            <tbody>
               <?php
if ($fechaform != "") {
    $res    = Inventario::Salidasporfecha($FechaStart, $FechaEnd);
    $campos = $res->getCampos();
} else {
    $campos = $campos->getCampos();
}

foreach ($campos as $campo) {
    $id                    = $campo['id'];
    $item_id               = $campo['item_id'];
    $requisicion_id        = $campo['requisicion_id'];
    $insumo_id             = $campo['insumo_id'];
    $cantidad              = $campo['cantidad'];
    $salida_id             = $campo['salida_id'];
    $fecha_registro        = $campo['fecha_registro'];
    $estado_detalle_salida = $campo['estado_detalle_salida'];
    $marca_temporal        = $campo['marca_temporal'];
    $creado_por            = $campo['creado_por'];
    $salida_por            = $campo['salida_por'];

    $nominsumo            = Insumos::obtenerNombreInsumo($insumo_id);
    $unidadmedida         = Insumos::obtenerUnidadmed($insumo_id);
    $nomunidadmedida      = Unidadesmed::obtenerNombre($unidadmedida);
  
    $valor=0;
    ?>   
            <tr>
              <td>RQ <?php echo ($requisicion_id . "-" . $item_id); ?></td>
              <td><?php echo ($nominsumo); ?> </td>
              <td><?php echo ($cantidad); ?></td>
              <td><?php echo ($nomunidadmedida); ?></td>
               <td><?php echo ("$ " . number_format($valor, 0)); ?></td>
              <td><?php echo ("$ " . number_format($valor, 0)); ?></td>
            </tr>
           <?php
}
?>
            </tbody>
          </table>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">

         <p class="lead"><strong>Observaciones</strong></p>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;font-size: 8px; text-align: justify;">
           <?php echo($observaciones); ?>
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td>
                  <?php

echo ("$" . number_format($Subtotalcot, 0));
?>
                </td>
              </tr>

              <tr>
                <th>Medio Pago:</th>
                <td>
                   <?php

echo ($mediopago);
?>
                </td>
              </tr>

            </table>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%"><small>VoBo Jefe de compra</small></th>
                <td></td>
              </tr>
            </tbody></table>
          </div>
        </div>
         <div class="col-xs-4">
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%"><small>VoBo Recibe</small></th>
                <td></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <div class="col-xs-4">
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%"><small>Firma Ing. Residente</small></th>

                <td></td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->

      <div class="row no-print">
        <div class="col-xs-12">
          <a href="vistas/requisiciones/cotizaciones_print.php?id=<?php echo ($idproveedor); ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

         

        </div>
      </div>
    </section>
            </div>
          </div> <!-- FIN DE ROW-->
        </div><!-- FIN DE CONTAINER FORMULARIO-->
      </div> <!-- Fin Row -->
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content -->


</div> <!-- Fin Content-Wrapper -->

<!-- Inicio Libreria formato moneda -->


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
<script>
  $(function () {
    $('#cotizaciones33').DataTable({
      "paging": true,
      "lengthChange": true,
      "lengthMenu": [[25, 50, 150, -1], [25, 50, 150, "All"]],
      "searching": true,
      "order": [[ 0, "asc" ]],
      "ordering": true,
      "info": true,
      "autoWidth": false,
    language: {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}

    });
  });
</script>
<script>
   function format2(n, currency) {
    return currency + " " + n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
function formatmoneda(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
        $(document).ready(function() {
    $('#example').DataTable( {
         "searching": true,
        "ordering": true,
        "paging":   true,
        "info":     true,
        "aLengthMenu": [[100, 200, 300, -1], [100, 200, 300, "Todas"]],
    "pageLength": 100,


    } );
} );
    </script>
