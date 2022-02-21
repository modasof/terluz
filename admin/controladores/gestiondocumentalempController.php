<?php
class GestiondocumentalempController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function todos() {
		$id = $_GET['id_modulo'];
		$campos=Gestiondocumentalemp::obtenerPagina($id);
		require_once 'vistas/gestiondocumentalemp/todos.php';
	}

	function varios() {
		$id = $_GET['id_cuenta'];
		$campos=Gestiondocumentalemp::obtenerPaginavarios($id);;
		require_once 'vistas/gestiondocumentalemp/varios.php';
	}

	function cargartodos() {
		$id_modulo = $_GET['id_modulo'];
		$id_cuenta = $_GET['id'];
		$res=Gestiondocumentalemp::cargarTodos($id_modulo,$id_cuenta);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos Actualizados!\", \"Se han actualizado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos=Gestiondocumentalemp::obtenerConfig($id_modulo);;
		require_once 'vistas/gestiondocumentalemp/configuracion.php';

	}


	function configuracion() {
		$id = $_GET['id_modulo'];
		$campos=Gestiondocumentalemp::obtenerConfig($id);;
		require_once 'vistas/gestiondocumentalemp/configuracion.php';
	}

	function listaequipos() {
		$campos=Gestiondocumentalemp::obtenerListaequipos();;
		require_once 'vistas/gestiondocumentalemp/lista.php';
	}

/*************************************************************/
/* FUNCION PARA AGREGAR NUEVO LLAMADO DESDE ROUTING.PHP */
/*************************************************************/
	function nuevo() {
		require_once 'vistas/gestiondocumentalemp/nuevo.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editar() {
		$idreg = $_GET['idreg'];
		$id_cuenta = $_GET['id'];
		$campos = Gestiondocumentalemp::obtenerPaginaPor($idreg);
		require_once 'vistas/gestiondocumentalemp/editar.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR VARIOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editarvarios() {
		$id = $_GET['id'];
		$id_cuenta = $_GET['id_cuenta'];
		$campos = Gestiondocumentalemp::obtenerPaginavariosPor($id);
		require_once 'vistas/gestiondocumentalemp/editarvarios.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminar() {
		$id = $_GET['iddel'];
		$id_modulo = $_GET['id_modulo'];
		$id_cuenta = $_GET['id'];
		$res = Gestiondocumentalemp::eliminarPor($id);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Gestiondocumentalemp::obtenerPagina($id_modulo);
		require_once 'vistas/gestiondocumentalemp/todos.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function activar() {
		$id = $_GET['iddel'];
		$id_modulo = $_GET['id_modulo'];
		$id_cuenta = $_GET['id'];
		$res = Gestiondocumentalemp::eliminarPor($id);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos Actualizados!\", \"Se han actualizado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al Actualizar!\", \"No se han actualizado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Gestiondocumentalemp::obtenerPagina($id_modulo);
		require_once 'vistas/gestiondocumentalemp/todos.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR VARIOS  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminarvarios() {
		$id = $_GET['id'];
		$id_cuenta = $_GET['id_cuenta'];
		$res = Gestiondocumentalemp::eliminarvariosPor($id);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Gestiondocumentalemp::obtenerPaginavarios($id_cuenta);
		require_once 'vistas/gestiondocumentalemp/varios.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function desactivarDocumento() {
		$id_modulo = $_GET['id_modulo'];
		$id_cuenta = $_GET['id'];
		$id_documento= $_GET['id_documento'];
		$imagen= $_GET['imagen'];
		$res = Gestiondocumentalemp::desactivarDocumento($id_cuenta,$id_modulo,$id_documento,$imagen);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos Actualizados!\", \"Se han actualizado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al Actualizar!\", \"No se han actualizado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Gestiondocumentalemp::obtenerPagina($id_modulo);
		require_once 'vistas/gestiondocumentalemp/todos.php';
	}



/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardar() {

	$ruta_imagen=$this->subir_fichero('images/documentosemp','imagen');
	//$nuevo['imagen']=$ruta_imagen;
	$id_modulo=$_GET['id_modulo'];
	$id_cuenta=$_GET['id'];
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
	$campo = new Gestiondocumentaleq('',$nuevoarreglo);
	$res = Gestiondocumentalemp::guardar($campo,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){swal(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->show($id_modulo);
}

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO VARIOS */
/*************************************************************/
function guardarvarios() {

	$ruta_imagen=$this->subir_fichero('images/documentosemp','imagen');
	//$nuevo['imagen']=$ruta_imagen;
	$id_cuenta=$_GET['id_cuenta'];
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
	$campo = new Gestiondocumentaleq('',$nuevoarreglo);
	$res = Gestiondocumentalemp::guardarvarios($campo,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){swal(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->showvarios($id_cuenta);
}





/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizar(){
	if (empty($_FILES['imagen']['name'])){
		$ruta_imagen = $_POST['ruta1'];
	} else {
		$ruta_imagen=$this->subir_fichero('images/documentosemp','imagen');
	}
	$id = $_GET['idreg'];
	$id_cuenta = $_GET['id'];
	$id_modulo = $_GET['id_modulo'];
	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
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
	$datosguardar = new Gestiondocumentaleq($id,$nuevoarreglo);
	$res = Gestiondocumentalemp::actualizar($id,$datosguardar,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina de miembros\", \"success\");});</script>";
	}else{
				echo "<script>jQuery(function(){swal(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
		}
	$this->show($id_cuenta);
}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizarvarios(){
	if (empty($_FILES['imagen']['name'])){
		$ruta_imagen = $_POST['ruta1'];
	} else {
		$ruta_imagen=$this->subir_fichero('images/documentosemp','imagen');
	}
	$id = $_GET['id'];
	$id_cuenta = $_GET['id_cuenta'];
	$variable = $_POST;
	$nuevoarreglo = array();
	extract($variable);
	foreach ($variable as $campo => $valor){
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
	$datosguardar = new Gestiondocumentaleq($id,$nuevoarreglo);
	$res = Gestiondocumentalemp::actualizarvarios($id,$datosguardar,$ruta_imagen);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina de miembros\", \"success\");});</script>";
	}else{
				echo "<script>jQuery(function(){swal(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
		}
	$this->showvarios($id_cuenta);
}

/*************************************************************/
/* FUNCION PARA MOSTRAR LA PAGINA*/
/*************************************************************/
	function show(){
		$id_modulo = $_GET['id_modulo'];
		$campos=Gestiondocumentalemp::obtenerPagina($id_modulo);
		require_once 'vistas/gestiondocumentalemp/todos.php';
	}

	function showvarios(){
		$id_cuenta = $_GET['id_cuenta'];
		$campos=Gestiondocumentalemp::obtenerPaginavarios($id_cuenta);
		require_once 'vistas/gestiondocumentalemp/varios.php';
	}


/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO CLIENTE */
/*************************************************************/
function carpetaextra() {

	$id = $_GET['id_cuenta'];
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
	$campo = new Gestiondocumentalemp('',$nuevoarreglo);
	$res = Gestiondocumentalemp::carpetaextra($campo);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){swal(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	
		$campos=Gestiondocumentalemp::obtenerPaginavarios($id);;
		require_once 'vistas/gestiondocumentalemp/varios.php';
	
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
