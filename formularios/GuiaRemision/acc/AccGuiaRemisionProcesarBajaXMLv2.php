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

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');


$InsResumenBaja = new ClsResumenBaja();
$InsGuiaRemision = new ClsGuiaRemision();
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
$l_stResult = $l_oProxy->MtdDarBajaGuiaRemision(json_encode($Comprobante));
$l_stResult = eregi_replace("'","\"",$l_stResult);
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
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaTicket",$Trama['TicketRespuesta'],$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaFecha",date("Y-m-d"),$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaHora",date("H:i:s"),$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaCodigo",$Trama['CodigoRespuesta'],$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaContenido",$Trama['MensajeRespuesta'],$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaTiempoCreacion",date("Y-m-d H:i:s"),$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
//$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaBajaRespuesta",$UltimaRespuesta,$InsResumenBaja->GreId,$InsResumenBaja->GrtId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsGuiaRemision->GreSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaObservacion",$Observaciones,$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
//ULTIMO TICKET
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsGuiaRemision->GreSunatRespuestaTicket),$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaTicketEstado","",$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
//ACCIONES
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatUltimaAccion","BAJA",$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatUltimaRespuesta",$UltimaRespuesta,$InsResumenBaja->GreId,$InsResumenBaja->GrtId);

//RESUMEN BAJA
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenTicket",$Trama['TicketRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenFecha",date("Y-m-d"),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenHora",date("H:i:s"),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenCodigo",$Trama['CodigoRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenContenido",$Trama['MensajeRespuesta'],$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaResumenTiempoCreacion",date("Y-m-d H:i:s"),$InsResumenBaja->RbaId);
//$InsResumenBaja->MtdEditarResumenBajaDato("GreSunatRespuestaBajaRespuesta",$UltimaRespuesta,$InsResumenBaja->GreId,$InsResumenBaja->GrtId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsResumenBaja->RbaSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaObservacion",$Observaciones,$InsResumenBaja->RbaId);
//ULTIMO TICKET
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsGuiaRemision->GreSunatRespuestaTicket),$InsResumenBaja->RbaId);
$InsResumenBaja->MtdEditarResumenBajaDato("RbaSunatRespuestaTicketEstado","",$InsResumenBaja->RbaId);
//$InsResumenBaja->MtdEditarResumenBajaDato("GreSunatUltimaAccion","BAJA",$InsResumenBaja->GreId,$InsResumenBaja->GrtId);
//$InsResumenBaja->MtdEditarResumenBajaDato("GreSunatUltimaRespuesta",$UltimaRespuesta,$InsResumenBaja->GreId,$InsResumenBaja->GrtId);

///deb($l_stResult);
echo ($l_stResult);

?>