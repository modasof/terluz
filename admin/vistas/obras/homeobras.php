<?php 
error_reporting(E_ALL);
ini_set('display_errors', '0');
include 'vistas/index/funciones.php';
include_once 'modelos/cuentas.php';
include_once 'controladores/cuentasController.php';
include_once 'modelos/gestiondocumental.php';
include_once 'controladores/gestiondocumentalController.php';

include_once 'modelos/requisicionesitems.php';
include_once 'controladores/requisicionesitemsController.php';

include_once 'modelos/requisiciones.php';
include_once 'controladores/requisicionesController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'modelos/frentes.php';
include_once 'controladores/frentesController.php';

include_once 'modelos/personalobras.php';
include_once 'controladores/personalobrasController.php';

include_once 'modelos/gestiondocumentaleq.php';
include_once 'controladores/gestiondocumentaleqController.php';

include_once 'controladores/equiposController.php';
include_once 'modelos/equipos.php';

include_once 'controladores/concretoController.php';
include_once 'modelos/concreto.php';

include_once 'controladores/reportesController.php';
include_once 'modelos/reportes.php';

include_once 'controladores/informecuentasporcobrarController.php';
include_once 'modelos/informecuentasporcobrar.php';

include_once 'controladores/equiposController.php';

include 'vistas/index/estadisticas.php';

include 'vistas/index/estadisticas_acpm.php';

include 'vistas/index/estadisticas_despachoscl.php';
include 'vistas/index/estadisticas_index.php';
include 'vistas/index/estadisticas_indexequipos.php';
include 'vistas/index/estadisticasinforme1.php';

include 'vistas/obras/formulas.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion = $_SESSION['IdUser'];

date_default_timezone_set("America/Bogota");
$totaldiasmes= date('t');


$mesactual= date('n');
$hoy= date('d');
$ayer=$hoy-1;
$antier=$hoy-6;


# ================================================
# =           Parametrización del año            =
# ================================================

if (isset($_GET['consultaAnual'])) {
    $anoactual = $_GET['consultaAnual'];
    $tope= 13;
}else{
    $anoactual   = date('Y');
    $tope= $mesactual+1;
}

# ======  End of Parametrización del año   =======


$mesanterior=$mesactual-1;

  $primerdiames=$mesactual."/01/".$anoactual;
  $ultimodiames=$mesactual."/".$totaldiasmes."/".$anoactual;

  $primerdiamescons=$anoactual."-".$mesactual."-01";
  $ultimodiamescons=$anoactual."-".$mesactual."-".$totaldiasmes;

$fechaform=$_POST['daterange'];
$FechaInicioDia=($primerdiamescons." 00:00:000");
$FechaFinalDia=($ultimodiamescons." 23:59:000");
//echo("FECHA QUE LLEGA:".$FechaInicioDia1."<br>");

$primerdiamesanterior=$anoactual."-".$mesanterior."-01";
$ultimodiamesanterior=$anoactual."-".$mesanterior."-".$totaldiasmes;
// Fecha del Mes anterior
$InicioMesanterior=($primerdiamesanterior." 00:00:000");
$FinalMesanterior=($ultimodiamesanterior." 23:59:000");


date_default_timezone_set("America/Bogota");
$MarcaTemporal = date('Y-m-d');
$MarcaTemporalAyer = $anoactual."-".$mesactual."-".$ayer;
$MarcaTemporalAntier = $anoactual."-".$mesactual."-".$antier;


$FechaInicioDiaActual=($MarcaTemporal." 00:00:000");
$FechaFinalDiaActual=($MarcaTemporal." 23:59:000");

$FechaInicioDiaAnterior=$anoactual."-".$mesactual."-".$ayer." 00:00:0000";
$FechaFinalDiaAnterior=$anoactual."-".$mesactual."-".$ayer." 23:59:0000";

 $fecha_actual = date("d-m-Y");
$semanaantes=date("Y-m-d",strtotime($fecha_actual."- 1 week")); 
$FechaInicio7dias=$semanaantes." 00:00:0000";
$FechaFinal7dias=$anoactual."-".$mesactual."-".$hoy." 23:59:0000";

$quincedias=date("Y-m-d",strtotime($fecha_actual."- 2 week")); 
$FechaInicio15dias=$quincedias." 00:00:0000";
$FechaFinal15dias=$anoactual."-".$mesactual."-".$hoy." 23:59:0000";

$sesentadias=date("Y-m-d",strtotime($fecha_actual."- 8 week")); 
$FechaInicio60dias=$sesentadias." 00:00:0000";
$FechaFinal60dias=$anoactual."-".$mesactual."-".$hoy." 23:59:0000";



$inicio2021="2021-01-01 00:00:0000";
$FechaFinal60dias=$anoactual."-".$mesactual."-".$hoy." 23:59:0000";

//echo("FECHA QUE LLEGA:".$fechaform."<br>");

$Sumacombustibledia=ReporteCombustibledia($FechaInicio15dias,$FechaFinal15dias);

if ($fechaform!="") {
      $arreglo=explode("-", $fechaform);
      $FechaIn=$arreglo[0];
      $FechaFn=$arreglo[1];
      $vectorfechaIn=explode("/", $FechaIn);
      $vectorfechaFn=explode("/", $FechaFn);
      $arreglofechauno=$vectorfechaIn[2]."-".$vectorfechaIn[0]."-".$vectorfechaIn[1];
      $arreglofechados=$vectorfechaFn[2]."-".$vectorfechaFn[0]."-".$vectorfechaFn[1];

      $FechaUno=str_replace(" ", "", $arreglofechauno);
      $FechaDos=str_replace(" ", "", $arreglofechados);
}

// Validación de la fecha en que inicia el Día

if ($FechaUno=="") {
  $FechaStart=$FechaInicioDia;
  $datofechain=$primerdiames;
          }
else
  {
    $FechaStart=($FechaUno." 00:00:000");
    $datofechain=$FechaUno;
  }
// Validación de la fecha en que Termina el Día
if ($FechaDos=="") {
    $FechaEnd=$FechaFinalDia;
    $datofechafinal=$ultimodiames;
  }
else
  {
    $FechaEnd=($FechaDos." 23:59:000");
    $limpiarvariable=str_replace(" ", "", $FechaDos);
    $datofechafinal=$limpiarvariable;
  }

 ?>

<div class="row">
    

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Terluz 
        <small><?php echo ($anoactual); ?></small>
      </h1>
     
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->

<?php 
        include_once 'tabla-obras.php';
 ?>


</div>

</div>

<script>

function eliminar(id){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=obras&&action=eliminarobra&&id="+id;
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

          <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
          <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
          <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

          <script src="dist/js/buttons.colVis.min.js"></script>
          <script src="dist/js/buttons.print.min.js"></script>
           <script src="dist/js/dataTables.select.min.js"></script>
           <script src="dist/js/buttons.flash.min.js"></script>

<script type="text/javascript">
      jQuery(function($) {



    var table = $('#cotizacionesnuevo').DataTable({

      responsive:true,
     "scrollX": true,
     "ordering": true,
      "searching": false,
       "paging":   false,
        "info":     false,

        "order": [[ <?php echo ($tope - $topemin + 1); ?>, "desc" ]],
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

    });
      })
    </script>
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
<!-- page script -->
<script>
  $(function () {
    $('#cotizaciones33').DataTable({
      "paging": true,
      "lengthChange": true,
      "lengthMenu": [[25, 50, 150, -1], [25, 50, 150, "All"]],
      "searching": false,
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
      "responsive":true,
      "ordering": true,
      "searching": false,
       "paging": false,
      "order": [[ 1, "desc" ]],
      "info":false,
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

             pageTotal1 = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

              pageTotal2 = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );



             // Update footer

               $( api.column( 1 ).footer() ).html(
                ''+formatmoneda(pageTotal1,'Vj' )
            );


              $( api.column( 2 ).footer() ).html(
                ''+formatmoneda(pageTotal2,'m3' )
            );

             $( api.column( 3 ).footer() ).html(
                ''+formatmoneda(pageTotal3,'$' )
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



  <!-- /.content-wrapper -->


