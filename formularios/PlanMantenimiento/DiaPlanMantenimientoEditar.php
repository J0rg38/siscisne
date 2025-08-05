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

	
require_once($InsPoo->MtdPaqActividad().'ClsPlanMantenimientoDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');


$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
$InsPlanMantenimientoDetalle->PmaId = $_GET['PmaId'];
$InsPlanMantenimientoDetalle->PmdId = $_GET['PmdId'];
$InsPlanMantenimientoDetalle->MtdObtenerPlanMantenimientoDetalle();

//if(empty($InsPlanMantenimientoDetalle->PmdId)){
//
//	$InsPlanMantenimientoDetalle->PmtId = $_GET['PmtId'];
//	$InsPlanMantenimientoDetalle->PmaId = $_GET['PmaId'];
//	$InsPlanMantenimientoDetalle->PmdKilometraje = $_GET['Kilometraje'];
//	$InsPlanMantenimientoDetalle->PmdCantidad = (empty($_SESSION['PmdCantidad'])?1:$_SESSION['PmdCantidad']);
//	$InsPlanMantenimientoDetalle->ProId = (empty($_SESSION['ProId'])?"":$_SESSION['ProId']);
//	$InsPlanMantenimientoDetalle->UmeId = (empty($_SESSION['UmeId'])?"UME-10007":$_SESSION['UmeId']);
//	
//	//$InsPlanMantenimientoDetalle->UmeId = "UME-10007";
//	
//}



?>
<?php
if($_POST['BtnEnviar']){

	$InsPlanMantenimientoDetalle->PmdId = $_POST['CmpId'];	
	$InsPlanMantenimientoDetalle->PmaId = $_POST['CmpPlanMantenimientoId'];	
	$InsPlanMantenimientoDetalle->PmtId = $_POST['CmpPlanMantenimientoTareaId'];
	$InsPlanMantenimientoDetalle->PmdAccion = $_POST['CmpAccion'];
	$InsPlanMantenimientoDetalle->PmdKilometraje = $_POST['CmpKilometraje'];

	if(!empty($InsPlanMantenimientoDetalle->PmdId)){
		$InsPlanMantenimientoDetalle->MtdEditarPlanMantenimientoDetalle();
	}else{
		$InsPlanMantenimientoDetalle->MtdRegistrarPlanMantenimientoDetalle();
			
	}
	
}
?>
<form method="post">

<table>
  <tr>
    <td>Id</td>
    <td><input type="text" name="CmpId" id="CmpId" value="<?php echo $InsPlanMantenimientoDetalle->PmdId;?>" /></td>
  </tr>

  <tr>
    <td>Plan de Mantenimiento</td>
    <td><input type="text" name="CmpPlanMantenimientoId" id="CmpPlanMantenimientoId" value="<?php echo $InsPlanMantenimientoDetalle->PmaId;?>" /></td>
  </tr>
  <tr>
    <td>Tarea:</td>
    <td><input name="CmpPlanMantenimientoTareaId" type="text" id="CmpPlanMantenimientoTareaId" value="<?php echo $InsPlanMantenimientoDetalle->PmtId?>" size="10" /></td>
  </tr>
  <tr>
  <td>Accion:</td>
  <td><?php echo $InsPlanMantenimientoDetalle->PmdAccion;?>
  <input name="CmpAccion" type="text" id="CmpAccion" value="<?php echo $InsPlanMantenimientoDetalle->PmdAccion?>" size="10" />
  </td>
</tr>


<tr>
  <td>Kilometraje.</td>
  <td><input type="text" name="CmpKilometraje" id="CmpKilometraje" value="<?php echo $InsPlanMantenimientoDetalle->PmdKilometraje;?>" /></td>
</tr>
<tr>
  <td colspan="2" align="center"><input type="submit" name="BtnEnviar" id="BtnEnviar" value="Enviar" /></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

</table>

</form>
<?php
if(!empty($ArrPlanMantenimientoDetalles)){
?>

<?php
foreach($ArrPlanMantenimientoDetalles as $DatPlanMantenimientoDetalle){
?>
	<?php echo $DatPlanMantenimientoDetalle->PmdId?>
<?php	
}
?>

<?php	
}else{
?>

<?php	
}
?>
