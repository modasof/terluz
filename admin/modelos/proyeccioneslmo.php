<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Proyeccioneslmo
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
            $db     = Db::getConnect();
            $sql    = "SELECT DISTINCT(lmo_id_lmo) FROM proyeccion_lmo WHERE obra_id_obra='" . $id . "' and proyeccion_publicado='1'";
            $select = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
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

            $select  = $db->query("SELECT * FROM proyeccion_lmo WHERE id_proyeccionlmo='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminarPor($id_obra,$idrango,$equipolme)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM  proyeccion_lmo  WHERE obra_id_obra='" . $id_obra . "' and rango_id_rango='".$idrango."' and lmo_id_lmo='".$equipolme."'");
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
    public static function eliminarequipoPor($id_obra,$equipolme)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM  proyeccion_lmo  WHERE obra_id_obra='" . $id_obra . "' and lmo_id_lmo='".$equipolme."'");
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
            $update = $db->prepare('UPDATE proyeccion_lmo SET
                                cantidad_lmo=:cantidad_lmo,
                                valor_unitario_lmo=:valor_unitario_lmo,
                                valor_total_lmo=:valor_total_lmo
                                WHERE id_proyeccionlmo=:id_proyeccionlmo');

            $update->bindValue('cantidad_lmo', utf8_encode($cantidad_lmo));
            $update->bindValue('valor_unitario_lmo', utf8_encode($valor_unitario_lmo));
            $update->bindValue('valor_total_lmo', utf8_encode($valor_total_lmo));
            $update->bindValue('id_proyeccionlmo', utf8_encode($id));
            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar($obra_id_obra,$lmo_id_lmo,$rangoseleccionado,$cantidad_lmo,$valornumero,$valor_total_lmo,$creado_por,$estado_proyeccion,$proyeccion_publicado,$marca_temporal)
    {
        try {
            $db            = Db::getConnect();
            
            $insert = $db->prepare('INSERT INTO proyeccion_lmo VALUES (NULL,
                                :obra_id_obra,
                                :lmo_id_lmo,
                                :rango_id_rango,
                                :cantidad_lmo,
                                :valor_unitario_lmo,
                                :valor_total_lmo,
                                :creado_por,
                                :estado_proyeccion,
                                :proyeccion_publicado,
                                :marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('lmo_id_lmo', utf8_encode($lmo_id_lmo));
            $insert->bindValue('rango_id_rango', utf8_encode($rangoseleccionado));
            $insert->bindValue('cantidad_lmo', utf8_encode($cantidad_lmo));
            $insert->bindValue('valor_unitario_lmo', utf8_encode($valornumero));
            $insert->bindValue('valor_total_lmo', utf8_encode($valor_total_lmo));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_proyeccion', utf8_encode($estado_proyeccion));
            $insert->bindValue('proyeccion_publicado', utf8_encode($proyeccion_publicado));
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
    public static function validapor($lmo_id_lmo, $obra_id,$rangoseleccionado)
    {
        try {
            $db = Db::getConnect();

            $select = $db->query("SELECT count(id_proyeccionlmo) as totales FROM proyeccion_lmo
where obra_id_obra ='" . $obra_id . "' and lmo_id_lmo='" . $lmo_id_lmo . "' and rango_id_rango='".$rangoseleccionado."' and proyeccion_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA OBTENER LA LISTA DE EQUIPOS EN LA ASF     **
 ********************************************************/
    public static function obtenerLista()
    {
        try {
    $db            = Db::getConnect();
    $select        = $db->query("SELECT * FROM proyeccion_lmo WHERE proyeccion_publicado='1'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccioneslmo('', $campos);
            $campostraidos = $camposs->getCampos();
            return $campostraidos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA OBTENER LA LISTA DE EQUIPOS EN LA ASF     **
 ********************************************************/
    public static function ListaProyeccionObras($id)
    {
        try {
            $db            = Db::getConnect();
            $select        = $db->query("SELECT * FROM proyeccion_lmo WHERE obra_id_obra='" . $id . "'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccioneslmo('', $campos);
            $campostraidos = $camposs->getCampos();
            return $campostraidos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


 public static function sqlcantidades($obraid,$rangoid,$equipoid)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT cantidad_lmo as totales FROM proyeccion_lmo  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lmo_id_lmo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

public static function sqlvalorunitario($obraid,$rangoid,$equipoid)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT valor_unitario_lmo as totales FROM proyeccion_lmo  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lmo_id_lmo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

public static function sqlvalortotal($obraid,$rangoid,$equipoid)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT valor_total_lmo as totales FROM proyeccion_lmo  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lmo_id_lmo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

     public static function sqlvalorrangoequiposporobra($id,$rango)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_total_lmo),0) as totales FROM proyeccion_lmo  WHERE obra_id_obra='".$id."' and proyeccion_publicado='1' and rango_id_rango='".$rango."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslmo('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }



}
