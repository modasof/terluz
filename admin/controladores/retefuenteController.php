<?php
class RetefuenteController {
	function __construct() {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/

	function todos() {
		$campos=Retefuente::obtenerPagina();;
		require_once 'vistas/retefuente/todos.php';
	}

/*************************************************************/
/* FUNCION PARA AGREGAR NUEVO LLAMADO DESDE ROUTING.PHP */
/*************************************************************/
	function nuevo() {
		require_once 'vistas/retefuente/nuevo.php';
	}

/*************************************************************/
/* FUNCION PARA MODIFICAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function editar() {
		$id = $_GET['id'];
		$campos = Retefuente::obtenerPaginaPor($id);
		require_once 'vistas/retefuente/editar.php';
	}

/*************************************************************/
/* FUNCION PARA ELIMINAR  LLAMADO DESDE ROUTING.PHP*/
/*************************************************************/
	function eliminar() {
		$id = $_GET['id'];
		$res = Retefuente::eliminarPor($id);
		if ($res){
			echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
		}else{
				echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
		}
		$campos = Retefuente::obtenerPagina();
		require_once 'vistas/retefuente/todos.php';
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
	$campo = new Retefuente('',$nuevoarreglo);
	$res = Retefuente::guardar($campo);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->show();
}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizar(){
	$id=$_GET['id'];
	$alias_retefuente=$_POST['alias_retefuente'];
	$valor_retefuente=$_POST['valor_retefuente'];
	$res = Retefuente::actualizarNombre($alias_retefuente,$valor_retefuente,$id);
	if ($res){
		echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
	}else{
		echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
	}
	$this->show();
}

/*************************************************************/
/* FUNCION PARA MOSTRAR LA PAGINA*/
/*************************************************************/
	function show(){
		$campos=Retefuente::obtenerPagina();
		require_once 'vistas/retefuente/todos.php';
	}
}
