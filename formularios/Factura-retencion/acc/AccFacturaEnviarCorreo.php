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

require_once($InsPoo->MtdPaqContabilidad().'ClsFactura.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsFacturaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');



$InsFactura = new ClsFactura();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsFactura->FacId = $GET_id;
$InsFactura->FtaId = $GET_ta;
$InsFactura->MtdObtenerFactura();
//
//$InsFactura->FacId=$InsFactura->FacId;
//$InsFactura->FacId=(string)(int)$InsFactura->FacId;
//190.117.111.8
$URL_LOCAL = "200.4.226.27";
$URL_REMOTO = "192.168.0.203:8080";
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-01-".$InsFactura->FtaNumero."-".$InsFactura->FacId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_PDF = $NOMBRE.".pdf";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";

/*
* FACTURA ELECTRONICA
*/



$mensaje = "";
$mensaje .= "<br>";
$mensaje .= "<b>Estimados Se&ntilde;ores.-</b>";
$mensaje .= "<br>";
$mensaje .= "<b>".$InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno."</b>";
$mensaje .= "<br><br>";

$mensaje .= "Remitimos los archivos y la informacion correspondiente al comprobante electronico <b>".$InsFactura->FtaNumero."-".$InsFactura->FacId."</b> emitido con fecha <b>".$InsFactura->FacFechaEmision."</b>";

$mensaje .= "<br><br>";
$mensaje .= "Saludos";
$mensaje .= "<br><br>";
$mensaje .= "Gracias";
$mensaje .= "<br><br>";

$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por SISCA a las ".date('d/m/Y H:i:s');

$Destinatarios = "";
$Destinatarios .= $InsFactura->CliEmail.",";
$Destinatarios .= $InsFactura->CliContactoEmail1.",";
$Destinatarios .= $InsFactura->CliContactoEmail2.",";
$Destinatarios .= $InsFactura->CliContactoEmail3.",";
$Destinatarios .= $InsFactura->CliEmailFacturacion.",";
$Destinatarios .= $CorreosEnvioComprobanteElectronico;


if(empty($InsFactura->CliEmail) and empty($InsFactura->CliEmailFacturacion)){
	
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
		$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"FACTURA: ".$InsFactura->FtaNumero."-".$InsFactura->FacId,$mensaje,"",array("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF,"../../../generados/comprobantes_fir/".$ARCHIVO_XML,"../../../generados/comprobantes_cdr/".$ARCHIVO_CDR));
	}
	
	
//	$Respuesta = "1";	
//	
//	$InsCorreo = new ClsCorreo();	
//	$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"FACTURA: ".$InsFactura->FtaNumero."-".$InsFactura->FacId,$mensaje,"",array("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF,"../../../generados/comprobantes_fir/".$ARCHIVO_XML,"../../../generados/comprobantes_cdr/".$ARCHIVO_CDR));
//	
}

$respuesta['CliContactoEmail1'] = $InsFactura->CliContactoEmail1;
$respuesta['CliContactoEmail2'] = $InsFactura->CliContactoEmail2;
$respuesta['CliContactoEmail3'] = $InsFactura->CliContactoEmail3;
$respuesta['CliEmailFacturacion'] = $InsFactura->CliEmailFacturacion;

$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['MensajeRespuesta'] = "";

echo json_encode($respuesta);

?>