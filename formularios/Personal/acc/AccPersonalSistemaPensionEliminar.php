<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');

require_once($InsProyecto->MtdRutLibrerias().'/JSON.php');

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsPersonalSistemaPension'.$Identificador])){
	$_SESSION['InsPersonalSistemaPension'.$Identificador] = new ClsSesionObjeto();
}

$_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdEliminarSesionObjeto($_POST['Item']);

$InsPersonalSistemaPension = array();

$InsPersonalSistemaPension = $_SESSION['InsPersonalSistemaPension'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$json = new JSON;
$var = $json->serialize( $InsPersonalSistemaPension );

$json->unserialize( $var );

echo $var;

?>