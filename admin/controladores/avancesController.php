<?php
class AvancesController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function todosporobra() {
		$id=$_GET['id_obra'];
		$campos=Avances::Todospor_obra($id);;
		require_once 'vistas/avances/todosobra.php';
	}

	function todosporcapitulo() {
		$id=$_GET['id_capitulo'];
		$campos=Avances::Todospor_capitulo($id);;
		require_once 'vistas/avances/todoscapitulo.php';
	}

	function todosporfrente() {
		$id=$_GET['id_frente'];
		$campos=Avances::Todospor_frente($id);;
		require_once 'vistas/avances/todosfrente.php';
	}

	function todosporactividad() {

		$id=$_GET['id_act'];
		$id_obra=$_GET['id_obra'];

		$campos=Avances::Todospor_actividad($id);;
		require_once 'vistas/avances/todosactividad.php';
	}

	function todosporusuario() {
		$id=$_GET['id_usuario'];
		$campos=Avances::Todospor_usuario($id);;
		require_once 'vistas/avances/todosusuario.php';
	}



/*************************************************************/
/* FUNCION PARA MOSTRAR REPORTE POR RANGO DE FECHAS*/
/*************************************************************/

function porfecha() {

	if (isset($_POST['daterange'])) {
  $fechaform=$_POST['daterange'];
}
elseif (isset($_GET['daterange'])) {
  $fechaform=$_GET['daterange'];
}
		$campos=Avances::todos();;
		require_once 'vistas/avances/reportehoras.php';
	}

/*************************************************************/
/* FUNCION PARA MOSTRAR REPORTE POR RANGO DE FECHAS*/
/*************************************************************/

function porfechafrente() {

	if (isset($_POST['daterange'])) {
  $fechaform=$_POST['daterange'];
}
elseif (isset($_GET['daterange'])) {
  $fechaform=$_GET['daterange'];
}
		$campos=Avances::ReporteHoras();;
		require_once 'vistas/avances/reportehoras.php';
	}


/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardarhoras() {

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
	//array_push($nuevoarreglo,$nuevo);
	$campo = new Horasmq('',$nuevoarreglo);
	$res = Avances::guardarhoras($campo,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->showhoras();
}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminar() {
		$id = $_GET['id'];
		$id_act = $_GET['id_act'];
		$id_obra = $_GET['id_obra'];

		$res = Avances::eliminarPor($id);
		if ($res){
			echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos=Avances::Todospor_actividad($id_act);;
		require_once 'vistas/avances/todosactividad.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editarhoras() {
		$id = $_GET['id'];
		$vereditar = $_GET['vereditar'];
		$campos = Avances::editarhorasPor($id);
		require_once 'vistas/avances/formeditarhoras.php';
	}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizar(){


	$id = $_GET['id'];
	$id_act = $_GET['id_act'];
	$id_obra = $_GET['id_obra'];


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

	$datosguardar = new Avances($id,$nuevoarreglo);
	$res = Avances::actualizar($id,$datosguardar);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
	}
		$campos=Avances::Todospor_actividad($id_act);;
		require_once 'vistas/avances/todosactividad.php';
}

/*************************************************************/
/* FUNCION PARA MOSTRAR LA PAGINA*/
/*************************************************************/
function showhoras(){
	$campos=Avances::ReporteHoras();
	require_once 'vistas/avances/reportehoras.php';
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
