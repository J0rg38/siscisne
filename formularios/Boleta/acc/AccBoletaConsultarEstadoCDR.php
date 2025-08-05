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
require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');




$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->FtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();



//$InsBoleta->BolId=$InsBoleta->BolId;
//$InsBoleta->BolId=(string)(int)$InsBoleta->BolId;
//190.117.111.8

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
//http://localhost:8080/SISTEMAS/SISCA/empresa/principal.php?Mod=Boleta&Form=Listado
//$URL_REMOTO = "192.168.12.186:8080/SISCA/empresa/";

$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-03-".$InsBoleta->FtaNumero."-".$InsBoleta->BolId."";
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

$ComprobanteXML['RUC'] = $EmpresaCodigo;
$ComprobanteXML['Tipo'] = "01";
$ComprobanteXML['Serie'] = $InsBoleta->FtaNumero;
$ComprobanteXML['Numero'] = $InsBoleta->BolId;

$l_stResult = $l_oProxy->MtdConsultarEstadoCDR(json_encode($ComprobanteXML));
$l_stResult = eregi_replace("'","\"",$l_stResult);

$Trama = json_decode($l_stResult,true);

$UltimaRespuesta = "";

if($Trama['CodigoRespuesta']=="D101"){
	$UltimaRespuesta = "APROBADO";
}else{
	$UltimaRespuesta = "ERROR";
}

//TICKET ENVIO
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioTicket",$Trama['TicketRespuesta'],$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaConsultaCDRFecha",$Trama['FechaRespuesta'],$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaConsultaCDRHora",$Trama['HoraRespuesta'],$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaConsultaCDRCodigo",$Trama['CodigoRespuesta'],$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaConsultaCDRContenido",$Trama['MensajeRespuesta'],$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaConsultaCDRTiempoCreacion",date("Y-m-d H:i:s"),$InsBoleta->BolId,$InsBoleta->FtaId);
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->FtaId);

//HISTORIAL OBSERVACIONES
$Observaciones = $InsBoleta->BolSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaObservacion",$Observaciones,$InsBoleta->BolId,$InsBoleta->FtaId);
//ULTIMO TICKET
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsBoleta->BolSunatRespuestaTicket),$InsBoleta->BolId,$InsBoleta->FtaId);
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaTicketEstado","",$InsBoleta->BolId,$InsBoleta->FtaId);
//FIRMA
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioDigestValue",$Trama['DigestValue'],$InsBoleta->BolId,$InsBoleta->FtaId);
//$InsBoleta->MtdEditarBoletaDato("BolSunatRespuestaEnvioSignatureValue",$Trama['SignatureValue'],$InsBoleta->BolId,$InsBoleta->FtaId);
//ACCIONES
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaAccion","CONSULTACDR",$InsBoleta->BolId,$InsBoleta->FtaId);
$InsBoleta->MtdEditarBoletaDato("BolSunatUltimaRespuesta",$UltimaRespuesta,$InsBoleta->BolId,$InsBoleta->FtaId);

//if(!empty($Trama['ZIPRespuesta'])){
//	$OUTPUT = "../../../generados/comprobantes_cdr/".$ARCHIVO_CDR;
//	$bin = base64_decode($Trama['ZIPRespuesta']);
//	file_put_contents($OUTPUT, $bin);
//}

echo ($l_stResult);
?>