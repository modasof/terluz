<?php
class VersionesuController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function todos() {
		$campos=Versiones::obtenerPagina();;
		require_once 'vistas/versionesu/todos.php';
	}

/*************************************************************/
/* FUNCION PARA AGREGAR NUEVO LLAMADO DESDE ROUTING.PHP */
/*************************************************************/
	function nuevo() {
		require_once 'vistas/versionesu/nuevo.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editar() {
		$id = $_GET['id'];
		$campos = Versiones::obtenerPaginaPor($id);
		require_once 'vistas/versionesu/editar.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminar() {
		$id = $_GET['id'];
		$res = Versiones::eliminarPor($id);
		if ($res){
			echo "<script>jQuery(function(){swal(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){swal(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Versiones::obtenerPagina();
		require_once 'vistas/versionesu/todos.php';
	}



/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardar() {

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
	$campo = new Versiones('',$nuevoarreglo);
	$res = Versiones::guardar($campo);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){swal(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->show();
}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizar(){
		$id = $_GET['id'];
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
	$datosguardar = new Versiones($id,$nuevoarreglo);
	$res = Versiones::actualizar($id,$datosguardar);
	if ($res){
		echo "<script>jQuery(function(){swal(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina de miembros\", \"success\");});</script>";
	}else{
				echo "<script>jQuery(function(){swal(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
		}
	$this->show();
}

/*************************************************************/
/* FUNCION PARA MOSTRAR LA PAGINA*/
/*************************************************************/
	function show(){
		$campos=Versiones::obtenerPagina();
		require_once 'vistas/versionesu/todos.php';
	}
}
