<?php
class FrentesController
{
    public function __construct()
    {}

/*************************************************************/
/* FUNCION PARA MOSTRAR TODOS LOS EGRESOS DESDE ROUTING.PHP*/
/*************************************************************/

    public function todosobra()
    {
        $id = $_GET['id_obra'];
        $campos    = Frentes::obtenerPaginafrentes($id);
        require_once 'vistas/frentes/todosobra.php';
    }

    /*=============================================
    =            Editar por canal_venta           =
    =============================================*/
    
    public function editar()
    {
        $id     = $_GET['id'];
        $campos = Frentes::obtenerPaginaPor($id);
        require_once 'vistas/frentes/editar.php';
    }

   
    /*=====  End of Section comment block  ======*/
    
    
    public function eliminar()
    {
        $id      = $_GET['id'];
        $id_obra = $_GET['id_obra'];
        $res     = Frentes::eliminarPor($id);
        if ($res) {
            echo "<script>jQuery(function(){Swal.fire(\"¡Datos eliminados!\", \"Se han eliminado correctamente los datos\", \"success\");});</script>";
        } else {
            echo "<script>jQuery(function(){Swal.fire(\"¡Error al eliminar!\", \"No se han eliminado correctamente los datos\", \"error\");});</script>";
        }
$campos    = Frentes::obtenerPaginafrentes($id_obra);
   require_once 'vistas/frentes/todosobra.php';
    }

/*************************************************************/
/* FUNCION PARA GUARDAR NUEVO REGISTRO */
/*************************************************************/
function guardar() {

    $id_obra = $_GET['id_obra'];
    $variable = $_POST;
    $nuevoarreglo = array();
    extract($variable);
    foreach ($variable as $campo => $valor){
        //ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
        $campo = strip_tags(trim($campo));
        $campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

        $valor = strip_tags(trim($valor));
        $valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        if ($campo=="imagen2"){
            $nuevoarreglo[$campo]=$ruta_imagen;
        }else{
            $nuevoarreglo[$campo]=$valor;
        }
    }
    
    $nombre_frente=$_POST['nombre_frente'];
    $nombreescalpado = utf8_encode($nombre_frente);
    $campo = new Frentes('',$nuevoarreglo);

    $validacionduplicado = Frentes::validapor($nombreescalpado,$id_obra);

    if ($validacionduplicado>0) {
         echo "<script>jQuery(function(){Swal.fire(\"¡Datos Duplicados!\", \"Ya existe un registro con este nombre en esta obra\", \"warning\");});</script>";
    }
    else{

    $res = Frentes::guardar($campo);

        if ($res){
        echo "<script>jQuery(function(){Swal.fire(\"¡Datos guardados!\", \"Se han guardado correctamente los datos\", \"success\");});</script>";
    }else{
        echo "<script>jQuery(function(){Swal.fire(\"¡Erro al guardar!\", \"No se han guardado correctamente los datos\", \"error\");});</script>";
    }

    }
   $campos    = Frentes::obtenerPaginafrentes($id_obra);
   require_once 'vistas/frentes/todosobra.php';
 
}

/*************************************************************/
/* FUNCION PARA ACTUALIZAR*/
/*************************************************************/
function actualizar(){
    $id = $_GET['id'];
    $id_obra = $_GET['id_obra'];
    $variable = $_POST;
    $nuevoarreglo = array();
    extract($variable);
    foreach ($variable as $campo => $valor){
        //ELIMINAR CUALQUIER ETIQUETA <> PARA INYECCION SCRIPT
        $campo = strip_tags(trim($campo));
        $campo  = htmlspecialchars($campo, ENT_QUOTES, 'UTF-8');

        $valor = strip_tags(trim($valor));
        $valor  = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        if ($campo=="imagen"){
            $nuevoarreglo[$campo]=$ruta_imagen;
        }else{
            $nuevoarreglo[$campo]=$valor;
        }
    }
    $datosguardar = new Frentes($id,$nuevoarreglo);
    $res = Frentes::actualizar($id,$datosguardar);
    if ($res){
        echo "<script>jQuery(function(){Swal.fire(\"¡Datos actualizados!\", \"Se ha actualizado correctamente la pagina \", \"success\");});</script>";
    }else{
                echo "<script>jQuery(function(){Swal.fire(\"¡Error al actualizar!\", \"Hubo un error al actualizar, comunique con el administrador del sistema\", \"error\");});</script>";
        }
   $campos    = Frentes::obtenerPaginafrentes($id_obra);
   require_once 'vistas/frentes/todosobra.php';
}



}
