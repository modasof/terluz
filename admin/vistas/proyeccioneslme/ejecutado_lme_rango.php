<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include_once 'modelos/listame.php';
include_once 'controladores/listameController.php';

include_once 'modelos/proyeccioneslme.php';
include_once 'controladores/proyeccioneslmeController.php';

include_once 'modelos/proveedores.php';
include_once 'controladores/proveedoresController.php';

include_once 'modelos/compras.php';
include_once 'controladores/comprasController.php';

include_once 'modelos/rubros.php';
include_once 'controladores/rubrosController.php';

include_once 'modelos/subrubros.php';
include_once 'controladores/subrubrosController.php';

include_once 'modelos/rangos.php';
include_once 'controladores/rangosController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'controladores/insumosController.php';
include_once 'modelos/insumos.php';

include_once 'controladores/serviciosController.php';
include_once 'modelos/servicios.php';

include_once 'controladores/unidadesmedController.php';
include_once 'modelos/unidadesmed.php';

include_once 'controladores/proyectosController.php';
include_once 'modelos/proyectos.php';

include_once 'controladores/requisicionesController.php';
include_once 'modelos/requisiciones.php';

include_once 'controladores/inventarioController.php';
include_once 'modelos/inventario.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

$getobra  = $_GET['id'];
$getrango = $_GET['rangoid'];
$getrubro = $_GET['getrubro'];

$nomrango     = Rangos::obtenerNombre($getrango);
$rangos       = Obras::unicorangoporobra($getobra, $getrango);
$campos_rango = $rangos->getcampos();
foreach ($campos_rango as $campo) {

    $fecha_inicio_label = $campo['fecha_inicio'];
    $fecha_fin_label    = $campo['fecha_fin'];

}

$resultado = Obras::obtenerpaginapor($getobra);

$campos_obra = $resultado->getcampos();

foreach ($campos_obra as $campoobra) {
    $nombre_obra = $campoobra['nombre_obra'];
}

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

    <?php if ($RolSesion == 14 or $RolSesion == 15) {
    ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=index&&action=index">Inicio</a></small>

         <small><a class="btn btn-warning btn-sm" href="?controller=rangos&&action=todosobra&&id_obra=<?php echo ($getobra); ?>">Volver a Rangos</a></small>

      </h1>

    </section>

  <?php
} else {
    ?>

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=obras&&action=dashboard">Volver a Obras</a></small>
         <small><a class="btn btn-warning btn-sm" href="?controller=rangos&&action=todosobra&&id_obra=<?php echo ($getobra); ?>">Volver a Rangos</a></small>

      </h1>
    </section>


  <?php
}

?>


<div style="background-color: white;" class="col-md-12">

  <div class="box-header with-border">
    <h1>Gastos registrados en Rango-<?php echo utf8_decode($nomrango); ?> </h1>
<i class="fa fa-info-circle"> </i>
<h3 class="box-title">PROYECTO : <?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio_label); ?> a la fecha final : <?php echo utf8_decode($fecha_fin_label); ?> </strong></h3>
</div>
   <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
    </div>
    <br>



              <div class="">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
             <tfoot style="display: table-header-group;">

                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                       <th style="background-color: #fcf8e3" class="success"></th>
                            </tfoot>
          <thead>
          <tr style="background-color: #4f5962;color: white;">
            <th>OC-N.</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Proveedor</th>
            <th>Pago a</th>
            <th >Vr. Subtotal</th>
            <th >Vr. Retenciones</th>
            <th >Vr. Iva</th>
            <th >Vr. A Pagar</th>
            <th >Abonos</th>
            <th>Saldo Pendiente</th>
            <th>Acción</th>
          </tr>
             <tr>

             <th>OC-N.</th>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Proveedor</th>
            <th>Pago a</th>
            <th >Vr. Subtotal</th>
            <th >Vr. Retenciones</th>
            <th >Vr. Iva</th>
            <th >Vr. A Pagar</th>
            <th >Abonos</th>
            <th>Saldo Pendiente</th>
            <th>Acción</th>
            </tr>
          </thead>
       <tbody>
 <?php
$rangos       = Obras::unicorangoporobra($getobra, $getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero         = $campo['mes_numero'];
    $fecha_inicio_rango = $campo['fecha_inicio'];
    $fecha_fin_rango    = $campo['fecha_fin'];
    ?>
<?php
}
?>

  <?php
# ===============================================
# =           Inicio            =
# ===============================================

$cuentas       = Proyeccioneslme::cxpfechaobra($getobra, $fecha_inicio_rango, $fecha_fin_rango, $getrubro);
$campos_cuenta = $cuentas->Getcampos();
foreach ($campos_cuenta as $campo) {

    $id                     = $campo['id'];
    $fecha_reporte          = $campo['fecha_reporte'];
    $compra_de              = $campo['compra_de'];
    $imagen                 = $campo['imagen'];
    $imagen_cot             = $campo['imagen_cot'];
    $valor_total            = $campo['valor_total'];
    $valor_retenciones      = $campo['valor_retenciones'];
    $valor_iva              = $campo['valor_iva'];
    $estado_orden           = $campo['estado_orden'];
    $rubro_id               = $campo['rubro_id'];
    $subrubro_id            = $campo['subrubro_id'];
    $vencimiento            = $campo['vencimiento'];
    $proveedor_id_proveedor = $campo['proveedor_id_proveedor'];
    $medio_pago             = $campo['medio_pago'];
    $marca_temporal         = $campo['marca_temporal'];
    $observaciones          = $campo['observaciones'];
    $usuario_creador        = $campo['usuario_creador'];
    $facturanum             = $campo['factura'];

    $nomproveedor   = Proveedores::obtenerNombreProveedor($proveedor_id_proveedor);
    $nomreportador  = usuarios::obtenerNombreUsuario($usuario_creador);
    $totalpago      = $valor_total - $valor_retenciones + $valor_iva;
    $detalleabonos  = Compras::sqlabonos($id);
    $cuentaporpagar = $totalpago - $detalleabonos;

    # ==================================================
    # =           Validación de los estados            =
    # ==================================================

    if ($estado_orden == "1") {
        $nomestado = "<small style='color:red;' class='label pull-left bg-red'>Sin Facturar</small>";
    } elseif ($estado_orden == "2") {
        $nomestado = "<small style='color:green;' class='label pull-left bg-green'>Facturado</small>";
    } else {
        $nomestado = "Sin Estado";
    }

    # ========================================================
    # =           Verificación de Rubro - Subrubro           =
    # ========================================================

    if ($rubro_id == 0) {
        $nombrerubro = "<span class='text-danger'><strong>Sin clasificar</strong></span>";
    } else {
        $nombrerubro = Rubros::obtenerNombreRubro($rubro_id);
    }

    if ($subrubro_id == 0) {
        $nombresubrubro = "<span class='text-danger'><strong>Sin clasificar</strong></span>";
    } else {
        $nombresubrubro = Subrubros::obtenerNombreSubrubro($subrubro_id);
    }

    ?>

         <tr>

          <td id="listado">

            <a style="display:none;" href="?controller=compras&action=cambiarestado&id=<?php echo ($id); ?>" class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Detalle">
                <i class="fa fa-dollar bigger-110 "> </i></a>



                  <?php
echo ("OC00" . $id);
    if ($imagen != "0") {
        ?>
                   <a target="_blank" href="<?php echo ($imagen); ?>"  class="tooltip-primary text-primary" title="Ver Soporte">
                <i class="fa fa-eye bigger-110 "> Factura</i>
              </a>
                  <?php
} else {
        echo "<i class='tooltip-danger text-danger fa fa-unlink'>Factura<i>";
    }

    ?>

     <?php
if ($imagen_cot != "0") {
        ?>
                   <a target="_blank" href="<?php echo ($imagen_cot); ?>"  class="tooltip-primary text-primary" title="Ver Soporte">
                <i class="fa fa-eye bigger-110 "> Cotización</i>
              </a>
                  <?php
} else {
        echo "<i class='tooltip-danger text-danger fa fa-unlink'>Cotización<i>";
    }

    ?>

                </td>
                <td><?php echo ($fecha_reporte); ?></td>
                <td><?php echo ($compra_de); ?></td>
                <td><?php echo ($nomproveedor); ?></td>
                <td><?php echo ($medio_pago); ?></td>

                <td><?php echo ("$" . number_format($valor_total)); ?></td>
                <td><?php echo ("$" . number_format($valor_retenciones)); ?></td>
                 <td><?php echo ("$" . number_format($valor_iva)); ?></td>
                <td><?php echo ("$" . number_format($totalpago)); ?></td>
                 <td><?php echo ("$" . number_format($detalleabonos)); ?></td>
                  <td><?php echo ("$" . number_format($cuentaporpagar)); ?></td>
                 <td>

                 <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle">
                          Acción
                          <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                        </button>

                        <ul class="dropdown-menu dropdown-info dropdown-menu-right">
              <?php
if ($imagen != "0") {
        ?>
                    <li>
             <a target="_blank" href="<?php echo ($imagen); ?>"  class="tooltip-primary text-primary" title="Ver Soporte">
                <i class="fa fa-eye bigger-110 "> Ver Soporte</i>
              </a>
                          </li>
                          <li>
               <a download="Soporte" href="<?php echo ($imagen); ?>"  class="tooltip-primary text-dark" title="Descargar Soporte">
                <i class="fa fa-cloud-download bigger-110 "> Descargar Soporte</i>
                </a>
                          </li>
                  <?php
} else {
        ?>
                  <li>
             <a target="_blank" href="#"  class="tooltip-primary text-danger" title="Ver Soporte">
                <i class="fa fa-unlink bigger-110 "> Sin Soporte</i>
              </a>
                          </li>

                  <?php
}

    ?>


                        </ul>
                      </div>
              </td>

        </tr>
<?php // Final Segundo Bucle

} // Final del primer Bucle

?>


       </tbody>
     </table>
   </div>

</div>



 <div style="background-color: white;" class="col-md-12">
  <div class="box-header with-border">
    <h1>Salidas por Almacén en Rango-<?php echo utf8_decode($nomrango); ?> </h1>
<i class="fa fa-info-circle"> </i>
<h3 class="box-title">PROYECTO : <?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio_label); ?> a la fecha final : <?php echo utf8_decode($fecha_fin_label); ?> </strong></h3>
</div>
              <div class="clearfix">
                      <div class="pull-left tableTools-container2"></div>
                    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones2" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 14px;">
            <tfoot style="display: table-header-group;">
                                   <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                     <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>

                            </tfoot>
          <thead>
             <tr style="background-color: #4f5962;color: white;">
              <th>Entrega</th>
              <th>Tipo Salida</th>
              <th>Proyecto</th>
               <th>Obra</th>
              <th>Despachada</th>
              <th>Recibe</th>
              <th>Fecha-Despacho</th>
             <th>Fecha-Recepción</th>
              <th>Insumo</th>
              <th>Cantidades</th>
              <th>Unidad</th>
              <th>Valor Entregado</th>
            </tr>
            <tr>
            <th>Entrega</th>
            <th>Tipo Salida</th>
            <th>Proyecto</th>
            <th>Obra</th>
            <th>Despachada</th>
            <th>Recibe</th>
            <th>Fecha-Despacho</th>
            <th>Fecha-Recepción</th>
            <th>Insumo</th>
            <th>Cantidades</th>
            <th>Unidad</th>
            <th>Valor Entregado</th>

            </tr>
          </thead>
       <tbody>

        <?php
$rangos       = Obras::unicorangoporobra($getobra, $getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero         = $campo['mes_numero'];
    $fecha_inicio_rango = $campo['fecha_inicio'];
    $fecha_fin_rango    = $campo['fecha_fin'];
    ?>
<?php
}
?>


            <?php

$gastosinventario = Inventario::salidasporfechaobra($fecha_inicio_rango, $fecha_fin_rango, $getobra, $getrubro);
$camposinventario = $gastosinventario->getCampos();
foreach ($camposinventario as $campo) {
    $id                    = $campo['id'];
    $item_id               = $campo['item_id'];
    $requisicion_id        = $campo['requisicion_id'];
    $insumo_id             = $campo['insumo_id'];
    $servicio_id           = $campo['servicio_id'];
    $cantidad              = $campo['cantidad'];
    $salida_id             = $campo['salida_id'];
    $fecha_registro        = $campo['fecha_registro'];
    $estado_detalle_salida = $campo['estado_detalle_salida'];
    $marca_temporal        = $campo['marca_temporal'];
    $creado_por            = $campo['creado_por'];
    $salida_por            = $campo['salida_por'];
    $valor_entregado       = $campo['valor_entregado'];
    $estado_recibido       = $campo['estado_recibido'];
    $id_rubro              = $campo['id_rubro'];
    $id_subrubro           = $campo['id_subrubro'];

    if ($estado_recibido == "Recibido Ok") {
        $fecha_recepcion = Inventario::fecharecepciondespacho($salida_id);
    } else {
        $fecha_recepcion = "<span class='badge bg-red'> Pendiente Recibir</span>";
    }

    $proyecto_id_proyecto = Requisiciones::obtenerIdproyecto($salida_id);
    $recibido_por         = Inventario::obteneusuariorecibe($salida_id);
    if ($insumo_id != 0) {
        $nominsumo       = Insumos::obtenerNombreInsumo($insumo_id);
        $unidadmedida    = Insumos::obtenerUnidadmed($insumo_id);
        $nomunidadmedida = Unidadesmed::obtenerNombre($unidadmedida);
    } else {
        $nominsumo       = Servicios::obtenerNombre($servicio_id);
        $unidadmedida    = Servicios::obtenerUnidadServicio($servicio_id);
        $nomunidadmedida = Unidadesmed::obtenerNombre($unidadmedida);

    }

    $nombredespacha = Usuarios::obtenerNombreUsuario($creado_por);
    $nombrerecibe   = Usuarios::obtenerNombreUsuario($recibido_por);
    $nombreproyecto = Proyectos::obtenerNombreProyecto($proyecto_id_proyecto);
   
    $nombrerubro = Rubros::obtenerNombreRubro($id_rubro);
    $nombresubrubro = Subrubros::obtenerNombreSubrubro($id_subrubro);

    $aplica = Inventario::Aplicaequipo($salida_id);

    if ($aplica == "Si") {
        $obra_id_obra = Inventario::Idequipo($salida_id);
        $nombreobra   = Obras::obtenernombreobra($obra_id_obra);
    } else {
        $nombreobra = "";
    }

    ?>
            <tr>
           <td><?php echo ("RQ" . $requisicion_id . "-" . $item_id); ?></td>
             <td><?php echo utf8_encode($nombrerubro) ?></td>
            <td><?php echo utf8_encode($nombresubrubro) ?></td>
             <td><?php echo utf8_encode($nombreobra) ?></td>
              <td><?php echo utf8_encode($nombredespacha); ?></td>
               <td><?php echo utf8_encode($nombrerecibe); ?></td>
               <td><?php echo utf8_encode($marca_temporal); ?></td>
                <td><?php echo utf8_encode($fecha_recepcion); ?></td>
               <td><?php echo utf8_encode($nominsumo); ?></td>
                <td><?php echo utf8_encode($cantidad); ?></td>
                 <td><?php echo utf8_encode($nomunidadmedida); ?></td>
                <td><?php echo utf8_encode("$" . number_format($valor_entregado, 0)); ?></td>



            </tr>
            <?php
}
?>
          </tbody>
          </table>
        </div> <!-- Fin Row -->


</div>

<script>

function eliminar(rango,obra,equipo){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=proyeccioneslme&&action=eliminarango&&id="+obra+"&&idrango="+rango+"&&equipolme="+equipo;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<script>

function eliminarequipo(obra,equipo){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=proyeccioneslme&&action=eliminaequipo&&id="+obra+"&&equipolme="+equipo;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>


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


<script>
   function format2(n, currency) {
    return currency + " " + n.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
function formatmoneda(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
$.extend( $.fn.dataTable.defaults, {
    responsive: true
} );

       $(document).ready(function() {
    $('#example2').DataTable( {

         "searching": false,
        "ordering": true,
        "paging":   false,
        "info":     true,

         "order": [[ 1, "desc" ]],
         "lengthMenu": [[5000, 7000, 10000, -1], [5000, 7000, 10000, "All"]],

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

    } );
} );
    </script>
<script type="text/javascript">
      jQuery(function($) {

$('#cotizaciones thead tr:eq(1) th').each( function () {
        var title = $('#cotizaciones thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input style="width:100%;border:black solid 1px;" type="text" placeholder=" '+title+'" />' );
    } );

    var table = $('#cotizaciones').DataTable({

      "ordering": false,
      "searching": true,
       "paging": false,
      //"order": [[ 1, "desc" ]],
      "info":false,
       fixedColumns: {
        left: 2,
    },
      orderCellsTop: true,
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

             <?php
$rangos       = Obras::unicorangoporobra($getobra, $getrango);
$campos_rango = $rangos->getcampos();

$bandera = 1;

foreach ($campos_rango as $campo) {
    $id_rango = $campo['id'];
    $bandera  = $bandera + 7;
    ?>

    pageTotal<?php echo ($id_rango) ?> = api
                .column( <?php echo ($bandera) ?>, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             $( api.column( <?php echo ($bandera) ?> ).footer() ).html(
                ''+formatmoneda(pageTotal<?php echo ($id_rango) ?>,'$' )
            );

<?php
}
?>





        },

    });

     $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
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
            null, null,null, null,null,null,null,null, null,
            { "bSortable": false }
          ],
          "aaSorting": [],
          "scrollX": true,



          } );

        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

        new $.fn.dataTable.Buttons( myTable, {
         buttons: [

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


        setTimeout(function() {
          $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);



      })
    </script>

 <script type="text/javascript">
      jQuery(function($) {

$('#cotizaciones2 thead tr:eq(1) th').each( function () {
        var title = $('#cotizaciones2 thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input style="width:100%;border:black solid 1px;" type="text" placeholder=" '+title+'" />' );
    } );

    var table = $('#cotizaciones2').DataTable({
      responsive:true,
      "ordering": true,
        "order": [[ 1, "asc" ]],
        orderCellsTop: true,
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


            // Total over all pages


            pageTotal11 = api
                .column( 11, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );



              $( api.column( 11 ).footer() ).html(
                '$'+formatmoneda(pageTotal11,'' )
                );

        },

    });

    // Apply the search
    table.columns().every(function (index) {
        $('#cotizaciones2 thead tr:eq(1) th:eq(' + index + ') input').on('keyup change', function () {
            table.column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();
        });
    });

        var myTable =
        $('#cotizaciones2')
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
        myTable.buttons().container().appendTo( $('.tableTools-container2') );


        setTimeout(function() {
          $($('.tableTools-container2')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);


      });
    </script>



  <!-- /.content-wrapper -->


