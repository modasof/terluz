<?php
class RangosController
{
    public function __construct()
    {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LOS EGRESOS DESDE ROUTING.PHP*/
/*************************************************************/

    public function todosobra()
    {
        $id     = $_GET['id_obra'];
        $campos = Rangos::obtenerPagina($id);
        require_once 'vistas/rangos/todosobra.php';
    }

    /*=============================================
    =            Editar por canal_venta           =
    =============================================*/

    public function editar()
    {
        $id     = $_GET['id'];
        $campos = Rangos::obtenerPaginaPor($id);
        require_once 'vistas/rangos/editar.php';
    }

    /*=====  End of Section comment block  ======*/

    public function eliminar()
    {
        $id      = $_GET['rangoid'];
        $id_obra = $_GET['id_obra'];

        # -----------  Subsection Eliminar todo registro del rango  -----------

        $res = Rangos::eliminardatalmePor($id);
        $res = Rangos::eliminardatainsPor($id);
        $res = Rangos::eliminardatalmoPor($id);
        $res = Rangos::eliminardataadmPor($id);
        $res = Rangos::eliminarPor($id);

        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
       $campos = Rangos::obtenerPagina($id_obra);
        require_once 'vistas/rangos/todosobra.php';
    }

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
    public function guardar()
    {

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
            if ($campo == "imagen2") {
                $nuevoarreglo[$campo] = $ruta_imagen;
            } else {
                $nuevoarreglo[$campo] = $valor;
            }
        }

        $mes_numero      = $_POST['mes_numero'];
        $nombreescalpado = utf8_encode($mes_numero);
        $campo           = new Rangos('', $nuevoarreglo);

        $validacionduplicado = Rangos::validapor($nombreescalpado, $id_obra);

        if ($validacionduplicado > 0) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos Duplicados!\", \"Ya existe el " . $nombreescalpado . " en esta obra\", \"warning\");});</script>";
        } else {

            $res = Rangos::guardar($campo);

            if ($res) {
                echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
            } else {
                echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
            }

        }
        $campos = Rangos::obtenerPagina($id_obra);
        require_once 'vistas/rangos/todosobra.php';

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
        $res          = Rangos::actualizar($id, $datosguardar);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina \", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
        }
        $campos = Rangos::obtenerPagina($id_obra);
        require_once 'vistas/rangos/todosobra.php';
    }

}
