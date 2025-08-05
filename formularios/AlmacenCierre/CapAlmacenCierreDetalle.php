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


$POST_ProductoId = $_POST['ProductoId'];
$POST_Ano = (empty($_POST['Ano'])?date("Y"):$_POST['Ano']);
$POST_AlmacenId = $_POST['AlmacenId'];

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardex = new ClsKardex();

//$InsAlmacenStock->ProId = $POST_ProductoId;
//$InsAlmacenStock->MtdObtenerAlmacenStock();




?>

<table class="EstFormulario">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><span class="EstFormularioSubTitulo">Entradas</span></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Compras:</td>
  <td>
  <input name="CmpEntradasTotalCompras" type="text" class="EstFormularioCajaDeshabilitada" id="CmpEntradasTotalCompras" value="<?php echo $POST_EntradasCompras;?>" size="15" maxlength="20" readonly="readonly" />
  
  </td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Otras Fichas:</td>
  <td><input name="EntradasTotalOtrasFichas" type="text" class="EstFormularioCajaDeshabilitada" id="EntradasTotalOtrasFichas" value="<?php echo $POST_EntradasOtrasFichas;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Transferencias:</td>
  <td><input name="CmpEntradasTotalTransferencias" type="text" class="EstFormularioCajaDeshabilitada" id="CmpEntradasTotalTransferencias" value="<?php echo $POST_EntradasTransferencias;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Conversiones:</td>
  <td><input name="CmpEntradasTotalConversiones" type="text" class="EstFormularioCajaDeshabilitada" id="CmpEntradasTotalConversiones" value="<?php echo $POST_EntradasConversiones;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><span class="EstFormularioSubTitulo">Salidas</span></td>
  <td></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Fichas de Salida (O.T.) </td>
  <td><input name="CmpSalidasOrdenTrabajos" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSalidasOrdenTrabajos" value="<?php echo $POST_SalidasOrdenTrabajos;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Ventas Concretadas:</td>
  <td><input name="CmpSalidasTotalVentaConcretadas" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSalidasTotalVentaConcretadas" value="<?php echo $POST_SalidasVentaConcretadas;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Otras Fichas</td>
  <td><input name="CmpSalidasTotalOtrasFichas" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSalidasTotalOtrasFichas" value="<?php echo $POST_SalidasOtrasFichas;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Transferencias:</td>
  <td><input name="CmpSalidasTotalTransferencias" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSalidasTotalTransferencias" value="<?php echo $POST_SalidasTransferencias;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>Conversiones:</td>
  <td><input name="CmpSalidasTotalConversiones" type="text" class="EstFormularioCajaDeshabilitada" id="CmpSalidasTotalConversiones" value="<?php echo $POST_SalidasConversiones;?>" size="15" maxlength="20" readonly="readonly" /></td>
  <td></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
</tr>
</table>
