<?php
session_start();
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
$POST_ClienteCSIVentaIncluir = $_POST['ClienteCSIVentaIncluir'];
$POST_ClienteCSIVentaExcluirMotivo = $_POST['ClienteCSIVentaExcluirMotivo'];

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$resultado = 0;

$InsCliente = new ClsCliente();
$InsCliente->CliId = $POST_ClienteId;
$InsCliente->CliCSIVentaIncluir = $POST_ClienteCSIVentaIncluir;
$InsCliente->CliCSIVentaExcluirMotivo = (($POST_ClienteCSIVentaExcluirMotivo=="undefined")?'':$POST_ClienteCSIVentaExcluirMotivo);
$InsCliente->CliCSIVentaExcluirUsuario =  $_SESSION['SesionUsuario'];

$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");

if($InsCliente->MtdEditarClienteCSIVenta()){
	$resultado = 1;	
}else{
	$resultado = 2;	
}

//$InsCliente->MtdEditarClienteDato("CliCSIVentaIncluir",$POST_ClienteCSIVentaIncluir,$POST_ClienteId);
//$InsCliente->MtdEditarClienteDato("CliCSIVentaExcluirMotivo","",$POST_ClienteId);

/*if($POST_ClienteCSIVentaIncluir == 2){
	$InsCliente->MtdEditarClienteDato("CliCSIVentaExcluirMotivo",(($POST_ClienteCSIVentaExcluirMotivo=="undefined")?'':$POST_ClienteCSIVentaExcluirMotivo),$POST_ClienteId);
}else{
	$InsCliente->MtdEditarClienteDato("CliCSIVentaExcluirMotivo","",$POST_ClienteId);
}*/
?>

