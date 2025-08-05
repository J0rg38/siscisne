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

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoLlamada.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoMantenimiento.php');
//require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsNotaCredito = new ClsNotaCredito();
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


//Obteniendo datos de NotaCredito
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito = $InsNotaCredito->MtdObtenerNotaCredito();

//Obteniendo monedas
$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,'MonId','Desc',NULL);
$ArrMonedas = $ResMoneda['Datos'];


if($InsNotaCredito->MonId<>$EmpresaMonedaId){
	
	$InsNotaCredito->NcrTotalGravado = round($InsNotaCredito->NcrTotalGravado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalExonerado = round($InsNotaCredito->NcrTotalExonerado/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalGratuito = round($InsNotaCredito->NcrTotalGratuito/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrTotalPagar = round($InsNotaCredito->NcrTotalPagar/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento/$InsNotaCredito->NcrTipoCambio,2);
	
	$InsNotaCredito->NcrSubTotal = round($InsNotaCredito->NcrSubTotal/$InsNotaCredito->NcrTipoCambio,2);	
	$InsNotaCredito->NcrImpuesto = round($InsNotaCredito->NcrImpuesto/$InsNotaCredito->NcrTipoCambio,2);
	$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal/$InsNotaCredito->NcrTipoCambio,2);	
	
}

//$InsNotaCredito->NcrSubTotal = number_format(($InsNotaCredito->NcrSubTotal/$InsTipoCambio->TcaMontoCompra),2);
//$InsNotaCredito->NcrImpuesto = number_format(($InsNotaCredito->NcrImpuesto/$InsTipoCambio->TcaMontoCompra),2);
//$InsNotaCredito->NcrTotal = number_format(($InsNotaCredito->NcrTotal/$InsTipoCambio->TcaMontoCompra),2);

//$InsSucursal = new ClsSucursal();
//$InsSucursal->SucId = $_SESSION['SesionSucursal'];
//$InsSucursal->MtdObtenerSucursal();
 
//include("ImpNotaCreditoImprimir".$EmpresaAlias.".php");



if(file_exists("ImpNotaCreditoImprimir".$InsNotaCredito->NctNumero.".php")){
	
	include("ImpNotaCreditoImprimir".$InsNotaCredito->NctNumero.".php");
		
}else{
	
	//$InsNotaCreditoTalonario = new ClsNotaCreditoTalonario();
//	$InsNotaCreditoTalonario->NctId = $InsNotaCredito->NctId;
//	$InsNotaCreditoTalonario->MtdObtenerNotaCreditoTalonario();		
//	
//	if(substr($InsNotaCreditoTalonario->NctNumero,0,1)=="F" or substr($InsNotaCreditoTalonario->NctNumero,0,1)=="B"){
//		
//		header("Location: FrmNotaCreditoGenerarPDF.php?Id=".$InsNotaCredito->NcrId."&Ta=".$InsNotaCredito->NctId."&ImprimirCodigo=1");
//		die();

//	}else{
		echo "No se encontro formato para esta serie";		
//	}

}
?>