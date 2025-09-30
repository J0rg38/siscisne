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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];
$GET_Ticket = $_GET['Ticket'];

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebito.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaDebitoDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

/*
* NOTA DE DEBITO ELECTRONICA
*/

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";

$InsNotaDebito = new ClsNotaDebito();

//Obteniendo datos de factura
$InsNotaDebito->NdbId = $GET_id;
$InsNotaDebito->NdtId = $GET_ta;
$InsNotaDebito->MtdObtenerNotaDebito();

/*
* NOTA DE DEBITO ELECTRONICA
*/
//echo "Conectando con SUNAT...";
//echo "<br>";
//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
//echo "<br>";

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');
$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$Ticket['Numero'] = $InsNotaDebito->NdbSunatRespuestaTicket."";

$l_stResult = $l_oProxy->MtdConsultarEstadoTicket(json_encode($Ticket));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$Trama = json_decode($l_stResult,true);

$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaTicket",$Trama['TicketRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaFecha",(!empty($Trama['TicketRespuesta'])?date("Y-m-d"):""),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaHora",(!empty($Trama['TicketRespuesta'])?date("H:i:s"):""),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
//
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaCodigo",$Trama['CodigoRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaContenido",$Trama['MensajeRespuesta'],$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaConsultaTiempoCreacion",date("Y-m-d H:i:s"),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);

$Observaciones = $InsNotaDebito->NdbSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaObservacion",$Observaciones,$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsNotaDebito->NdbSunatRespuestaTicket),$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);
$InsNotaDebito->MtdEditarNotaDebitoDato("NdbSunatRespuestaTicketEstado","",$InsNotaDebito->NdbId,$InsNotaDebito->NdtId);

echo ($l_stResult);
?>