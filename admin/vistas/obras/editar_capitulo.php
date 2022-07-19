<div  class="col-md-12">
<div class="box box-warning box-solid">
<div class="box-header with-border">
<h3 class="box-title">Actualizar Información Capítulo</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body" style="">
   <form role="form" action="?controller=obras&&action=actualizarcapitulo&&id=<?php echo ($obrasel); ?>&&cap=<?php echo($getcapitulo); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
<?php
date_default_timezone_set("America/Bogota");
$TiempoActual = date('Y-m-d H:i:s');

$res    = Obras::editarcapituloPor($getcapitulo);
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
}
?>

              <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">
              <input type="hidden" name="estado_capitulo" value="<?php echo ($estado_capitulo); ?>">
              <input type="hidden" name="creado_por" value="<?php echo ($creado_por); ?>">
               <input type="hidden" name="obra_id_obra" value="<?php echo ($obra_id_obra); ?>">
              <input type="hidden" name="capitulo_publicado" value="<?php echo ($capitulo_publicado); ?>">


                <div class="card-body">

              <div class="row">
                 <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nombres">Código Capítulo</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="cod_capitulo" class="form-control" id="cod_capitulo" placeholder="Ingrese el código" value="<?php echo utf8_decode($cod_capitulo); ?>"  required>
              </div>

                  </div>
                  </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombres">Nombre Capítulo</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="nombre_capitulo" class="form-control" id="nombre_capitulo" placeholder="Ingrese el nombre del capítulo" value="<?php echo utf8_decode($nombre_capitulo); ?>" required>
              </div>

                  </div>
                  </div>

                   <div class="col-sm-3">
                  <div class="form-group">
                    <label for="nombres">Prioridad Actividad</label>
                     <div class="input-group">
               <select name="prioridad" id="" class="form-control" required>
                <option value="<?php echo ($prioridad); ?>"><?php echo ("Prioridad ".$prioridad)?></option>
                <?php
for ($i = 1; $i < 101; $i++) {
    echo ("<option value='" . $i . "'>Prioridad " . $i . "</option>");
}

?>
               </select>
              </div>

                  </div>
                  </div>

              </div>
              <div class="card-footer">
                <button name="Submit" type="submit" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Actualizar Información</button>
                 <a class="btn btn-danger" href="?controller=obras&&action=detalle_obra&&id=<?php echo($obrasel) ?>">Cancelar</a>
              </div>
              </div>
              <!-- /.card -->

  </form>


</div>

</div>

</div>
