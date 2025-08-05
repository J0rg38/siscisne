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

require_once($InsProyecto->MtdRutLibrerias().'JSON2.php');

require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');

$POST_PlanMantenimientoId = $_POST['PlanMantenimientoId'];
$POST_MantenimientoKilometraje = $_POST['MantenimientoKilometraje'];
$POST_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];

$InsTareaProducto = new ClsTareaProducto();
$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL,NULL,NULL,'TprId','Desc',NULL,$POST_PlanMantenimientoId,$POST_Kilometraje,$POST_PlanMantenimientoTareaId);
$ArrTareaProductos = $ResTareaProducto['Datos'];

//$TprId = "";
//foreach($ArrTareaProductos as $DatTareaProducto){
//	$TprId =  $DatTareaProducto->TprId;
//}

$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
unset($ArrTareaProductos);
$InsTareaProducto->MtdObtenerTareaProducto();
$InsTareaProducto->TprCantidad = round($InsTareaProducto->TprCantidad,2);

$InsTareaProducto->InsMysql=NULL;
//$json = new JSON;
//$var = $json->serialize( $InsProducto );
//$json->unserialize( $var );
$json = new Services_JSON();
echo $json->encode($InsTareaProducto);
?>