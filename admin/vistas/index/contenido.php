<?php 
$RolSesion = $_SESSION['IdRol'];
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

$RolSesion = $_SESSION['IdRol'];
$IdSesion = $_SESSION['IdUser'];
$elcliente = $_SESSION['CodigoCliente'];

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

 <?php 
    $res=Usuarios::mostrarnotificaciones($IdSesion);
    $campos = $res->getCampos();
     foreach ($campos as $campo){        
            $id = $campo['id']; 
            $usuario_creador = $campo['usuario_creador']; 
            $marca_temporal = $campo['marca_temporal']; 
            $nomusuariocreador = Usuarios::obtenerNombreUsuario($usuario_creador);
            $detalle = $campo['detalle']; 

            ?>

            <script>
    $(function() {
Command: toastr["success"]("<?php echo($detalle."<br/>Fecha:".$marca_temporal); ?><br /><br /><button type='button' onclick='myFunction<?php echo($id); ?>(<?php echo($id); ?>,<?php echo($IdSesion); ?>)' class='btn btn-danger'>Ok</button><button type='button' onclick='myFunctioncerrar<?php echo($id); ?>(<?php echo($IdSesion); ?>)' class='btn btn-danger'>Cerrar todas</button>", "<?php echo($nomusuariocreador); ?>")

toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "showDuration": "7000",
  "hideDuration": "2000",
  "timeOut": 0,
  "extendedTimeOut": 0,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut",
  "tapToDismiss": false
}
});
</script>



<script>
function myFunction<?php echo($id); ?>(id,usuario) {
  window.location.href="?controller=usuarios&&action=notificacionleida&&id="+id+"&&marcadopor="+usuario;
  //alert("Notificación Marcada como leída");
}
</script>
<script>
function myFunctioncerrar<?php echo($id); ?>(usuario) {
  window.location.href="?controller=usuarios&&action=notificacionleidatodas&&marcadopor="+usuario;
  //alert("Notificación Marcada como leída");
}
</script>


            <?php

    }


 ?>
 <!-- CCS Y JS DATERANGE -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--Inicio Contenido Según perfil-->
<?php 
    

    if ($RolSesion==1) { // Rol Súper Admin 
      require_once "homegerencia.php";
    }
    elseif ($RolSesion==2) {  // Rol Equipos
      require_once "homeequipos.php";
    }
    elseif ($RolSesion==4) { //Rol Conductor 
      require_once "homeconductor.php";
    }
     elseif ($RolSesion==5) {  // Rol Siso 
      require_once "homerecursoshumanos.php";
    }
    elseif ($RolSesion==6) {  // Rol Cliente
      require_once "homeclientes.php";
    }
     elseif ($RolSesion==7) { //Rol Administrador Volquetas
      require_once "homeadminvolquetas.php";
    }
     elseif ($RolSesion==8) {  // Rol Jefe de Planta
      require_once "homejefeplanta.php";
    }
    elseif ($RolSesion==10) {  // Rol Operador 
      require_once "homeoperador.php";
    }
    elseif ($RolSesion==11) {  // Asistente Administrativo
      require_once "homeoperador.php";
    }
    elseif ($RolSesion==12) {  // Asistente Contable
      require_once "homeoperador.php";
    }
    elseif ($RolSesion==13) {  // Almacenista
      require_once "homeequipos.php";
    }
     elseif ($RolSesion==14) {  // Solicitante
      require_once "vistas/obras/home_residente.php";
      //require_once "vistas/almacen/homesolicitante.php";
    }
     elseif ($RolSesion==15) {  // Director
      //require_once "vistas/obras/home_director.php";
      require_once "vistas/almacen/homedirector.php";
    }
  
 ?>
<!--Final Contenido Según Perfil-->




  <script>
    <?php 

    $graficamesanterior=$_GET['graficamesanterior'];


if ($graficamesanterior!="") {
  $mesactualin = date("n");
  $mesactual = $mesactualin-1;
  //$mesvector=12;
  $mesvector=$mesactual-1;
}
else
{
  $mesactual = date("n");
  //$mesvector=12;
  $mesvector=$mesactual-1;
}

     ?>

var dataPoints = [];
  var stockChart = new CanvasJS.StockChart("grafica_1", {
    //exportEnabled: true,
    title: {
      //text:"StockChart with Line using JSON Data"
    },
    subtitles: [{
      //text:"Historial Terraje Obinco"
    }],
    charts: [{
      axisX: {
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "YYYY MMM DD"
        }
      },
      axisY: {
        title: "Despachos General",
        prefix: "",
        suffix: "m3",
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "#,###.00m3",
        }
      },
      data: [{
        type: "area",
        color: "#FB8E00",
        xValueFormatString: "YYYY MMM DD",
        yValueFormatString: "#,###.##m3",
        dataPoints : dataPoints
      }]
    }],
    navigator: {
      slider: {
        minimum: new Date( <?php echo($anoactual); ?>, <?php echo($mesanterior-1); ?>, <?php echo($ayer); ?>),
        maximum: new Date( <?php echo($anoactual); ?>, <?php echo($mesactual); ?>, <?php echo($ayer); ?>),
      }
    },
     rangeSelector: {
      buttons: []
    }
  });

    <?php 
$res=Reportes::GraficaHistorialDespachos();
$campos = $res->getCampos();
foreach($campos as $campo){
   $fechaterraje = $campo['fecha_reporte'];
   $cantidadm3 = $campo['totales'];
   $fechagraficada=date("Y-m-d",strtotime($fechaterraje."+ 1 day")); 
     ?> 
    dataPoints.push({x: new Date("<?php echo($fechagraficada) ?>"), y: Number(<?php echo($cantidadm3) ?>)});
     <?php 
   }
      ?>
   
    stockChart.render();
  ;


  // Incio Segunda Gráfica 
  var dataPoints = [];
  var stockChart2 = new CanvasJS.StockChart("grafica_2", {
    //exportEnabled: true,
    title: {
      //text:"StockChart with Line using JSON Data"
    },
    subtitles: [{
      //text:"Historial Terraje Obinco"
    }],
    charts: [{
      axisX: {
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "YYYY MMM DD"
        }
      },
      axisY: {
        title: "Total Horas MQ",
        prefix: "",
        suffix: "hr",
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "#,###.00hr",
        }
      },
      data: [{
        type: "line",
        color: "#FB8E00",
        xValueFormatString: "YYYY MMM DD",
        yValueFormatString: "#,###.##hr",
        dataPoints : dataPoints
      }]
    }],
    navigator: {
      slider: {
        minimum: new Date(2021, 01, 01),
        maximum: new Date(2021, 12, 31)
      }
    },
     rangeSelector: {
      buttons: []
    }
  });

    <?php 
$res=Reportes::GraficaHistorialRegistroHoras();
$campos = $res->getCampos();
foreach($campos as $campo){
   $fechaterraje = $campo['fecha_reporte'];
   $cantidadm2 = $campo['totales'];
   $fechagraficada=date("Y-m-d",strtotime($fechaterraje."+ 1 day")); 
     ?> 
    dataPoints.push({x: new Date("<?php echo($fechagraficada) ?>"), y: Number(<?php echo($cantidadm2) ?>)});
     <?php 
   }
      ?>
   
    stockChart2.render();
  ;
// Incio Tercera Gráfica 
  var dataPoints = [];
  var stockChart3 = new CanvasJS.StockChart("grafica_3", {
    //exportEnabled: true,
    title: {
      //text:"StockChart with Line using JSON Data"
    },
    subtitles: [{
      //text:"Historial Terraje Obinco"
    }],
    charts: [{
      axisX: {
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "YYYY MMM DD"
        }
      },
      axisY: {
        title: "Consumo ACPM",
        prefix: "",
        suffix: "gl",
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "#,###.00gl",
        }
      },
      data: [{
        type: "line",
        color: "#FB8E00",
        xValueFormatString: "YYYY MMM DD",
        yValueFormatString: "#,###.##gl",
        dataPoints : dataPoints
      }]
    }],
    navigator: {
      slider: {
        minimum: new Date(2021, 01, 01),
        maximum: new Date(2021, 12, 31)
      }
    },
     rangeSelector: {
      buttons: []
    }
  });

    <?php 
$res=Reportes::GraficaHistorialConsumoAcpm();
$campos = $res->getCampos();
foreach($campos as $campo){
   $fechaterraje = $campo['fecha_reporte'];
   $cantidadm3 = $campo['totales'];
   $fechagraficada=date("Y-m-d",strtotime($fechaterraje."+ 1 day")); 
     ?> 
    dataPoints.push({x: new Date("<?php echo($fechagraficada) ?>"), y: Number(<?php echo($cantidadm3) ?>)});
     <?php 
   }
      ?>
   
    stockChart3.render();
  ;

  // Incio Cuarta Gráfica 
  
  var dataPoints1 = [], dataPoints2 = [];
  var stockChart4 = new CanvasJS.StockChart("grafica_4",{
    theme: "light1",
    animationEnabled: true,
    title:{
      //text:"Multi-Series StockChart with Navigator"
    },
    subtitles: [{
      //text: "No of Trades: BTC/USD vs BTC/EUR"
    }],
    charts: [{
       axisX: {
        crosshair: {
          enabled: true,
          snapToDataPoint: true,
          valueFormatString: "YYYY MMM DD"
        }
      },
      axisY: {
        title: "Contado  - Crédito"
      },
      toolTip: {
        shared: true
      },
      legend: {
            cursor: "pointer",
            itemclick: function (e) {
              if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible)
                e.dataSeries.visible = false;
              else
                e.dataSeries.visible = true;
              e.chart.render();
            }
        },
      data: [{
        showInLegend: true,
        name: "Contado $",
        color: "#FB8E00",
        yValueFormatString: "#,##0",
        xValueType: "dateTime",
        dataPoints : dataPoints1
      },{
        showInLegend: true,
        name: "Crédito $",
        color: "#274350",
        yValueFormatString: "#,##0",
        dataPoints : dataPoints2
      }]
    }],
    rangeSelector: {
      enabled: false
    },
    navigator: {
      data: [{
        dataPoints: dataPoints1
      }],
      slider: {
        minimum: new Date(2018, 00, 15),
        maximum: new Date(2018, 02, 01)
      }
    }
  });
  
<?php 
$res=Reportes::GraficaHistorialComprasContado();
$campos = $res->getCampos();
foreach($campos as $campo){
   $fechaterraje = $campo['fecha_reporte'];
   $cantidadm2 = $campo['totales'];
   $fechagraficada=date("Y-m-d",strtotime($fechaterraje."+ 1 day")); 
     ?> 
    dataPoints1.push({x: new Date("<?php echo($fechagraficada) ?>"), y: Number(<?php echo($cantidadm2) ?>)});
     <?php 
   }
?>

<?php 
$res=Reportes::GraficaHistorialComprasCredito();
$campos = $res->getCampos();
foreach($campos as $campo){
   $fechaterraje = $campo['fecha_reporte'];
   $cantidadm2 = $campo['totales'];
   $fechagraficada=date("Y-m-d",strtotime($fechaterraje."+ 1 day")); 
     ?> 
    dataPoints2.push({x: new Date("<?php echo($fechagraficada) ?>"), y: Number(<?php echo($cantidadm2) ?>)});
     <?php 
   }
?>

    stockChart4.render();
  ;
  

</script>

<script src="dist/js/canvasjs.min.js"></script>

