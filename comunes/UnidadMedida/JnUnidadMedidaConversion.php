<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

$GET_UnidadMedida1 = $_GET['UnidadMedida1'];
$GET_UnidadMedida2 = $_GET['UnidadMedida2'];//AL QUE QUIERO CONVERTIR

$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsUnidadMedidaConversion->UmcEquivalente = 0;


$InsUnidadMedidaConversion->UmeId1 = $GET_UnidadMedida1;
$InsUnidadMedidaConversion->UmeId2 = $GET_UnidadMedida2;
//$ArrUnidadMedidaConversiones = array();

if($GET_UnidadMedida1 == $GET_UnidadMedida2){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
//	$ArrUnidadMedidaConversiones[] = $InsUnidadMedidaConversion;
}else{

	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$GET_UnidadMedida2,$GET_UnidadMedida1);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];

	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
	
//$InsUnidadMedidaConversion->UmcEquivalente = 1;
//$ArrUnidadMedidaConversiones[] = $InsUnidadMedidaConversion;
}

$InsUnidadMedidaConversion->InsMysql=NULL;
//deb($ArrUnidadMedidaConversiones);

//$json = new Services_JSON();
//echo $json->encode($InsUnidadMedidaConversion);


$json = new JSON;
//$var = $json->serialize( $ArrUnidadMedidaConversiones );
$var = $json->serialize( $InsUnidadMedidaConversion );
$json->unserialize( $var );
echo $var;
	
?>


	
