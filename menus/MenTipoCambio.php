<?php
//exit();
session_start();
require_once('../proyecto/ClsProyecto.php');
require_once('../proyecto/ClsPoo.php');

$InsPoo->Ruta = "../";
$InsProyecto->Ruta = "../";

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

require_once($InsPoo->MtdPaqContabilidad().'ClsTipoCambio.php');
?>

<?php
//if($_SESSION['SisTipoCambio']!=false){
?>
<?php

$InsTipoCambio = new ClsTipoCambio();
$InsTipoCambio->MonId = "MON-10001";
$InsTipoCambio->TcaFecha = date("Y-m-d");

$InsTipoCambio->MtdObtenerTipoCambioActual();

if(empty($InsTipoCambio->TcaId)){
	
	$InsTipoCambio->MtdObtenerTipoCambioUltimo();
	//if(empty($InsTipoCambio->TcaId)){
	//}
	//unset($InsTipoCambio);	
}
?>

<?php
if(!empty($InsTipoCambio->TcaId)){
?>	

	<table class="EstTablaTipoCambio" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
      <td align="left" valign="middle"><?php echo $InsTipoCambio->MonSimbolo;?></td>
      <td align="left" valign="middle"><span class="EstTipoCambioEtiqueta">Compra:</span></td>
      <td colspan="4" align="left" valign="middle"><?php echo $InsTipoCambio->TcaMontoCompra;?></td>
	</tr>
	<tr>
      <td width="27%" align="left" valign="middle"><?php echo $InsTipoCambio->MonSimbolo;?></td>
      <td width="14%" align="left" valign="middle"><span class="EstTipoCambioEtiqueta">Venta:</span></td>
      <td width="23%" align="left" valign="middle"><?php echo $InsTipoCambio->TcaMontoVenta;?></td>
      <td width="5%" align="left" valign="middle">&nbsp;</td>
      <td width="13%" align="left" valign="middle"><span class="EstTipoCambioEtiqueta">Comercial:</span></td>
      <td width="18%" align="left" valign="middle"><?php echo $InsTipoCambio->TcaMontoComercial;?></td>
	</tr>
	</table>

<?php	
	$_SESSION[$InsTipoCambio->MonId]['SisTipoCambioCompra'] = $InsTipoCambio->TcaMontoCompra;
	$_SESSION[$InsTipoCambio->MonId]['SisTipoCambioVenta'] = $InsTipoCambio->TcaMontoVenta; 
	$_SESSION[$InsTipoCambio->MonId]['SisTipoCambioComercial'] = $InsTipoCambio->TcaMontoComercial; 
}else{
?>
	<table class="EstTablaTipoCambio" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td align="right" valign="middle">No se pudo obtener el tipo de cambio</td>
	</tr>
	</table>
<?php	
}
?>


<?php
/*//}else{
?>
        <table class="EstTablaTipoCambio" width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td align="right" valign="middle">No se pudo obtener el tipo de cambio</td>
          </tr>
        </table>
<?php
//}*/
?>

