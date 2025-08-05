<?php
//header('Content-type: text/json');
//header('Content-type: application/json');

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

require_once($InsProyecto->MtdRutLibrerias().'JSON.php');
require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimiento.php');

//$POST_PlanMantenimientoId = $_POST['PlanMantenimientoId'];
$POST_MantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
$POST_VehiculoModeloId = $_POST['VehiculoModeloId'];
$POST_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];

$InsTareaProducto = new ClsTareaProducto();
$InsPlanMantenimiento = new ClsPlanMantenimiento();

$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL,NULL,NULL,'PmaId','ASC',1,NULL,NULL,$POST_VehiculoModeloId);
$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];
							
$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
unset($ArrPlanMantenimientos);
$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

//$InsPlanMantenimiento->PmaId = $POST_PlanMantenimientoId
//$InsPlanMantenimiento
// public function MtdObtenerTareaProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oTarea=NULL) {
	
//deb($InsPlanMantenimiento->PmaChevroletKilometrajes['90']['eq']);

//deb($InsPlanMantenimiento->PmaChevroletKilometrajes);

//deb($InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq']);
$InsTareaProducto = new ClsTareaProducto();
$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$InsPlanMantenimiento->PmaId,$InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$POST_MantenimientoKilometraje]['eq'],$POST_PlanMantenimientoTareaId);
$ArrTareaProductos = $ResTareaProducto['Datos'];

$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
unset($ArrTareaProductos);
$InsTareaProducto->MtdObtenerTareaProducto();
$InsTareaProducto->InsMysql=NULL;


$json = new JSON;
//$var = $json->serialize( $ArrTareaProductos );
$var = $json->serialize( $InsTareaProducto );
$json->unserialize( $var );
echo $var;
	
?>