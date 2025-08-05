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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_mon = ($_GET['Mon']);
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

if(empty($GET_mon)){
	$GET_mon = $EmpresaMonedaId;
}

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

//require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsNotaDebito = new ClsNotaDebito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de moneda escogida
$InsMoneda->MonId = $GET_mon;
$InsMoneda = $InsMoneda->MtdObtenerMoneda();

//Obteniendo tipo de cambio
$InsTipoCambio->MonId = $GET_mon;
$InsTipoCambio->TcaFecha = date("Y-m-d");
$InsTipoCambio->MtdObtenerTipoCambioActual();

if(empty($InsTipoCambio->TcaMontoCompra)){
	$InsTipoCambio->TcaMontoCompra = 1;
}

if(empty($InsTipoCambio->TcaMontoVenta)){
	$InsTipoCambio->TcaMontoVenta = 1;
}


//Obteniendo datos de NotaDebito
$InsNotaDebito->NdbId = $GET_id;
$InsNotaDebito->NdtId = $GET_ta;
$InsNotaDebito = $InsNotaDebito->MtdObtenerNotaDebito();

//Obteniendo monedas
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];

$InsNotaDebito->NdbSubTotal = (($InsNotaDebito->NdbSubTotal/$InsTipoCambio->TcaMontoCompra));
$InsNotaDebito->NdbImpuesto = (($InsNotaDebito->NdbImpuesto/$InsTipoCambio->TcaMontoCompra));
$InsNotaDebito->NdbTotal = (($InsNotaDebito->NdbTotal/$InsTipoCambio->TcaMontoCompra));

//$InsNotaDebito->NdbSubTotal = number_format(($InsNotaDebito->NdbSubTotal/$InsTipoCambio->TcaMontoCompra),2);
//$InsNotaDebito->NdbImpuesto = number_format(($InsNotaDebito->NdbImpuesto/$InsTipoCambio->TcaMontoCompra),2);
//$InsNotaDebito->NdbTotal = number_format(($InsNotaDebito->NdbTotal/$InsTipoCambio->TcaMontoCompra),2);

//$InsSucursal = new ClsSucursal();
//$InsSucursal->SucId = $_SESSION['SesionSucursal'];
//$InsSucursal->MtdObtenerSucursal();


//include("ImpNotaDebitoImprimir".$EmpresaAlias.".php");


if(file_exists("ImpNotaDebitoImprimir".$InsNotaDebito->NtNumero.".php")){
	
	include("ImpNotaDebitoImprimir".$InsNotaDebito->NtNumero.".php");
		
}else{
	
	//$InsNotaDebitoTalonario = new ClsNotaDebitoTalonario();
//	$InsNotaDebitoTalonario->NtId = $InsNotaDebito->NtId;
//	$InsNotaDebitoTalonario->MtdObtenerNotaDebitoTalonario();		
//	
//	if(substr($InsNotaDebitoTalonario->NtNumero,0,1)=="F" or substr($InsNotaDebitoTalonario->NtNumero,0,1)=="B"){
//		
//		header("Location: FrmNotaDebitoGenerarPDF.php?Id=".$InsNotaDebito->NcrId."&Ta=".$InsNotaDebito->NtId."&ImprimirCodigo=1");
//		die();

//	}else{
		echo "No se encontro formato para esta serie";		
//	}

}
?>