<?php
session_start();
header("Content-Type: application/json;charset=utf-8");
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

set_time_limit(1000);

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaLetra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');


require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');



$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();
//
//$InsBoleta->BolId=$InsBoleta->BolId;
//$InsBoleta->BolId=(string)(int)$InsBoleta->BolId;
//190.117.111.8
//$URL_LOCAL = "190.117.157.125";
//$URL_LOCAL = $SistemaServidor2;
$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";
$CARPETA_LOCAL = "sistema";
$NOMBRE = $EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";

/*
* FACTURA ELECTRONICA
*/
//echo "Conectando con SUNAT...";
//echo "<br>";
//
//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
//echo "<br>";

$wsdl = 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl' ;


$l_oClient = new nusoap_client($wsdl,'wsdl');

$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
	
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$ComprobanteXML['CDRRUC'] = $EmpresaCodigo;
$ComprobanteXML['CDRTipoComprobante'] = "03";
$ComprobanteXML['CDRSerie'] = $InsBoleta->BtaNumero;
$ComprobanteXML['CDRNumero'] = $InsBoleta->BolId;
$ComprobanteXML['CDRXMLNombre'] = $NOMBRE;

$l_stResult = $l_oProxy->MtdConsultarCDR(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$l_stResult = utf8_encode($l_stResult);

$Trama = json_decode($l_stResult,true);

$UltimaRespuesta = "";


if($Trama['CodigoRespuesta']=="D101"){
	
	$UltimaRespuesta = "APROBADO";

}else if($Trama['CodigoRespuesta']=="D102"){
	
	$UltimaRespuesta = "ERROR";
	
}else if($Trama['CodigoRespuesta']=="D103"){
	
	$UltimaRespuesta = "ERROR";
	
}else if($Trama['CodigoRespuesta']=="D104"){
	
	$UltimaRespuesta = "ERROR";

}else if($Trama['CodigoRespuesta']=="D105"){
	
	$UltimaRespuesta = "ERROR";

}else if($Trama['CodigoRespuesta']=="D106"){
	
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

//if($Trama['CodigoRespuesta']=="000"){
//	$UltimaRespuesta = "APROBADO";
//}else{
//
//	$CodigoRespuesta = $Trama['CodigoRespuesta'] + 1 - 1;
//
//	if($CodigoRespuesta>= 100 and $CodigoRespuesta <=1999){
//		$UltimaRespuesta = "EXCEPCION";
//	}else if($CodigoRespuesta>= 2000 and $CodigoRespuesta <=3999){
//		$UltimaRespuesta = "RECHAZO";	
//	}else if($CodigoRespuesta>= 4000){
//		$UltimaRespuesta = "OBSERVADO";	
//	}else{
//		$UltimaRespuesta = "ERROR";
//	}
//
//}




$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);

$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);

$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->BtaId);

$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaActividad","ALTA",$InsBoleta->BolId,$InsBoleta->BtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->BtaId);

//if(!empty($Trama['XmlFirmado'])){
//
//	$OUTPUT = "../../../generados/firmados/".$NOMBRE.".xml";
//
//	$bin = base64_decode($Trama['XmlFirmado']);
//	file_put_contents($OUTPUT, $bin);	
//	
//}

if(!empty($Trama['XmlFirmado'])){

	$OUTPUT = "../../../generados/comprobantes_fir/".$ARCHIVO_XML;

	$bin = @base64_decode($Trama['XmlFirmado']);
	@file_put_contents($OUTPUT, $bin);	
	
}

if(!empty($Trama['ZIPRespuesta'])){

	$OUTPUT = "../../../generados/comprobantes_cdr/".$ARCHIVO_CDR;

	$bin = @base64_decode($Trama['ZIPRespuesta']);
	@file_put_contents($OUTPUT, $bin);	
	
}

echo ($l_stResult);
?>