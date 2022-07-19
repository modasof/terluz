<?php
class ProyeccioneslmoController
{
    public function __construct()
    {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LOS EGRESOS DESDE ROUTING.PHP*/
/*************************************************************/

    public function todosobra()
    {
        $id     = $_GET['id'];
        $campos = Proyeccioneslmo::obtenerPagina($id);
        require_once 'vistas/proyeccioneslmo/proyeccion_lmo.php';
    }


    function proyeccionesrango(){
    $id = $_GET['id'];
    $rangoid = $_GET['rangoid'];
    $campos = Proyeccioneslmo::obtenerPagina($id);
    require_once 'vistas/proyeccioneslmo/proyeccion_lmo_rango.php';
}

    /*=============================================
    =            Editar por canal_venta           =
    =============================================*/

    public function editar()
    {
        $id     = $_GET['id'];
        $campos = Proyeccioneslmo::obtenerPaginaPor($id);
        require_once 'vistas/rangos/editar.php';
    }

    /*=====  End of Section comment block  ======*/

    public function eliminarango()
    {
        $id_obra      = $_GET['id'];
        $idrango = $_GET['idrango'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccioneslmo::eliminarPor($id_obra,$idrango,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccioneslmo::obtenerPagina($id_obra);
        require_once 'vistas/proyeccioneslmo/proyeccion_lmo.php';
    }

     public function eliminaequipo()
    {
        $id_obra      = $_GET['id'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccioneslmo::eliminarequipoPor($id_obra,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccioneslmo::obtenerPagina($id_obra);
        require_once 'vistas/proyeccioneslmo/proyeccion_lmo.php';
    }

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
    public function guardar()
    {

        $id_obra            = $_GET['id'];
        $obra_id_obra       = $_POST['obra_id_obra'];
        $lmo_id_lmo         = $_POST['lmo_id_lmo'];
        $rango_id_rango     = $_POST['rango_id_rango'];
        $cantidad_lmo       = $_POST['cantidad_lmo'];
        $valor_unitario_lmo = $_POST['valor_unitario_lmo'];

        $V1          = str_replace(".", "", $valor_unitario_lmo);
        $V2          = str_replace(" ", "", $V1);
        $valor_final = str_replace("$", "", $V2);
        $valornumero = (int) $valor_final;

        $valor_total_lmo      = $cantidad_lmo * $valornumero;
        $creado_por           = $_POST['creado_por'];
        $estado_proyeccion    = $_POST['estado_proyeccion'];
        $proyeccion_publicado = $_POST['proyeccion_publicado'];
        $marca_temporal       = $_POST['marca_temporal'];

        foreach ($rango_id_rango as $rangoseleccionado) {

            $validacionduplicado = Proyeccioneslmo::validapor($lmo_id_lmo, $obra_id_obra,$rangoseleccionado);

            if ($validacionduplicado > 0) {
                echo "<script>jQuery(function(){Swal.fire(\"¡Datos Duplicados!\", \"Ya ha seleccionado este equipo para este rango en esta obra\", \"warning\");});</script>";
            } else {

                $res = Proyeccioneslmo::guardar($obra_id_obra, $lmo_id_lmo, $rangoseleccionado, $cantidad_lmo, $valornumero, $valor_total_lmo, $creado_por, $estado_proyeccion, $proyeccion_publicado, $marca_temporal);
                 if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
        }
            }

        }
       

        $campos = Proyeccioneslmo::obtenerPagina($id_obra);
        require_once 'vistas/proyeccioneslmo/proyeccion_lmo.php';

    }

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
    public function actualizar()
    {
        $id           = $_GET['id'];
        $id_obra      = $_GET['id_obra'];
        $variable     = $_POST;
        $nuevoarreglo = array();
        extract($variable);
        foreach ($variable as $campo => $valor) {
            //ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
            $campo = strip_tags(trim($campo));
            $campo = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

            $valor = strip_tags(trim($valor));
            $valor = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
            if ($campo == "imagen") {
                $nuevoarreglo[$campo] = $ruta_imagen;
            } else {
                $nuevoarreglo[$campo] = $valor;
            }
        }
        $datosguardar = new Rangos($id, $nuevoarreglo);
        $res          = Proyeccioneslmo::actualizar($id, $datosguardar);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina \", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
        }
        $campos = Proyeccioneslmo::obtenerPagina($id_obra);
        require_once 'vistas/rangos/todosobra.php';
    }

}
