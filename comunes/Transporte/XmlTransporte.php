<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
require_once('paquetes/PaqLogistica/Clases/ClsTransporte.php');

$InsTransporte = new ClsTransporte();

$q = strtolower($_GET["q"]);
if (!$q) return;


$ResTransporte = $InsTransporte->MtdObtenerTransportes("TraNombre","contiene",$q,"TraNombre","ASC",1,NULL,NULL,NULL,true);
	
	$ArrTransportes = $ResTransporte['Datos'];
	$TransportesTotal = $ResTransporte['Total'];	
	
	if(empty($ArrTransportes)){
		
	}else{
		foreach($ArrTransportes as $DatTransporte){			
			echo $DatTransporte->TraNombre."|".$DatTransporte->TraId."\n";	
		}
	}
	

?>