<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador]->MtdEliminarSesionObjeto($_POST['Item']);



?>