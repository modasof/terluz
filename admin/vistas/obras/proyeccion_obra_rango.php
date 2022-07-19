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

include_once 'modelos/rangos.php';
include_once 'controladores/rangosController.php';

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
$IdSesion  = $_SESSION['IdUser'];

date_default_timezone_set("America/Bogota");

$campo_diaactual     = date('Y-m-d');
$campo_marcatemporal = date('Y-m-d H:i:s');

$totaldiasmes = date('t');

$getobra = $_GET['id'];
$getrango = $_GET['rangoid'];
$nomrango = Rangos::obtenerNombre($getrango);
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();
foreach ($campos_rango as $campo) {
   
    $fecha_inicio_label = $campo['fecha_inicio'];
    $fecha_fin_label    = $campo['fecha_fin'];

}

$mesactual = date('n');
$hoy       = date('d');
$ayer      = $hoy - 1;
$antier    = $hoy - 6;

$campos = $campos->Getcampos();
foreach ($campos as $campo) {

    $id_obra          = $campo['id_obra'];
    $nombre_obra      = $campo['nombre_obra'];
    $contrato_obra    = $campo['contrato_obra'];
    $contratante      = $campo['contratante'];
    $objeto           = $campo['objeto'];
    $interventoria    = $campo['interventoria'];
    $fecha_inicio     = $campo['fecha_inicio'];
    $ciudad_id_ciudad = $campo['ciudad_id_ciudad'];
    $marca_temporal   = $campo['marca_temporal'];
    $obra_estado      = $campo['obra_estado'];
    $obra_publicada   = $campo['obra_publicada'];
    $creado_por       = $campo['creado_por'];
    $usuario_asignado = $campo['usuario_asignado'];

    $nomresponsable = Usuarios::obtenerNombreUsuario($usuario_asignado);
}

# ================================================
# =           Parametrización del año            =
# ================================================

if (isset($_GET['consultaAnual'])) {
    $anoactual = $_GET['consultaAnual'];
    $tope      = 13;
} else {
    $anoactual = date('Y');
    $tope      = $mesactual + 1;
}

# ======  End of Parametrización del año   =======

$mesanterior = $mesactual - 1;

$primerdiames = $mesactual . "/01/" . $anoactual;
$ultimodiames = $mesactual . "/" . $totaldiasmes . "/" . $anoactual;

$primerdiamescons = $anoactual . "-" . $mesactual . "-01";
$ultimodiamescons = $anoactual . "-" . $mesactual . "-" . $totaldiasmes;

$fechaform      = $_POST['daterange'];
$FechaInicioDia = ($primerdiamescons . " 00:00:000");
$FechaFinalDia  = ($ultimodiamescons . " 23:59:000");
//echo("FECHA QUE LLEGA:".$FechaInicioDia1."<br>");

$primerdiamesanterior = $anoactual . "-" . $mesanterior . "-01";
$ultimodiamesanterior = $anoactual . "-" . $mesanterior . "-" . $totaldiasmes;
// Fecha del Mes anterior
$InicioMesanterior = ($primerdiamesanterior . " 00:00:000");
$FinalMesanterior  = ($ultimodiamesanterior . " 23:59:000");

date_default_timezone_set("America/Bogota");
$MarcaTemporal       = date('Y-m-d');
$MarcaTemporalAyer   = $anoactual . "-" . $mesactual . "-" . $ayer;
$MarcaTemporalAntier = $anoactual . "-" . $mesactual . "-" . $antier;

$FechaInicioDiaActual = ($MarcaTemporal . " 00:00:000");
$FechaFinalDiaActual  = ($MarcaTemporal . " 23:59:000");

$FechaInicioDiaAnterior = $anoactual . "-" . $mesactual . "-" . $ayer . " 00:00:0000";
$FechaFinalDiaAnterior  = $anoactual . "-" . $mesactual . "-" . $ayer . " 23:59:0000";

$fecha_actual     = date("d-m-Y");
$semanaantes      = date("Y-m-d", strtotime($fecha_actual . "- 1 week"));
$FechaInicio7dias = $semanaantes . " 00:00:0000";
$FechaFinal7dias  = $anoactual . "-" . $mesactual . "-" . $hoy . " 23:59:0000";

$quincedias        = date("Y-m-d", strtotime($fecha_actual . "- 2 week"));
$FechaInicio15dias = $quincedias . " 00:00:0000";
$FechaFinal15dias  = $anoactual . "-" . $mesactual . "-" . $hoy . " 23:59:0000";

$sesentadias       = date("Y-m-d", strtotime($fecha_actual . "- 8 week"));
$FechaInicio60dias = $sesentadias . " 00:00:0000";
$FechaFinal60dias  = $anoactual . "-" . $mesactual . "-" . $hoy . " 23:59:0000";

$inicio2021       = "2021-01-01 00:00:0000";
$FechaFinal60dias = $anoactual . "-" . $mesactual . "-" . $hoy . " 23:59:0000";

//echo("FECHA QUE LLEGA:".$fechaform."<br>");

$Sumacombustibledia = ReporteCombustibledia($FechaInicio15dias, $FechaFinal15dias);

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
    $datofechain = $primerdiames;
} else {
    $FechaStart  = ($FechaUno . " 00:00:000");
    $datofechain = $FechaUno;
}
// Validación de la fecha en que Termina el Día
if ($FechaDos == "") {
    $FechaEnd       = $FechaFinalDia;
    $datofechafinal = $ultimodiames;
} else {
    $FechaEnd        = ($FechaDos . " 23:59:000");
    $limpiarvariable = str_replace(" ", "", $FechaDos);
    $datofechafinal  = $limpiarvariable;
}

?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small><a class="btn btn-info btn-sm" href="?controller=obras&&action=dashboard">Volver a Obras</a></small>

         <small><a class="btn btn-warning btn-sm" href="?controller=rangos&&action=todosobra&&id_obra=<?php echo($getobra); ?>">Volver a Rangos</a></small>

      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->

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

    <div>
        <strong>Ver/Ocultar Columnas:</strong>
          <a class="btn btn-info btn-sm toggle-vis" data-column="1">Actividades</a>
        - <a class="toggle-vis btn btn-info btn-sm" data-column="2">Cant. Original</a>
        - <a class="toggle-vis btn btn-info btn-sm" data-column="3">Cant. Final</a> 
        - <a class="toggle-vis btn btn-info btn-sm" data-column="4">Un</a>
        - <a class="toggle-vis btn btn-info btn-sm" data-column="5">Vr. Unitario</a>
        - <a class="toggle-vis btn btn-info btn-sm" data-column="6">Vr. Total</a>


    </div>
              <div class="table-responsive mailbox-messages">
          <table id="cotizaciones" class="table  table-responsive table-striped table-bordered table-hover" style="width: 100%;font-size: 13px;">
             <tfoot style="display: table-header-group;">

                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                    <th style="background-color: #fcf8e3" class="success"></th>
                                   
                                   
                                     
                                      <?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $id_rango_th  = $campo['id'];
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
    $valorproyectadorango = Obras::sqlvalorrangoporobra($getobra,$id_rango_th);
    $totalejectuado = Valorejecutadoporrango($getobra,$fecha_inicio,$fecha_fin);

?>
    <th style="background-color: #fcf8e3" class="success"><?php echo ("$".number_format($valorproyectadorango,0)); ?></th>
<?php
}

?>
 <th style="background-color: #fcf8e3" class="success">
     <?php echo ("$".number_format($totalejectuado,0)); ?>
 </th>

                            </tfoot>
          <thead>
              <tr style="background-color: #4f5962;color: white;">

             <th>Capítulo</th>
             <th>Actividades</th>
             <th>Cant. Original</th>
             <th>Cant. Final</th>
             <th>Un</th>
             <th>Valor Unitario</th>
             <th>Vr. Total</th>

             <?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
?>
     <th><?php echo("Rango-".$mes_numero." <br>Desde ".$fecha_inicio." Hasta ".$fecha_fin); ?></th>
<?php
}

?>
<th>Avance</th>

            </tr>
             <tr>

             <th>Capítulo</th>
             <th>Actividades</th>
             <th>Cant. Original</th>
             <th>Cant. Final</th>
             <th>Un</th>
             <th>Valor Unitario</th>
             <th>Vr. Total</th>
             <?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
    $mes_numero   = $campo['mes_numero'];
    $fecha_inicio = $campo['fecha_inicio'];
    $fecha_fin    = $campo['fecha_fin'];
?>
     <th><?php echo("Rango-".$mes_numero); ?></th>
<?php
}

?>
<th>Avance</th>

            </tr>
          </thead>
       <tbody>
         <?php
$res    = Obras::capitulosporobra($getobra);
$campos = $res->getcampos();

foreach ($campos as $campo) {

    $id_capitulo        = $campo['id_capitulo'];
    $obra_id_obra       = $campo['obra_id_obra'];
    $nombre_capitulo    = $campo['nombre_capitulo'];
    $cod_capitulo       = $campo['cod_capitulo'];
    $marca_temporal     = $campo['marca_temporal'];
    $creado_por         = $campo['creado_por'];
    $estado_capitulo    = $campo['estado_capitulo'];
    $capitulo_publicado = $campo['capitulo_publicado'];
    $prioridad          = $campo['prioridad'];

    $valorcapitulo = Valorcapitulo($id_capitulo);
    $sqlavances_cap = Obras::sqlavancesporcapitulo($id_capitulo);

    $sqlmayores_cap = Obras::sqlamodificacionesmayoresporcapitulo($id_capitulo);
    $sqlmenores_cap = Obras::sqlamodificacionesmenoresporcapitulo($id_capitulo);
    $valorfinal_cap = ($sqlmayores_cap-$sqlmenores_cap)+$valorcapitulo;

    $pendiente_cap = $valorfinal_cap-$sqlavances_cap;
    $porcentaje_cap = formulaporcentaje($sqlavances_cap,$valorfinal_cap);
    ?>
    <tr class="info">
      <td><strong><?php echo utf8_decode($nombre_capitulo); ?> </strong></td>

      <td><strong>
          Actividades
       </strong></td>
     
       <td><strong>Cant. Original</strong></td>
      <td><strong>Cant. Final</strong></td>
      <td>
          <strong>
              Un
          </strong>
      </td>
      <td>
          <strong>
              Valor Unitario
          </strong>
      </td>
         <td style="font-weight: bold;">
         <?php echo ("$" . number_format($valorfinal_cap,0)); ?>
      </td>
<?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
   
   
    $mes_numero_cap   = $campo['mes_numero'];
    
?>
    <td><?php echo utf8_decode("Rango-".$mes_numero_cap); ?></td>
<?php
}
?>
<td>-</td>

    </tr>

  <?php
# ===============================================
    # =           Inicio de  Actividades            =
    # ===============================================

    $res    = Obras::actividadesporcapitulo($id_capitulo);
    $campos = $res->getcampos();

    foreach ($campos as $campo) {

        $id_actividad         = $campo['id_actividad'];
        $capitulo_id_capitulo = $campo['capitulo_id_capitulo'];
        $obra_id_obra         = $campo['obra_id_obra'];
        $cod_actividad        = $campo['cod_actividad'];
        $detalle              = $campo['detalle'];
        $unidad_id_unidad     = $campo['unidad_id_unidad'];
        $cantidad             = $campo['cantidad'];
        $valor_unitario       = $campo['valor_unitario'];
        $valor_total          = $campo['valor_total'];
        $marca_temporal       = $campo['marca_temporal'];
        $creado_por           = $campo['creado_por'];
        $estado_actividad     = $campo['estado_actividad'];
        $actividad_publicada  = $campo['actividad_publicada'];
        $prioridad            = $campo['prioridad'];
        $nomunidad            = Unidadesmed::obtenerNombre($unidad_id_unidad);

        $nomcapitulo = Obras::obtenernombrecapitulo($capitulo_id_capitulo);

        $contadordetalle = strlen($detalle);

        if ($contadordetalle >= 120) {
            $detallecorto    = substr($detalle, 0, 120);
            $nombreactividad = $detallecorto . "...";
        } else {
            $nombreactividad = $detalle;
        }
   
    $sqlcantidadesmayores=Obras::sqlmayorespor($id_actividad);
      $sqlcantidadesmenores=Obras::sqlmenorespor($id_actividad);
      $valorcantidadesmayores=$sqlcantidadesmayores*$valor_unitario;
      $valorcantidadesmenores=$sqlcantidadesmenores*$valor_unitario;
      $totalcantidades=($cantidad+$sqlcantidadesmayores)-$sqlcantidadesmenores;
      $valorfinalact = $totalcantidades*$valor_unitario;
     
      $sqlavances_act = Obras::sqlavancesporactividad($id_actividad);
     
     

      $cantidadesfinales = ($cantidad+$sqlcantidadesmayores-$sqlcantidadesmenores);
      $cantidadesfinalesredondeadas = number_format($cantidadesfinales,2);

      # -----------  Subsection comment Cálculo de porcentaje  -----------
      
      $valorfinal=$sqlavances_act*$valor_unitario;

      $calculo1 = round(($sqlavances_act/$cantidadesfinales)*100,2);

      $valor_pendiente_act = $valorfinalact-$valorfinal;
      $cantidades_pendientes = $cantidadesfinales-$sqlavances_act;

        ?>
        <tr>
          <td>
             <small><?php echo utf8_decode($nomcapitulo); ?></small>
            <strong><?php echo utf8_decode($cod_actividad) ?></strong>
           </td>
          <td><?php echo utf8_decode($detalle) ?> </td>
          <td><?php echo (number_format($cantidad, 2)); ?> </td>
          <td>
            <?php 

            if ($cantidad<$cantidadesfinales) {
                echo("<strong class='text-success'> ".number_format($cantidadesfinales, 2)." <i class='fa fa-arrow-circle-up'> </i></strong>");
            }elseif($cantidad>$cantidadesfinales){
                echo("<strong class='text-danger'> ".number_format($cantidadesfinales, 2)." <i class='fa fa-arrow-circle-down'> </i></strong>");
            }else
            {
                echo("<strong  class='text-info'> ".number_format($cantidadesfinales, 2)." </strong>");   
            }

             ?>
            
        </td>
          <td><?php echo utf8_decode($nomunidad) ?> </td>
          <td><?php echo ("$" . number_format($valor_unitario, 0)); ?> </td>
          <td><?php echo ("$" . number_format($valorfinalact, 0)); ?></td>

<?php
$rangos       = Obras::unicorangoporobra($getobra,$getrango);
$campos_rango = $rangos->getcampos();

foreach ($campos_rango as $campo) {
   
    $id_rango_act   = $campo['id'];
    $mes_numero_act   = $campo['mes_numero'];
    $fecha_inicio_act = $campo['fecha_inicio'];
    $fecha_fin_act    = $campo['fecha_fin'];
?>
   
    <?php 
$sqlcantidadesproyectadas = Obras::sqlproyeccionpor($id_actividad,$id_rango_act);

$sqlcantidadesejecutadas = Cantidadejecutadoporrango($getobra,$fecha_inicio_act,$fecha_fin_act,$id_actividad);
  if ($sqlcantidadesproyectadas>0) {
    echo("<td class='warning'>");
  }else{
     echo("<td>");
  }
   ?>    
      <?php 
      echo(number_format($sqlcantidadesproyectadas,2));
       ?>

    </td>
<?php
}

?>
<td>
    <?php 
    echo(number_format($sqlcantidadesejecutadas,2));
    ?>
    <a target="_blank" class="pull-right" href="?controller=avances&&action=todosporactividad&&id_obra=<?php echo($getobra); ?>&&id_act=<?php echo($id_actividad); ?>"><i class="fa fa-calendar"></i></a>
</td>

        </tr>
<?php
} // Final Segundo Bucle

} // Final del primer Bucle

?>


       </tbody>
     </table>
   </div>

</div>

</div>

<script>

function eliminar(id,obra,rango){
   eliminar=confirm("¿Deseas eliminar este registro?");
   if (eliminar)
     window.location.href="?controller=obras&&action=eliminarcantidadesproyectadas&&id="+obra+"&&idact="+id+"&&idrango="+rango;
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

             pageTotal6 = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );




             $( api.column( 6 ).footer() ).html(
                ''+formatmoneda(pageTotal6/2,'$' )
            );



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


