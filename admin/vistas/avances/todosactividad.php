<?php
ini_set('display_errors', '0');

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'modelos/frentes.php';
include_once 'controladores/frentesController.php';

include_once 'modelos/avances.php';
include_once 'controladores/avancesController.php';

include_once 'modelos/funcionarios.php';
include_once 'controladores/funcionariosController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

$getobra      = $_GET['id_obra'];
$getactividad = $_GET['id_act'];
$getid= $_GET['editarid'];

 $datosact = Obras::editaractividadPor($getactividad);
            $datosact = $datosact->getCampos();
            foreach ($datosact as $campo_act){

    $capitulo_id_capitulo = $campo_act['capitulo_id_capitulo'];
    $obra_id_obra         = $campo_act['obra_id_obra'];
    $cod_actividad        = $campo_act['cod_actividad'];
    $detalle              = $campo_act['detalle'];
    $unidad_id_unidad     = $campo_act['unidad_id_unidad'];
    $cantidad             = $campo_act['cantidad'];
    $valor_unitario       = $campo_act['valor_unitario'];
    $valor_total          = $campo_act['valor_total'];
    $marca_temporal       = $campo_act['marca_temporal'];
    $creado_por           = $campo_act['creado_por'];
    $estado_actividad     = $campo_act['estado_actividad'];
    $actividad_publicada  = $campo_act['actividad_publicada'];
    $prioridad            = $campo_act['prioridad'];
    $nomunidad            = Unidadesmed::obtenerNombre($unidad_id_unidad);

            }
    $nomobra      = Obras::obtenernombreobra($obra_id_obra);
    $sqlavances_act = Obras::sqlavancesporactividad($getactividad);
    $porcentaje_act = Formulaporcentaje($sqlavances_act,$cantidad);





//id, fecha_reporte, cliente_id_cliente, producto_id_producto, valor_m3, cantidad, creado_por, estado_reporte, reporte_publicado, marca_temporal, observaciones.

if (isset($_POST['daterange'])) {
    $fechaform = $_POST['daterange'];
} elseif (isset($_GET['daterange'])) {
    $fechaform = $_GET['daterange'];
}

date_default_timezone_set("America/Bogota");
$MarcaTemporal  = date('Y-m-d');
$FechaInicioDia = ($MarcaTemporal . " 00:00:000");
$FechaFinalDia  = ($MarcaTemporal . " 23:59:000");
//echo("FECHA QUE LLEGA:".$fechaform."<br>");

if ($fechaform != "") {
    $arreglo         = explode("-", $fechaform);
    $FechaIn         = $arreglo[0];
    $FechaFn         = $arreglo[1];
    $vectorfechaIn   = explode("/", $FechaIn);
    $vectorfechaFn   = explode("/", $FechaFn);
    $arreglofechauno = $vectorfechaIn[2] . "-" . $vectorfechaIn[0] . "-" . $vectorfechaIn[1];
    $arreglofechados = $vectorfechaFn[2] . "-" . $vectorfechaFn[0] . "-" . $vectorfechaFn[1];

    $FechaUno = str_replace(" ", "", $arreglofechauno);
    $FechaDos = str_replace(" ", "", $arreglofechados);
}

// Validación de la fecha en que inicia el Día

if ($FechaUno == "") {
    $FechaStart  = $FechaInicioDia;
    $datofechain = $MarcaTemporal;
} else {
    $FechaStart  = ($FechaUno . " 00:00:000");
    $datofechain = $FechaUno;
}
// Validación de la fecha en que Termina el Día
if ($FechaDos == "") {
    $FechaEnd       = $FechaFinalDia;
    $datofechafinal = $MarcaTemporal;
} else {
    $FechaEnd        = ($FechaDos . " 23:59:000");
    $limpiarvariable = str_replace(" ", "", $FechaDos);
    $datofechafinal  = $limpiarvariable;
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


<?php if ($RolSesion==14 or $RolSesion==15) {
  ?>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="?controller=obras&&action=avance_obra&&id=<?php echo ($getobra) ?>"><?php echo utf8_decode($nomobra); ?></a></li>

          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <?php
}else{
  ?>

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
          <li class="breadcrumb-item"><a href="?controller=obras&&action=dashboard">Obras</a></li>
            <li class="breadcrumb-item active"><a href="?controller=obras&&action=avance_obra&&id=<?php echo ($getobra) ?>"><?php echo utf8_decode($nomobra); ?></a></li>

          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <?php
} 

?>

    <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
 <?php 
if ($getid != '') {
    require_once 'editar_avance.php';
}
  ?>
      <div class="row">
         <div class="col-md-6">
            <div class="box">
<div class="box-header">
<h3 class="box-title">Proyecto: <?php echo utf8_decode($nomobra); ?></h3>
</div>

<div class="box-body no-padding">
<table class="table table-striped">
<tbody>
  <tr>
    <th>Cód</th>
    <th>Actividad</th>
    <th>Cant. Original</th>
    <th>Avance</th>
    <th>%</th>
</tr>
<tr>
<td><?php echo utf8_decode($cod_actividad); ?></td>
<td><?php echo utf8_decode($detalle); ?></td>
<td><?php echo utf8_decode(round($cantidad,2)." ".$nomunidad); ?></td>
<td><?php echo utf8_decode(round($sqlavances_act)." ".$nomunidad); ?></td>
<td>
   <?php if ($porcentaje_act>100) {
          echo("<strong class='text-danger'>".$porcentaje_act." % <i class='fa fa-arrow-circle-up'></i></strong>");
        }elseif($porcentaje_act<100 and $porcentaje_act>=1){
           echo("<strong  class='text-warning'>".$porcentaje_act." % <i class='fa fa-arrow-circle-right'></i></strong>");
        }elseif($porcentaje_act==100){
          echo("<strong  class='text-success'>".$porcentaje_act." % <i class='fa fa-thumbs-up'></i></strong>");
        }elseif ($porcentaje_act==0) {
          echo("<strong  class='text-info'>".$porcentaje_act." % </strong>");
        }

         ?>
</td>
</tr>

</tbody></table>
</div>

</div>
            </div>

             <div class="col-md-6">
            <div class="box">
<div class="box-header">
<h3 class="box-title">Avance por Frente</h3>
</div>

<div class="box-body no-padding">
<table class="table table-striped">
<tbody>
  <tr>
      <th style="width: 10px">#</th>
      <th>Frente</th>
      <th>Avance</th>
      <th style="width: 40px">Label</th>
</tr>

<?php 

    $frentesunicos = Avances::listafrentesporactividad($getactividad);
    $frentesunicos = $frentesunicos->getCampos();
    foreach ($frentesunicos as $campo_frente) {
      $frente_id=$campo_frente['frente_id'];
     $nomfrente = Frentes::obtenerNombre($frente_id);
     $cantidadavancefrente = Avances::sqlavancesporactividadfrente($getactividad,$frente_id);

     $porcentaje_frente = Formulaporcentaje($cantidadavancefrente,$sqlavances_act);

?>
  <tr>
      <td>1.</td>
      <td><?php echo utf8_decode($nomfrente); ?></td>
      <td>
        <?php echo utf8_decode(round($cantidadavancefrente,2)." ".$nomunidad); ?>
      </td>
      <td>
         <?php if ($porcentaje_frente>100) {
          echo("<strong class='text-danger'>".$porcentaje_frente." % <i class='fa fa-arrow-circle-up'></i></strong>");
        }elseif($porcentaje_frente<100 and $porcentaje_frente>=1){
           echo("<strong  class='text-warning'>".$porcentaje_frente." % <i class='fa fa-arrow-circle-right'></i></strong>");
        }elseif($porcentaje_frente==100){
          echo("<strong  class='text-success'>".$porcentaje_frente." % <i class='fa fa-thumbs-up'></i></strong>");
        }elseif ($porcentaje_frente==0) {
          echo("<strong  class='text-info'>".$porcentaje_frente." % </strong>");
        }

         ?>
      </td>
</tr>


<?php

    }

 ?>



</tbody></table>
</div>

</div>
            </div>


            <!-- ESTE DIV LO USO PARA CENTRAR EL FORMULARIO -->
            <!-- left column -->
           <div class="col-md-12">

          
               <div class="row">
          <!-- MAP & BOX PANE -->
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte </h3>



              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
                <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                          <div class="row">
        <form action="?controller=horasmq&&action=horasporfecha" method="post" id="FormFechas" autocomplete="off">
         <div class="col-md-8">
                        <div class="form-group">
                          <label>Seleccione el Rango de Fecha<span>*</span></label>
                          <input type="text"  name="daterange" class="form-control" required value="">
                        </div>
                      </div>
          <div class="form-group">
            <div class="col-xs-12 col-sm-6">
              <button class="btn btn-primary btn-sm" type="Submit">Realizar Consulta</button>
          </div>
          </div>
        </form>
        <script type="text/javascript">
  $('input[name="daterange"]').daterangepicker({
    ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este Mes': [moment().startOf('month'), moment().endOf('month')],
        'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "desde",
        "toLabel": "hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    //"startDate": "03/24/2019",
    //"endDate": "03/30/2019",
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>
      </div>
       <div class="col-sm-12">
        <?php
if ($fechaform != "") {
    ?>
           <h3 class="m-0 text-dark">Reporte Horas Máquina del <?php echo (fechalarga($datofechain)) ?> al <?php echo (fechalarga($datofechafinal)) ?></h3>
          <?php
} else {
    ?>
           <h3 class="m-0 text-dark">Reporte Total Horas Máquinaria</h3>
          <?php
}

?>

        </div><!-- /.col -->
              <div class="clearfix">
                      <div class="pull-left tableTools-container"></div>
                    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 14px;">
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

                            </tfoot>
          <thead>
            <tr style="background-color: #4f5962;color: white;">
              <th style="width: 2%;"><i class="fa fa-edit"></i></th>
              <th>Obra</th>
              <th>Capitulo</th>
              <th>Actividad</th>
              <th>Frente</th>
              <th>Fecha</th>
              <th>Reportado por</th>
              <th>Localización</th>
              <th>Avance</th>
              <th>Observaciones</th>
              <th>Acta</th>
            </tr>
            <tr>
              <th style="width: 2%;"><i class="fa fa-edit"></i></th>
              <th>Obra</th>
              <th>Capitulo</th>
              <th>Actividad</th>
              <th>Frente</th>
              <th>Fecha</th>
              <th>Reportado por</th>
              <th>Localización</th>
              <th>Avance</th>
              <th>Observaciones</th>
              <th>Acta</th>
            </tr>
          </thead>
       <tbody>
            <?php
if ($fechaform != "") {
    $res    = Avances::porfecha($FechaStart, $FechaEnd);
    $campos = $res->getCampos();
} else {
    $campos = $campos->getCampos();
}
foreach ($campos as $campo) {
    $id                     = $campo['id_cantidades'];
    $obra_id_obra           = $campo['obra_id_obra'];
    $capitulo_id_capitulo   = $campo['capitulo_id_capitulo'];
    $actividad_id_actividad = $campo['actividad_id_actividad'];
    $frente_id_frente       = $campo['frente_id_frente'];
    $localizacion           = $campo['localizacion'];
    $observaciones          = $campo['observaciones'];
    $fecha_reporte          = $campo['fecha_reporte'];
    $avance                 = $campo['avance'];
    $acta_numero            = $campo['acta_numero'];
    $creado_por             = $campo['creado_por'];
    $estado_avance          = $campo['estado_avance'];
    $avance_publicado       = $campo['avance_publicado'];
    $marca_temporal         = $campo['marca_temporal'];

    $nomobra       = Obras::obtenernombreobra($obra_id_obra);
    $nomfrente     = Frentes::obtenerNombre($frente_id_frente);
    $nomcapitulo   = Obras::obtenernombrecapitulo($capitulo_id_capitulo);
    $nomreportador = usuarios::obtenerNombreUsuario($creado_por);

    ?>
            <tr>
              <td>


              <a href="?controller=avances&&action=todosporactividad&&id_obra=<?php echo($getobra) ?>&&id_act=<?php echo($getactividad) ?>&&editarid=<?php echo($id) ?>" class="tooltip-primary text-success" data-rel="tooltip" data-placement="top" title="" data-original-title="Editar">
                <i class="fa fa-edit bigger-110 "></i>
              </a>
              <a href="#" onclick="eliminar(<?php echo $id; ?>,<?php echo $getactividad; ?>,<?php echo $getobra; ?>);" class="tooltip-primary text-danger" data-rel="tooltip" data-placement="top" title="" data-original-title="Eliminar">
                <i class="fa fa-trash bigger-110 "></i>
              </a>
              </td>
              <td><?php echo utf8_decode($nomobra) ?></td>
              <td><?php echo utf8_decode($nomcapitulo) ?></td>
              <td><?php echo utf8_decode($detalle) ?></td>
              <td><?php echo utf8_decode($nomfrente) ?></td>
              <td><?php echo utf8_decode($fecha_reporte) ?></td>
              <td><?php echo utf8_decode($nomreportador) ?></td>
              <td><?php echo utf8_decode($localizacion) ?></td>
              <td><?php echo utf8_decode($avance) ?></td>
              <td><?php echo utf8_decode($observaciones) ?></td>
              <td><?php echo utf8_decode($acta_numero) ?></td>



            </tr>
            <?php
}
?>
          </tbody>
          </table>
        </div> <!-- Fin Row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
           </div>

                     

          </div> <!-- FIN DE ROW-->
        </div><!-- FIN DE CONTAINER FORMULARIO-->
      </div> <!-- Fin Row -->
    </div> <!-- Fin Container -->
  </div> <!-- Fin Content -->

 
</div> <!-- Fin Content-Wrapper -->
<script>
function eliminar(id,act,obra){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=avances&&action=eliminar&&id="+id+"&&id_act="+act+"&&id_obra="+obra;
else
  //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
    alert('No se ha podido eliminar el registro...')
}
</script>
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
<script type="text/javascript">
      jQuery(function($) {

$('#cotizaciones thead tr:eq(1) th').each( function () {
        var title = $('#cotizaciones thead tr:eq(0) th').eq( $(this).index() ).text();
        $(this).html( '<input style="width:100%;border:black solid 1px;" type="text" placeholder=" '+title+'" />' );
    } );

    var table = $('#cotizaciones').DataTable({
      responsive:true,
      "ordering": true,
        "order": [[ 1, "desc" ]],
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



          pageTotal8 = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );









   $( api.column( 8 ).footer() ).html(
                ''+formatmoneda(pageTotal8,'' )
            );

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
