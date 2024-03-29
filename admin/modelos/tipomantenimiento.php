<?php
/**
* CLASE PARA TRABAJAR CON LAS MARCAS
*/

class TipoMantenimiento
{
    private $id;
    private $campos; //devuelve todos los campos de la tabla


	function __construct($id,$campos)
	{
        $this->setId($id);
        $this->setCampos($campos);
	}

	/************************************************************************************
	** FUNCIONES PARA ESTABLECER Y OBTENER LAS VARIABLES DE LA TABLA       ***
	/***********************************************************************************/

	//ESTABLECER Y OBTENER ID
	public function getId(){
		return $this->id;
	}
	public function setId($id){ //Establece el nuevo valor del campo
		$this->id = $id;
	}

	//ESTABLECER Y OBTENER LOS CAMPOS
	public function getCampos(){
		return $this->campos;
	}
	public function setCampos($campos){ //Establece el nuevo valor del campo
		$this->campos = $campos;
	}


/*******************************************************
** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS	  **
********************************************************/
public static function obtenerPagina(){
	try {
		$db=Db::getConnect();

		$select=$db->query("SELECT * FROM tipomantenimiento");
    	$camposs=$select->fetchAll();
    	$campos = new TipoMantenimiento('',$camposs);
		return $campos;
	}
	catch(PDOException $e) {
		echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
	}
}

/*******************************************************
** FUNCION PARA VALIDAR UN REGISTRO DUPLICADO **
********************************************************/
public static function validacionpor($nombre_tipomantenimiento){
	try {
		$db=Db::getConnect();

		$select=$db->query("SELECT COUNT(nombre_tipomantenimiento) AS total FROM tipomantenimiento WHERE nombre_tipomantenimiento='".$nombre_tipomantenimiento."'");
    	$camposs=$select->fetchAll();
    	$campos = new TipoMantenimiento('',$camposs);
    	$marcas = $campos->getCampos();
		foreach($marcas as $marca){
			$mar = $marca['total'];
		}
		return $mar;
	}
	catch(PDOException $e) {
		echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
	}
}

/***************************************************************
** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FILTRADOS POR ID  **
***************************************************************/
public static function obtenerPaginaPor($id){
	try {
		$db=Db::getConnect();
		$select=$db->query("SELECT * FROM tipomantenimiento WHERE id_tipomantenimiento='".$id."'");
		$camposs=$select->fetchAll();
		$campos = new TipoMantenimiento('',$camposs);
		return $campos;
	}
	catch(PDOException $e) {
		echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
	}
}


/***************************************************************
** FUNCION PARA ELIINAR POR ID  **
***************************************************************/
public static function eliminarPor($id){
	try {
		$db=Db::getConnect();
		$select=$db->query("DELETE FROM tipomantenimiento WHERE id_tipomantenimiento='".$id."'");
		if ($select){
			return true;
			}else{return false;}
	}
	catch(PDOException $e) {
		echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
	}
}


/********************************************************************
*** FUNCION PARA MODIFICAR ****
********************************************************************/
public static function actualizar($id,$campos){
	try {
		$db=Db::getConnect();
		$campostraidos = $campos->getCampos();
		extract($campostraidos);

		$update=$db->prepare('UPDATE tipomantenimiento SET
								nombre_tipomantenimiento=:nombre_tipomantenimiento,
								tipo_tipomantenimiento=:tipo_tipomantenimiento,
								frecuencia_tipomantenimiento=:frecuencia_tipomantenimiento								
								WHERE id_tipomantenimiento=:id_tipomantenimiento');

		$update->bindValue('tipo_tipomantenimiento',$tipo_tipomantenimiento);
		$update->bindValue('frecuencia_tipomantenimiento',$frecuencia_tipomantenimiento);		
		$update->bindValue('nombre_tipomantenimiento',$nombre_tipomantenimiento);
		$update->bindValue('id_tipomantenimiento',$id);
		$update->execute();
		return true;
	}
	catch(PDOException $e) {
		echo '{"error al guardar la configuración ":{"text":'. $e->getMessage() .'}}';
	}
}

/***************************************************************
*** FUNCION PARA GUARDAR **
***************************************************************/
public static function guardar($campos){
	try {
		$db=Db::getConnect();
		$campostraidos = $campos->getCampos();
		extract($campostraidos);

		$insert=$db->prepare('INSERT INTO tipomantenimiento VALUES (NULL,:nombre_tipomantenimiento, :tipo_tipomantenimiento, :frecuencia_tipomantenimiento)');

		$insert->bindValue('tipo_tipomantenimiento',$tipo_tipomantenimiento);
		$insert->bindValue('frecuencia_tipomantenimiento',$frecuencia_tipomantenimiento);		
		$insert->bindValue('nombre_tipomantenimiento',$nombre_tipomantenimiento);
		$insert->execute();

		return true;
	}
	catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

}

?>
