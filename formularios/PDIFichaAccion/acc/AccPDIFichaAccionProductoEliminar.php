<?php
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$_SESSION['InsFichaAccionProducto'.$ModalidadIngreso.$Identificador]->MtdEliminarSesionObjeto($_POST['Item']);



?>