<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include_once 'modelos/rubros.php';
include_once 'controladores/rubrosController.php';

include_once 'modelos/subrubros.php';
include_once 'controladores/subrubrosController.php';

include_once 'modelos/proyeccionesadm.php';
include_once 'controladores/proyeccionesadmController.php';

include_once 'modelos/unidadesmed.php';
include_once 'controladores/unidadesmedController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

$getobra = $_GET['id'];

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
   <?php if ($RolSesion==14 or $RolSesion==15) {
  ?>
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=index&&action=index">Inicio</a></small>
      </h1>

    </section>

  <?php
}else{
  ?>

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=obras&&action=dashboard">Volver a Obras</a></small>
      </h1>
    </section>

  <?php
} 

?>
    <!-- Main content -->
<div style="background-color: white;" class="col-md-12">
<div class="box box-solid">
<div class="box-header with-border">
<i class="fa fa-info-circle"> </i>
<h3 class="box-title"><?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio); ?> </strong></h3>
</div>

<div class="box-body">
   <form role="form" action="?controller=proyeccionesadm&&action=guardar&&id=<?php echo ($getobra); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
<?php
date_default_timezone_set("America/Bogota");
$TiempoActual = date('Y-m-d H:i:s');
$diaactual    = date('Y-m-d');
?>
        <input type="hidden" name="obra_id_obra" value="<?php echo ($getobra); ?>">
        <input type="hidden" name="creado_por" value="<?php echo ($IdSesion); ?>">
        <input type="hidden" name="estado_proyeccion" value="1">
        <input type="hidden" name="proyeccion_publicado" value="1">
        <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">

<dl>
<dd>
  <div class="col-md-12">
    <div class="col-md-6">

    <div  style="display: none;" id="divrubro" class="col-md-12">
        <div class="form-group">
                <label for="sel1">Rubro:<span>*</span></label>
        <select class="form-control" id="rubro_id_rubro" name="rubro_id_rubro" >
            <option value="4" selected>Seleccione...</option>
        </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="sel1">Sub-Rubro Administrativo:<span>*</span></label>
        <select class="form-control mi-selector" id="id_subrubro" name="subrubro_id_subrubro" >
            <option value="">Seleccionar...</option>
            <?php
$rubros = Subrubros::obtenerListaSubrubrosAdmin(4);
foreach ($rubros as $rubro) {
    $id_rubro     = $rubro['id_subrubro'];
    $nombre_rubro = $rubro['nombre_subrubro'];
    ?>
        <option value="<?php echo $id_rubro; ?>"><?php echo utf8_encode($nombre_rubro); ?></option>
        <?php }?>
        </select>
        </div>
    </div>

     <div style="display: none;" class="col-md-12 col-xs-12">
        <label>Cantidad<span>*</span></label>

    <input type="number" step="any" name="cantidad_adm" placeholder="Cantidades Proyectadas" class="form-control" required value="1">
        <small>Decimales separados con punto</small>
    </div>

    <div class="col-md-12">
            <div class="form-group">
                <label>Valor Unitario: <span>*</span></label>
        <input type="text" name="valor_unitario_adm" placeholder="Valor del gasto" class="form-control" id="demo1">
            </div>
    </div>

    </div>

    <div class="col-md-6">


<div class="col-md-12">

    <div class="form-group">
 <label>Selecciona los Rangos que aplican estos valores: <span>*</span></label>
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
    <div class="checkbox">
<label>
    <input type="checkbox" name="rango_id_rango[]" value="<?php echo ($id_rango_th) ?>" ><strong><?php echo ("Rango-" . $mes_numero); ?></strong><?php echo (" Inicia el " . $fecha_inicio . " hasta el " . $fecha_fin); ?>
</label>
</div>
<?php
}

?>


</div>
</div>

    </div>







  </div>

</dd>

<!-- Inicio Libreria formato moneda -->
<script src="dist/js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript">
$("#demo1").maskMoney({
prefix:'$ ', // The symbol to be displayed before the value entered by the user
allowZero:true, // Prevent users from inputing zero
allowNegative:true, // Prevent users from inputing negative values
defaultZero:false, // when the user enters the field, it sets a default mask using zero
thousands: '.', // The thousands separator
decimal: '.' , // The decimal separator
precision: 0, // How many decimal places are allowed
affixesStay : true, // set if the symbol will stay in the field after the user exits the field.
symbolPosition : 'left' // use this setting to position the symbol at the left or right side of the value. default 'left'
}); //
        </script>



<button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i> Guardar</button>

</dl>
 </form>
</div>

</div>

</div>


<div style="background-color: white;" class="col-md-12">

  <div class="box-header with-border">
    <h1>PROYECCIÓN GASTOS ADMIN </h1>
<i class="fa fa-info-circle"> </i>
<h3 class="box-title"><?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio); ?> </strong></h3>
</div>

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
    <th style="background-color: #fcf8e3" class="success"></th>
<?php
}

?>

                            </tfoot>
          <thead>
              <tr style="background-color: #4f5962;color: white;">

            <th>Rubro</th>
            <th>Item</th>
            


             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>

    <th>Vr. Unitario</th>
     <th><?php echo ("Rango-" . $mes_numero); ?></th>
<?php
}

?>


            </tr>
             <tr>
            <th>Rubro</th>
            <th>Item</th>
           

             <?php
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>

    <th>Vr. Unitario</th>
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

$campos = $campos->Getcampos();
foreach ($campos as $campo) {

    $id_proyeccionadm     = $campo['id_proyeccionadm'];
    $rubro_id_rubro       = $campo['rubro_id_rubro'];
    $subrubro_id_subrubro = $campo['subrubro_id_subrubro'];
    $nombrecampo          = Subrubros::obtenerNombreSubrubro($subrubro_id_subrubro);
    $nombrecampo2         = Rubros::obtenerNombreRubro($rubro_id_rubro);

    ?>

 <tr>
     <td>

            <?php echo utf8_decode($nombrecampo2); ?>
        </td>
          <td>

            <?php echo utf8_decode($nombrecampo); ?>
            <br>
    <a href="#" onclick="eliminarequipo(<?php echo $getobra; ?>,<?php echo $subrubro_id_subrubro; ?>);" class="pull-right tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                <i class="fa fa-trash bigger-110 "> Eliminar</i>
    </a>
        </td>
       




<?php
$rangos       = Obras::rangosporobra($getobra);
    $campos_rango = $rangos->getcampos();

    foreach ($campos_rango as $campo) {

        $id_rango_act     = $campo['id'];
        $mes_numero_act   = $campo['mes_numero'];
        $fecha_inicio_act = $campo['fecha_inicio'];
        $fecha_fin_act    = $campo['fecha_fin'];

        $sqlcantidades    = Proyeccionesadm::sqlcantidades($getobra, $id_rango_act, $subrubro_id_subrubro);
        $sqlvalorunitario = Proyeccionesadm::sqlvalorunitario($getobra, $id_rango_act, $subrubro_id_subrubro);
        $sqlvalortotal    = Proyeccionesadm::sqlvalortotal($getobra, $id_rango_act, $subrubro_id_subrubro);

        ?>

 <td>
     <?php
echo ("Cant.:" . round($sqlcantidades, 2));
        echo ("<br>");
        echo ("$" . number_format($sqlvalorunitario, 0));
        ?>
         <a href="#" onclick="eliminar(<?php echo $id_rango_act; ?>,<?php echo $getobra; ?>,<?php echo $subrubro_id_subrubro; ?>);" class="pull-right tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                <i class="fa fa-trash bigger-110 "></i>
      </a>
 </td>
 <td>
     <?php
echo ("$" . number_format($sqlvalortotal, 0));
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

</div>

<script>

function eliminar(rango,obra,equipo){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=proyeccionesadm&&action=eliminarango&&id="+obra+"&&idrango="+rango+"&&equipolme="+equipo;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<script>

function eliminarequipo(obra,equipo){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=proyeccionesadm&&action=eliminafila&&id="+obra+"&&equipolme="+equipo;
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
$rangos       = Obras::rangosporobra($getobra);
$campos_rango = $rangos->getcampos();

$bandera = 1;

foreach ($campos_rango as $campo) {
    $id_rango = $campo['id'];
    $bandera  = $bandera + 2;
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



  <!-- /.content-wrapper -->


