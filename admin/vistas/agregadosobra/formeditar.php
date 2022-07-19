<?php
ini_set('display_errors', '0');

include_once 'modelos/obras.php';
include_once 'controladores/obrasController.php';

include_once 'modelos/proyeccionesins.php';
include_once 'controladores/proyeccionesinsController.php';

include_once 'modelos/insumos.php';
include_once 'controladores/insumosController.php';

include_once 'modelos/destinos.php';
include_once 'controladores/destinosController.php';

include_once 'modelos/agregadosobra.php';
include_once 'controladores/agregadosobraController.php';

include_once 'modelos/frentes.php';
include_once 'controladores/frentesController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';

$RolSesion = $_SESSION['IdRol'];
$IdSesion = $_SESSION['IdUser'];
$idventa=$_GET['id'];
$getobra=$_GET['id_obra'];
$vereditar=$_GET['vereditar'];

$res=Agregadosobra::editarPor($idventa);
$campos = $res->getCampos();
foreach($campos as $campo){
            $id = $campo['id'];
            $imagen = $campo['imagen'];
            $fecha_reporte = $campo['fecha_reporte'];
            $insumo_id_insumo = $campo['insumo_id_insumo'];
            $origen_id_origen = $campo['origen_id_origen'];
            $recibido_por = $campo['recibido_por'];
            $cantidad = $campo['cantidad'];
            $placa = $campo['placa'];
            $localizacion = $campo['localizacion'];
            $creado_por = $campo['creado_por'];
            $estado_reporte = $campo['estado_reporte'];
            $reporte_publicado = $campo['reporte_publicado'];
            $marca_temporal = $campo['marca_temporal'];
            $observaciones = $campo['observaciones'];
            $obra_id_obra = $campo['obra_id_obra'];
            $frente_id_frente = $campo['frente_id_frente'];

            $nominsumo=Insumos::obtenerNombreInsumo($insumo_id_insumo);
            $nomcantera=Destinos::obtenerNombreDestino($origen_id_origen);
            $nomobra=Obras::obtenernombreobra($obra_id_obra);
            $nomfrente=Frentes::obtenerNombre($frente_id_frente);
            $nomreportador=usuarios::obtenerNombreUsuario($recibido_por);        

}

?>

<!-- CCS Y JS PARA LA CARGA DE IMAGEN -->
<script src="plugins/dropify/dropify.min.js"></script>
<link rel="stylesheet" href="plugins/dropify/dropify.min.css">
 <!-- CCS Y JS DATERANGE -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
<!-- Content Wrapper. Contains page content -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Editar Recepción Material</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>
           
            <!--<li class="breadcrumb-item active"><a href="?controller=equipos&&action=todos">Equipos</a></li>-->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
    <!-- /.content-header -->

	<!-- Main content -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				
					
						<!-- ESTE DIV LO USO PARA CENTRAR EL FORMULARIO -->
						<!-- left column -->
						<div class="col-md-8">
	<form role="form" autocomplete="off" action="?controller=agregadosobra&&action=actualizar&&id=<?php echo($idventa); ?>&&id_obra=<?php echo($getobra); ?>" method="POST" enctype="multipart/form-data" >
							<?php  
								date_default_timezone_set("America/Bogota");
								$TiempoActual = date('Y-m-d H:i:s');
							?>
							
				<input type="hidden" name="creado_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="recibido_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="obra_id_obra" value="<?php echo($getobra);?>">
					<input type="hidden" name="estado_reporte" value="<?php echo($estado_reporte);?>">
					<input type="hidden" name="reporte_publicado" value="<?php echo($reporte_publicado);?>">
					<input type="hidden" name="marca_temporal" value="<?php echo($TiempoActual);?>">
					<div class="card-body">
							<div class="row">
			 <div class="col-md-12">
										<div class="form-group">
										  <label for="fila2_columna1">Documento <small>Tamaño máximo 10MB</small></label>
												<div class="custom-file">
													 <input name="imagen" type="file" id="input-file-now" class="dropify" data-default-file="<?php echo $imagen;?>" multiple="multiple" data-allowed-file-extensions="png jpg jpeg mp4 pdf xls xlsx webm" data-show-errors="true" data-max-file-size="10M" data-errors-position="outside" accept="image/png, .jpeg, .jpg, image/gif,.pdf,.xlsx"/ >
													 <input type="hidden" name="ruta1" value="<?php echo $imagen;?>" >
												</div>
										</div>
									   </div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Fecha del Reporte: <span>*</span></label>
													<input type="date" name="fecha_reporte" placeholder="Fecha" class="form-control required" required id="fecha_reporte" value="<?php echo utf8_decode($fecha_reporte); ?>">
												</div>
											</div>
											
											
										
										<div class="col-md-12">
												<div class="form-group">
													<label>Cantidad (m3)<span>*</span></label>
													<input type="number" step="any" name="cantidad" placeholder="Cantidad" class="form-control" required value="<?php echo utf8_decode($cantidad); ?>">
													<small>Decimales separados con punto</small>
												</div>
										</div>
											<div class="col-md-12">
												<div class="form-group">
													<label>Placa<span>*</span></label>
													<input type="text" name="placa" placeholder="Placa" class="form-control" required value="<?php echo utf8_decode($placa); ?>">
												</div>
										</div>
										<div class="col-md-12">
												<div class="form-group">
													<label>Localización<span>*</span></label>
													<input type="text" name="localizacion" placeholder="Ej. KM 0" class="form-control" required value="<?php echo utf8_decode($localizacion); ?>">
												</div>
										</div>

						<div class="col-md-12">

												<div class="form-group">
													<label> Selecione el Origen: <span>*</span></label>
								<select style="width: 300px;" class="form-control mi-selector" id="origen_id_origen" name="origen_id_origen" required>
										<option value="<?php echo utf8_decode($origen_id_origen); ?>" selected><?php echo utf8_decode($nomcantera); ?></option>
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
										<option value="<?php echo utf8_decode($insumo_id_insumo); ?>" selected><?php echo utf8_decode($nominsumo); ?></option>
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
			<option value="<?php echo utf8_decode($frente_id_frente); ?>"><?php echo utf8_decode($nomfrente); ?></option>
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
									<textarea class="form-control" rows="2" id="descripcion" name="observaciones"><?php echo utf8_decode($observaciones); ?></textarea>
												</div>
											</div>
											
										</div>
							<div class="row">
								<div class="card-footer">
								  <button name="Submit" type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para actualizar la información">Actualizar</button>
								</div>
						  </div>
						  </form>
					  </div>

					 
					


					</div> <!-- FIN DE ROW-->
				</div><!-- FIN DE CONTAINER FORMULARIO-->
			</div> <!-- Fin Row -->
		</div> <!-- Fin Container -->
	</div> <!-- Fin Content -->

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

