<?php
session_start();
header('Content-Type: application/json');

////PRINCIPALES
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../../';
$InsProyecto->Ruta = '../../../';

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
////AUDITORIA
require_once($InsPoo->MtdPaqAcceso().'ClsAuditoria.php');

$POST_ClienteId = $_POST['ClienteId'];
$POST_ClienteCSIIncluir = $_POST['ClienteCSIIncluir'];
$POST_ClienteCSIExcluirMotivo = $_POST['ClienteCSIExcluirMotivo'];

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$resultado = 0;

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->CliCSIIncluir = $POST_ClienteCSIIncluir;

if($POST_ClienteCSIIncluir==1){
	
	$InsCliente->CliCSIExcluirMotivo = "";
	$InsCliente->CliCSIExcluirFecha = NULL;
	$InsCliente->CliCSIExcluirUsuario =  "";
}else{
	
	$InsCliente->CliCSIExcluirMotivo = (($POST_ClienteCSIExcluirMotivo=="undefined")?'':$POST_ClienteCSIExcluirMotivo);
	$InsCliente->CliCSIExcluirFecha = date("Y-m-d");	
	$InsCliente->CliCSIExcluirUsuario =  $_SESSION['SesionUsuario'];
}

$Resultado = array();


$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");

if($InsCliente->MtdEditarClienteCSIPostVenta()){
	$resultado = 1;	
}else{
	$resultado = 2;	
}

$Resultado['Respuesta'] = $resultado;
$Resultado['POST_ClienteCSIIncluir'] = $POST_ClienteCSIIncluir;
$Resultado['CliCSIExcluirFecha'] = FncCambiaFechaANormal($InsCliente->CliCSIExcluirFecha,true);
$Resultado['CliCSIExcluirMotivo'] = $InsCliente->CliCSIExcluirMotivo;
$Resultado['CliCSIExcluirUsuario'] = $InsCliente->CliCSIExcluirUsuario;

echo json_encode($Resultado);

?>