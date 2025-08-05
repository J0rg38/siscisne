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
require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');




$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();



//$InsFactura->FacId=$InsFactura->FacId;
//$InsFactura->FacId=(string)(int)$InsFactura->FacId;
//190.117.111.8


$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
//http://localhost:8080/SISTEMAS/SISCA/empresa/principal.php?Mod=Factura&Form=Listado
//$URL_REMOTO = "192.168.12.186:8080/SISCA/empresa/";

$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId."";
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

//echo 'http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl';

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');

$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
	
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
//$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
$ComprobanteXML['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO_XML;
$ComprobanteXML['XMLNombre'] = $NOMBRE;

$l_stResult = $l_oProxy->MtdFirmar(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);

$Trama = json_decode($l_stResult,true);
//
//$UltimaRespuesta = "";
//
//if($Trama['CodigoRespuesta']=="P101"){
//	
//	$UltimaRespuesta = "APROBADO";
//
//}else if($Trama['CodigoRespuesta']=="P102"){
//	
//	$UltimaRespuesta = "ERROR";
//	
//}else if($Trama['CodigoRespuesta']=="P103"){
//	
//	$UltimaRespuesta = "ERROR";
//				
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
//
//
////TICKET ENVIO
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioFecha",$Trama['FechaRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioHora",$Trama['HoraRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioCodigo",$Trama['CodigoRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioContenido",$Trama['MensajeRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioTiempoCreacion",date("Y-m-d H:i:s"),$InsFactura->FacId,$InsFactura->FtaId);
////$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
//
////HISTORIAL OBSERVACIONES
//$Observaciones = $InsFactura->FacSunatRespuestaObservacion;
//$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaObservacion",$Observaciones,$InsFactura->FacId,$InsFactura->FtaId);
////ULTIMO TICKET
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsFactura->FacSunatRespuestaTicket),$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicketEstado","",$InsFactura->FacId,$InsFactura->FtaId);
////FIRMA
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsFactura->FacId,$InsFactura->FtaId);
////ACCIONES
//$InsFactura->MtdEditarFacturaDato("FacSunatUltimaAccion","ALTA",$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatUltimaRespuesta",$UltimaRespuesta,$InsFactura->FacId,$InsFactura->FtaId);
//
//if(!empty($Trama['XmlFirmado'])){
//
//	$OUTPUT = "../../../generados/comprobantes_fir/".$ARCHIVO_XML;
//
//	$bin = base64_decode($Trama['XmlFirmado']);
//	file_put_contents($OUTPUT, $bin);	
//	
//}
//
//if(!empty($Trama['ZIPRespuesta'])){
//
//	$OUTPUT = "../../../generados/comprobantes_cdr/".$ARCHIVO_CDR;
//
//	$bin = base64_decode($Trama['ZIPRespuesta']);
//	file_put_contents($OUTPUT, $bin);	
//	
//}

echo ($l_stResult);
?>