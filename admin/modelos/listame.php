<?php
/**
 * CLASE PARA TRABAJAR CON EL LISTADO DE MÁQUINARIA Y EQUIPOS
 */
class Listame
{
    private $id;
    private $campos; //devuelve todos los campos de la tabla

    public function __construct($id, $campos)
    {
        $this->setId($id);
        $this->setCampos($campos);
    }
    /************************************************************************************
     ** FUNCIONES PARA ESTABLECER Y OBTENER LAS VARIABLES DE LA TABLA       ***
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
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FECHAS      **
 ********************************************************/
    public static function obtenerPagina()
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM lista_me WHERE reporte_publicado='1' order by nombre_lme DESC");
            $camposs = $select->fetchAll();
            $campos  = new Listame('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
id, fecha_reporte, cliente_id_cliente, producto_id_producto, valor_m3, cantidad, creado_por, estado_reporte, reporte_publicado, marca_temporal, observaciones
 ***************************************************************/
    public static function guardar($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO lista_me VALUES (NULL,:nombre_lme,:unidad_id_unidad,:fecha_reporte,:valor_unitario,:reporte_publicado,:marca_temporal,:estado_reporte,:creado_por)');

            $V1          = str_replace(".", "", $valor_unitario);
            $V2          = str_replace(" ", "", $V1);
            $valor_final = str_replace("$", "", $V2);
            $valornumero = (int) $valor_final;

            $insert->bindValue('nombre_lme', utf8_encode($nombre_lme));
            $insert->bindValue('unidad_id_unidad', utf8_encode($unidad_id_unidad));
            $insert->bindValue('fecha_reporte', utf8_encode($fecha_reporte));
            $insert->bindValue('valor_unitario', utf8_encode($valornumero));
            $insert->bindValue('reporte_publicado', utf8_encode($reporte_publicado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('estado_reporte', utf8_encode($estado_reporte));
            $insert->bindValue('creado_por', utf8_encode($creado_por));

            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminarPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("UPDATE lista_me SET reporte_publicado='0' WHERE id_lme='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FILTRADOS POR ID  **
 ***************************************************************/
    public static function obtenerPaginaPor($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM lista_me WHERE id_lme='" . $id . "' and estado_reporte='1'");
            $camposs = $select->fetchAll();
            $campos  = new Listame('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA MODIFICAR REPORTE DE EQUIPO ****
 ********************************************************************/
    public static function actualizar($id, $campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE lista_me SET
								nombre_lme=:nombre_lme,
								unidad_id_unidad=:unidad_id_unidad,
								fecha_reporte=:fecha_reporte,
								valor_unitario=:valor_unitario,
								reporte_publicado=:reporte_publicado,
								marca_temporal=:marca_temporal,
								estado_reporte=:estado_reporte,
								creado_por=:creado_por
								WHERE id_lme=:id_lme');

            $V1          = str_replace(".", "", $valor_unitario);
            $V2          = str_replace(" ", "", $V1);
            $valor_final = str_replace("$", "", $V2);
            $valornumero = (int) $valor_final;

            $update->bindValue('nombre_lme', utf8_encode($nombre_lme));
            $update->bindValue('unidad_id_unidad', utf8_encode($unidad_id_unidad));
            $update->bindValue('fecha_reporte', utf8_encode($fecha_reporte));
            $update->bindValue('valor_unitario', utf8_encode($valornumero));
            $update->bindValue('reporte_publicado', utf8_encode($reporte_publicado));
            $update->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $update->bindValue('estado_reporte', utf8_encode($estado_reporte));
            $update->bindValue('creado_por', utf8_encode($creado_por));
            $update->bindValue('id_lme', utf8_encode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }


    /*******************************************************
** FUNCION PARA MOSTRAR EL NOMBRE DEL PRODUCTO **
********************************************************/
public static function validacionduplicado($nombre_lme,$unidad){
	try {
		$db=Db::getConnect();

		$select=$db->query("SELECT count(nombre_lme) as totales FROM lista_me WHERE nombre_lme='".$nombre_lme."' and unidad_id_unidad='".$unidad."'");
    	$camposs=$select->fetchAll();
    	$campos = new Listame('',$camposs);
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
        $select=$db->query("SELECT * FROM lista_me WHERE reporte_publicado='1' order by nombre_lme");
        $campos=$select->fetchAll();
        $camposs = new Listame('',$campos);
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

        $select=$db->query("SELECT nombre_lme FROM lista_me WHERE id_lme='".$id."'");
        $camposs=$select->fetchAll();
        $campos = new Listame('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['nombre_lme'];
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
public static function obtenerUnidadmedida($id){
    try {
        $db=Db::getConnect();

        $select=$db->query("SELECT unidad_id_unidad FROM lista_me WHERE id_lme='".$id."'");
        $camposs=$select->fetchAll();
        $campos = new Listame('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['unidad_id_unidad'];
        }
        return $mar;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}


}
