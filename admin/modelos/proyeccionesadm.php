<?php
/**
 * CLASE PARA TRABAJAR CON LOS GASTOS
 */
class Proyeccionesadm
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
            $sql    = "SELECT DISTINCT(subrubro_id_subrubro),rubro_id_rubro FROM proyeccion_adm WHERE obra_id_obra='" . $id . "' and proyeccion_publicado='1'";
            $select = $db->query($sql);
            //echo ($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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

            $select  = $db->query("SELECT * FROM proyeccion_adm WHERE id_proyeccionadm='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
            $select = $db->query("DELETE FROM  proyeccion_adm  WHERE obra_id_obra='" . $id_obra . "' and rango_id_rango='".$idrango."' and subrubro_id_subrubro='".$equipolme."'");
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
            $select = $db->query("DELETE FROM  proyeccion_adm  WHERE obra_id_obra='" . $id_obra . "' and subrubro_id_subrubro='".$equipolme."'");
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
            $update = $db->prepare('UPDATE proyeccion_adm SET
                                cantidad_adm=:cantidad_adm,
                                valor_unitario_adm=:valor_unitario_adm,
                                valor_total_adm=:valor_total_adm
                                WHERE id_proyeccionadm=:id_proyeccionadm');

            $update->bindValue('cantidad_adm', utf8_encode($cantidad_adm));
            $update->bindValue('valor_unitario_adm', utf8_encode($valor_unitario_adm));
            $update->bindValue('valor_total_adm', utf8_encode($valor_total_adm));
            $update->bindValue('id_proyeccionadm', utf8_encode($id));
            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar($obra_id_obra,$rubro_id_rubro,$subrubro_id_subrubro,$rangoseleccionado,$cantidad_adm,$valornumero,$valor_total_adm,$creado_por,$estado_proyeccion,$proyeccion_publicado,$marca_temporal)
    {
        try {
            $db            = Db::getConnect();
            
            $insert = $db->prepare('INSERT INTO proyeccion_adm VALUES (NULL,
                                :obra_id_obra,
                                :rubro_id_rubro,
                                :subrubro_id_subrubro,
                                :rango_id_rango,
                                :cantidad_adm,
                                :valor_unitario_adm,
                                :valor_total_adm,
                                :creado_por,
                                :estado_proyeccion,
                                :proyeccion_publicado,
                                :marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('rubro_id_rubro', utf8_encode($rubro_id_rubro));
            $insert->bindValue('subrubro_id_subrubro', utf8_encode($subrubro_id_subrubro));
            $insert->bindValue('rango_id_rango', utf8_encode($rangoseleccionado));
            $insert->bindValue('cantidad_adm', utf8_encode($cantidad_adm));
            $insert->bindValue('valor_unitario_adm', utf8_encode($valornumero));
            $insert->bindValue('valor_total_adm', utf8_encode($valor_total_adm));
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
    public static function validapor($rubro_id_rubro,$subrubro_id_subrubro, $obra_id,$rangoseleccionado)
    {
        try {
            $db = Db::getConnect();

            $select = $db->query("SELECT count(id_proyeccionadm) as totales FROM proyeccion_adm
where obra_id_obra ='" . $obra_id . "' and rubro_id_rubro='" . $rubro_id_rubro . "' and subrubro_id_subrubro='".$subrubro_id_subrubro."' and rango_id_rango='".$rangoseleccionado."' and proyeccion_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
    $select        = $db->query("SELECT * FROM proyeccion_adm WHERE proyeccion_publicado='1'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccionesadm('', $campos);
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
            $select        = $db->query("SELECT * FROM proyeccion_adm WHERE obra_id_obra='" . $id . "'");
            $campos        = $select->fetchAll();
            $camposs       = new Proyeccionesadm('', $campos);
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
        $sql="SELECT cantidad_adm as totales FROM proyeccion_adm  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and subrubro_id_subrubro='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
        $sql="SELECT valor_unitario_adm as totales FROM proyeccion_adm  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and subrubro_id_subrubro='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
        $sql="SELECT valor_total_adm as totales FROM proyeccion_adm  WHERE obra_id_obra='".$obraid."' and rango_id_rango='".$rangoid."' and subrubro_id_subrubro='".$equipoid."' and  proyeccion_publicado='1'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
        $sql="SELECT IFNULL(SUM(valor_total_adm),0) as totales FROM proyeccion_adm  WHERE obra_id_obra='".$id."' and proyeccion_publicado='1' and rango_id_rango='".$rango."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


     public static function sqlvalorgastoporrubro($id,$fecha_1,$fecha_2,$rubroppal)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_total),0) as totales FROM ordenescompra  WHERE obra_id_obra='".$id."' and estado_orden='1' and fecha_reporte>='".$fecha_1."' and fecha_reporte<='".$fecha_2."' and compra_de='cxp' and rubro_id='".$rubroppal."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    
 public static function sqlvalorinventario($id,$fecha_1,$fecha_2,$rubroppal)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_salida),0) as totales FROM salidas_ins  WHERE obra_id_obra='".$id."' and fecha_reporte>='".$fecha_1."' and fecha_reporte<='".$fecha_2."' and id_rubro='".$rubroppal."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['totales'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }




     public static function sqlvalorgastosagregados($id,$fecha_1,$fecha_2,$rubroppal,$subrubro)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_total),0) as totales FROM ordenescompra  WHERE obra_id_obra='".$id."' and estado_orden='1' and fecha_reporte>='".$fecha_1."' and fecha_reporte<='".$fecha_2."' and compra_de='cxp' and rubro_id='".$rubroppal."' and subrubro_id='".$subrubro."'";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Proyeccionesadm('', $camposs);
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
