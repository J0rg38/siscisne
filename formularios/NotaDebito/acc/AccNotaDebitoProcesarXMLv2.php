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
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');



$InsNotaDebito = new ClsNotaDebito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaDebito->NdbId = $GET_id;
$InsNotaDebito->NdtId = $GET_ta;
$InsNotaDebito->MtdObtenerNotaDebito();
//
//$InsNotaDebito->NdbId=$InsNotaDebito->NdbId;
//$InsNotaDebito->NdbId=(string)(int)$InsNotaDebito->NdbId;
//190.117.111.8
$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-08-".$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";
/*
* NOTA DE DEBITO ELECTRONICA
*/
//echo "Conectando con SUNAT...";
//echo "<br>";
//
//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
//echo "<br>";

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');

$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
	
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
$ComprobanteXML['XMLNombre'] = $NOMBRE;

$l_stResult = $l_oProxy->MtdProcesarNotaDebito(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$l_stResult = utf8_encode($l_stResult);

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
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
//$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsNotaDebito->NdbSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaObservacion",$Observaciones,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
//ULTIMO TICKET
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaDebito->NdbSunatRespuestaTicket),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicketEstado","",$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
//FIRMA
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
//ACCIONES
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatUltimaAccion","ALTA",$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatUltimaRespuesta",$UltimaRespuesta,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);

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