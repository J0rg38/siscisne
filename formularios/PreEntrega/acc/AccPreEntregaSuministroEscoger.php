<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

$Identificador = $_POST['Identificador'];
$ModalidadIngreso = $_POST['ModalidadIngreso'];

session_start();
if (!isset($_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$InsFichaIngresoSuministro1 = array();
$InsFichaIngresoSuministro1 = $_SESSION['InsFichaIngresoSuministro'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$json = new JSON;
$var = $json->serialize( $InsFichaIngresoSuministro1 );

$json->unserialize( $var );

echo $var;


?>