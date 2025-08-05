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
$GET_Seleccionados = $_GET['Seleccionados'];

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaVenta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaLetra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');

require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

/*
* FACTURA ELECTRONICA
*/
//echo "Conectando con SUNAT...";
//echo "<br>";
//
//echo "WSDL: http://192.168.0.252:8080/SUNAT/WsSUNAT.php?wsdl";
//echo "<br>";

$URL_LOCAL = "200.4.226.27";
$URL_REMOTO = "192.168.0.203:8080";
$CARPETA = "SUNAT";
$NOMBRE = $GET_Nombre;
$ARCHIVO = $NOMBRE.".xml";

$l_oClient = new nusoap_client('http://'.$URL_REMOTO.'/'.$CARPETA.'/WsSUNAT.php?wsdl','wsdl');
$l_oProxy = $l_oClient->getProxy();

$err = $l_oClient->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$Comprobante['XMLUrl'] = "http://".$URL_LOCAL."/".$SistemaNombreCarpeta."/generados/comprobantes/".$ARCHIVO;
$Comprobante['XMLNombre'] = $NOMBRE;


//echo $Comprobante['XMLUrl'];

//exit();
$l_stResult = $l_oProxy->MtdDarBajaFactura(json_encode($Comprobante));
$l_stResult = eregi_replace("'","\"",$l_stResult);
$Trama = json_decode($l_stResult,true);

$ArrFacturas = explode("@",$GET_Seleccionados);
$Fecha = "";

if(!empty($ArrFacturas)){
	foreach($ArrFacturas as $DatFactura){		
		if(!empty($DatFactura)){
			
			list($Id,$Ta) = explode("%",$DatFactura);
			
			$InsFactura->FacId = $Id;
			$InsFactura->FtaId = $Ta;
			$InsFactura->MtdObtenerFactura(false);

			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaTicket",$Trama['TicketRespuesta'],$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaFecha",date("Y-m-d"),$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaHora",date("H:i:s"),$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaCodigo",$Trama['CodigoRespuesta'],$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaContenido",$Trama['MensajeRespuesta'],$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaBajaTiempoCreacion",date("Y-m-d H:i:s"),$Id,$Ta);
			
			$Observaciones = $InsFactura->FacSunatRespuestaObservacion;
			$Observaciones .= date("d/m/Y h:i:s")." - ".$Trama['MensajeRespuesta'].chr(13);
			
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaObservacion",$Observaciones,$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicket",(!empty($Trama['TicketRespuesta'])?$Trama['TicketRespuesta']:$InsFactura->FacSunatRespuestaTicket),$Id,$Ta);
			$InsFactura->MtdEditarFacturaDato("FacSunatRespuestaTicketEstado","",$Id,$Ta);

			
		}
	}
}


echo ($l_stResult);
?>