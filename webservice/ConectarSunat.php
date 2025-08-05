<?php
session_start();
//session_destroy();
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDeb'] = false;}
if(empty($_SESSION['MysqlDeb'])){$_SESSION['MysqlDebLevel'] = 0;}
if(!empty($_GET['d']) and !empty($_GET['v'])){if(($_GET['d']==1)){$_SESSION['MysqlDeb']=true;}else{$_SESSION['MysqlDeb']=false;}$_SESSION['MysqlDebLevel']=$_GET['v'];}
////ARCHIVOS PRINCIPALES
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

require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');



/**
	* constructor
	*
	* @param    mixed $endpoint SOAP server or WSDL URL (string), or wsdl instance (object)
	* @param    mixed $wsdl optional, set to 'wsdl' or true if using WSDL
	* @param    string $proxyhost optional
	* @param    string $proxyport optional
	* @param	string $proxyusername optional
	* @param	string $proxypassword optional
	* @param	integer $timeout set the connection timeout
	* @param	integer $response_timeout set the response timeout
	* @param	string $portName optional portName in WSDL document
	* @access   public
	*/
	
	//function nusoap_client($endpoint,$wsdl = false,$proxyhost = false,$proxyport = false,$proxyusername = false, $proxypassword = false, $timeout = 0, $response_timeout = 30, $portName = ''){
		
		
$wsdl = 'https://www.sunat.gob.pe/ol-ti-itcpgem-beta/billService?wsdl';
		 //https://www.sunat.gob.pe/ol-ti-itcpgem-beta/billService?wsdl

$l_oClient = new nusoap_client($wsdl,'wsdl');
$l_oClient->setCredentials("20100066603MODDATOS","moddatos","basic");

$param = array('ticket' => '201100000011227');

$result = $l_oClient->call('getStatus', $param);


deb(":3 ".$result);

//$l_oProxy = $l_oClient->getProxy();

//$err = $l_oClient->getError();
//
//if ($err) {
//	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//}

if ($l_oClient->fault) {
	echo 'Fallo: ';
	print_r($result);
} else {	// Chequea errores
	$err = $l_oClient->getError();
	if ($err) {		// Muestra el error
		echo 'Error: ' . $err ;
		print_r ($result);
	} else {		// Muestra el resultado
		echo 'Resultado: ';
		print_r ($result);
	}
}



//$l_stResult = $l_oProxy->MtdRegistrarPedido(json_encode($Pedido));
//$Respuesta = json_decode($l_stResult,true);

?>