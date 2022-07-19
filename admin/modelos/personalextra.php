<?php
/**
 * CLASE PARA TRABAJAR CON EL LISTADO DE MÁQUINARIA Y EQUIPOS
 */
class Personalextra
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

            $select  = $db->query("SELECT * FROM personal_extra WHERE extra_publicado='1' order by nombre_extra DESC");
            $camposs = $select->fetchAll();
            $campos  = new Personalextra('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR **
id, fecha_reporte, cliente_id_cliente, producto_id_producto, valor_m3, cantidad, creado_por, estado_reporte, reporte_publicado, marca_temporal, observaciones
 ***************************************************************/
    public static function guardar($campos,$imagen)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO personal_extra VALUES (NULL,:imagen,:nombre_extra,:celular_extra,:documento,:cargo,:creado_por,:extra_publicado,:estado_extra,:marca_temporal)');

            $insert->bindValue('imagen', utf8_encode($imagen));
            $insert->bindValue('nombre_extra', utf8_encode($nombre_extra));
            $insert->bindValue('celular_extra', utf8_encode($celular_extra));
            $insert->bindValue('documento', utf8_encode($documento));
            $insert->bindValue('cargo', utf8_encode($cargo));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('extra_publicado', utf8_encode($extra_publicado));
            $insert->bindValue('estado_extra', utf8_encode($estado_extra));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
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
            $select = $db->query("UPDATE personal_extra SET extra_publicado='0' WHERE id_extra='" . $id . "'");
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
            $select  = $db->query("SELECT * FROM personal_extra WHERE id_extra='" . $id . "' and estado_extra='1'");
            $camposs = $select->fetchAll();
            $campos  = new Personalextra('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA MODIFICAR REPORTE DE EQUIPO ****
 ********************************************************************/
    public static function actualizar($id, $campos,$imagen)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE personal_extra SET
                                imagen=:imagen,
                                nombre_extra=:nombre_extra,
                                celular_extra=:celular_extra,
                                documento=:documento,
                                cargo=:cargo,
                                creado_por=:creado_por,
                                extra_publicado=:extra_publicado,
                                estado_extra=:estado_extra,
                                marca_temporal=:marca_temporal
                                WHERE id_extra=:id_extra');

    
            $update->bindValue('nombre_extra', utf8_encode($nombre_extra));
            $update->bindValue('celular_extra', utf8_encode($celular_extra));
            $update->bindValue('documento', utf8_encode($documento));
            $update->bindValue('cargo', utf8_encode($cargo));
            $update->bindValue('creado_por', utf8_encode($creado_por));
            $update->bindValue('extra_publicado', utf8_encode($extra_publicado));
            $update->bindValue('estado_extra', utf8_encode($estado_extra));
            $update->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $update->bindValue('id_extra', utf8_encode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
     ** FUNCION PARA MOSTRAR EL NOMBRE DEL PRODUCTO **
     ********************************************************/
    public static function validacionduplicado($documento)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT count(id_extra) as totales FROM personal_extra WHERE documento='" . $documento . "' and extra_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Personalextra('', $camposs);
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
            $select        = $db->query("SELECT * FROM personal_extra WHERE extra_publicado='1' order by nombre_extra");
            $campos        = $select->fetchAll();
            $camposs       = new Personalextra('', $campos);
            $campostraidos = $camposs->getCampos();
            return $campostraidos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE DEL EQUIPO **
 ********************************************************/
    public static function obtenerNombre($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT nombre_extra FROM personal_extra WHERE id_extra='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Personalextra('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['nombre_extra'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE DEL EQUIPO **
 ********************************************************/
    public static function obtenerCargo($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT cargo FROM personal_extra WHERE id_extra='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Personalextra('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['cargo'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

}
