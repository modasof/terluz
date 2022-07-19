<?php
//Include database configuration file
include '../../include/class.conexion.php';

if(isset($_POST["obra_id_obra"]) && !empty($_POST["obra_id_obra"])){
	$db=Db::getConnect();
	$select=$db->query("SELECT * FROM frentes WHERE obra_id_obra = '".$_POST['obra_id_obra']."' and frente_publicado='1'");
	$campo=$select->fetchAll();
	$i = 0;
	echo("<option value'0'>Seleccionar Frente</option>");
	foreach($campo as $campos){
		$i = $i+1;
		$nombre_frente = $campos['nombre_frente'];
		$id_frente = $campos['id_frente'];
		echo '<option value="'.$id_frente.'">'.utf8_decode($nombre_frente).'</option>';
	}

    $rowCount = $i;
    //Display states list
    if($rowCount > 0){
    }else{
        echo '<option value="">Frentes no creados</option>';
    }
}

?>
