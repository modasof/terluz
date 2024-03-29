<?php
class HorasmqController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function horas() {
		$id_obra=$_GET['id_obra'];
		$campos=Horasmq::ReporteHoras($id_obra);;
		require_once 'vistas/horasmq/reportehoras.php';
	}

/*************************************************************/
/* FUNCION PARA MOSTRAR REPORTE POR RANGO DE FECHAS*/
/*************************************************************/

function horasporfecha() {
$id_obra=$_GET['id_obra'];
	if (isset($_POST['daterange'])) {
  $fechaform=$_POST['daterange'];
}
elseif (isset($_GET['daterange'])) {
  $fechaform=$_GET['daterange'];
}
		$campos=Horasmq::ReporteHoras($id_obra);;
		require_once 'vistas/horasmq/reportehoras.php';
	}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarhoras() {

	$id_obra=$_GET['id_obra'];
	$ruta_imagen=$this->subir_fichero('images/horasmq','imagen');
	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
		if ($campo=="texto"){
			$nuevoarreglo[$campo]=$valor;  //OJO AL TEXTO DEL SLIDER ACEPTA ETIQUETAS PHP
		}else{
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
	}

	$fecha_reporte=$_POST['fecha_reporte'];
	$equipo_id_equipo=$_POST['equipo_id_equipo'];
	$hora_inactiva=$_POST['hora_inactiva'];
	$obra_id_obra=$_POST['obra_id_obra'];


	$validacion=Horasmq::validarduplicado($fecha_reporte,$equipo_id_equipo,$obra_id_obra);

	if ($validacion>0) {
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"El equipo seleccionado ya tiene horas reportadas el día ".$fecha_reporte." \", \"warning\");});</script>";
	}
	else{

			//array_push($nuevoarreglo,$nuevo);
	$campo = new Horasmq('',$nuevoarreglo);
	$res = Horasmq::guardarhoras($campo,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}

	}


	$campos=Horasmq::ReporteHoras($id_obra);
	require_once 'vistas/horasmq/reportehoras.php';

	
}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarhoras() {
		$id = $_GET['id'];
		$id_obra = $_GET['id_obra'];
		$res = Horasmq::eliminarhorasPor($id);
		if ($res){
			echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Horasmq::ReporteHoras($id_obra);
		require_once 'vistas/horasmq/reportehoras.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editarhoras() {
		$id = $_GET['id'];
		$id_obra =$_GET['id_obra'];
		$vereditar = $_GET['vereditar'];
		$campos = Horasmq::editarhorasPor($id);
		require_once 'vistas/horasmq/formeditarhoras.php';
	}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizarhoras(){
	$id = $_GET['id'];
	$id_obra=$_GET['id_obra'];
	if (empty($_FILES['imagen']['name'])){
		$ruta_imagen = $_POST['ruta1'];
	} else {
		$ruta_imagen=$this->subir_fichero('images/horasmq','imagen');
	}
	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);

	foreach ($variable as $campo => $valor){
		if ($campo=="texto"){
			$nuevoarreglo[$campo]=$valor;  //OJO AL TEXTO DEL SLIDER ACEPTA ETIQUETAS PHP
		}else{
			//ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
			$campo = strip_tags(trim($campo));
			$campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

			$valor = strip_tags(trim($valor));
			$valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
			if ($campo=="imagen"){
			$nuevoarreglo[$campo]=$ruta_imagen;
		}else{
			$nuevoarreglo[$campo]=$valor;
		}
		}
	}

	$datosguardar = new Horasmq($id,$nuevoarreglo);
	$res = Horasmq::actualizarhoras($id,$datosguardar,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
	}
	$campos = Horasmq::ReporteHoras($id_obra);
		require_once 'vistas/horasmq/reportehoras.php';
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
