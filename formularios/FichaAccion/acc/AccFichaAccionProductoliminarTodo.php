<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();	
}

$RepSesionObjetos = $_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];

if(!empty($ArrSesionObjetos)){
	foreach($ArrSesionObjetos as $DatSesionObjeto){
		$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdEliminarSesionObjeto($DatSesionObjeto->Item);
	}
}
?>
