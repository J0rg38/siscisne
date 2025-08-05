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
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCredito.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoAlmacenMovimiento.php');
//require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoLetra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');


$InsNotaCredito = new ClsNotaCredito();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsNotaCredito->NcrId = $GET_id;
$InsNotaCredito->NctId = $GET_ta;
$InsNotaCredito->MtdObtenerNotaCredito();
//
//$InsNotaCredito->NcrId=$InsNotaCredito->NcrId;
//$InsNotaCredito->NcrId=(string)(int)$InsNotaCredito->NcrId;
//190.117.111.8
//$URL_LOCAL = "190.117.157.125";
//$URL_LOCAL = $SistemaServidor2;
$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-07-".$InsNotaCredito->NctNumero."-".$InsNotaCredito->NcrId."";
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


$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');

$l_oProxy = $l_oClient->getProxy();

$l_oProxy->response_timeout = 2000;
$l_oClient->response_timeout = 2000;

if ($l_oProxy->fault) {
    echo 'Error1: ';
    print_r($result);
    echo "<br>";	
} else {
    // check result
    $err_msg = $l_oProxy->getError();
    if ($err_msg) {
        // Print error msg
        echo 'Error2: '.$err_msg;
        echo "<br>";
    } else {
       // Print result
       // echo 'Result: ';
      //  print_r($result);
     //  echo "<br>";
    }
}




//$wsdl = 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl' ;
//
//$l_oClient = new nusoap_client($wsdl,'wsdl');
//
//$l_oProxy = $l_oClient->getProxy();
//
//$err = $l_oClient->getError();
//	
//if ($err) {
//	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
//}


$ComprobanteXML['CDRRUC'] = $EmpresaCodigo;
$ComprobanteXML['CDRTipoComprobante'] = "07";
$ComprobanteXML['CDRSerie'] = $InsNotaCredito->NctNumero;
$ComprobanteXML['CDRNumero'] = $InsNotaCredito->NcrId;
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


$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

$Observaciones = $InsNotaCredito->NcrSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaObservacion",$Observaciones,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaCredito->NcrSunatRespuestaTicket),$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaTicketEstado","",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaActividad","ALTA",$InsNotaCredito->NcrId,$InsNotaCredito->NctId);
$InsNotaCredito->MtdEditarNotaCreditoDato("NcrSunatUltimaRespuesta",$UltimaRespuesta,$InsNotaCredito->NcrId,$InsNotaCredito->NctId);

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