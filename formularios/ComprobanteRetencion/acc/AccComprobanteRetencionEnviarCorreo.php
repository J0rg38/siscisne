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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

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

require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencion.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsComprobanteRetencionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');



$InsComprobanteRetencion = new ClsComprobanteRetencion();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsComprobanteRetencion->CrnId = $GET_id;
$InsComprobanteRetencion->CrtId = $GET_ta;
$InsComprobanteRetencion->MtdObtenerComprobanteRetencion();
//
//$InsComprobanteRetencion->CrnId=$InsComprobanteRetencion->CrnId;
//$InsComprobanteRetencion->CrnId=(string)(int)$InsComprobanteRetencion->CrnId;
//190.117.111.8
$URL_LOCAL = "200.4.226.27";
$URL_REMOTO = "192.168.0.203:8080";
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-01-".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_PDF = $NOMBRE.".pdf";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";

/*
* COMPROBANTE DE RETENCION ELECTRONICA
*/



$mensaje = "";
$mensaje .= "<br>";
$mensaje .= "<b>Estimados Se&ntilde;ores.-</b>";
$mensaje .= "<br>";
$mensaje .= "<b>".$InsComprobanteRetencion->CliNombre." ".$InsComprobanteRetencion->CliApellidoPaterno." ".$InsComprobanteRetencion->CliApellidoMaterno."</b>";
$mensaje .= "<br><br>";

$mensaje .= "Remitimos los archivos y la informacion correspondiente al comprobante electronico <b>".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId."</b> emitido con fecha <b>".$InsComprobanteRetencion->CrnFechaEmision."</b>";

$mensaje .= "<br><br>";
$mensaje .= "Saludos";
$mensaje .= "<br><br>";
$mensaje .= "Gracias";
$mensaje .= "<br><br>";

$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por SISCA a las ".date('d/m/Y H:i:s');

$Destinatarios = "";
$Destinatarios .= $InsComprobanteRetencion->CliEmail.",";
$Destinatarios .= $InsComprobanteRetencion->CliEmail2.",";
$Destinatarios .= $InsComprobanteRetencion->CliEmail3.",";
$Destinatarios .= $InsComprobanteRetencion->CliEmailComprobanteRetencioncion."";
$Destinatarios .= "jblanco@cyc.com.pe,";

if(empty($InsComprobanteRetencion->CliEmail) and empty($InsComprobanteRetencion->CliEmailComprobanteRetencioncion)){
	
	$Respuesta = "2";
	
}else{
	
	
	if(!file_exists("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF)){
		$Respuesta = "3";		
	}else if(!file_exists("../../../generados/comprobantes_fir/".$ARCHIVO_XML)){
		$Respuesta = "4";	
	}else if(!file_exists("../../../generados/comprobantes_cdr/".$ARCHIVO_CDR)){
		$Respuesta = "5";	
	}else{
		$Respuesta = "1";	
		$InsCorreo = new ClsCorreo();	
		$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"COMPROBANTE DE RETENCION: ".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId,$mensaje,"",array("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF,"../../../generados/comprobantes_fir/".$ARCHIVO_XML,"../../../generados/comprobantes_cdr/".$ARCHIVO_CDR));
	}
	
	
//	$Respuesta = "1";	
//	
//	$InsCorreo = new ClsCorreo();	
//	$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"COMPROBANTE DE RETENCION: ".$InsComprobanteRetencion->CrtNumero."-".$InsComprobanteRetencion->CrnId,$mensaje,"",array("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF,"../../../generados/comprobantes_fir/".$ARCHIVO_XML,"../../../generados/comprobantes_cdr/".$ARCHIVO_CDR));
//	
}

$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['MensajeRespuesta'] = "";

echo json_encode($respuesta);

?>