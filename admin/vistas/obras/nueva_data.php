<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
header('Content-Type: text/html; charset=UTF-8');

$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

include_once 'modelos/unidadesmed.php';
include_once 'controladores/unidadesmedController.php';

include 'vistas/obras/formulas.php';

$obrasel = $_GET['id'];

$valorobra = Valorinicialobra($obrasel);

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

?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector').select2();
    });
});
</script>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector2').select2();
    });
});
</script>



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

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

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

<?php

$getcapitulo  = $_GET['idcap'];
$getactividad = $_GET['idact'];

if ($getcapitulo != '') {
    require_once 'editar_capitulo.php';
}

if ($getactividad != '') {
    require_once 'editar_actividad.php';
}

?>

<div class="col-md-12">
<div class="box box-solid">
<div class="box-header with-border">
<i class="fa fa-info-circle"> </i>
<h3 class="box-title"><?php echo utf8_decode($nombre_obra); ?> <strong>Fecha Inicio : <?php echo ($fecha_inicio); ?> </strong></h3>
</div>

<div class="box-body">
   <form role="form" action="?controller=obras&&action=actualizarobra&&id=<?php echo ($obrasel); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">

<dl>
<dt>Objeto del contrato:</dt>
<dd>
  <div class="col-md-12">

    <div class="col-md-4">
   <textarea class="form-control" rows="5" name="objeto" id="objeto" placeholder="Ingrese el objeto del contrato" maxlength="500" required><?php echo utf8_decode($objeto); ?></textarea>
</div>
<div class="col-md-8">

    <div class="col-md-6">
      <strong>Contrato Obra Nº</strong>
      <input name="contrato_obra" class="form-control" type="text" value="<?php echo utf8_decode($contrato_obra); ?>">
    </div>

     <div class="col-md-6">
      <strong>Nombre Obra</strong>
      <input name="nombre_obra" class="form-control" type="text" value="<?php echo utf8_decode($nombre_obra); ?>">
    </div>

     <div class="col-md-6">
      <strong>Contratante</strong>
      <input name="contratante" class="form-control" type="text" value="<?php echo utf8_decode($contratante); ?>">
    </div>

     <div class="col-md-6">
      <strong>Inteventoria</strong>
      <input name="interventoria" class="form-control" type="text" value="<?php echo utf8_decode($interventoria); ?>">
    </div>
    <div class="col-md-6">
      <strong>Responsable</strong>
      <select name="usuario_asignado" class="form-control mi-selector3" >
        <option value="<?php echo($usuario_asignado) ?>"><?php echo($nomresponsable); ?> </option>
        <?php
                                  $cajas = Usuarios::ListaDirectoresObra();
                                  foreach($cajas as $caja){
                                    $id_usuario = $caja['id_usuario'];
                                    $nombre_usuario = $caja['nombre_usuario'];
                                ?>
                                <option value="<?php echo $id_usuario; ?>"><?php echo $nombre_usuario; ?></option>
                                <?php }?>
      </select>
      
    </div>
      <div  class="col-md-6">
                        <div class="form-group">
                          <label>Fecha Inicio: <span>*</span></label>
                          <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha" class="form-control required" value="<?php echo($fecha_inicio); ?>" required>
                        </div>
                </div>



</div>

  </div>

</dd>


<a style="display: none;" class="btn btn-warning btn-sm pull-left" href="?controller=obras&&action=dashboard"><i class="fa fa-dashboard"></i> Panel Ppal. </a>
<button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i> Actualizar Información</button>

</dl>
 </form>
</div>

</div>

</div>


<div class="col-md-12">

  <div class="input-group">
<a data-toggle="modal" data-target="#modal-form1" href="#"  class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Agregar Capítulo</a>

<a data-toggle="modal" data-target="#modal-form2" href="#"  class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Agregar Actividad</a>
<br>

<button onclick="cerrarcapitulos()">Contraer Capítulos</button>

<button onclick="expandirarbol()">Expandir Todo</button>

<span class="input-group-addon"><i class="fa fa-search"></i></span>
<input type="text"  id="plugins4_q" class="form-control" name="campo" placeholder="Búsqueda por palabra">
</div>


    <div id="jstree">

<ul>
<li>
  <strong>OBRA <?php echo utf8_decode($nombre_obra); ?></strong>
  <strong class="text-danger"> Subtotal.:<?php echo ("$" . number_format($valorobra, 0, ",", ".")); ?></strong>
<ul>

  <?php
$res    = Obras::capitulosporobra($obrasel);
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

    ?>
    <li class="divcapitulos">
      <span onclick="eliminarcapitulo(<?php echo ($id_capitulo); ?>,<?php echo ($obrasel); ?>)" class="btn btn-warning" href=""><i class="fa fa-trash fa-x2"></i>
      </span>
        <span onclick="editarcapitulo(<?php echo ($id_capitulo); ?>,<?php echo ($obrasel); ?>)" class="btn btn-warning" href=""><i class="fa fa-edit fa-x2"></i>
      </span>

    <strong> <?php echo utf8_decode($prioridad . "-[" . $cod_capitulo . "]" . $nombre_capitulo); ?> </strong>
  <strong class="text-danger"> Subtotal.:<?php echo ("$" . number_format($valorcapitulo, 0, ",", ".")); ?></strong>
  <ul>

      <?php

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

        $contadordetalle = strlen($detalle);

        if ($contadordetalle >= 100) {
            $detallecorto    = substr($detalle, 0, 120);
            $nombreactividad = $detallecorto . "...";
        } else {
            $nombreactividad = $detalle;
        }

        ?>
    <li>
      <span onclick="eliminaractividad(<?php echo ($id_actividad); ?>,<?php echo ($obrasel); ?>)" class="btn btn-info text-danger" href=""><i class="fa fa-trash fa-x3"></i></span>

      <span onclick="editaractividad(<?php echo ($id_actividad); ?>,<?php echo ($obrasel); ?>)" class="btn btn-info text-success" href=""><i class="fa fa-edit fa-x3"></i></span>
      <strong> <?php echo utf8_decode($prioridad . "-[" . $cod_actividad . "]"); ?></strong>
      <?php echo utf8_decode($nombreactividad); ?>

      <strong class="text-success">Cantidad.:<?php echo (number_format($cantidad, 2, ",", ".") . "-" . $nomunidad); ?> </strong>
      /-----/
      <strong class="text-primary"> Vr Un.:<?php echo ("$" . number_format($valor_unitario, 0, ",", ".")); ?></strong>
      /-----/
      <strong class="text-danger"> Subtotal.:<?php echo ("$" . number_format($valor_total, 0, ",", ".")); ?></strong>




    </li>
        <?php
}
    ?>



  </ul>
</li>


    <?php

}

?>



</ul>
</li>

</ul>
</div>





</div>

</div>


<!-- Inicio Modal Clientes -->
    <div id="modal-form1" class="modal" tabindex="-1">
               <!-- Inicio Modal -->
    <div>

<form action="?controller=obras&&action=guardarcapitulo&&id=<?php echo ($obrasel); ?>" method="post" autocomplete="off">

   <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">
              <input type="hidden" name="estado_capitulo" value="1">
              <input type="hidden" name="creado_por" value="<?php echo ($IdSesion); ?>">
               <input type="hidden" name="obra_id_obra" value="<?php echo ($obrasel); ?>">
              <input type="hidden" name="capitulo_publicado" value="1">


                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a href="#" type="button" class="close" data-dismiss="modal">&times;</a>
                        <h4 class="black bigger">Agregar Capítulo:</h4>
                      </div>

                 <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Código Capítulo</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="cod_capitulo" value="" class="form-control" id="cod_capitulo" placeholder="Ingrese el código" >
              </div>

                  </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Prioridad Capítulo</label>
                     <div class="input-group">
               <select class="form-control" name="prioridad" id="" required>
                <option value="">Seleccionar...</option>
                <?php
for ($i = 1; $i < 101; $i++) {
    echo ("<option value='" . $i . "'>Prioridad " . $i . "</option>");
}

?>
               </select>
              </div>

                  </div>
                  </div>
                 <div class="col-sm-12">
                  <div class="form-group">
                    <label for="nombres">Agregar Capítulo</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="nombre_capitulo" value="" class="form-control" id="nombre_capitulo" placeholder="Ingrese el nombre del capítulo"  required>
              </div>

                  </div>
                  </div>



                      <div class="modal-footer">
                        <a href="Clientes-Abonos.php?AbonosFactura=<?php echo ($AbonosFactura) ?>" class="btn btn-sm btn-danger" data-dismiss="modal">
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


 <!-- Inicio Modal Actividades -->
    <div id="modal-form2" class="modal" tabindex="-1">
               <!-- Inicio Modal -->
    <div>

<form action="?controller=obras&&action=guardaractividad&&id=<?php echo ($obrasel); ?>" method="post" autocomplete="off">

    <input type="hidden" name="obra_id_obra" value="<?php echo ($obrasel); ?>">
              <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">
              <input type="hidden" name="estado_actividad" value="1">
              <input type="hidden" name="creado_por" value="<?php echo ($IdSesion); ?>">
              <input type="hidden" name="actividad_publicada" value="1">

                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <a href="#" type="button" class="close" data-dismiss="modal">&times;</a>
                        <h4 class="black bigger">Agregar Actividad:</h4>
                      </div>
               <div  id="divcajas" class="col-md-12">
                          <div class="form-group">
                              <label for="sel1">Seleccione el capítulo:<span>*</span></label>
                              <select style="width: 350px;" class="form-control mi-selector"  name="capitulo_id_capitulo" >
                                  <option value="" selected>Seleccionar...</option>
                                <?php
$cajas = Obras::obtenerlistacapitulos($obrasel);
foreach ($cajas as $caja) {
    $id_capitulo     = $caja['id_capitulo'];
    $nombre_capitulo = $caja['nombre_capitulo'];
    $cod_capitulo    = $caja['cod_capitulo'];
    ?>
     <option value="<?php echo $id_capitulo; ?>"><?php echo utf8_decode("[" . $cod_capitulo . "]" . $nombre_capitulo); ?></option>
                                <?php }?>
                              </select>
                          </div>
                </div>

                <div class="col-md-12">
                        <div class="form-group">
                          <label for="nombres">Detalle de la Actividad</label>
                            <textarea class="form-control" rows="2" name="detalle" id="detalle" placeholder="Detalle de la actividad" maxlength="500" required></textarea>
                        </div>
                </div>
                  <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nombres">Código Actividad</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="cod_actividad" value="" class="form-control" id="cod_actividad" placeholder="código" maxlength="250" required>
              </div>
                  </div>
                  </div>

               <div  id="divcajas" class="col-md-4">
                          <div class="form-group">
                              <label for="sel1">Unidad Medida:<span>*</span></label>
                              <select class="form-control mi-selector2"  name="unidad_id_unidad" >
                                  <option value="" selected>Seleccionar...</option>
                                <?php
$cajas = Unidadesmed::obtenerListaUnidades();
foreach ($cajas as $caja) {
    $id_unidad   = $caja['id'];
    $abreviatura = $caja['abreviatura'];
    ?>
                                <option value="<?php echo $id_unidad; ?>"><?php echo utf8_decode($abreviatura); ?></option>
                                <?php }?>
                              </select>
                          </div>
                </div>

                  <div class="col-md-4">
                        <div class="form-group">
                          <label>Cantidades<span>*</span></label>
                          <input type="number" step="any" name="cantidad" placeholder="Cantidades" class="form-control" required value="">
                          <small>Decimales separados con punto</small>
                        </div>
                  </div>

                  <div class="col-md-6">
                        <div class="form-group">
                          <label>Valor Unitario: <span>*</span></label>
                          <input type="text" name="valor_unitario" placeholder="Valor Unitario" class="form-control" id="demo1">
                        </div>
                    </div>

                     <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Prioridad Actividad</label>
                     <div class="input-group">
               <select name="prioridad" id="" class="form-control" required>
                <option class="form-group form-control" value="">Seleccionar...</option>
                <?php
for ($i = 1; $i < 101; $i++) {
    echo ("<option value='" . $i . "'>Prioridad " . $i . "</option>");
}

?>
               </select>
              </div>

                  </div>
                  </div>




                      <div class="modal-footer">
                        <a href="Clientes-Abonos.php?AbonosFactura=<?php echo ($AbonosFactura) ?>" class="btn btn-sm btn-danger" data-dismiss="modal">
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

<script type="text/javascript">
   function eliminarcapitulo(idcap,id){

  Swal.fire({
  title: 'Estás seguro de Eliminar?',
  text: "Está acción eliminará todas las actividades relacionadas!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, deseo eliminar este capítulo!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="?controller=obras&&action=eliminarcapitulo&&idcap="+idcap+"&&id="+id;
  }
})


   };
</script>

<script type="text/javascript">
   function eliminaractividad(idact,id){

  Swal.fire({
  title: 'Estás seguro de Eliminar?',
  text: "Está acción eliminará la actividad, y no se puede reversar!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, deseo eliminar este actividad!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="?controller=obras&&action=eliminaractividad&&idact="+idact+"&&id="+id;
  }
})


   };
</script>

<script type="text/javascript">
  function editarcapitulo(idcap,id){

    window.location.href="?controller=obras&&action=detalle_obra&&idcap="+idcap+"&&id="+id;
  }
</script>

<script type="text/javascript">
  function editaractividad(idact,id){
    window.location.href="?controller=obras&&action=detalle_obra&&idact="+idact+"&&id="+id;
  }
</script>

<!-- Inicio Libreria formato moneda -->
<script src="dist/js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript">
$("#demo1").maskMoney({
prefix:'$ ', // The symbol to be displayed before the value entered by the user
allowZero:true, // Prevent users from inputing zero
allowNegative:true, // Prevent users from inputing negative values
defaultZero:true, // when the user enters the field, it sets a default mask using zero
thousands: '.', // The thousands separator
decimal: ',' , // The decimal separator
precision: 0, // How many decimal places are allowed
affixesStay : true, // set if the symbol will stay in the field after the user exits the field.
symbolPosition : 'left' // use this setting to position the symbol at the left or right side of the value. default 'left'
}); //
    </script>

<script type="text/javascript">
$(document).ready(function(){
  $.jstree.defaults.core.themes.variant = "large";
     $("#jstree").jstree({
    "plugins" : [ "search" ],

  });
  var to = false;
  $('#plugins4_q').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#plugins4_q').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });
  $("#jstree").jstree("open_all");

  //$("#jstree li").on("click", "a",
    //    function() {
    //        document.location.href = this;
    //    }
    //);
});
</script>

<script>
  function cerrarcapitulos(){
     $(".divcapitulos").jstree('close_all');
  }
</script>

<script>
  function expandirarbol(){
     $("#jstree").jstree("open_all");
  }
</script>








  <!-- /.content-wrapper -->
