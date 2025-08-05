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
if (!isset($_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

$InsFichaIngresoProducto1 = array();
$InsFichaIngresoProducto1 = $_SESSION['InsFichaIngresoProducto'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$json = new JSON;
$var = $json->serialize( $InsFichaIngresoProducto1 );

$json->unserialize( $var );

echo $var;


?>