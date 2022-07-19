<?php
class ProyeccionesinsController
{
    public function __construct()
    {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LOS EGRESOS DESDE ROUTING.PHP*/
/*************************************************************/

    public function todosobra()
    {
        $id     = $_GET['id'];
        $campos = Proyeccionesins::obtenerPagina($id);
        require_once 'vistas/proyeccionesins/proyeccion_ins.php';
    }


    function proyeccionesrango(){
    $id = $_GET['id'];
    $rangoid = $_GET['rangoid'];
    $campos = Proyeccionesins::obtenerPagina($id);
    require_once 'vistas/proyeccionesins/proyeccion_ins_rango.php';
}

    /*=============================================
    =            Editar por canal_venta           =
    =============================================*/

    public function editar()
    {
        $id     = $_GET['id'];
        $campos = Proyeccionesins::obtenerPaginaPor($id);
        require_once 'vistas/rangos/editar.php';
    }

    /*=====  End of Section comment block  ======*/

    public function eliminarango()
    {
        $id_obra      = $_GET['id'];
        $idrango = $_GET['idrango'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccionesins::eliminarPor($id_obra,$idrango,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccionesins::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesins/proyeccion_ins.php';
    }

     public function eliminaequipo()
    {
        $id_obra      = $_GET['id'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccionesins::eliminarequipoPor($id_obra,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccionesins::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesins/proyeccion_ins.php';
    }

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
    public function guardar()
    {

        $id_obra            = $_GET['id'];
        $obra_id_obra       = $_POST['obra_id_obra'];
        $insumo_id_insumo         = $_POST['insumo_id_insumo'];
        $rango_id_rango     = $_POST['rango_id_rango'];
        $cantidad_ins       = $_POST['cantidad_ins'];
        $valor_unitario_ins = $_POST['valor_unitario_ins'];

        $V1          = str_replace(".", "", $valor_unitario_ins);
        $V2          = str_replace(" ", "", $V1);
        $valor_final = str_replace("$", "", $V2);
        $valornumero = (int) $valor_final;

        $valor_total_ins      = $cantidad_ins * $valornumero;
        $creado_por           = $_POST['creado_por'];
        $estado_proyeccion    = $_POST['estado_proyeccion'];
        $proyeccion_publicado = $_POST['proyeccion_publicado'];
        $marca_temporal       = $_POST['marca_temporal'];

        foreach ($rango_id_rango as $rangoseleccionado) {

            $validacionduplicado = Proyeccionesins::validapor($insumo_id_insumo, $obra_id_obra,$rangoseleccionado);

            if ($validacionduplicado > 0) {
                echo "<script>jQuery(function(){Swal.fire(\"¡Datos Duplicados!\", \"Ya ha seleccionado este equipo para este rango en esta obra\", \"warning\");});</script>";
            } else {

                $res = Proyeccionesins::guardar($obra_id_obra, $insumo_id_insumo, $rangoseleccionado, $cantidad_ins, $valornumero, $valor_total_ins, $creado_por, $estado_proyeccion, $proyeccion_publicado, $marca_temporal);
                 if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
        }
            }

        }
       

        $campos = Proyeccionesins::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesins/proyeccion_ins.php';

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
        $res          = Proyeccionesins::actualizar($id, $datosguardar);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina \", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
        }
        $campos = Proyeccionesins::obtenerPagina($id_obra);
        require_once 'vistas/rangos/todosobra.php';
    }

}
