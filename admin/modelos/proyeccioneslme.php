<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Proyeccioneslme
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
            $sql    = "SELECT DISTINCT(lme_id_lme) FROM proyeccion_lme WHERE obra_id_obra='" . $id . "' and proyeccion_publicado='1'";
            $select = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FECHAS    **
********************************************************/
public static function cxpfechaobra($id,$fechainicio,$fechafin,$rubro){
    try {
        $db=Db::getConnect();
        $sql="SELECT * FROM ordenescompra WHERE estado_orden<>'0' and id_factura_compra='0' and compra_de='Cxp' and obra_id_obra='".$id."' and fecha_reporte>='".$fechainicio."' and fecha_reporte<='".$fechafin."' and rubro_id='".$rubro."'";
        //echo($sql);
        $select=$db->query($sql);
        $camposs=$select->fetchAll();
        $campos = new Proyeccioneslme('',$camposs);
        return $campos;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE TESTIMONIOS      **
 ********************************************************/
    public static function obtenerPaginaPor($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM proyeccion_lme WHERE id_proyeccionlme='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
** FUNCION PARA OBTENER LA LISTA DE CLIENTES      **
********************************************************/
public static function obtenerlmeObra($id){
    try {
        $db=Db::getConnect();
        $sql="SELECT DISTINCT(lme_id_lme) as lme_id_lme FROM proyeccion_lme WHERE obra_id_obra='" . $id . "'";
        $select=$db->query($sql);
        $campos=$select->fetchAll();
        $camposs = new Proyeccioneslme('',$campos);
        $campostraidos = $camposs->getCampos();
        return $campostraidos;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminarPor($id_obra,$idrango,$equipolme)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM  proyeccion_lme  WHERE obra_id_obra='" . $id_obra . "' and rango_id_rango='".$idrango."' and lme_id_lme='".$equipolme."'");
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
            $select = $db->query("DELETE FROM  proyeccion_lme  WHERE obra_id_obra='" . $id_obra . "' and lme_id_lme='".$equipolme."'");
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
            $update = $db->prepare('UPDATE proyeccion_lme SET
                                cantidad_lme=:cantidad_lme,
                                valor_unitario_lme=:valor_unitario_lme,
                                valor_total_lme=:valor_total_lme
                                WHERE id_proyeccionlme=:id_proyeccionlme');

            $update->bindValue('cantidad_lme', utf8_encode($cantidad_lme));
            $update->bindValue('valor_unitario_lme', utf8_encode($valor_unitario_lme));
            $update->bindValue('valor_total_lme', utf8_encode($valor_total_lme));
            $update->bindValue('id_proyeccionlme', utf8_encode($id));
            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar($obra_id_obra,$lme_id_lme,$rangoseleccionado,$cantidad_lme,$valornumero,$valor_total_lme,$creado_por,$estado_proyeccion,$proyeccion_publicado,$marca_temporal)
    {
        try {
            $db            = Db::getConnect();
            
            $insert = $db->prepare('INSERT INTO proyeccion_lme VALUES (NULL,
                                :obra_id_obra,
                                :lme_id_lme,
                                :rango_id_rango,
                                :cantidad_lme,
                                :valor_unitario_lme,
                                :valor_total_lme,
                                :creado_por,
                                :estado_proyeccion,
                                :proyeccion_publicado,
                                :marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('lme_id_lme', utf8_encode($lme_id_lme));
            $insert->bindValue('rango_id_rango', utf8_encode($rangoseleccionado));
            $insert->bindValue('cantidad_lme', utf8_encode($cantidad_lme));
            $insert->bindValue('valor_unitario_lme', utf8_encode($valornumero));
            $insert->bindValue('valor_total_lme', utf8_encode($valor_total_lme));
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
    public static function validapor($lme_id_lme, $obra_id,$rangoseleccionado)
    {
        try {
            $db = Db::getConnect();

            $select = $db->query("SELECT count(id_proyeccionlme) as totales FROM proyeccion_lme
where obra_id_obra ='" . $obra_id . "' and lme_id_lme='" . $lme_id_lme . "' and rango_id_rango='".$rangoseleccionado."' and proyeccion_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
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
            $select        = $db->query("SELECT * FROM proyeccion_lme WHERE proyeccion_publicado='1'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccioneslme('', $campos);
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
            $select        = $db->query("SELECT * FROM proyeccion_lme WHERE obra_id_obra='" . $id . "'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccioneslme('', $campos);
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
        $sql="SELECT cantidad_lme as totales FROM proyeccion_lme  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lme_id_lme='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

public static function sqlcantidadesreportadas($obraid,$fechainicio,$fechafin,$lme_id_lme)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(hora_inactiva),0) as totales FROM reporte_horasmq  WHERE obra_id_obra='".$obraid."' and fecha_reporte>='".$fechainicio."' and fecha_reporte<='".$fechafin."' and equipo_id_equipo='".$lme_id_lme."' and  reporte_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
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
        $sql="SELECT valor_unitario_lme as totales FROM proyeccion_lme  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lme_id_lme='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
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
        $sql="SELECT valor_total_lme as totales FROM proyeccion_lme  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and lme_id_lme='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccioneslme('', $camposs);
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
        $sql="SELECT IFNULL(SUM(valor_total_lme),0) as totales FROM proyeccion_lme  WHERE obra_id_obra='".$id."' and proyeccion_publicado='1' and rango_id_rango='".$rango."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
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
