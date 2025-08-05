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

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipo.php');

$InsProductoTipo = new ClsProductoTipo();

$RepProductoTipo = $InsProductoTipo->MtdObtenerProductoTipos(NULL,NULL,'RtiNombre',"ASC",NULL);
$ArrProductoTipos = $RepProductoTipo['Datos'];

?>


<style type="text/css">
@import url('comunes/Producto/css/CssProducto.css');
</style>


<div class="EstFormularioArea"> 
<div id="ForBuscadorProductos"  >
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="EstFormulario">
    <tr>
      <td>&nbsp;</td>
      <td><span class="EstFormularioSubTitulo"> Buscador
      </span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tipo de Producto: 
        <select class="EstFormularioCombo" onchange="FncProductoListar2();" id="CmpProductoTipos" name="CmpProductoTipos">
        <option value = "0">Todos</option>
       <?php
			foreach($ArrProductoTipos as $DatProductoTipo){
			?>
                <option <?php echo $DatProductoTipo->RtiId;?> value="<?php echo $DatProductoTipo->RtiId?>"><?php echo $DatProductoTipo->RtiNombre?></option>
                <?php
			}
			?>
        
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><select class="EstFormularioCaja"  name="CmpProductoCampo" id="CmpProductoCampo">
        <option value="ProId" >Codigo</option>
        <option value="ProCodigoAlternativo" >Cod. Alternativo</option>
        <option value="ProCodigoOriginal" >Cod. Original</option>
        <option value="ProNombre" selected="selected">Nombre</option>
      </select>
        <select class="EstFormularioCombo" name="CmpProductoCondicion" id="CmpProductoCondicion">
          <option value="esigual">Es igual a</option>
          <option value="noesigual">No es igual a</option>
          <option value="comienza">Comienza por</option>
          <option value="termina">Termina con</option>
          <option selected="selected" value="contiene">Contiene</option>
          <option value="nocontiene">No Contiene</option>
        </select>
<input onkeyup="FncProductoListar(event);" class="EstFormularioCaja" type="text" id="CmpProductoFiltro" name="CmpProductoFiltro" size="50"  />
		<a href="javascript:FncProductoListar2();">
        <img border="0"  align="absmiddle" src="imagenes/buscar.gif" alt="[Buscar]" title="Buscar" width="20" height="20" /></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div class="EstCapProductos" id="CapProductos"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   