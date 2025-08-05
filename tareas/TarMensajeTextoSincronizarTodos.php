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



require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');


require_once($InsProyecto->MtdRutClases().'ClsMensajeTexto.php');

$InsMensajeTexto = new ClsMensajeTexto();

//$wsdl = 'http://192.168.0.11:8080/apppavill/webservice/WsMensajeTexto.php?wsdl';
$wsdl = 'http://192.168.10.6:8080/sissms/webservice/WsMensajeTexto.php?wsdl';

$l_oClient = new nusoap_client($wsdl,'wsdl');
$l_oProxy = $l_oClient->getProxy();
	
$err = $l_oClient->getError();

if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

echo "Sincronizando...";
echo "<br>";

//MtdObtenerMensajeTextos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MteId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL)
$ResMensajeTexto = $InsMensajeTexto->MtdObtenerMensajeTextos(NULL,NULL,NULL,"MteTiempoCreacion","DESC","10",NULL,NULL,NULL);
$ArrMensajeTextos = $ResMensajeTexto['Datos'];

$l_stResult = $l_oProxy->MtdProcesarMensajeTextos(json_encode($ArrMensajeTextos));

if($_SESSION['MysqlDeb']){
	
	deb($l_stResult);
	
}
	
	switch($l_stResult){
		
		case "1":
			echo "Se proceso correctamente los mensajes de texto";	
			echo "<br>";
		break;
		
		case "2":
			echo "No se pudo procesar los mensajes de texto";
			echo "<br>";
		break;
	
		default:
			echo "Ha ocurrido un error interno. ".$l_stResult;
			echo "<br>";
		break;	
		
}

	
?>