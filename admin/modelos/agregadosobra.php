<?php
/**
 * CLASE PARA TRABAJAR CON LAS MARCAS
 */
class Agregadosobra
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
    public static function ReporteAgregados($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM reporte_agregados WHERE reporte_publicado='1' and fecha_reporte BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() and obra_id_obra='" . $id . "' order by fecha_reporte DESC");
            $camposs = $select->fetchAll();
            $campos  = new Agregadosobra('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR RANGO DE FECHA      **
 ********************************************************/
    public static function porfecha($FechaStart, $FechaEnd, $obra)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM reporte_agregados WHERE reporte_publicado='1' and fecha_reporte >='" . $FechaStart . "' and fecha_reporte <='" . $FechaEnd . "' and obra_id_obra='" . $obra . "' order by fecha_reporte DESC");
            $camposs = $select->fetchAll();
            $campos  = new Agregadosobra('', $camposs);
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

            $insert = $db->prepare('INSERT INTO reporte_agregados VALUES (NULL,:imagen,:fecha_reporte,:insumo_id_insumo,:origen_id_origen,:recibido_por,:cantidad,:placa,:localizacion,:creado_por, :estado_reporte, :reporte_publicado,:marca_temporal, :observaciones,:obra_id_obra,:frente_id_frente)');

            $t          = strtotime($fecha_reporte);
            $nuevafecha = date('y-m-d', $t);

            $insert->bindValue('imagen', utf8_encode($imagen));
            $insert->bindValue('fecha_reporte', utf8_encode($nuevafecha));
            $insert->bindValue('insumo_id_insumo', utf8_encode($insumo_id_insumo));
            $insert->bindValue('origen_id_origen', utf8_encode($origen_id_origen));
            $insert->bindValue('recibido_por', utf8_encode($recibido_por));
            $insert->bindValue('cantidad', utf8_encode($cantidad));
            $insert->bindValue('placa', utf8_encode($placa));
            $insert->bindValue('localizacion', utf8_encode($localizacion));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_reporte', utf8_encode($estado_reporte));
            $insert->bindValue('reporte_publicado', utf8_encode($reporte_publicado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('observaciones', utf8_encode($observaciones));
            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('frente_id_frente', utf8_encode($frente_id_frente));
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
            $select = $db->query("DELETE FROM reporte_agregados WHERE id='" . $id . "'");
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
    public static function editarPor($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM reporte_agregados WHERE id='" . $id . "' and estado_reporte='1'");
            $camposs = $select->fetchAll();
            $campos  = new Agregadosobra('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA MODIFICAR REPORTE DE EQUIPO ****
 ********************************************************************/
    public static function actualizar($id, $campos, $imagen)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE reporte_agregados SET
								imagen=:imagen,
								fecha_reporte=:fecha_reporte,
								insumo_id_insumo=:insumo_id_insumo,
								origen_id_origen=:origen_id_origen,
								recibido_por=:recibido_por,
								cantidad=:cantidad,
								placa=:placa,
                                localizacion=:localizacion,
								creado_por=:creado_por,
								estado_reporte=:estado_reporte,
								reporte_publicado=:reporte_publicado,
								marca_temporal=:marca_temporal,
								observaciones=:observaciones,
								obra_id_obra=:obra_id_obra,
								frente_id_frente=:frente_id_frente
								WHERE id=:id');

            $t          = strtotime($fecha_reporte);
            $nuevafecha = date('y-m-d', $t);

            $update->bindValue('imagen', utf8_encode($imagen));
            $update->bindValue('fecha_reporte', utf8_encode($nuevafecha));
            $update->bindValue('insumo_id_insumo', utf8_encode($insumo_id_insumo));
            $update->bindValue('origen_id_origen', utf8_encode($origen_id_origen));
            $update->bindValue('recibido_por', utf8_encode($recibido_por));
            $update->bindValue('cantidad', utf8_encode($cantidad));
            $update->bindValue('placa', utf8_encode($placa));
            $update->bindValue('localizacion', utf8_encode($localizacion));
            $update->bindValue('creado_por', utf8_encode($creado_por));
            $update->bindValue('estado_reporte', utf8_encode($estado_reporte));
            $update->bindValue('reporte_publicado', utf8_encode($reporte_publicado));
            $update->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $update->bindValue('observaciones', utf8_encode($observaciones));
            $update->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $update->bindValue('frente_id_frente', utf8_encode($frente_id_frente));
            $update->bindValue('id', utf8_encode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

}
