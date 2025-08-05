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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];
$GET_Ticket = $_GET['Ticket'];

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

/*
* COMPROBANTE DE RETENCION ELECTRONICA
*/

$URL_LOCAL = "192.168.10.6:8080";
$URL_REMOTO = "192.168.10.4:8080";
$CARPETA = "SUNAT";

$InsComprobanteRetencion = new ClsComprobanteRetencion();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();

/*
* COMPROBANTE DE RETENCION ELECTRONICA
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

$Ticket['Numero'] = $InsComprobanteRetencion->CrnSunatRespuestaTicket."";

$l_stResult = $l_oProxy->MtdConsultarEstadoTicket(json_encode($Ticket));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$Trama = json_decode($l_stResult,true);

$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaTicket",$Trama['TicketRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaFecha",(!empty($Trama['TicketRespuesta'])?date("Y-m-d"):""),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaHora",(!empty($Trama['TicketRespuesta'])?date("H:i:s"):""),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
//
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaCodigo",$Trama['CodigoRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaContenido",$Trama['MensajeRespuesta'],$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaConsultaTiempoCreacion",date("Y-m-d H:i:s"),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);

$Observaciones = $InsComprobanteRetencion->CrnSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaObservacion",$Observaciones,$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsComprobanteRetencion->CrnSunatRespuestaTicket),$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);
$InsComprobanteRetencion->MtdEditarComprobanteRetencionDato("CrnSunatRespuestaTicketEstado","",$InsComprobanteRetencion->CrnId,$InsComprobanteRetencion->CrtId);

echo ($l_stResult);
?>