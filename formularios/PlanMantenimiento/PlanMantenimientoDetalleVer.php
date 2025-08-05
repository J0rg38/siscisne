<?php

session_start();
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
?>

<?php
$GET_PlanMantenimientoId = $_POST['PlanMantenimientoId'];
$GET_PlanMantenimientoDetalleId = $_POST['PlanMantenimientoDetalleId'];

require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');

$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoDetalle->PmdId = $GET_PlanMantenimientoDetalleId;
$InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalle();
?>

<?php
if($InsPlanMantenimientoDetalle->PmdAccion<>"X"){
?>
    <a   href="javascript:FncPlanMantenimientoDetalleCargarFormulario('Editar','<?php echo $InsPlanMantenimientoDetalle->PmdId;?>','<?php echo $InsPlanMantenimientoDetalle->PmaId;?>');">
    <?php echo ($InsPlanMantenimientoDetalle->PmdAccion);?>
    </a>
<?php	
}else{
?>
    <a   href="javascript:FncPlanMantenimientoDetalleCargarFormulario('Editar','<?php echo $InsPlanMantenimientoDetalle->PmdId;?>','<?php echo $InsPlanMantenimientoDetalle->PmaId;?>');">
    -
    </a>
<?php	
}
?>

