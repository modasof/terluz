<div class="col-md-12">
<div class="box box-info box-solid">
<div class="box-header with-border">
<h3 class="box-title">Actualizar Información Actividad</h3>
<div class="box-tools pull-right">
<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
</button>
</div>

</div>

<div class="box-body" style="">
   <form role="form" action="?controller=obras&&action=actualizaractividad&&id=<?php echo ($obrasel); ?>&&act=<?php echo ($getactividad); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
    <?php
date_default_timezone_set("America/Bogota");
$TiempoActual = date('Y-m-d H:i:s');

$res    = Obras::editaractividadPor($getactividad);
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
    $nomcapitulo          = Obras::obtenernombrecapitulo($capitulo_id_capitulo);
}

?>

              <input type="hidden" name="obra_id_obra" value="<?php echo ($obra_id_obra); ?>">
              <input type="hidden" name="marca_temporal" value="<?php echo ($TiempoActual); ?>">
              <input type="hidden" name="estado_actividad" value="<?php echo ($estado_actividad); ?>">
              <input type="hidden" name="creado_por" value="<?php echo ($creado_por); ?>">
              <input type="hidden" name="actividad_publicada" value="<?php echo ($actividad_publicada); ?>">

                <div class="card-body">

              <div class="row">
                <div  id="divcajas" class="col-md-6">
                          <div class="form-group">
                              <label for="sel1">Seleccione el capítulo:<span>*</span></label>
                              <select class="form-control mi-selector"  name="capitulo_id_capitulo" >
<option value="<?php echo ($capitulo_id_capitulo); ?>" selected><?php echo utf8_decode($nomcapitulo); ?></option>
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

                <div class="col-md-6">
                        <div class="form-group">
                          <label for="nombres">Detalle de la Actividad</label>
                            <textarea class="form-control" rows="2" name="detalle" id="detalle" placeholder="Detalle de la actividad" maxlength="500" required><?php echo utf8_decode($detalle); ?></textarea>
                        </div>
                </div>
                  <div class="col-sm-2">
                  <div class="form-group">
                    <label for="nombres">Código Actividad</label>
                     <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
               <input type="text" name="cod_actividad" value="<?php echo utf8_decode($cod_actividad); ?>" class="form-control" id="cod_actividad" placeholder="código" maxlength="250" required>
              </div>
                  </div>
                  </div>

               <div  id="divcajas" class="col-md-3">
                          <div class="form-group">
                              <label for="sel1">Unidad Medida:<span>*</span></label>
                              <select class="form-control mi-selector2"  name="unidad_id_unidad" >
                              <option value="<?php echo utf8_decode($unidad_id_unidad); ?>" selected><?php echo utf8_decode($nomunidad); ?></option>
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

                  <div class="col-md-2">
                        <div class="form-group">
                          <label>Cantidades<span>*</span></label>
                          <input type="number" step="any" name="cantidad" placeholder="Cantidades" class="form-control" required value="<?php echo utf8_decode($cantidad); ?>">
                          <small>Decimales separados con punto</small>
                        </div>
                  </div>

                  <div class="col-md-2">
                        <div class="form-group">
                          <label>Valor Unitario: <span>*</span></label>
                          <input type="text" name="valor_unitario" placeholder="Valor Unitario" class="form-control" id="demo1" value="<?php echo utf8_decode($valor_unitario); ?>">
                        </div>
                    </div>

                   <div class="col-sm-2">
                  <div class="form-group">
                    <label for="nombres">Prioridad Actividad</label>
                     <div class="input-group">
               <select class="form-control" name="prioridad" id="" required>
                <option value="<?php echo ($prioridad); ?>"><?php echo ("Prioridad " . $prioridad); ?></option>
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
                <button name="Submit" type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Actualizar Actividad</button>
                <a class="btn btn-danger" href="?controller=obras&&action=detalle_obra&&id=<?php echo ($obrasel) ?>">Cancelar</a>
              </div>
              </div>
              <!-- /.card -->

  </form>

</div>

</div>

</div>