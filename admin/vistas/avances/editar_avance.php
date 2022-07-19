<div class="col-md-12">
<div class="box box-info box-solid">
<div class="box-header with-border">
<h3 class="box-title">Actualizar Información Avance</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body" style="">
   <form role="form" action="?controller=avances&&action=actualizar&&id=<?php echo ($getid); ?>&&id_act=<?php echo ($getactividad); ?>&&id_obra=<?php echo($getobra); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
    <?php
date_default_timezone_set("America/Bogota");
$TiempoActual = date('Y-m-d H:i:s');

$res2    = Avances::editarPor($getid);
$campos2 = $res2->getcampos();
foreach ($campos2 as $campo2) {

   $id                      = $campo2['id_cantidades'];
    $obra_id_obra           = $campo2['obra_id_obra'];
    $capitulo_id_capitulo   = $campo2['capitulo_id_capitulo'];
    $actividad_id_actividad = $campo2['actividad_id_actividad'];
    $frente_id_frente       = $campo2['frente_id_frente'];
    $localizacion           = $campo2['localizacion'];
    $observaciones          = $campo2['observaciones'];
    $fecha_reporte          = $campo2['fecha_reporte'];
    $avance                 = $campo2['avance'];
    $acta_numero            = $campo2['acta_numero'];
    $creado_por             = $campo2['creado_por'];
    $estado_avance          = $campo2['estado_avance'];
    $avance_publicado       = $campo2['avance_publicado'];
    $marca_temporal         = $campo2['marca_temporal'];

    $nomobra       = Obras::obtenernombreobra($obra_id_obra);
    $nomfrente     = Frentes::obtenerNombre($frente_id_frente);
    $nomcapitulo   = Obras::obtenernombrecapitulo($capitulo_id_capitulo);
    $nomreportador = usuarios::obtenerNombreUsuario($creado_por);
}

?>

    <input type="hidden" name="obra_id_obra" value="<?php echo($obra_id_obra); ?>">
    <input type="hidden" name="capitulo_id_capitulo" value="<?php echo($capitulo_id_capitulo); ?>">
    <input type="hidden" name="actividad_id_actividad" value="<?php echo($actividad_id_actividad);?>">
    <input type="hidden" name="acta_numero" value="<?php echo($acta_numero);?>">
    <input type="hidden" name="creado_por" value="<?php echo($IdSesion);?>">
    <input type="hidden" name="estado_avance" value="1">
    <input type="hidden" name="avance_publicado" value="1">
    <input type="hidden" name="marca_temporal" value="<?php echo($marca_temporal) ?>">

                <div class="card-body">

              <div class="row">

                 <div class="col-md-12">
                        <div class="form-group">
                          <label>Fecha del Reporte: <span>*</span></label>
                          <input type="date" name="fecha_reporte" placeholder="Fecha" class="form-control required" required id="fecha_reporte" value="<?php echo($fecha_reporte); ?>">
                        </div>
                      </div>

                      <div class="col-md-12 col-xs-12">
                          <label>Localización <span>*</span></label>
                          <input type="text" name="localizacion" placeholder="Localización" class="form-control" required value="<?php echo utf8_decode($localizacion); ?>">
                      </div>

                      <div class="col-md-12 col-xs-12">
                          <label>Reportar Cantidades<span>*</span></label>
                          <input type="number" step="any" name="avance" placeholder="Cantidades del Avance" class="form-control" required value="<?php echo($avance); ?>">
                          <small>Decimales separados con punto</small>
                      </div>

                        <div class="col-md-12 col-xs-12">
   <textarea class="form-control" rows="3" name="observaciones" id="observaciones" placeholder="observaciones" maxlength="500" required><?php echo utf8_decode($observaciones); ?></textarea>
  </div>

                       <div class="col-md-12 col-xs-12">
                      
                          <label> Seleccione el Frente: <span>*</span></label>
                <select style="width: 300px;" class="form-control" id="frente_id_frente" name="frente_id_frente" required>
                    <option value="<?php echo($frente_id_frente); ?>" selected><?php echo($nomfrente); ?></option>
                    <?php
                    $rubros = Obras::ListaFrentesObra($getobra);
                    foreach ($rubros as $campo){
                      $id_frente = $campo['id_frente'];
                      $nombre_frente = $campo['nombre_frente'];  
                    ?>

    <option value="<?php echo $id_frente; ?>"><?php echo utf8_encode($nombre_frente); ?></option>

                    <?php } ?>
                </select>

                       
                    </div>

               

             
        

              </div>
              <div class="card-footer">
                <button name="Submit" type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Actualizar Actividad</button>
                <a class="btn btn-danger" href="?controller=avances&&action=todosporactividad&&id_obra=<?php echo($obra_id_obra);?>&&id_act=<?php echo($actividad_id_actividad); ?>">Cancelar</a>
              </div>
              </div>
              <!-- /.card -->

  </form>

</div>

</div>

</div>