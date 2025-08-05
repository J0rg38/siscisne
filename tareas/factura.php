<?php
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../';
$InsPoo->Ruta = '../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


//require_once('../librerias/nusoap-0.9.5/lib/nusoap.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');
//require_once('../librerias/JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON.php');

require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');


require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$client = new nusoap_client('http://127.0.0.1:8081/webservice1.asmx','wsdl');

$err = $client->getError();


if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$json = new Services_JSON();

echo "<br>";
echo "Procesando...";
echo "<br>";

//$param = array(	'oComprobante' => json_encode($Comprobante));
$param = array(	'oComprobante' => $json->encode($Comprobante));

///deb($Comprobante);

$Respuesta = $client->call('guardaBoletaElectronica', $param);

echo "Respuesta: ".$Respuesta;
echo "<br>";

	

echo "------------------------------------------<br />";
echo "Proceso Terminado<br />";
echo date("d/m/Y H:i:s")."<br />";
echo "------------------------------------------<br />";
?>