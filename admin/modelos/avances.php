<?php
/**
 * CLASE PARA TRABAJAR CON LAS MARCAS
 */
class Avances
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
    public static function Todospor_actividad($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM actividades_avance WHERE avance_publicado='1' and actividad_id_actividad='" . $id . "' order by fecha_reporte DESC");
            $camposs = $select->fetchAll();
            $campos  = new Avances('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    /***************************************************************
     ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FILTRADOS POR ID  **
     ***************************************************************/
    public static function listafrentesporactividad($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT DISTINCT(frente_id_frente) as frente_id FROM actividades_avance WHERE actividad_id_actividad='" . $id . "' and avance_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Avances('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR RANGO DE FECHA      **
 ********************************************************/
    public static function porfecha($FechaStart, $FechaEnd)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM reporte_horasmq WHERE reporte_publicado='1' and fecha_reporte >='" . $FechaStart . "' and fecha_reporte <='" . $FechaEnd . "' order by fecha_reporte DESC");
            $camposs = $select->fetchAll();
            $campos  = new Avances('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
id, fecha_reporte, cliente_id_cliente, producto_id_producto, valor_m3, cantidad, creado_por, estado_reporte, reporte_publicado, marca_temporal, observaciones
 ***************************************************************/
    public static function guardar($campos, $imagen)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO reporte_horasmq VALUES (NULL,:imagen,:fecha_reporte,:equipo_id_equipo,:despachado_por,:punto_despacho,:recibido_por,:valor_m3,:valor_hora_operador,:cantidad,:indicador,:hora_inactiva,:creado_por, :estado_reporte, :reporte_publicado,:marca_temporal, :observaciones,:obra_id_obra,:frente_id_frente,:cliente_id_cliente,:equipo_adicional,:nombre_equipo_adicional )');

            $V1          = str_replace(".", "", $valor_m3);
            $V2          = str_replace(" ", "", $V1);
            $valor_final = str_replace("$", "", $V2);
            $valornumero = (int) $valor_final;

            $V11          = str_replace(".", "", $valor_hora_operador);
            $V21          = str_replace(" ", "", $V11);
            $valor_final1 = str_replace("$", "", $V21);
            $valornumero1 = (int) $valor_final1;

            //if ($punto_despacho=="Comercializadora") {
            //    $valornumero=0;
            //}
            //elseif ($punto_despacho=="Cantera 1") {
            //    $valornumero=0;
            //}

            $t          = strtotime($fecha_reporte);
            $nuevafecha = date('y-m-d', $t);

            $insert->bindValue('fecha_reporte', utf8_decode($nuevafecha));
            $insert->bindValue('imagen', utf8_decode($imagen));
            $insert->bindValue('equipo_id_equipo', utf8_decode($equipo_id_equipo));
            $insert->bindValue('despachado_por', utf8_decode($despachado_por));
            $insert->bindValue('punto_despacho', utf8_decode($punto_despacho));
            $insert->bindValue('recibido_por', utf8_decode($recibido_por));
            $insert->bindValue('valor_m3', utf8_decode($valornumero));
            $insert->bindValue('valor_hora_operador', utf8_decode($valornumero1));
            $insert->bindValue('cantidad', utf8_decode($cantidad));
            $insert->bindValue('indicador', utf8_decode($indicador));
            $insert->bindValue('hora_inactiva', utf8_decode($hora_inactiva));
            $insert->bindValue('creado_por', utf8_decode($creado_por));
            $insert->bindValue('estado_reporte', utf8_decode($estado_reporte));
            $insert->bindValue('reporte_publicado', utf8_decode($reporte_publicado));
            $insert->bindValue('marca_temporal', utf8_decode($marca_temporal));
            $insert->bindValue('observaciones', utf8_decode($observaciones));
            $insert->bindValue('obra_id_obra', utf8_decode($obra_id_obra));
            $insert->bindValue('frente_id_frente', utf8_decode($frente_id_frente));
            $insert->bindValue('cliente_id_cliente', utf8_decode($cliente_id_cliente));
            $insert->bindValue('equipo_adicional', utf8_decode($equipo_adicional));
            $insert->bindValue('nombre_equipo_adicional', utf8_decode($nombre_equipo_adicional));
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
            $select = $db->query("DELETE FROM actividades_avance WHERE id_cantidades='" . $id . "'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    public static function editarPor($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM actividades_avance WHERE id_cantidades='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Avances('', $camposs);
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

            $update = $db->prepare('UPDATE actividades_avance SET
								obra_id_obra=:obra_id_obra,
								capitulo_id_capitulo=:capitulo_id_capitulo,
								actividad_id_actividad=:actividad_id_actividad,
								frente_id_frente=:frente_id_frente,
								localizacion=:localizacion,
								observaciones=:observaciones,
								fecha_reporte=:fecha_reporte,
								avance=:avance,
								acta_numero=:acta_numero,
								creado_por=:creado_por,
								estado_avance=:estado_avance,
								avance_publicado=:avance_publicado,
								marca_temporal=:marca_temporal
								WHERE id_cantidades=:id_cantidades');

           
            $update->bindValue('obra_id_obra', utf8_decode($obra_id_obra));
            $update->bindValue('capitulo_id_capitulo', utf8_decode($capitulo_id_capitulo));
            $update->bindValue('actividad_id_actividad', utf8_decode($actividad_id_actividad));
            $update->bindValue('frente_id_frente', utf8_decode($frente_id_frente));
            $update->bindValue('localizacion', utf8_decode($localizacion));
            $update->bindValue('observaciones', utf8_decode($observaciones));
            $update->bindValue('fecha_reporte', utf8_decode($fecha_reporte));
            $update->bindValue('avance', utf8_decode($avance));
            $update->bindValue('acta_numero', utf8_decode($acta_numero));
            $update->bindValue('creado_por', utf8_decode($creado_por));
            $update->bindValue('estado_avance', utf8_decode($estado_avance));
            $update->bindValue('avance_publicado', utf8_decode($avance_publicado));
            $update->bindValue('marca_temporal', utf8_decode($marca_temporal));
            $update->bindValue('id_cantidades', utf8_decode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
     ** FUNCION PARA MOSTRAR CANTIDADES MAYORES  **
     ********************************************************/
    public static function sqlavancesporactividadfrente($act, $frente)
    {
        try {
            $db     = Db::getConnect();
            $sql    = "SELECT IFNULL(SUM(avance),0) as totales FROM actividades_avance WHERE actividad_id_actividad='" . $act . "' and frente_id_frente='" . $frente . "' and avance_publicado='1'";
            $select = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Avances('', $camposs);
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
