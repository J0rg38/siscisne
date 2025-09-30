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

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');

/*
* FACTURA ELECTRONICA
*/

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";

$InsFactura = new ClsFactura();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();

/*
* FACTURA ELECTRONICA
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

$Ticket['Numero'] = $InsFactura->FacSunatRespuestaTicket."";

$l_stResult = $l_oProxy->MtdConsultarEstadoTicket(json_encode($Ticket));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$Trama = json_decode($l_stResult,true);

$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaTicket",$Trama['TicketRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaFecha",(!empty($Trama['TicketRespuesta'])?date("Y-m-d"):""),$InsFactura->FacId,$InsFactura->FtaId);
$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaHora",(!empty($Trama['TicketRespuesta'])?date("H:i:s"):""),$InsFactura->FacId,$InsFactura->FtaId);
//
$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaCodigo",$Trama['CodigoRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaContenido",$Trama['MensajeRespuesta'],$InsFactura->FacId,$InsFactura->FtaId);
$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaConsultaTiempoCreacion",date("Y-m-d H:i:s"),$InsFactura->FacId,$InsFactura->FtaId);

$Observaciones = $InsFactura->FacSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaObservacion",$Observaciones,$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsFactura->FacSunatRespuestaTicket),$InsFactura->FacId,$InsFactura->FtaId);
//$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicketEstado","",$InsFactura->FacId,$InsFactura->FtaId);

echo ($l_stResult);
?>