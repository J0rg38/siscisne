<?php
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];

if(!empty($ArrSesionObjetos)){
	foreach($ArrSesionObjetos as $DatSesionObjeto){
		$_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador]->MtdEliminarSesionObjeto($DatSesionObjeto->Item);
	}
}
?>
