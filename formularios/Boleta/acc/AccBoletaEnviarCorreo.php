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

require_once($InsPoo->MtdPaqContabilidad().'ClsBoleta.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaAlmacenMovimiento.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsBoletaDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsResumenBaja.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');



$InsBoleta = new ClsBoleta();
$InsMoneda = new ClsMoneda();
$InsTipoCambio = new ClsTipoCambio();

//Obteniendo datos de factura
$InsBoleta->BolId = $GET_id;
$InsBoleta->BtaId = $GET_ta;
$InsBoleta->MtdObtenerBoleta();
//
//$InsBoleta->BolId=$InsBoleta->BolId;
//$InsBoleta->BolId=(string)(int)$InsBoleta->BolId;
//190.117.111.8
$URL_LOCAL = "200.4.226.27";
$URL_REMOTO = "192.168.0.203:8080";
$CARPETA = "SUNAT";
$NOMBRE = $EmpresaCodigo."-03-".$InsBoleta->BtaNumero."-".$InsBoleta->BolId."";
$ARCHIVO_XML = $NOMBRE.".xml";
$ARCHIVO_PDF = $NOMBRE.".pdf";
$ARCHIVO_CDR = "R-".$NOMBRE.".zip";

/*
* BOLETA ELECTRONICA
*/



$mensaje = "";
$mensaje .= "<br>";
$mensaje .= "<b>Estimados Se&ntilde;ores.-</b>";
$mensaje .= "<br>";
$mensaje .= "<b>".$InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno."</b>";
$mensaje .= "<br><br>";

$mensaje .= "Remitimos los archivos y la informacion correspondiente al comprobante electronico <b>".$InsBoleta->BtaNumero."-".$InsBoleta->BolId."</b> emitido con fecha <b>".$InsBoleta->BolFechaEmision."</b>";

$mensaje .= "<br><br>";
$mensaje .= "Saludos";
$mensaje .= "<br><br>";
$mensaje .= "Gracias";
$mensaje .= "<br><br>";

$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por SISCA a las ".date('d/m/Y H:i:s');

$Destinatarios = "";
$Destinatarios .= $InsBoleta->CliEmail.",";
$Destinatarios .= $InsBoleta->CliContactoEmail1.",";
$Destinatarios .= $InsBoleta->CliContactoEmail2.",";
$Destinatarios .= $InsBoleta->CliContactoEmail3.",";
$Destinatarios .= $InsBoleta->CliEmailFacturacion.",";
$Destinatarios .= $CorreosEnvioComprobanteElectronico;

if(empty($InsBoleta->CliEmail) and empty($InsBoleta->CliEmailBoletacion)){
	
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
		$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"BOLETA: ".$InsBoleta->BtaNumero."-".$InsBoleta->BolId,$mensaje,"",array("../../../generados/comprobantes_pdf/".$ARCHIVO_PDF,"../../../generados/comprobantes_fir/".$ARCHIVO_XML,"../../../generados/comprobantes_cdr/".$ARCHIVO_CDR));
	}
	
	
}

$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['MensajeRespuesta'] = "";

echo json_encode($respuesta);

?>