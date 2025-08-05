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
if (!isset($_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$InsFichaAccionSuministro1 = array();
$InsFichaAccionSuministro1 = $_SESSION['InsFichaAccionSuministro'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$json = new JSON;
$var = $json->serialize( $InsFichaAccionSuministro1 );

$json->unserialize( $var );

echo $var;


?>