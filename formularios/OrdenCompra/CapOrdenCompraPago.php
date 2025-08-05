<?php
session_start();
////PRINCIPALES
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$POST_ClienteId = $_POST['ClienteId'];

require_once($InsPoo->MtdPaqLogistica().'ClsCliente.php');

$InsCliente = new ClsCliente();

$InsCliente->CliId = $POST_ClienteId;
$InsCliente->MtdObtenerCliente();

?>


<?php
if($InsCliente->CliCSIIncluir == 2){
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<input class="EstFormularioCaja" type="text" maxlength="500" size="30" name="CapClienteCSIExcluirMotivo_<?php echo $InsCliente->CliId;?>" id="CapClienteCSIExcluirMotivo_<?php echo $InsCliente->CliId;?>" value="<?php echo $InsCliente->CliCSIExcluirMotivo;?>" />
</td>
<td>

	<input type="button" name="BtnGuardar_<?php echo $InsCliente->CliId;?>" id="BtnGuardar_<?php echo $InsCliente->CliId;?>" value="Guardar" onclick="FncClienteCSIEditarAccion('<?php echo $InsCliente->CliId;?>');" />
</td>
</tr>
</table>    
<?php	
}else{
?>
-
<?php	
}
?>