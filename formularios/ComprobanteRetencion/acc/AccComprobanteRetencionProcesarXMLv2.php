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
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');



$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();



//$InsComprobanteRetencion->CrnId=$InsComprobanteRetencion->CrnId;
//$InsComprobanteRetencion->CrnId=(string)(int)$InsComprobanteRetencion->CrnId;
//190.117.111.8


$URL_LOCAL = "192.168.10.6:8080";
//$URL_LOCAL = "192.168.12.186:8080";

$URL_REMOTO = "192.168.10.4:8080";
//http://localhost:8080/SISTEMAS/SISCA/empresa/principal.php?Mod=ComprobanteRetencion&Form=Listado
//$URL_REMOTO = "192.168.12.186:8080/SISCA/empresa/";

$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-20-".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";
/*
* COMPROBANTE DE RETENCION ELECTRONICA
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

//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/sistema/generados/comprobantes_xml/".$ARCHIVO_XML;
//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/sistema/generados/comprobantes_xml/".$ARCHIVO_XML;
$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/sistema/generados/comprobantes_xml/".$ARCHIVO_XML;
//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/SISTEMAS/SISCA/empresa/generados/comprobantes_xml/".$ARCHIVO_XML;

$ComprobanteXML['XMLNombre'] = $NOMBRE;

$l_stResult = $l_oProxy->MtdProcesarRetencion(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);

$Trama = json_decode($l_stResult,true);

//deb($l_stResult);


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
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
//$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsComprobanteRetencion->CrnSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaObservacion",$Observaciones,$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
//ULTIMO TICKET
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsComprobanteRetencion->CrnSunatRespuestaTicket),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaTicketEstado","",$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
//FIRMA
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
//ACCIONES
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatUltimaAccion","ALTA",$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatUltimaRespuesta",$UltimaRespuesta,$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);

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