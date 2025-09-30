<?php
session_start();
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
////require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
//require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');


require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');
require_once($InsProyecto->MtdRutLibrerias().'nusoap-0.9.5/lib/nusoap.php');

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');


$InsResumenBaja = new ClsResumenBaja();
$InsNotaCredito = new ClsNotaCredito();
//Obteniendo datos de factura
$InsResumenBaja->RbaId = $GET_id;
$InsResumenBaja->MtdObtenerResumenBaja();

/*
* FACTURA ELECTRONICA
*/

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";
$NOMBRE = $InsResumenBaja->RbaArchivo;
$ARCHIVO = $NOMBRE.".xml";

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');
$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$Comprobante['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO;
$Comprobante['XMLNombre'] = $NOMBRE;

//deb($Comprobante);
///exit();
$l_stResult = $l_oProxy->MtdDarBajaNotaCredito(json_encode($Comprobante));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$l_stResult = utf8_encode($l_stResult);

$Trama = json_decode($l_stResult,true);

$UltimaRespuesta = "";

if($Trama['CodigoRespuesta']=="B101"){
	$UltimaRespuesta = "APROBADO";
	
}else if($Trama['CodigoRespuesta']=="B102"){
	$UltimaRespuesta = "ERROR";	
	
}else if($Trama['CodigoRespuesta']=="B103"){
	$UltimaRespuesta = "ERROR";	
		
}else if($Trama['CodigoRespuesta']=="B104"){
	$UltimaRespuesta = "ERROR";	
			
}else{
	
	$CodigoRespuesta = $Trama['CodigoRespuesta'] + 1 - 1;
		
	if($CodigoRespuesta>= 100 and $CodigoRespuesta <=1999){
		$UltimaRespuesta = "EXCEPCION";
	}else if($CodigoRespuesta>= 2000 and $CodigoRespuesta <=3999){
		$UltimaRespuesta = "RECHAZO";	
	}else if($CodigoRespuesta>= 4000){
		$UltimaRespuesta = "OBSERVADO";	
	}else{
		$UltimaRespuesta = "ERROR";
	} 
	
}

//TICKET ENVIO
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaTicket",$Trama['TicketRespuesta'],$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaFecha",date("Y-m-d"),$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaHora",date("H:i:s"),$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaCodigo",$Trama['CodigoRespuesta'],$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaContenido",$Trama['MensajeRespuesta'],$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaTiempoCreacion",date("Y-m-d H:i:s"),$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
//$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaBajaRespuesta",$UltimaRespuesta,$InsResumenBaja->NcrId,$InsResumenBaja->NctId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsNotaCredito->NcrSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaObservacion",$Observaciones,$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
//ULTIMO TICKET
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaCredito->NcrSunatRespuestaTicket),$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicketEstado","",$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
//ACCIONES
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaAccion","BAJA",$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaRespuesta",$UltimaRespuesta,$InsResumenBaja->NcrId,$InsResumenBaja->NctId);

//RESUMEN BAJA
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenTicket",$Trama['TicketRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenFecha",date("Y-m-d"),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenHora",date("H:i:s"),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenCodigo",$Trama['CodigoRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenContenido",$Trama['MensajeRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenTiempoCreacion",date("Y-m-d H:i:s"),$InsResumenBaja->RbaId);
//$InsResumenBaja->MtdEditarResumenBajaDato("NcrSunatRespuestaBajaRespuesta",$UltimaRespuesta,$InsResumenBaja->NcrId,$InsResumenBaja->NctId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsResumenBaja->RbaSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaObservacion",$Observaciones,$InsResumenBaja->RbaId);
//ULTIMO TICKET
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaCredito->NcrSunatRespuestaTicket),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaTicketEstado","",$InsResumenBaja->RbaId);
//$InsResumenBaja->MtdEditarResumenBajaDato("NcrSunatUltimaAccion","BAJA",$InsResumenBaja->NcrId,$InsResumenBaja->NctId);
//$InsResumenBaja->MtdEditarResumenBajaDato("NcrSunatUltimaRespuesta",$UltimaRespuesta,$InsResumenBaja->NcrId,$InsResumenBaja->NctId);

///deb($l_stResult);
echo ($l_stResult);

?>