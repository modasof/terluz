<!-- Content Wrapper. Contains page content -->
  <?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

include_once 'controladores/insumosController.php';
include_once 'modelos/insumos.php';

include_once 'controladores/serviciosController.php';
include_once 'modelos/servicios.php';

include_once 'controladores/equipostemporalesController.php';
include_once 'modelos/equipostemporales.php';

include_once 'controladores/inventarioController.php';
include_once 'modelos/inventario.php';

include_once 'controladores/unidadesmedController.php';
include_once 'modelos/unidadesmed.php';

include_once 'controladores/usuariosController.php';
include_once 'modelos/usuarios.php';

include_once 'controladores/unidadesmedController.php';
include_once 'modelos/unidadesmed.php';

include_once 'controladores/proveedoresController.php';
include_once 'modelos/proveedores.php';

include_once 'controladores/categoriainsumosController.php';
include_once 'modelos/categoriainsumos.php';

include_once 'controladores/estadosreqController.php';
include_once 'modelos/estadosreq.php';

include_once 'controladores/requisicionesitemsController.php';
include_once 'modelos/requisicionesitems.php';

include_once 'controladores/requisicionesController.php';
include_once 'modelos/requisiciones.php';

include_once 'controladores/proyectosController.php';
include_once 'modelos/proyectos.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

require_once 'vistas/index/header-formdate.php';

?>

<!-- CCS Y JS DATERANGE -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard Gerencia
        <small>version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard Gerencia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
       
<div class="col-md-12">
   <div class="col-md-3">
          <div class="box">
           
            <div class="box-body">
              <table class="table table-bordered" style="font-size: 13px;">
                <tbody><tr>
                  <th >Aprobar RQ</th>
                  <th style="width: 10px">Total</th>
                  <th>Ver</th>
                </tr>
               <?php
# =============================================
# =           Lista de Estados Requisiciones         =
# =============================================

$rubros = Estadosreq::ObtenerListaEstados();
foreach ($rubros as $campo) {
    $id            = $campo['id'];
    $nombre        = $campo['nombre'];
    $cantidaditems = contarregistrosporestado($id, $IdSesion);

    if ($id==7) {
?>
                <tr>
                  <td><?php echo ($nombre); ?></td>
                  <td><?php echo ($cantidaditems); ?></td>
                  <td><a href="?controller=requisiciones&&action=todosporusuarioestado&&id=<?php echo($idse
                  ) ?>&&estadosolicitado=<?php echo($id); ?>">Ver</a></td>
                </tr>
                <?php
              }
}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


         <div class="col-md-3 ">
          <div class="box bg-success"> 
            <div class="box-body">
              <table class="table table-bordered" style="font-size: 13px;">
                <tbody><tr>
                  <th >Inventario Entradas</th>
                  <th style="width: 10px">Total</th>
                  <th>Ver</th>
                </tr>
               <?php
# =============================================
# =           Lista de Estados Requisiciones         =
# =============================================

$rubros = Estadosreq::ObtenerListaEstados();
foreach ($rubros as $campo) {
    $id            = $campo['id'];
    $nombre        = $campo['nombre'];
    $cantidaditems = contarregistrosporestado($id, $IdSesion);

    if ($id==7) {
?>
                <tr>
                  <td><?php echo ($nombre); ?></td>
                  <td><?php echo ($cantidaditems); ?></td>
                  <td><a href="?controller=requisiciones&&action=todosporusuarioestado&&id=<?php echo($idse
                  ) ?>&&estadosolicitado=<?php echo($id); ?>">Ver</a></td>
                </tr>
                <?php
              }
}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


 <div class="col-md-3 ">
          <div class="box bg-danger"> 
            <div class="box-body">
              <table class="table table-bordered" style="font-size: 13px;">
                <tbody><tr>
                  <th >Inventario Salidas</th>
                  <th style="width: 10px">Total</th>
                  <th>Ver</th>
                </tr>
               <?php
# =============================================
# =           Lista de Estados Requisiciones         =
# =============================================

$rubros = Estadosreq::ObtenerListaEstados();
foreach ($rubros as $campo) {
    $id            = $campo['id'];
    $nombre        = $campo['nombre'];
    $cantidaditems = contarregistrosporestado($id, $IdSesion);

    if ($id==7) {
?>
                <tr>
                  <td><?php echo ($nombre); ?></td>
                  <td><?php echo ($cantidaditems); ?></td>
                  <td><a href="?controller=requisiciones&&action=todosporusuarioestado&&id=<?php echo($idse
                  ) ?>&&estadosolicitado=<?php echo($id); ?>">Ver</a></td>
                </tr>
                <?php
              }
}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


 <div class="col-md-3 ">
          <div class="box bg-info"> 
            <div class="box-body">
              <table class="table table-bordered" style="font-size: 13px;">
                <tbody><tr>
                  <th >Inventario Actual</th>
                  <th style="width: 10px">Total</th>
                  <th>Ver</th>
                </tr>
               <?php
# =============================================
# =           Lista de Estados Requisiciones         =
# =============================================

$rubros = Estadosreq::ObtenerListaEstados();
foreach ($rubros as $campo) {
    $id            = $campo['id'];
    $nombre        = $campo['nombre'];
    $cantidaditems = contarregistrosporestado($id, $IdSesion);

    if ($id==7) {
?>
                <tr>
                  <td><?php echo ($nombre); ?></td>
                  <td><?php echo ($cantidaditems); ?></td>
                  <td><a href="?controller=requisiciones&&action=todosporusuarioestado&&id=<?php echo($idse
                  ) ?>&&estadosolicitado=<?php echo($id); ?>">Ver</a></td>
                </tr>
                <?php
              }
}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>



      <div class="col-md-4">
          <div class="box">
            <div  class="box-header with-border">
              <h3 class="box-title "><strong>Total Entregado</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered" style="font-size: 13px;">
                <tbody><tr>
                  <th >Proyecto</th>
                  <th style="width: 35%;">Total</th>
                </tr>
               <?php
# =============================================
# =           Lista de Estados Requisiciones         =
# =============================================

$rubros = Proyectos::obtenerListaProyectos();
foreach ($rubros as $campo) {
    $id            = $campo['id_proyecto'];
    $nombre        = $campo['nombre_proyecto'];
    $cantidaditems = contarregistrosporestado($id, $IdSesion);
?>
                <tr>
                  <td><?php echo ($nombre); ?></td>
                  <td><a href="?controller=requisiciones&&action=todosporusuarioestado&&id=<?php echo($idse
                  ) ?>&&estadosolicitado=<?php echo($id); ?>">$ 1.579.000.000</a></td>
                </tr>
                <?php
}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


  
</div>
        

      </div>
    </section>
    <!-- /.content -->
  </div>
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
       "searching": true,
        "paging":   false,
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




             pageTotal2 = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

               //$( api.column( 2 ).footer() ).html(
               // ''+formatmoneda(pageTotal2,'' )
               // );

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


        setTimeout(function() {
          $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
          });
        }, 500);


      });
    </script>
