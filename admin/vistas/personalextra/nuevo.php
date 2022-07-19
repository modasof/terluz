<?php 
error_reporting(E_ALL);
ini_set('display_errors', '0');

 ?>
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


<!--<div class="box box-primary collapsed-box	">-->
<div class="box box-primary	">
            <div class="box-header with-border">
              <h3 class="box-title"> Crear Registro
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
	<form role="form" autocomplete="off" action="?controller=personalextra&&action=guardar" method="POST" enctype="multipart/form-data"  id="formulario" name="formulario" onsubmit="return validateForm();">
							<?php  
								date_default_timezone_set("America/Bogota");
								$TiempoActual = date('Y-m-d H:i:s');
								$diaactual = date('Y-m-d');
							?>
							
					<input type="hidden" name="creado_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="estado_extra" value="1">
					<input type="hidden" name="extra_publicado" value="1">
					<input type="hidden" name="marca_temporal" value="<?php echo($TiempoActual);?>">
					
					<div class="card-body">
							<div class="row">

									<div class="col-md-12">
                    <div class="form-group">
                      <label for="fila2_columna1">Certificado Bancario <small>Tamaño máximo 5MB</small></label>
                        <div class="custom-file">
                           <input name="imagen" type="file" id="input-file-now" class="dropify" data-default-file=""  multiple="multiple" data-allowed-file-extensions="png jpg jpeg mp4 pdf xls xlsx webm" data-show-errors="true" data-max-file-size="5M" data-errors-position="outside" accept="image/png, .jpeg, .jpg, image/gif,.pdf,.xlsx"/ required>
                        </div>
                    </div>
                </div>

									<div class="col-md-12">
												<div class="form-group">
													<label>Documento <span>*</span></label>
													<input type="text"  name="documento" placeholder="CC/Nit/Tarjeta Identidad" class="form-control" required value="">
												</div>
									</div>
									<div class="col-md-12">
												<div class="form-group">
													<label>Nombres y Apellidos <span>*</span></label>
													<input type="text"  name="nombre_extra" placeholder="Nombres y Apellidos" class="form-control" required value="">
												</div>
									</div>
									<div class="col-md-12">
												<div class="form-group">
													<label>Número de contacto <span>*</span></label>
													<input type="text"  name="celular_extra" placeholder="Número de contacto" class="form-control" required value="">
												</div>
									</div>
									 <div class="col-md-12">
                        <div class="form-group">
                          <label for="nombres">Descripción del servicio prestado</label>
                            <textarea class="form-control" rows="2" name="cargo" id="cargo" placeholder="Descripción del servicio prestado" maxlength="500" required></textarea>
                        </div>
                </div>
						
							
										</div>
							<div class="row">
								<div class="card-footer">
								  <button type="submit" class="btn btn-primary" id="boton_enviar"  data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Guardar</button>
								</div>
						  </div>
						  </form>
</div>
</div>


</div> <!-- Fin Content-Wrapper -->




		
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
