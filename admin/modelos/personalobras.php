<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Personalobras
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
    public static function obtenerPaginapornomina($id)
    {
        try {
            $db = Db::getConnect();
            $sql = "SELECT * FROM personal_obras WHERE obra_id_obra='" . $id . "' and personal_publicado='1' and usuario_id_usuario<>'0' order by id_personal DESC";
            $select  = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Personalobras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS      **
 ********************************************************/
    public static function obtenerPaginaporextra($id)
    {
        try {
            $db = Db::getConnect();
            $sql = "SELECT * FROM personal_obras WHERE obra_id_obra='" . $id . "' and personal_publicado='1' and extra_id_extra<>'0' order by id_personal DESC";
            $select  = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Personalobras('', $camposs);
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
            $select = $db->query("DELETE FROM personal_obras WHERE id_personal='" . $id . "'");
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

            $insert = $db->prepare('INSERT INTO personal_obras VALUES (NULL,
            					:usuario_id_usuario,
								:extra_id_extra,
								:obra_id_obra,
                                :frente_id_frente,
								:creado_por,
                                :personal_publicado,
								:estado_personal,
								:marca_temporal)');
            $insert->bindValue('usuario_id_usuario', utf8_encode($usuario_id_usuario));
            $insert->bindValue('extra_id_extra', utf8_encode($extra_id_extra));
            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('frente_id_frente', utf8_encode($frente_id_frente));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('personal_publicado', utf8_encode($personal_publicado));
            $insert->bindValue('estado_personal', utf8_encode($estado_personal));
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

		$select=$db->query("SELECT count(id_personal) as totales FROM personal_obras
where obra_id_obra ='".$id."' and personal_publicado='1'");
    	$camposs=$select->fetchAll();
    	$campos = new Personalobras('',$camposs);
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

    

}
