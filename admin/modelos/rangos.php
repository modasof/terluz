<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Rangos
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
    public static function obtenerPagina($id)
    {
        try {
            $db = Db::getConnect();
            $sql = "SELECT * FROM rangos_obra WHERE obra_id_obra='" . $id . "' and rango_publicado='1' order by mes_numero ASC";
            $select  = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Rangos('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS      **
 ********************************************************/
    public static function obtenerRangosporfecha($id,$fecha_1,$fecha_2)
    {
        try {
            $db = Db::getConnect();
            $sql = "SELECT * FROM rangos_obra WHERE obra_id_obra='" . $id . "' and rango_publicado='1' and fecha_inicio>='".$fecha_1."' and fecha_inicio<='".$fecha_2."' and fecha_fin>='".$fecha_1."' and fecha_fin<='".$fecha_2."' order by mes_numero ASC";
            $select  = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Rangos('', $camposs);
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

            $select  = $db->query("SELECT * FROM rangos_obra WHERE id='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Rangos('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminardatalmePor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM proyeccion_lme WHERE rango_id_rango='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminardatainsPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM proyeccion_ins WHERE rango_id_rango='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminardatalmoPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM proyeccion_lmo WHERE rango_id_rango='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminardataadmPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM proyeccion_adm WHERE rango_id_rango='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
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
            $select = $db->query("DELETE FROM rangos_obra WHERE id='" . $id . "'");
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
            $update = $db->prepare('UPDATE rangos_obra SET
                                fecha_inicio=:fecha_inicio,
                                fecha_fin=:fecha_fin
								WHERE id=:id');
            $update->bindValue('fecha_inicio', utf8_encode($fecha_inicio));
            $update->bindValue('fecha_fin', utf8_encode($fecha_fin));
            $update->bindValue('id', utf8_encode($id));
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

            $insert = $db->prepare('INSERT INTO rangos_obra VALUES (NULL,
            					:mes_numero,
								:obra_id_obra,
								:fecha_inicio,
								:fecha_fin,
                                :creado_por,
								:rango_publicado,
                                :estado_rango,
								:marca_temporal)');

            $insert->bindValue('mes_numero', utf8_encode($mes_numero));
            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('fecha_inicio', utf8_encode($fecha_inicio));
            $insert->bindValue('fecha_fin', utf8_encode($fecha_fin));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('rango_publicado', utf8_encode($rango_publicado));
            $insert->bindValue('estado_rango', utf8_encode($estado_rango));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));

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

		$select=$db->query("SELECT count(id) as totales FROM rangos_obra
where obra_id_obra ='".$id."' and rango_publicado='1'");
    	$camposs=$select->fetchAll();
    	$campos = new Rangos('',$camposs);
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
public static function validapor($mes_numero,$obra_id){
    try {
        $db=Db::getConnect();

        $select=$db->query("SELECT count(id) as totales FROM rangos_obra
where obra_id_obra ='".$obra_id."' and mes_numero='".$mes_numero."' and rango_publicado='1'");
        $camposs=$select->fetchAll();
        $campos = new Rangos('',$camposs);
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
public static function obtenerLista(){
    try {
        $db=Db::getConnect();
        $select=$db->query("SELECT * FROM rangos_obra WHERE rango_publicado='1' order by mes_numero");
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
public static function ListaRangoObras($id){
    try {
        $db=Db::getConnect();
        $select=$db->query("SELECT * FROM rangos_obra WHERE obra_id_obra='" . $id . "'");
        $campos=$select->fetchAll();
        $camposs = new Rangos('',$campos);
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

        $select=$db->query("SELECT mes_numero FROM rangos_obra WHERE id='".$id."'");
        $camposs=$select->fetchAll();
        $campos = new Rangos('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['mes_numero'];
        }
        return $mar;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}





    

}
