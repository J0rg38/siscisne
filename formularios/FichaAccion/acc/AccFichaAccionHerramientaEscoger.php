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
if (!isset($_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$InsFichaAccionHerramienta1 = array();
$InsFichaAccionHerramienta1 = $_SESSION['InsFichaAccionHerramienta'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$json = new JSON;
$var = $json->serialize( $InsFichaAccionHerramienta1 );

$json->unserialize( $var );

echo $var;


?>