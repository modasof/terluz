<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Frentes
{
    private $id;
    private $campos; //devuelve todos los campos de la tabla

    public function __construct($id, $campos)
    {
        $this->setId($id);
        $this->setCampos($campos);
    }

    /************************************************************************************
     ** FUNCIONES PARA ESTABLECER Y OBTENER LAS VARIABLES DE LA TABLA GASTOS       ***
    /***********************************************************************************/

    //ESTABLECER Y OBTENER ID
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        //Establece el nuevo valor del campo
        $this->id = $id;
    }

    //ESTABLECER Y OBTENER LOS CAMPOS
    public function getCampos()
    {
        return $this->campos;
    }
    public function setCampos($campos)
    {
        //Establece el nuevo valor del campo
        $this->campos = $campos;
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS      **
 ********************************************************/
    public static function obtenerPaginafrentes($id)
    {
        try {
            $db = Db::getConnect();
            $sql = "SELECT * FROM frentes WHERE obra_id_obra='" . $id . "' and frente_publicado='1' order by id_frente DESC";
            $select  = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Frentes('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS      **
 ********************************************************/
    public static function obtenerPaginaPor($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM frentes WHERE id_frente='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Frentes('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminarPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("UPDATE frentes SET frente_publicado='0' WHERE id_frente='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA MODIFICAR ****
 ********************************************************************/
    public static function actualizar($id, $campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);
            $update = $db->prepare('UPDATE frentes SET
								nombre_frente=:nombre_frente,
                                observaciones=:observaciones
								WHERE id_frente=:id_frente');
            $update->bindValue('nombre_frente', utf8_encode($nombre_frente));
            $update->bindValue('observaciones', utf8_encode($observaciones));
            $update->bindValue('id_frente', utf8_encode($id));
            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO frentes VALUES (NULL,
            					:obra_id_obra,
								:nombre_frente,
								:creado_por,
								:estado_frente,
                                :frente_publicado,
								:marca_temporal,
								:observaciones)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('nombre_frente', utf8_encode($nombre_frente));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_frente', utf8_encode($estado_frente));
            $insert->bindValue('frente_publicado', utf8_encode($frente_publicado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('observaciones', utf8_encode($observaciones));

            $insert->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
** FUNCION PARA MOSTRAR EL NOMBRE DEL EQUIPO **
********************************************************/
public static function cantidadporobra($id){
	try {
		$db=Db::getConnect();

		$select=$db->query("SELECT count(id_frente) as totales FROM frentes
where obra_id_obra ='".$id."' and frente_publicado='1'");
    	$camposs=$select->fetchAll();
    	$campos = new Frentes('',$camposs);
    	$marcas = $campos->getCampos();
		foreach($marcas as $marca){
			$mar = $marca['totales'];
		}
		return $mar;
	}
	catch(PDOException $e) {
		echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
	}
}

/*******************************************************
** FUNCION PARA MOSTRAR EL NOMBRE DEL EQUIPO **
********************************************************/
public static function validapor($nombre,$obra_id){
    try {
        $db=Db::getConnect();

        $select=$db->query("SELECT count(id_frente) as totales FROM frentes
where obra_id_obra ='".$obra_id."' and nombre_frente='".$nombre."' and frente_publicado='1'");
        $camposs=$select->fetchAll();
        $campos = new Frentes('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['totales'];
        }
        return $mar;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}

/*******************************************************
** FUNCION PARA OBTENER LA LISTA DE EQUIPOS EN LA ASF     **
********************************************************/
public static function obtenerListaFrentes(){
    try {
        $db=Db::getConnect();
        $select=$db->query("SELECT * FROM frentes WHERE frente_publicado='1' order by nombre_frente");
        $campos=$select->fetchAll();
        $camposs = new Frentes('',$campos);
        $campostraidos = $camposs->getCampos();
        return $campostraidos;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}

/*******************************************************
** FUNCION PARA OBTENER LA LISTA DE EQUIPOS EN LA ASF     **
********************************************************/
public static function ListaFrentesObras($id){
    try {
        $db=Db::getConnect();
        $select=$db->query("SELECT * FROM frentes WHERE obra_id_obra='" . $id . "' and frente_publicado='1'");
        $campos=$select->fetchAll();
        $camposs = new Frentes('',$campos);
        $campostraidos = $camposs->getCampos();
        return $campostraidos;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}

/*******************************************************
** FUNCION PARA MOSTRAR EL NOMBRE DEL EQUIPO **
********************************************************/
public static function obtenerNombre($id){
    try {
        $db=Db::getConnect();

        $select=$db->query("SELECT nombre_frente FROM frentes WHERE id_frente='".$id."'");
        $camposs=$select->fetchAll();
        $campos = new Frentes('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['nombre_frente'];
        }
        return $mar;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}





    

}
