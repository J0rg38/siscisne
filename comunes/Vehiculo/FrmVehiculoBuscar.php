<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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
?>

<style type="text/css">
@import url('comunes/Vehiculo/css/CssVehiculo.css');
</style>

<div class="EstFormularioArea">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstFormulario">

<tr>
  <td>&nbsp;</td>
  <td width="709">B&uacute;squeda de Vehiculos</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="1" align="left">&nbsp;</td>
  <td align="left">
  

	<select name="CmpVehiculoCampo" id="CmpVehiculoCampo" class="EstFormularioCombo">
    </select>
    
    <select class="EstFormularioCombo" name="CmpVehiculoCondicion" id="CmpVehiculoCondicion">
      <option value="esigual">Es igual a</option>
      <option value="noesigual">No es igual a</option>
      <option value="comienza">Comienza por</option>
      <option value="termina">Termina con</option>
      <option value="contiene">Contiene</option>
      <option value="nocontiene">No Contiene</option>
      </select>
		
	<input name="CmpFiltro" type="text" class="EstFormularioCaja" id="CmpFiltro" size="45" maxlength="255" onkeyup="FncVehiculoFiltrar(event);" />    
    <a href="javascript:FncVehiculoFiltrar2();"><img border="0"  align="absmiddle" src="imagenes/buscar.gif" alt="[Buscar]" title="Buscar" width="20" height="20" /></a>
    
	</td>
  <td width="1" align="left">&nbsp;</td>
</tr>


<tr>
  <td>&nbsp;</td>
  <td><div class="EstCapVehiculos" id="CapVehiculos"></div></td>
  <td>&nbsp;</td>
</tr>
</table>


</div>


