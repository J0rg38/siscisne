<?php
session_start();
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
$GET_Id = $_GET['Id'];

require_once($InsPoo->MtdPaqContabilidad().'ClsResumenDiario.php');

$InsResumenDiario = new ClsResumenDiario();
$InsResumenDiario->RdiId = $GET_Id;
$InsResumenDiario->MtdObtenerResumenDiario();

/*
* FACTURA ELECTRONICA
*/
//echo "Conectando con SUNAT...";
//echo "<br>";

$URL_LOCAL = $SistemaServidor2;
$URL_REMOTO = $SistemaServidor3;
$CARPETA = "SUNAT";

$NOMBRE = $GET_Nombre;
$ARCHIVO = $NOMBRE.".xml";

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');
$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$Comprobante['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes_xml/".$ARCHIVO;
$Comprobante['XMLNombre'] = $NOMBRE;

$l_stResult = $l_oProxy->MtdProcesarResumenDiario(json_encode($Comprobante));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$Trama = json_decode($l_stResult,true);

$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenTicket",$Trama['TicketRespuesta'],$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenFecha",date("Y-m-d"),$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenHora",date("H:i:s"),$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenCodigo",$Trama['CodigoRespuesta'],$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenContenido",$Trama['MensajeRespuesta'],$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaResumenTiempoCreacion",date("Y-m-d H:i:s"),$InsResumenDiario->RdiId);

$Observaciones = $InsResumenDiario->RdiSunatRespuestaObservacion;
$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);

$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaObservacion",$Observaciones,$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsResumenDiario->RdiSunatRespuestaTicket),$InsResumenDiario->RdiId);
$InsResumenDiario->MtdEditarResumenDiarioDato("RdiSunatRespuestaTicketEstado","",$InsResumenDiario->RdiId);

echo ($l_stResult);
?>