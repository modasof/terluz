<?php
/**
 * CLASE PARA TRABAJAR CON LAS OBRAS
 */
class Obras
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
** FUNCION PARA MOSTRAR EL NOMBRE DEL PRODUCTO **
********************************************************/
public static function validacionpor($actividad_id_actividad,$fecha_reporte){
    try {
        $db=Db::getConnect();

        $select=$db->query("SELECT COUNT(id_cantidades) AS total FROM  actividades_avance WHERE actividad_id_actividad='".$actividad_id_actividad."' and fecha_reporte='".$fecha_reporte."'");
        $camposs=$select->fetchAll();
        $campos = new Obras('',$camposs);
        $marcas = $campos->getCampos();
        foreach($marcas as $marca){
            $mar = $marca['total'];
        }
        return $mar;
    }
    catch(PDOException $e) {
        echo '{"error en obtener la pagina":{"text":'. $e->getMessage() .'}}';
    }
}


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS      **
 ********************************************************/
    public static function todos()
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM obras WHERE obra_publicada='1' order by id_obra DESC");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS      **
 ********************************************************/
    public static function misobras($id)
    {
        try {
            $db = Db::getConnect();
            $sql="SELECT DISTINCT(obra_id_obra) FROM personal_obras WHERE usuario_id_usuario='".$id."' order by obra_id_obra DESC";
            $select  = $db->query($sql);
            //echo($sql);
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR ID      **
 ********************************************************/
    public static function obtenerpaginapor($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM obras WHERE id_obra='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function obtenerlistaciudades()
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM ciudades order by nombre_ciudad asc");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function obtenerlistacapitulos($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM capitulos WHERE obra_id_obra='" . $id . "' order by prioridad asc");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function ListaObrasAsignadas($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT DISTINCT(obra_id_obra) FROM personal_obras WHERE usuario_id_usuario='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function ListaObras()
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM obras WHERE obra_publicada='1'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function ListaFrentesAsignadas($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT DISTINCT(frente_id_frente) FROM personal_obras WHERE usuario_id_usuario='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LAS CAJAS              **
 ********************************************************/
    public static function ListaFrentesObra($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM frentes WHERE obra_id_obra='" . $id . "' and frente_publicado='1'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            return $marcas;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }



/***************************************************************
 *** FUNCION PARA GUARDAR LA OBRA**
 ***************************************************************/
    public static function guardar_obra($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO obras VALUES (NULL,:nombre_obra,:contrato_obra,:contratante,:objeto,:interventoria,:fecha_inicio,:ciudad_id_ciudad,:marca_temporal,:obra_estado,:obra_publicada,:creado_por,:usuario_asignado)');

            $insert->bindValue('nombre_obra', utf8_encode($nombre_obra));
            $insert->bindValue('contrato_obra', utf8_encode($contrato_obra));
            $insert->bindValue('contratante', utf8_encode($contratante));
            $insert->bindValue('objeto', utf8_encode($objeto));
            $insert->bindValue('interventoria', utf8_encode($interventoria));
            $insert->bindValue('fecha_inicio', utf8_encode($fecha_inicio));
            $insert->bindValue('ciudad_id_ciudad', utf8_encode($ciudad_id_ciudad));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('obra_estado', utf8_encode($obra_estado));
            $insert->bindValue('obra_publicada', utf8_encode($obra_publicada));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('usuario_asignado', utf8_encode($usuario_asignado));
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    /********************************************************************
     *** FUNCION PARA ACTUALIZAR REPORTE ****
     ********************************************************************/
    public static function actualizar_obra($id, $campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE obras SET
                                nombre_obra=:nombre_obra,
                                contrato_obra=:contrato_obra,
                                contratante=:contratante,
                                objeto=:objeto,
                                interventoria=:interventoria,
                                usuario_asignado=:usuario_asignado,
                                fecha_inicio=:fecha_inicio
                                WHERE id_obra=:id_obra');

            $update->bindValue('nombre_obra', utf8_encode($nombre_obra));
            $update->bindValue('contrato_obra', utf8_encode($contrato_obra));
            $update->bindValue('contratante', utf8_encode($contratante));
            $update->bindValue('objeto', utf8_encode($objeto));
            $update->bindValue('interventoria', utf8_encode($interventoria));
            $update->bindValue('usuario_asignado', utf8_encode($usuario_asignado));
            $update->bindValue('fecha_inicio', utf8_encode($fecha_inicio));
            $update->bindValue('id_obra', utf8_decode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 *** FUNCION PARA GUARDAR LA OBRA**
 ***************************************************************/
    public static function guardar_capitulo($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO capitulos VALUES (NULL,:obra_id_obra,:nombre_capitulo,:cod_capitulo,:marca_temporal,:creado_por,:estado_capitulo,:capitulo_publicado,:prioridad)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('nombre_capitulo', utf8_encode($nombre_capitulo));
            $insert->bindValue('cod_capitulo', utf8_encode($cod_capitulo));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_capitulo', utf8_encode($estado_capitulo));
            $insert->bindValue('capitulo_publicado', utf8_encode($capitulo_publicado));
            $insert->bindValue('prioridad', utf8_encode($prioridad));
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FILTRADOS POR ID  **
 ***************************************************************/
    public static function editarcapituloPor($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM capitulos WHERE id_capitulo='" . $id . "' and estado_capitulo='1'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA ACTUALIZAR REPORTE ****
 ********************************************************************/
    public static function actualizar_capitulo($id, $campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE capitulos SET
                                obra_id_obra=:obra_id_obra,
                                nombre_capitulo=:nombre_capitulo,
                                cod_capitulo=:cod_capitulo,
                                marca_temporal=:marca_temporal,
                                creado_por=:creado_por,
                                estado_capitulo=:estado_capitulo,
                                capitulo_publicado=:capitulo_publicado,
                                prioridad=:prioridad
                                WHERE id_capitulo=:id_capitulo');

            $update->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $update->bindValue('nombre_capitulo', utf8_encode($nombre_capitulo));
            $update->bindValue('cod_capitulo', utf8_encode($cod_capitulo));
            $update->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $update->bindValue('creado_por', utf8_encode($creado_por));
            $update->bindValue('estado_capitulo', utf8_encode($estado_capitulo));
            $update->bindValue('capitulo_publicado', utf8_encode($capitulo_publicado));
            $update->bindValue('prioridad', utf8_encode($prioridad));
            $update->bindValue('id_capitulo', utf8_decode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE  **
 ********************************************************/
    public static function obtenernombreobra($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT nombre_obra FROM obras WHERE id_obra='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['nombre_obra'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE  **
 ********************************************************/
    public static function obteneridobra($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT DISTINCT(obra_id_obra) FROM personal_obras WHERE usuario_id_usuario='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['obra_id_obra'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }


/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE  **
 ********************************************************/
    public static function obtenernombrecapitulo($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT nombre_capitulo FROM capitulos WHERE id_capitulo='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['nombre_capitulo'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }



/***************************************************************
 *** FUNCION PARA GUARDAR LA OBRA**
 ***************************************************************/
    public static function guardar_actividad($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO actividades_obra VALUES (NULL,:capitulo_id_capitulo,:obra_id_obra,:cod_actividad,:detalle,:unidad_id_unidad,:cantidad,:valor_unitario,:valor_total,:marca_temporal,:creado_por,:estado_actividad,:actividad_publicada,:prioridad)');

            $V1             = str_replace(".", "", $valor_unitario);
            $V2             = str_replace(" ", "", $V1);
            $valor_final    = str_replace("$", "", $V2);
            $valornumero    = (int) $valor_final;
            $valorcalculado = $valornumero * $cantidad;

            $insert->bindValue('capitulo_id_capitulo', utf8_encode($capitulo_id_capitulo));
            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('cod_actividad', utf8_encode($cod_actividad));
            $insert->bindValue('detalle', utf8_encode($detalle));
            $insert->bindValue('unidad_id_unidad', utf8_encode($unidad_id_unidad));
            $insert->bindValue('cantidad', utf8_encode($cantidad));
            $insert->bindValue('valor_unitario', utf8_encode($valornumero));
            $insert->bindValue('valor_total', utf8_encode($valorcalculado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_actividad', utf8_encode($estado_actividad));
            $insert->bindValue('actividad_publicada', utf8_encode($actividad_publicada));
            $insert->bindValue('prioridad', utf8_encode($prioridad));
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }


/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar_cantidadesmayores($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO actividades_cantidades VALUES (NULL,:obra_id_obra,:capitulo_id_capitulo,:actividad_id_actividad,:fecha_reporte,:mayores,:menores,:creado_por,:estado_cantidades,:cantidades_publicado,:marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('capitulo_id_capitulo', utf8_encode($capitulo_id_capitulo));
            $insert->bindValue('actividad_id_actividad', utf8_encode($actividad_id_actividad));
            $insert->bindValue('fecha_reporte', utf8_encode($fecha_reporte));
            $insert->bindValue('mayores', utf8_encode($mayores));
            $insert->bindValue('menores', utf8_encode($menores));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_cantidades', utf8_encode($estado_cantidades));
            $insert->bindValue('cantidades_publicado', utf8_encode($cantidades_publicado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }


/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar_cantidadesproyectadas($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $insert = $db->prepare('INSERT INTO actividades_proyeccion VALUES (NULL,:obra_id_obra,:capitulo_id_capitulo,:actividad_id_actividad,:rango_id_rango,:cantidad_proyectada,:creado_por,:estado_proyeccion,:proyeccion_publicado,:marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('capitulo_id_capitulo', utf8_encode($capitulo_id_capitulo));
            $insert->bindValue('actividad_id_actividad', utf8_encode($actividad_id_actividad));
            $insert->bindValue('rango_id_rango', utf8_encode($rango_id_rango));
            $insert->bindValue('cantidad_proyectada', utf8_encode($cantidad_proyectada));
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


/***************************************************************
 *** FUNCION PARA GUARDAR **
 ***************************************************************/
    public static function guardar_avance($campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

    $insert = $db->prepare('INSERT INTO actividades_avance VALUES (NULL,:obra_id_obra,:capitulo_id_capitulo,:actividad_id_actividad,:frente_id_frente,:localizacion,:observaciones,:fecha_reporte,:avance,:acta_numero,:creado_por,:estado_cantidades,:cantidades_publicado,:marca_temporal)');

            $insert->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $insert->bindValue('capitulo_id_capitulo', utf8_encode($capitulo_id_capitulo));
            $insert->bindValue('actividad_id_actividad', utf8_encode($actividad_id_actividad));
            $insert->bindValue('frente_id_frente', utf8_encode($frente_id_frente));
            $insert->bindValue('localizacion', utf8_encode($localizacion));
            $insert->bindValue('observaciones', utf8_encode($observaciones));
            $insert->bindValue('fecha_reporte', utf8_encode($fecha_reporte));
            $insert->bindValue('avance', utf8_encode($avance));
            $insert->bindValue('acta_numero', utf8_encode($acta_numero));
            $insert->bindValue('creado_por', utf8_encode($creado_por));
            $insert->bindValue('estado_cantidades', utf8_encode($estado_cantidades));
            $insert->bindValue('cantidades_publicado', utf8_encode($cantidades_publicado));
            $insert->bindValue('marca_temporal', utf8_encode($marca_temporal));
            $insert->execute();

            return true;
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }

    /***************************************************************
     ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS DE FILTRADOS POR ID  **
     ***************************************************************/
    public static function editaractividadPor($id)
    {
        try {
            $db      = Db::getConnect();
            $select  = $db->query("SELECT * FROM actividades_obra WHERE id_actividad='" . $id . "' and estado_actividad='1'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/********************************************************************
 *** FUNCION PARA ACTUALIZAR REPORTE ****
 ********************************************************************/
    public static function actualizar_actividad($id, $campos)
    {
        try {
            $db            = Db::getConnect();
            $campostraidos = $campos->getCampos();
            extract($campostraidos);

            $update = $db->prepare('UPDATE actividades_obra SET
                                capitulo_id_capitulo=:capitulo_id_capitulo,
                                obra_id_obra=:obra_id_obra,
                                cod_actividad=:cod_actividad,
                                detalle=:detalle,
                                unidad_id_unidad=:unidad_id_unidad,
                                cantidad=:cantidad,
                                valor_unitario=:valor_unitario,
                                valor_total=:valor_total,
                                marca_temporal=:marca_temporal,
                                creado_por=:creado_por,
                                estado_actividad=:estado_actividad,
                                actividad_publicada=:actividad_publicada,
                                prioridad=:prioridad
                                WHERE id_actividad=:id_actividad');

            $V1             = str_replace(".", "", $valor_unitario);
            $V2             = str_replace(" ", "", $V1);
            $valor_final    = str_replace("$", "", $V2);
            $valornumero    = (int) $valor_final;
            //$cantidadnum    = (int) $cantidad;
            $valorcalculado = $valornumero * $cantidad;

            $update->bindValue('capitulo_id_capitulo', utf8_encode($capitulo_id_capitulo));
            $update->bindValue('obra_id_obra', utf8_encode($obra_id_obra));
            $update->bindValue('cod_actividad', utf8_encode($cod_actividad));
            $update->bindValue('detalle', utf8_encode($detalle));
            $update->bindValue('unidad_id_unidad', utf8_encode($unidad_id_unidad));
            $update->bindValue('cantidad', utf8_encode($cantidad));
            $update->bindValue('valor_unitario', utf8_encode($valornumero));
            $update->bindValue('valor_total', utf8_encode($valorcalculado));
            $update->bindValue('marca_temporal', utf8_decode($marca_temporal));
            $update->bindValue('creado_por', utf8_decode($creado_por));
            $update->bindValue('estado_actividad', utf8_decode($estado_actividad));
            $update->bindValue('actividad_publicada', utf8_decode($actividad_publicada));
            $update->bindValue('prioridad', utf8_decode($prioridad));
            $update->bindValue('id_actividad', utf8_decode($id));

            $update->execute();
            return true;
        } catch (PDOException $e) {
            echo '{"error al guardar la configuración ":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE  **
 ********************************************************/
    public static function obtenernombreactividad($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT detalle FROM actividades_obra WHERE id_actividad='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['detalle'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR EL NOMBRE DEL PRODUCTO **
 ********************************************************/
    public static function obtenerultimaobra()
    {
        try {
            $db      = Db::getConnect();
            $sql     = "SELECT id_obra FROM obras order by id_obra desc limit 1";
            $select  = $db->query($sql);
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            $marcas  = $campos->getCampos();
            foreach ($marcas as $marca) {
                $mar = $marca['id_obra'];
            }
            return $mar;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR ID      **
 ********************************************************/
    public static function capitulosporobra($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM capitulos WHERE obra_id_obra='" . $id . "' order by prioridad");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR ID      **
 ********************************************************/
    public static function rangosporobra($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM rangos_obra WHERE obra_id_obra='" . $id . "'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

 /*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR ID      **
 ********************************************************/
    public static function unicorangoporobra($id,$rangoid)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM rangos_obra WHERE obra_id_obra='" . $id . "' and id='".$rangoid."'");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/*******************************************************
 ** FUNCION PARA MOSTRAR TODOS LOS CAMPOS POR ID      **
 ********************************************************/
    public static function actividadesporcapitulo($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT * FROM actividades_obra WHERE capitulo_id_capitulo='" . $id . "' order by prioridad asc");
            $camposs = $select->fetchAll();
            $campos  = new Obras('', $camposs);
            return $campos;
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

/***************************************************************
 ** FUNCION PARA ELIINAR POR ID  **
 ***************************************************************/
    public static function eliminarobraPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("UPDATE obras SET obra_publicada='0' WHERE id_obra='" . $id . "'");
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
    public static function eliminaractividadesPorCap($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM actividades_obra WHERE capitulo_id_capitulo='" . $id . "'");
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
    public static function eliminarcapituloPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM capitulos WHERE id_capitulo='" . $id . "'");
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
    public static function eliminaractividadPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM actividades_obra WHERE id_actividad='" . $id . "'");
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
    public static function eliminarcantidadesPor($id)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM actividades_cantidades WHERE actividad_id_actividad='" . $id . "'");
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
    public static function eliminarcantidades_proyectadasPor($id,$idrango)
    {
        try {
            $db     = Db::getConnect();
            $select = $db->query("DELETE FROM actividades_proyeccion WHERE actividad_id_actividad='" . $id . "' and rango_id_rango='".$idrango."'");
            if ($select) {
                return true;
            } else {return false;}
        } catch (PDOException $e) {
            echo '{"error en obtener la pagina":{"text":' . $e->getMessage() . '}}';
        }
    }

    /*******************************************************
 ** FUNCION PARA MOSTRAR CANTIDADES MAYORES  **
 ********************************************************/
    public static function sqlmayorespor($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT IFNULL(SUM(mayores),0) as totales FROM actividades_cantidades WHERE actividad_id_actividad='" . $id . "' and cantidades_publicado='1'");
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

      /*******************************************************
 ** FUNCION PARA MOSTRAR CANTIDADES MAYORES  **
 ********************************************************/
    public static function sqlmenorespor($id)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT IFNULL(SUM(menores),0) as totales FROM actividades_cantidades WHERE actividad_id_actividad='" . $id . "' and cantidades_publicado='1'");
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

    /*******************************************************
 ** FUNCION PARA MOSTRAR CANTIDADES MAYORES  **
 ********************************************************/
    public static function sqlproyeccionpor($id,$rangoid)
    {
        try {
            $db = Db::getConnect();

            $select  = $db->query("SELECT IFNULL(SUM(cantidad_proyectada),0) as totales FROM actividades_proyeccion WHERE actividad_id_actividad='" . $id . "' and rango_id_rango='".$rangoid."' and proyeccion_publicado='1'");
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


     /*******************************************************
 ** FUNCION PARA MOSTRAR CANTIDADES MAYORES  **
 ********************************************************/
    public static function sqlavancesporactividad($id)
    {
        try {
            $db = Db::getConnect();
                $sql="SELECT IFNULL(SUM(avance),0) as totales FROM actividades_avance WHERE actividad_id_actividad='" . $id . "' and avance_publicado='1'";
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


       public static function sqlavancesporcapitulo($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.avance*B.valor_unitario),0) as totales FROM actividades_avance as A, actividades_obra as B WHERE A.capitulo_id_capitulo='".$id."' and avance_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

     public static function sqlamodificacionesmayoresporcapitulo($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.mayores*B.valor_unitario),0) as totales FROM actividades_cantidades as A, actividades_obra as B WHERE A.capitulo_id_capitulo='".$id."' and cantidades_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

     public static function sqlamodificacionesmenoresporcapitulo($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.menores*B.valor_unitario),0) as totales FROM actividades_cantidades as A, actividades_obra as B WHERE A.capitulo_id_capitulo='".$id."' and cantidades_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

     public static function sqlavancesporobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.avance*B.valor_unitario),0) as totales FROM actividades_avance as A, actividades_obra as B WHERE A.obra_id_obra='".$id."' and avance_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

    public static function sqlvalormayoresporobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.mayores*B.valor_unitario),0) as totales FROM actividades_cantidades as A, actividades_obra as B WHERE A.obra_id_obra='".$id."' and cantidades_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

    public static function sqlvalormenoresporobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.menores*B.valor_unitario),0) as totales FROM actividades_cantidades as A, actividades_obra as B WHERE A.obra_id_obra='".$id."' and cantidades_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

      public static function sqlidrango($id,$fechainiciorangoactual,$fechafinrangoactual)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT id as totales FROM rangos_obra WHERE fecha_inicio>='".$fechainiciorangoactual."' and fecha_inicio<='".$fechafinrangoactual."' and fecha_fin>='".$fechainiciorangoactual."' and fecha_fin<='".$fechafinrangoactual."' and obra_id_obra='".$id."';";
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


     public static function sqlvalorrangoporobra($id,$rango)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.cantidad_proyectada*B.valor_unitario),0) as totales FROM actividades_proyeccion as A, actividades_obra as B WHERE A.obra_id_obra='".$id."' and proyeccion_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1' and A.rango_id_rango='".$rango."'";
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

     public static function sqlvalorproyectadoporobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(A.cantidad_proyectada*B.valor_unitario),0) as totales FROM actividades_proyeccion as A, actividades_obra as B WHERE A.obra_id_obra='".$id."' and proyeccion_publicado='1' and A.actividad_id_actividad=B.id_actividad and B.actividad_publicada='1'";
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

     public static function sqlvalorgastoporobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_total),0) as totales FROM ordenescompra  WHERE obra_id_obra='".$id."' and estado_orden='1' and compra_de='cxp'";
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

    public static function sqlvalorinventarioobra($id)
    {
        try {
            $db = Db::getConnect();
        $sql="SELECT IFNULL(SUM(valor_salida),0) as totales FROM salidas_ins  WHERE obra_id_obra='".$id."'";
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
