<?php
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

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

$GET_MonedaId = $_GET['MonedaId'];
 $GET_Fecha = FncCambiaFechaAMysql($_GET['Fecha']);

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = $GET_MonedaId;
$InsTipoCambio->TcaFecha = $GET_Fecha;
$InsTipoCambio->MtdObtenerTipoCambioFecha();


if(empty($InsTipoCambio->TcaId)){


	$InsTipoCambio->MtdObtenerTipoCambioUltimo();

//	$ResTipoCambio = $InsTipoCambio->MtdObtenerTipoCambios(NULL,NULL,"TcaFecha","DESC","1",$GET_MonedaId);
//	$ArrTipoCambios = $ResTipoCambio['Datos'];
//
//	$InsTipoCambio->TcaId = $ArrTipoCambios[0]->TcaId;
//	unset($ArrTipoCambios);
//	$InsTipoCambio->MtdObtenerTipoCambio();

}
$InsTipoCambio->InsMysql = NULL;
$json = new JSON;
$var = $json->serialize( $InsTipoCambio );

$json->unserialize( $var );

echo $var;
	
?>


	
