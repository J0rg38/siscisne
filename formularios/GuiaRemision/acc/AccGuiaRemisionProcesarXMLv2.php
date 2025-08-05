<?php
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

$GET_Nombre = $_GET['Nombre'];
$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];

//deb($GET_Nombre );
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

$InsGuiaRemision = new ClsGuiaRemision();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsGuiaRemision->GreId = $GET_id;
$InsGuiaRemision->GrtId = $GET_ta;
$InsGuiaRemision->MtdObtenerGuiaRemision();

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-09-".$InsGuiaRemision->GrtNumero."-".$InsGuiaRemision->GreId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";
/*
* FACTURA ELECTRONICA
*/

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');

$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
	
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
$ComprobanteXML['XMLNombre'] = $NOMBRE;


$l_stResult = $l_oProxy->MtdProcesarGuiaRemision(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);

$Trama = json_decode($l_stResult,true);

$UltimaRespuesta = "";

if($Trama['CodigoRespuesta']=="P101"){
	
	$UltimaRespuesta = "APROBADO";

}else if($Trama['CodigoRespuesta']=="P102"){
	
	$UltimaRespuesta = "ERROR";
	
}else if($Trama['CodigoRespuesta']=="P103"){
	
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
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
//$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsGuiaRemision->GreSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaObservacion",$Observaciones,$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
//ULTIMO TICKET
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsGuiaRemision->GreSunatRespuestaTicket),$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaTicketEstado","",$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
//FIRMA
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
//ACCIONES
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatUltimaAccion","ALTA",$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);
$InsGuiaRemision->MtdEditarGuiaRemisionDato("GreSunatUltimaRespuesta",$UltimaRespuesta,$InsGuiaRemision->GreId,$InsGuiaRemision->GrtId);

if(!empty($Trama['XmlFirmado'])){

	$OUTPUT = "../../../generados/comprobantes_fir/".$ARCHIVO_XML;

	$bin = base64_decode($Trama['XmlFirmado']);
	file_put_contents($OUTPUT, $bin);	

}

if(!empty($Trama['ZIPRespuesta'])){

	$OUTPUT = "../../../generados/comprobantes_cdr/".$ARCHIVO_CDR;

	$bin = base64_decode($Trama['ZIPRespuesta']);
	file_put_contents($OUTPUT, $bin);	

}

echo ($l_stResult);
?>