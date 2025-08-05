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
$Respuesta = "";

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');
//require_once($InsPoo->MtdPaqLogistica().'ClsClienteCategoria.php');
require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');

$InsCliente = new ClsCliente();

//Obteniendo datos de factura
$InsCliente->CliId = $GET_id;
$InsCliente->MtdObtenerCliente();


//190.117.111.8
$URL_LOCAL = "200.4.226.27";
$URL_REMOTO = "192.168.0.203:8080";
//$CARPETA = "SUNAT";
//$NOMBRE = $EmpresaCodigo."-01-".$InsCliente->FtaNumero."-".$InsCliente->FacId."";
//$ARCHIVO = $NOMBRE.".xml";

/*
* FACTURA ELECTRONICA
*/




$mensaje = "";
$mensaje .= "<br>";
$mensaje .= "<b>Estimados Se&ntilde;ores.-</b>";
$mensaje .= "<br>";
$mensaje .= "<b>".$InsCliente->CliNombre." ".$InsCliente->CliApellidoPaterno." ".$InsCliente->CliApellidoPaterno."</b>";
$mensaje .= "<br><br>";

$mensaje .= "Le informamos que para realizar la consulta y descarga de sus comprobantes ";
$mensaje .= "electronicos a traves de nuestro portal lo puede realizar con el siguiente enlace : <a target='_blank' href='".$SistemaUrl."/comprobantes/login.php'>".$SistemaUrl."/comprobantes/login.php</a>, ";
$mensaje .= "asi mismo le remitimos la <b>clave electronica</b> asignada para ser validado en el formulario de consulta.";

$mensaje .= "<br>";
$mensaje .= "<br>";
$mensaje .= "Clave Electronica asignada.";
$mensaje .= "<br>";
$mensaje .= "<h2>".$InsCliente->CliClaveElectronica."</h2>";

$mensaje .= "<br><br>";
$mensaje .= "Saludos";
$mensaje .= "<br><br>";
$mensaje .= "Gracias";
$mensaje .= "<br><br>";

$mensaje .= "<br>";
$mensaje .= "Mensaje autogenerado por SISCA a las ".date('d/m/Y H:i:s');

$Destinatarios .= "";
//$Destinatarios .= "lucaroink@hotmail.com,";
$Destinatarios .= $InsCliente->CliEmail.",";
$Destinatarios .= $InsCliente->CliEmail2.",";
$Destinatarios .= $InsCliente->CliEmail3.",";
$Destinatarios .= $InsCliente->CliEmailFacturacion."";

if(empty($InsCliente->CliEmailFacturacion)){
	
	if(empty($InsCliente->CliClaveElectronica)){
		$Respuesta = "3";
	}else{
		$Respuesta = "2";	
	}
	
	
}else{
	$Respuesta = "1";	
	
	$InsCorreo = new ClsCorreo();	
//	$InsCorreo->MtdEnviarCorreo($Destinatarios,"lucaroink.contabilidad@gmail.com","".$EmpresaNombre,"FACTURA: ".$InsCliente->FtaNumero."-".$InsCliente->FacId,$mensaje,"../../../generados/comprobantes/",array($NOMBRE.".pdf",$NOMBRE.".xml"),"trovastudios@gmail.com");
	$InsCorreo->MtdEnviarCorreo($Destinatarios,"sistema.automotriz.cisne@gmail.com","".$EmpresaNombre,"CLAVE ELECTRONICA: ".$InsCliente->CliNombre."".$InsCliente->CliApellidoPaterno."".$InsCliente->CliApellidoMaterno,$mensaje,"",NULL,"trovastudios@gmail.com");
	
}

$respuesta['CodigoRespuesta'] = $Respuesta;
$respuesta['MensajeRespuesta'] = "";

echo json_encode($respuesta);

?>