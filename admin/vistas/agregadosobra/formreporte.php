<!-- CCS Y JS PARA LA CARGA DE IMAGEN -->
<script src="plugins/dropify/dropify.min.js"></script>
<link rel="stylesheet" href="plugins/dropify/dropify.min.css">
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
<script type="text/javascript">
  jQuery(document).ready(function($){
    $(document).ready(function() {
        $('.mi-selector3').select2();
    });
});
</script>


<div class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title"> Recepción de Material en Obra
              	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </h3>

              <div class="box-tools pull-right">
              <!--   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button> -->
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	<form role="form" autocomplete="off" action="?controller=agregadosobra&&action=guardar&&id_obra=<?php echo($getobra); ?>" method="POST" enctype="multipart/form-data" >
							<?php  
								date_default_timezone_set("America/Bogota");
								$TiempoActual = date('Y-m-d H:i:s');
							?>
							
					<input type="hidden" name="creado_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="recibido_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="obra_id_obra" value="<?php echo($getobra);?>">
					<input type="hidden" name="estado_reporte" value="1">
					<input type="hidden" name="reporte_publicado" value="1">
					<input type="hidden" name="marca_temporal" value="<?php echo($TiempoActual);?>">
					<div class="card-body">
							<div class="row">
				<div class="col-md-12">
                    <div class="form-group">
                      <label for="fila2_columna1">Soporte <small>Tamaño máximo 5MB</small></label>
                        <div class="custom-file">
                           <input name="imagen" type="file" id="input-file-now" class="dropify" data-default-file=""  multiple="multiple" data-allowed-file-extensions="png jpg jpeg mp4 pdf xls xlsx webm" data-show-errors="true" data-max-file-size="5M" data-errors-position="outside" accept="image/png, .jpeg, .jpg, image/gif,.pdf,.xlsx"/ required>
                        </div>
                    </div>
                </div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Fecha del Reporte: <span>*</span></label>
													<input type="date" name="fecha_reporte" placeholder="Fecha" class="form-control required" required id="fecha_reporte">
												</div>
											</div>
											
											
										
										<div class="col-md-12">
												<div class="form-group">
													<label>Cantidad (m3)<span>*</span></label>
													<input type="number" step="any" name="cantidad" placeholder="Cantidad" class="form-control" required value="">
													<small>Decimales separados con punto</small>
												</div>
										</div>

											<div class="col-md-12">
												<div class="form-group">
													<label>Placa<span>*</span></label>
													<input type="text" name="placa" placeholder="Placa" class="form-control" required value="">
												</div>
										</div>

											<div class="col-md-12">
												<div class="form-group">
													<label>Localización<span>*</span></label>
													<input type="text" name="localizacion" placeholder="Ej. KM 0" class="form-control" required value="">
												</div>
										</div>

						<div class="col-md-12">

												<div class="form-group">
													<label> Selecione el Origen: <span>*</span></label>
								<select style="width: 300px;" class="form-control mi-selector" id="origen_id_origen" name="origen_id_origen" required>
										<option value="" selected>Seleccionar...</option>
										<?php
										$equipos = Destinos::obtenerListaDestinos();
										foreach ($equipos as $campo_dest){
											$id_destino = $campo_dest['id_destino'];
											$nombre_destino = $campo_dest['nombre_destino'];
										?>
										<option value="<?php echo $id_destino; ?>"><?php echo utf8_decode($nombre_destino); ?></option>
										<?php } ?>
								</select>
												</div>
						</div>
										
						<div class="col-md-12">

												<div class="form-group">
													<label> Seleccione el Insumo: <span>*</span></label>
								<select style="width: 300px;" class="form-control mi-selector" id="insumo_id_insumo" name="insumo_id_insumo" required>
										<option value="" selected>Seleccionar...</option>
										<?php
										$equipos = Proyeccionesins::obtenerinsObra($getobra);
										foreach ($equipos as $campo_eq){
											$insumo_id_insumo = $campo_eq['insumo_id_insumo'];
											$nombre_insumo = Insumos::obtenerNombreInsumo($insumo_id_insumo);
										?>
										<option value="<?php echo $insumo_id_insumo; ?>"><?php echo utf8_decode($nombre_insumo); ?></option>
										<?php } ?>
								</select>
												</div>
						</div>
			
										<div class="col-md-12">
												<div class="form-group">
													<label> Seleccione el Frente: <span>*</span></label>
						<select class="form-control" id="frente_id_frente" name="frente_id_frente" >
													  	<option value="">Seleccionar...</option>
										<?php
										$rubros = Frentes::ListaFrentesObras($getobra);
										foreach ($rubros as $campo){
											$id_frente = $campo['id_frente'];
											$nombre_frente = $campo['nombre_frente'];
											
										?>
										<option value="<?php echo $id_frente; ?>"><?php echo utf8_decode($nombre_frente); ?></option>
										<?php } ?>
							</select>

												</div>
											</div>
											
											<div class="col-md-12">
												<div class="form-group">
													<label>Observaciones<span>*</span></label>
									<textarea class="form-control" rows="2" id="descripcion" name="observaciones"></textarea>
												</div>
											</div>
											
										</div>
							<div class="row">
								<div class="card-footer">
								  <button name="Submit" type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Guardar Registro</button>
								</div>
						  </div>
						  </form>
</div>
</div>


</div> <!-- Fin Content-Wrapper -->
<!-- Inicio Libreria formato moneda -->
<script src="dist/js/jquery.maskMoney.js" type="text/javascript"></script>
<script type="text/javascript">			
$("#demo1").maskMoney({
prefix:'$ ', // The symbol to be displayed before the value entered by the user
allowZero:true, // Prevent users from inputing zero
allowNegative:true, // Prevent users from inputing negative values
defaultZero:false, // when the user enters the field, it sets a default mask using zero
thousands: '.', // The thousands separator
decimal: '.' , // The decimal separator
precision: 0, // How many decimal places are allowed
affixesStay : true, // set if the symbol will stay in the field after the user exits the field. 
symbolPosition : 'left' // use this setting to position the symbol at the left or right side of the value. default 'left'
}); //
		</script>
<script type="text/javascript">			
$("#demo2").maskMoney({
prefix:'$ ', // The symbol to be displayed before the value entered by the user
allowZero:true, // Prevent users from inputing zero
allowNegative:true, // Prevent users from inputing negative values
defaultZero:false, // when the user enters the field, it sets a default mask using zero
thousands: '.', // The thousands separator
decimal: '.' , // The decimal separator
precision: 0, // How many decimal places are allowed
affixesStay : true, // set if the symbol will stay in the field after the user exits the field. 
symbolPosition : 'left' // use this setting to position the symbol at the left or right side of the value. default 'left'
}); //
		</script>
		<script type="text/javascript">
 $('#equipo_adicional').change(function() {
    var el = $(this);
    if(el.val() === "No") {
          $('#campo_equipo').hide();   
    } else {
      alert("Has seleccionado Equipo adicional, indica cuál?"); 
          $('#campo_equipo').show();
    }      
});
</script>
<script type="text/javascript">
	var datefield = document.createElement("input")

datefield.setAttribute("type", "date")

if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
    document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
    document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"><\/script>\n') 
}        
if (datefield.type != "date"){ //if browser doesn't support input type="date", initialize date picker widget:
    $(document).ready(function() {
        $('#fecha_reporte').datepicker();
        //dateFormat: 'dd/mm/yy'
    }); 
} 
</script>

<script type="text/javascript">
  $(function () {
   $('[data-toggle="tooltip"]').tooltip();
  })
</script>

<script>
	//CARGA DE IMAGENES
	$(document).ready(function(){
    // Basic
		$('.dropify').dropify();
		$('.dropify2').dropify();
    });

	$('.dropify').dropify({
				messages: {
					'default': 'Arrastra y suelta un archivo aquí o haz clic',
					'replace': 'Arrastra y suelta o haz clic para reemplazar',
					'remove':  'Remover',
					'error':   'Oops, sucedió algo mal.'
				},
				error: {
						'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} maximo).',
						'imageFormat': 'El formato de imagen no está permitido ({{ value }} solamente).',
						'fileExtension': 'El archivo no está permitido ({{ value }} solamente).'
				}
	});

	var drEvent = $('.dropify').dropify();

	drEvent.on('dropify.beforeClear', function(event, element){
		return confirm("Realmente desea eliminar la imagen \"" + element.filename + "\" ?");
	});

	drEvent.on('dropify.error.fileSize', function(event, element){
		alert('Imagen demasiado grande!');
	});
	drEvent.on('dropify.error.minWidth', function(event, element){
		alert('Min width error message!');
	});
	drEvent.on('dropify.error.maxWidth', function(event, element){
		alert('Max width error message!');
	});
	drEvent.on('dropify.error.minHeight', function(event, element){
		alert('Min height error message!');
	});
	drEvent.on('dropify.error.maxHeight', function(event, element){
		alert('Max height error message!');
	});
	drEvent.on('dropify.error.imageFormat', function(event, element){
		alert('Error en el formato de la imagen!');
	});

	drEvent.on('dropify.errors', function(event, element){
		alert('Ha ocurrido un error!');
	});
	  var drEvent = $('.dropify').dropify();

	drEvent.on('dropify.afterClear', function(event, element){
		alert('Archivo Eliminado');
	});
</script>
