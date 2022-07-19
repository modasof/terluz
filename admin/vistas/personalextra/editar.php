<?php
ini_set('display_errors', '0');

include_once 'modelos/personalextra.php';
include_once 'controladores/personalextraController.php';

include_once 'modelos/usuarios.php';
include_once 'controladores/usuariosController.php';



$RolSesion = $_SESSION['IdRol'];
$IdSesion  = $_SESSION['IdUser'];
$idventa   = $_GET['id'];
$vereditar = $_GET['vereditar'];

$res    = Personalextra::obtenerPaginaPor($idventa);
$campos = $res->getCampos();
foreach ($campos as $campo) {
   $id_extra        = $campo['id_extra'];
    $nombre_extra    = $campo['nombre_extra'];
    $celular_extra   = $campo['celular_extra'];
    $documento       = $campo['documento'];
    $cargo           = $campo['cargo'];
    $creado_por      = $campo['creado_por'];
    $extra_publicado = $campo['extra_publicado'];
    $estado_extra    = $campo['estado_extra'];
    $marca_temporal  = $campo['marca_temporal'];
    $nomcreado = Usuarios::obtenerNombreUsuario($creado_por);

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

<!-- Content Wrapper. Contains page content -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Editar Registro</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?controller=index&&action=index">Inicio</a></li>

            <li class="breadcrumb-item active"><a href="?controller=obras&&action=dashboard">Dashboard Obras</a></li>
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
	<form role="form" autocomplete="off" action="?controller=personalextra&&action=actualizar&&id=<?php echo ($idventa); ?>" method="POST" enctype="multipart/form-data"  id="formulario" name="formulario" onsubmit="return validateForm();">
								<?php  
								date_default_timezone_set("America/Bogota");
								$TiempoActual = date('Y-m-d H:i:s');
								$diaactual = date('Y-m-d');
							?>
							
					<input type="hidden" name="creado_por" value="<?php echo($IdSesion);?>">
					<input type="hidden" name="estado_extra" value="<?php echo($estado_extra);?>">
					<input type="hidden" name="extra_publicado" value="<?php echo($extra_publicado);?>">
					<input type="hidden" name="marca_temporal" value="<?php echo($TiempoActual);?>">
					
					<div class="card-body">
							<div class="row">

								<div class="col-md-12">
												<div class="form-group">
													<label>Documento <span>*</span></label>
													<input type="text"  name="documento" placeholder="CC/Nit/Tarjeta Identidad" class="form-control" required value="<?php echo utf8_decode($documento); ?>">
												</div>
									</div>
									<div class="col-md-12">
												<div class="form-group">
													<label>Nombres y Apellidos <span>*</span></label>
													<input type="text"  name="nombre_extra" placeholder="Nombres y Apellidos Identidad" class="form-control" required value="<?php echo utf8_decode($nombre_extra); ?>">
												</div>
									</div>
										<div class="col-md-12">
												<div class="form-group">
													<label>Número de contacto <span>*</span></label>
													<input type="text"  name="celular_extra" placeholder="Nombres y Apellidos Identidad" class="form-control" required value="<?php echo utf8_decode($celular_extra); ?>">
												</div>
									</div>
									 <div class="col-md-12">
                        <div class="form-group">
                          <label for="nombres">Descripción del servicio prestado</label>
                            <textarea class="form-control" rows="2" name="cargo" id="cargo" placeholder="Descripción del servicio prestado" maxlength="500" required><?php echo utf8_decode($cargo); ?></textarea>
                        </div>
                </div>
							
										</div>
							<div class="row">
								<div class="card-footer">
								  <button type="submit" class="btn btn-primary" id="boton_enviar"  data-toggle="tooltip" data-placement="bottom" title="Haz clic aqui para guardar la información">Actualizar</button>
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

