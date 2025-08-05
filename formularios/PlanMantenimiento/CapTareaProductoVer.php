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
$GET_Id = $_POST['Id'];
$GET_PlanMantenimientoId = $_POST['PlanMantenimientoId'];
$GET_PlanMantenimientoTareaId = $_POST['PlanMantenimientoTareaId'];
$GET_PlanMantenimientoDetalleId = $_POST['PlanMantenimientoDetalleId'];
$GET_PlanMantenimientoDetalleKilometraje = $_POST['PlanMantenimientoDetalleKilometraje'];
$GET_PlanMantenimientoDetalleAccion = $_POST['PlanMantenimientoDetalleAccion'];
$GET_TareaProductoId = $_POST['TareaProductoId'];

require_once($InsPoo->MtdPaqActividad().'ClsTareaProducto.php');

$InsTareaProducto = new ClsTareaProducto();
$InsTareaProducto->TprId = $GET_TareaProductoId;
$InsTareaProducto->MtdObtenerTareaProducto();
?>





<?php
if(empty($InsTareaProducto->TprId )){
?>


    <a   href="javascript:FncTareaProductoCargarFormulario('Registrar','','<?php echo $GET_PlanMantenimientoDetalleId;?>','<?php echo $GET_PlanMantenimientoId;?>','<?php echo $GET_PlanMantenimientoTareaId;?>','<?php echo $GET_PlanMantenimientoDetalleKilometraje;?>');">
    <?php echo (($GET_PlanMantenimientoDetalleAccion=="X")?'':$GET_PlanMantenimientoDetalleAccion);?>
    </a>
    
<?php	
}else{
?>


<span style="font-size:6px;"><?php echo $InsTareaProducto->TprId;?></span><br />
<span style="font-size:8px; color:#F00;"><?php echo $InsTareaProducto->ProCodigoOriginal;?></span><br />
<span style="font-size:8px;"><?php echo $InsTareaProducto->ProNombre;?></span><br />
<span style="font-size:8px; color:#03F;"><?php echo $InsTareaProducto->TprCantidad;?></span><br />
<span style="font-size:8px; color:#0C3;"><?php echo $InsTareaProducto->UmeNombre;?></span><br />



    <a   href="javascript:FncTareaProductoCargarFormulario('Editar','<?php echo $InsTareaProducto->TprId;?>','<?php echo $GET_PlanMantenimientoDetalleId;?>','<?php echo $GET_PlanMantenimientoId;?>','<?php echo $GET_PlanMantenimientoTareaId;?>','<?php echo $GET_PlanMantenimientoDetalleKilometraje;?>');">
    <?php echo (($GET_PlanMantenimientoDetalleAccion=="X")?'':$GET_PlanMantenimientoDetalleAccion);?>
    </a>
    
<?php
}
?>

