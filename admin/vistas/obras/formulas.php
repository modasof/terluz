<?php 

function Valorinicialobra($obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT IFNULL(sum(valor_total),0) as totales FROM actividades_obra WHERE obra_id_obra='".$obra."' and actividad_publicada='1'");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function rangominimo($obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT MIN(fecha_inicio) as totales FROM rangos_obra WHERE obra_id_obra='".$obra."' and rango_publicado='1'");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function rangomaximo($obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT MAX(fecha_inicio) as totales FROM rangos_obra WHERE obra_id_obra='".$obra."' and rango_publicado='1'");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function tiempoTranscurridoFechas($fechaInicio, $fechaFin)
{
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha  = $fecha1->diff($fecha2);
    $tiempo = "";

    //años
    if ($fecha->y > 0) {
        $tiempo .= $fecha->y;

        if ($fecha->y == 1) {
            $tiempo .= " año, ";
        } else {
            $tiempo .= " años, ";
        }

    }

    //meses
    if ($fecha->m > 0) {
        $tiempo .= $fecha->m;

        if ($fecha->m == 1) {
            $tiempo .= " mes ";
        } else {
            $tiempo .= " meses ";
        }

    }

    //dias
    if ($fecha->d > 0) {
        $tiempo .= $fecha->d;

        if ($fecha->d == 1) {
            $tiempo .= " día ";
        } else {
            $tiempo .= " días ";
        }

    }

    //horas
    if ($fecha->h > 0) {
        $tiempo .= $fecha->h;

        if ($fecha->h == 1) {
            $tiempo .= " hora ";
        } else {
            $tiempo .= " horas ";
        }

    }

    return $tiempo;
}


function Valorcapitulo($capitulo){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT IFNULL(sum(valor_total),0) as totales FROM actividades_obra WHERE capitulo_id_capitulo='".$capitulo."' and actividad_publicada='1'");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function Horasmesgeneralfecha($FechaStart,$FechaEnd,$obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$sql="SELECT IFNULL(sum(hora_inactiva),0) as totales FROM reporte_horasmq WHERE fecha_reporte >='".$FechaStart."' and fecha_reporte <='".$FechaEnd."' and reporte_publicado<>'0' and obra_id_obra='".$obra."'";
	$select = $db->prepare($sql);
	//echo($sql);
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function Horastotalesobra($obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$sql="SELECT IFNULL(sum(hora_inactiva),0) as totales FROM reporte_horasmq WHERE reporte_publicado<>'0' and obra_id_obra='".$obra."'";
	$select = $db->prepare($sql);
	//echo($sql);
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function Horasmaquinafecha($FechaStart,$FechaEnd,$equipo,$obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$sql="SELECT SUM(hora_inactiva) AS totales FROM reporte_horasmq WHERE fecha_reporte >='".$FechaStart."' and fecha_reporte <='".$FechaEnd."' AND reporte_publicado<>'0' AND equipo_id_equipo='".$equipo."' and obra_id_obra='".$obra."'";
	$select = $db->prepare($sql);
	//echo($sql);
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}


function Horasmaquinaporequipo($equipo,$obra){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$sql="SELECT SUM(hora_inactiva) AS totales FROM reporte_horasmq WHERE  reporte_publicado<>'0' AND equipo_id_equipo='".$equipo."' and obra_id_obra='".$obra."'";
	$select = $db->prepare($sql);
	//echo($sql);
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}

function formulaporcentaje ($menor,$mayor){

	$calculo = round(($menor/$mayor)*100,2);

	return($calculo);

}


function Valorejecutadoporrango($obra,$fecha_inicial,$fecha_final){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT IFNULL(sum(A.avance*B.valor_unitario),0) as totales FROM actividades_avance as A, actividades_obra as B WHERE A.fecha_reporte >='".$fecha_inicial."' and A.fecha_reporte <='".$fecha_final."' and A.obra_id_obra=B.obra_id_obra and A.obra_id_obra='".$obra."' and A.actividad_id_actividad=B.id_actividad");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}


function Cantidadejecutadoporrango($obra,$fecha_inicial,$fecha_final,$idactividad){
	$db = Db::getConnect();
	//$mesactual = date("n");
	$select = $db->prepare("SELECT IFNULL(sum(A.avance),0) as totales FROM actividades_avance as A WHERE A.fecha_reporte >='".$fecha_inicial."' and A.fecha_reporte <='".$fecha_final."' and A.obra_id_obra='".$obra."' and A.actividad_id_actividad='".$idactividad."' ");
	$select->execute();
	$valor = $select->fetchAll(); 
	foreach($valor as $campo){
		$total = $campo['totales'];
		}
	return $total;
	}
	











 ?>