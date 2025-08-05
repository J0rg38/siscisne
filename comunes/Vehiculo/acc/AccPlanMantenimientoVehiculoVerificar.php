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


require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

$POST_VehiculoModeloId = $_POST['VehiculoModeloId'];



require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoTarea.php');

$InsPlanMantenimiento = new ClsPlanMantenimiento();

//deb($POST_VehiculoModeloId);
if(!empty($POST_VehiculoModeloId)){
	
	
	//MtdObtenerPlanMantenimientos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PmaId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL)
	$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',"1",NULL,NULL,$POST_VehiculoModeloId) ;
	$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
	
	$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
	unset($ArrPlanMantenimientos);
	
	$InsPlanMantenimiento->MtdObtenerPlanMantenimiento(false);
	
}

$InsPlanMantenimiento->InsMysql=NULL;

$json = new Services_JSON();
$var = $json->encode($InsPlanMantenimiento);

echo $var;

?>