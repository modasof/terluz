<?php
class ProyeccionesadmController
{
    public function __construct()
    {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LOS EGRESOS DESDE ROUTING.PHP*/
/*************************************************************/

    public function todosobra()
    {
        $id     = $_GET['id'];
        $campos = Proyeccionesadm::obtenerPagina($id);
        require_once 'vistas/proyeccionesadm/proyeccion_adm.php';
    }


    function proyeccionesrango(){
    $id = $_GET['id'];
    $rangoid = $_GET['rangoid'];
    $campos = Proyeccionesadm::obtenerPagina($id);
    require_once 'vistas/proyeccionesadm/proyeccion_adm_rango.php';
}

    /*=============================================
    =            Editar por canal_venta           =
    =============================================*/

    public function editar()
    {
        $id     = $_GET['id'];
        $campos = Proyeccionesadm::obtenerPaginaPor($id);
        require_once 'vistas/rangos/editar.php';
    }

    /*=====  End of Section comment block  ======*/

    public function eliminarango()
    {
        $id_obra      = $_GET['id'];
        $idrango = $_GET['idrango'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccionesadm::eliminarPor($id_obra,$idrango,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccionesadm::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesadm/proyeccion_adm.php';
    }

     public function eliminafila()
    {
        $id_obra      = $_GET['id'];
        $equipolme = $_GET['equipolme'];

        $res     = Proyeccionesadm::eliminarequipoPor($id_obra,$equipolme);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
        $campos = Proyeccionesadm::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesadm/proyeccion_adm.php';
    }

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
    public function guardar()
    {

        $id_obra            = $_GET['id'];
        $obra_id_obra       = $_POST['obra_id_obra'];
        $rubro_id_rubro         = $_POST['rubro_id_rubro'];
        $subrubro_id_subrubro         = $_POST['subrubro_id_subrubro'];
        $rango_id_rango     = $_POST['rango_id_rango'];
        $cantidad_adm       = $_POST['cantidad_adm'];
        $valor_unitario_adm = $_POST['valor_unitario_adm'];

        $V1          = str_replace(".", "", $valor_unitario_adm);
        $V2          = str_replace(" ", "", $V1);
        $valor_final = str_replace("$", "", $V2);
        $valornumero = (int) $valor_final;

        $valor_total_adm      = $cantidad_adm * $valornumero;
        $creado_por           = $_POST['creado_por'];
        $estado_proyeccion    = $_POST['estado_proyeccion'];
        $proyeccion_publicado = $_POST['proyeccion_publicado'];
        $marca_temporal       = $_POST['marca_temporal'];

        foreach ($rango_id_rango as $rangoseleccionado) {

            $validacionduplicado = Proyeccionesadm::validapor($rubro_id_rubro,$subrubro_id_subrubro, $obra_id_obra,$rangoseleccionado);

            if ($validacionduplicado > 0) {
                echo "<script>jQuery(function(){Swal.fire(\"¡Datos Duplicados!\", \"Ya ha seleccionado este equipo para este rango en esta obra\", \"warning\");});</script>";
            } else {

                $res = Proyeccionesadm::guardar($obra_id_obra, $rubro_id_rubro,$subrubro_id_subrubro, $rangoseleccionado, $cantidad_adm, $valornumero, $valor_total_adm, $creado_por, $estado_proyeccion, $proyeccion_publicado, $marca_temporal);
                 if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
        }
            }

        }
       

        $campos = Proyeccionesadm::obtenerPagina($id_obra);
        require_once 'vistas/proyeccionesadm/proyeccion_adm.php';

    }


}
