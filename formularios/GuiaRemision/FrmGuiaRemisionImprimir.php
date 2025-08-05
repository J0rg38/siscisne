<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');
$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';
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

$GET_id = $_GET['Id'];
$GET_ta = $_GET['Ta'];
$GET_TiempoImpresion = $_GET['TiempoImpresion'];

require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemision.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionDetalle.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionTalonario.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsGuiaRemisionAlmacenMovimiento.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');

$InsGuiaRemision = new ClsGuiaRemision();
$InsGuiaRemisionTalonario = new ClsGuiaRemisionTalonario();

$InsGuiaRemision->GreId = $GET_id;
$InsGuiaRemision->GrtId = $GET_ta;
$InsGuiaRemision->MtdObtenerGuiaRemision();

if(file_exists("ImpGuiaRemisionImprimir".$InsGuiaRemision->GrtNumero.".php")){
	
	
}else{
	
	$InsGuiaRemisionTalonario = new ClsGuiaRemisionTalonario();
	$InsGuiaRemisionTalonario->GrtId = $InsGuiaRemision->GrtId;
	$InsGuiaRemisionTalonario->MtdObtenerGuiaRemisionTalonario();		
	
	if(substr($InsGuiaRemisionTalonario->GrtNumero,0,1)=="G" or substr($InsGuiaRemisionTalonario->GrtNumero,0,1)=="E"){
		
		header("Location: FrmGuiaRemisionGenerarPDF.php?Id=".$InsGuiaRemision->GreId."&Ta=".$InsGuiaRemision->GrtId."&ImprimirCodigo=1");
		die();

	}else{
		
		echo "No se encontro formato para esta serie";		
		
	}

}


//include("ImpGuiaRemisionImprimir1.php");
?>