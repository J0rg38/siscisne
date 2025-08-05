<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

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

<style type="text/css">
@import url('comunes/Proveedor/css/CssProveedor.css');
</style>


<div class="EstFormularioArea">

<table width="100%" border="0" cellpadding="2" cellspacing="1" class="EstFormulario">

<tr>
  <td>&nbsp;</td>
  <td width="98%">B&uacute;squeda de Proveedores
    <input type="hidden" name="Ruta" id="Ruta" value="<?php echo $_GET['Ruta']?>" />
    <input type="hidden" name="Tipo" id="Tipo" value="<?php echo $_GET['Tipo']?>" />
    
    </td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="left">&nbsp;</td>
  <td align="left">
  
  
  <!--<select name="CmpProveedorCampo" id="CmpProveedorCampo" class="EstFormularioCombo">
    <option value="PrvNombre">Nombre</option>
    <option value="PrvNumeroDocumento">Num. Documento</option>
    </select>    <select class="EstFormularioCombo" name="CmpProveedorCondicion" id="CmpProveedorCondicion">
      <option value="esigual">Es igual a</option>
      <option value="noesigual">No es igual a</option>
      <option value="comienza">Comienza por</option>
      <option value="termina">Termina con</option>
      <option selected="selected" value="contiene">Contiene</option>
      <option value="nocontiene">No Contiene</option>
      </select>  -->
      
      
      <input name="CmpFiltro" type="text" class="EstFormularioCaja" id="CmpFiltro" size="45" maxlength="255" onkeyup="FncProveedorFiltrar(event);" />
    <a href="javascript:FncProveedorFiltrar2();">
      <img border="0"  align="absmiddle" src="imagenes/buscar.gif" alt="[Buscar]" title="Buscar" width="20" height="20" /></a></td>
  <td width="1%" align="left">&nbsp;</td>
</tr>


<tr>
  <td>&nbsp;</td>
  <td><div class="EstCapProveedores" id="CapProveedores"></div></td>
  <td>&nbsp;</td>
</tr>
</table>


</div>
