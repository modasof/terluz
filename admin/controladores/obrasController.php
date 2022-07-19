<?php
class obrasController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function dashboard() {
		require_once 'vistas/obras/homeobras.php';
	}

	function nueva_obra() {
		require_once 'vistas/obras/nueva_obra.php';
	}

	


/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarobra() {

	$variable = $_POST;

	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_obra($campo);

	$ultimaobra = Obras::obtenerultimaobra();

	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se ha guardado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $ultimaobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	//$this->detalle_obra();
}




/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarobra() {

		$id = $_GET['id'];
		$res = Obras::eliminarobraPor($id);
		if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}

			require_once 'vistas/obras/homeobras.php';
	}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizarobra(){

	$idobra = $_GET['id'];
	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);

	foreach ($variable as $campo => $valor){
		if ($campo=="texto"){
			$nuevoarreglo[$campo]=$valor; 
		}else{
			//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
			$campo = strip_tags(trim($campo));
			$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

			$valor = strip_tags(trim($valor));
			$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
			$nuevoarreglo[$campo]=$valor;
		}
	}

	$datosguardar = new Obras($idobra,$nuevoarreglo);
	$res = Obras::actualizar_obra($idobra,$datosguardar);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Actualizados!\", \"Se ha actualizado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $idobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
	}
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarcapitulo() {

	$variable = $_POST;
	$idobra= $_GET['id'];
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_capitulo($campo);

	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se ha guardado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $idobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	//$this->detalle_obra();
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardaractividad() {

	$variable = $_POST;
	$idobra= $_GET['id'];
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_actividad($campo);

	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se ha guardado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $idobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	//$this->detalle_obra();
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarcantmayores() {

	$variable = $_POST;
	$idobra= $_GET['id'];
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_cantidadesmayores($campo);

	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$campos=Obras::obtenerpaginapor($idobra);
	require_once 'vistas/obras/modificaciones_obra.php';
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarcantidadesproyectadas() {

	$variable = $_POST;
	$idobra= $_GET['id'];
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_cantidadesproyectadas($campo);

	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$campos=Obras::obtenerpaginapor($idobra);
	require_once 'vistas/obras/proyeccion_obra.php';
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardaravance() {

	$variable = $_POST;
	$idobra= $_GET['id'];
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
		$campo = strip_tags(trim($campo));
		$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

		$valor = strip_tags(trim($valor));
		$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
		if ($campo=="imagen2"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
	}
	$campo = new Obras('',$nuevoarreglo);
	$res = Obras::guardar_avance($campo);

	if ($res){
			echo "<script>jQuery(function(){Swal.fire(\"¡Datos Guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$campos=Obras::obtenerpaginapor($idobra);
	require_once 'vistas/obras/avance_obra.php';
}


/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarcapitulo() {
		$id = $_GET['id'];
		$idcap = $_GET['idcap'];
		$res = Obras::eliminaractividadesPorCap($idcap);
		$res = Obras::eliminarcapituloPor($idcap);
		if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Eliminados!\", \"Se ha eliminado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $id . "';});});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
	}


/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminaractividad() {
		$id = $_GET['id'];
		$idact = $_GET['idact'];
		$res = Obras::eliminaractividadPor($idact);
		if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Eliminados!\", \"Se ha eliminado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $id . "';});});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarcantidades() {
		$id = $_GET['id'];
		$idact = $_GET['idact'];
		$res = Obras::eliminarcantidadesPor($idact);
		if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Eliminados!\", \"Se ha eliminado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=modificaciones&&id=" . $id . "';});});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/modificaciones_obra.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarcantidadesproyectadas() {
		$id = $_GET['id'];
		$idact = $_GET['idact'];
		$idrango = $_GET['idrango'];
		$res = Obras::eliminarcantidades_proyectadasPor($idact,$idrango);
		if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/proyeccion_obra.php';
	}


/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizarcapitulo(){

	$id = $_GET['cap'];
	$idobra = $_GET['id'];

	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);

	foreach ($variable as $campo => $valor){
		if ($campo=="texto"){
			$nuevoarreglo[$campo]=$valor; 
		}else{
			//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
			$campo = strip_tags(trim($campo));
			$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

			$valor = strip_tags(trim($valor));
			$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
			$nuevoarreglo[$campo]=$valor;
		}
	}

	$datosguardar = new Obras($id,$nuevoarreglo);
	$res = Obras::actualizar_capitulo($id,$datosguardar);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Actualizados!\", \"Se ha actualizado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $idobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
	}
}


/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizaractividad(){

	$id = $_GET['act'];
	$idobra = $_GET['id'];

	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);

	foreach ($variable as $campo => $valor){
		if ($campo=="texto"){
			$nuevoarreglo[$campo]=$valor; 
		}else{
			//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
			$campo = strip_tags(trim($campo));
			$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

			$valor = strip_tags(trim($valor));
			$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
			$nuevoarreglo[$campo]=$valor;
		}
	}

	$datosguardar = new Obras($id,$nuevoarreglo);
	$res = Obras::actualizar_actividad($id,$datosguardar);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos Actualizados!\", \"Se ha actualizado correctamente la información\", \"success\").then(function(){window.location='?controller=obras&&action=detalle_obra&&id=" . $idobra . "';});});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
	}
}

/*************************************************************/
/* FUNCION PARA MOSTRAR LA PAGINA*/
/*************************************************************/
function detalle_obra(){
	$id = $_GET['id'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/nueva_data.php';
}


function modificaciones(){
	$id = $_GET['id'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/modificaciones_obra.php';
}

function proyecciones(){
	$id = $_GET['id'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/proyeccion_obra.php';
}

function proyeccionesrango(){
	$id = $_GET['id'];
	$rangoid = $_GET['rangoid'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/proyeccion_obra_rango.php';
}

function proyeccioneslme(){
	$id = $_GET['id'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/proyeccion_lme.php';
}

function avance_obra(){
	$id = $_GET['id'];
	$campos=Obras::obtenerpaginapor($id);
	require_once 'vistas/obras/avance_obra.php';
}

/*************************************************************/
/* FUNCION PARA SUBIR UN ARCHIVO  */
/*************************************************************/

	function subir_fichero($directorio_destino, $nombre_fichero)
	{
		$tmp_name = $_FILES[$nombre_fichero]['tmp_name'];
		//si hemos enviado un directorio que existe realmente y hemos subido el archivo
		if (is_dir($directorio_destino) && is_uploaded_file($tmp_name))
		{
			$img_file = $_FILES[$nombre_fichero]['name'];
			$Aleaotorio=rand(0,99999);
			$img_file=$Aleaotorio.$img_file;
			$img_type = $_FILES[$nombre_fichero]['type'];
			// Si se trata de una imagen
			if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||strpos($img_type, "jpg")) || strpos($img_type, "png")))
			{
				//¿Tenemos permisos para subir la imágen?
				if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file))
				{
					$retornar = $directorio_destino . '/' . $img_file; //RETORNAMOS EL NOMBRE Y RUTA DEL FICHERO
					return $retornar;
				}
			} else {
				if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file))
				{
					$retornar = $directorio_destino . '/' . $img_file; //RETORNAMOS EL NOMBRE Y RUTA DEL FICHERO
					return $retornar;
				}
			}
		}
		//Si llegamos hasta aquí es que algo ha fallado
		$vacio ='';
		return $vacio;
	}



 }
