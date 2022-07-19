<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include_once 'modelos/listamo.php';
include_once 'controladores/listamoController.php';

include_once 'modelos/proyeccioneslmo.php';
include_once 'controladores/proyeccioneslmoController.php';

include_once 'modelos/unidadesmed.php';
include_once 'controladores/unidadesmedController.php';

include_once 'modelos/rangos.php';
include_once 'controladores/rangosController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

$getobra = $_GET['id'];
$getrango = $_GET['rangoid'];

$nomrango = Rangos::obtenerNombre($getrango);
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();
foreach ($campos_rango as $campo) {
   
    $fecha_inicio_label = $campo['fecha_inicio'];
    $fecha_fin_label    = $campo['fecha_fin'];

}


$resultado = Obras::obtenerpaginapor($getobra);

$campos_obra=$resultado->getcampos();

foreach ($campos_obra as $campoobra) {
    $nombre_obra=$campoobra['nombre_obra'];  
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

         <small><a class="btn btn-warning btn-sm" href="?controller=rangos&&action=todosobra&&id_obra=<?php echo($getobra); ?>">Volver a Rangos</a></small>

      </h1>

    </section>

  <?php
}else{
  ?>

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=obras&&action=dashboard">Volver a Obras</a></small>
         <small><a class="btn btn-warning btn-sm" href="?controller=rangos&&action=todosobra&&id_obra=<?php echo($getobra); ?>">Volver a Rangos</a></small>

      </h1>
    </section>


  <?php
} 

?>


<div style="background-color: white;" class="col-md-12">

  <div class="box-header with-border">
    <h1>HA SELECCIONADO EL RANGO-<?php echo utf8_decode($nomrango); ?> </h1>
<i class="fa fa-info-circle"> </i>
<h3 class="box-title">PROYECTO : <?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio_label); ?> a la fecha final : <?php echo utf8_decode($fecha_fin_label); ?> </strong></h3>
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

$rangos       = Obras::unicorangoporobra($getobra,$getrango);
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
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
    <th>Vr. Unitario</th>
     <th><?php echo ("Rango-" . $mes_numero); ?></th>
      <th>Cantidad Proyectada</th>
<?php
}

?>

            </tr>
             <tr>

            <th>Equipos</th>
            <th>Unidad</th>

             <?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    ?>
    
    <th>Vr. Unitario</th>
     <th><?php echo ("Rango-" . $mes_numero); ?></th>
     <th>Cantidad Proyectada</th>
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

    $id_proyeccionlmo = $campo['id_proyeccionlmo'];
    $lmo_id_lmo       = $campo['lmo_id_lmo'];
    $nomequipo = Listamo::obtenerNombre($lmo_id_lmo);
    $unidadmedidaequipo=Listamo::obtenerUnidadmedida($lmo_id_lmo);
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
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
    $campos_rango = $rangos->getcampos();

    foreach ($campos_rango as $campo) {

        $id_rango_act     = $campo['id'];
        $mes_numero_act   = $campo['mes_numero'];
        $fecha_inicio_act = $campo['fecha_inicio'];
        $fecha_fin_act    = $campo['fecha_fin'];

        $sqlcantidades= Proyeccioneslmo::sqlcantidades($getobra,$id_rango_act,$lmo_id_lmo);
        $sqlvalorunitario= Proyeccioneslmo::sqlvalorunitario($getobra,$id_rango_act,$lmo_id_lmo);
        $sqlvalortotal= Proyeccioneslmo::sqlvalortotal($getobra,$id_rango_act,$lmo_id_lmo);

        ?>

 <td>
     <?php
           echo ("$".number_format($sqlvalorunitario,0));
        ?>
 </td>
 <td>
     <?php
            echo ("$".number_format($sqlvalortotal,0));
        ?>
 </td>
 <td>
     <?php 
     echo (round($sqlcantidades,2));
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
     window.location.href="?controller=proyeccioneslmo&&action=eliminarango&&id="+obra+"&&idrango="+rango+"&&equipolmo="+equipo;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>

<script>

function eliminarequipo(obra,equipo){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=proyeccioneslmo&&action=eliminaequipo&&id="+obra+"&&equipolmo="+equipo;
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
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

$bandera=1;

foreach ($campos_rango as $campo) {
    $id_rango   = $campo['id'];
    $bandera=$bandera+2;
    ?>

    pageTotal<?php echo($id_rango) ?> = api
                .column( <?php echo($bandera) ?>, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             $( api.column( <?php echo($bandera) ?> ).footer() ).html(
                ''+formatmoneda(pageTotal<?php echo($id_rango) ?>,'$' )
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


