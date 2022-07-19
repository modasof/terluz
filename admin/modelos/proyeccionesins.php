<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Proyeccionesins
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
            $sql    = "SELECT DISTINCT(insumo_id_insumo) FROM proyeccion_ins WHERE obra_id_obra='" . $id . "' and proyeccion_publicado='1'";
            $select = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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

            $select  = $db->query("SELECT * FROM proyeccion_ins WHERE id_proyeccionins='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
** FUNCION PARA OBTENER LA LISTA DE CLIENTES      **
********************************************************/
public static function obtenerinsObra($id){
    try {
        $db=Db::getConnect();
        $sql="SELECT DISTINCT(insumo_id_insumo) as insumo_id_insumo FROM proyeccion_ins WHERE obra_id_obra='" . $id . "'";
        $select=$db->query($sql);
        $campos=$select->fetchAll();
        $camposs = new Proyeccionesins('',$campos);
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
            $select = $db->query("DELETE FROM  proyeccion_ins  WHERE obra_id_obra='" . $id_obra . "' and rango_id_rango='".$idrango."' and insumo_id_insumo='".$equipolme."'");
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
            $select = $db->query("DELETE FROM  proyeccion_ins  WHERE obra_id_obra='" . $id_obra . "' and insumo_id_insumo='".$equipolme."'");
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
            $update = $db->prepare('UPDATE proyeccion_ins SET
                                cantidad_ins=:cantidad_ins,
                                valor_unitario_ins=:valor_unitario_ins,
                                valor_total_ins=:valor_total_ins
                                WHERE id_proyeccionins=:id_proyeccionins');

            $update->bindValue('cantidad_ins', utf8_encode($cantidad_ins));
            $update->bindValue('valor_unitario_ins', utf8_encode($valor_unitario_ins));
            $update->bindValue('valor_total_ins', utf8_encode($valor_total_ins));
            $update->bindValue('id_proyeccionins', utf8_encode($id));
            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar($obra_id_obra,$insumo_id_insumo,$rangoseleccionado,$cantidad_ins,$valornumero,$valor_total_ins,$creado_por,$estado_proyeccion,$proyeccion_publicado,$marca_temporal)
    {
        try {
            $db            = Db::getConnect();
            
            $insert = $db->prepare('INSERT INTO proyeccion_ins VALUES (NULL,
                                :obra_id_obra,
                                :insumo_id_insumo,
                                :rango_id_rango,
                                :cantidad_ins,
                                :valor_unitario_ins,
                                :valor_total_ins,
                                :creado_por,
                                :estado_proyeccion,
                                :proyeccion_publicado,
                                :marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('insumo_id_insumo', utf8_encode($insumo_id_insumo));
            $insert->bindValue('rango_id_rango', utf8_encode($rangoseleccionado));
            $insert->bindValue('cantidad_ins', utf8_encode($cantidad_ins));
            $insert->bindValue('valor_unitario_ins', utf8_encode($valornumero));
            $insert->bindValue('valor_total_ins', utf8_encode($valor_total_ins));
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
    public static function validapor($insumo_id_insumo, $obra_id,$rangoseleccionado)
    {
        try {
            $db = Db::getConnect();

            $select = $db->query("SELECT count(id_proyeccionins) as totales FROM proyeccion_ins
where obra_id_obra ='" . $obra_id . "' and insumo_id_insumo='" . $insumo_id_insumo . "' and rango_id_rango='".$rangoseleccionado."' and proyeccion_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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
            $select        = $db->query("SELECT * FROM proyeccion_ins WHERE proyeccion_publicado='1'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccionesins('', $campos);
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
            $select        = $db->query("SELECT * FROM proyeccion_ins WHERE obra_id_obra='" . $id . "'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccionesins('', $campos);
            $campostraidos = $camposs->getCampos();
            return $campostraidos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

 public static function sqlcantidadestotales($obraid,$equipoid)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(sum(cantidad_ins),0) as totales  FROM proyeccion_ins  WHERE obra_id_obra='".$obraid."' and insumo_id_insumo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


 public static function sqlcantidades($obraid,$rangoid,$equipoid)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT cantidad_ins as totales FROM proyeccion_ins  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and insumo_id_insumo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }



public static function sqlcantidadesreportadas($obraid,$fechainicio,$fechafin,$insumo_id_insumo)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(cantidad),0) as totales FROM reporte_agregados WHERE obra_id_obra='".$obraid."' and fecha_reporte>='".$fechainicio."' and fecha_reporte<='".$fechafin."' and insumo_id_insumo='".$insumo_id_insumo."' and  reporte_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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
        $sql="SELECT valor_unitario_ins as totales FROM proyeccion_ins  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and insumo_id_insumo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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
        $sql="SELECT valor_total_ins as totales FROM proyeccion_ins  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and insumo_id_insumo='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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
        $sql="SELECT IFNULL(SUM(valor_total_ins),0) as totales FROM proyeccion_ins  WHERE obra_id_obra='".$id."' and proyeccion_publicado='1' and rango_id_rango='".$rango."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesins('', $camposs);
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
