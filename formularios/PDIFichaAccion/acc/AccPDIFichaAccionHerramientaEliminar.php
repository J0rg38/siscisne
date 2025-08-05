<?php
require_once('../../../proyecto/ClsProyecto.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador]->MtdEliminarSesionObjeto($_POST['Item']);



?>