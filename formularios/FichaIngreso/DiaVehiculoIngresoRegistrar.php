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
      <td width="1%">&nbsp;</td>
      <td width="7%">&nbsp;</td>
      <td width="70%">&nbsp;</td>
      <td width="22%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>VIN: </td>
      <td><input name="CmpVIN" type="text" class="EstFormularioCaja" id="CmpVIN" value="<?php echo $InsVehiculoIngreso->EinVIN;?>" size="20" maxlength="40"  /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Marca:</td>
      <td><select class="EstFormularioCombo" name="CmpVehiculoMarca" id="CmpVehiculoMarca" >
        <option value="">Escoja una opcion</option>
        <?php
			foreach($ArrVehiculoMarcas as $DatVehiculoMarca){
			?>
        <option <?php echo $DatVehiculoMarca->VmaId;?> <?php echo ($DatVehiculoMarca->VmaId==$InsVehiculoIngreso->VmaId)?'selected="selected"':"";?> value="<?php echo $DatVehiculoMarca->VmaId?>"><?php echo $DatVehiculoMarca->VmaNombre?></option>
        <?php
			}
			?>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Modelo:</td>
      <td><select class="EstFormularioCombo" name="CmpVehiculoModelo" id="CmpVehiculoModelo">
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Version:</td>
      <td><select class="EstFormularioCombo" name="CmpVehiculoVersion" id="CmpVehiculoVersion">
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Color:</td>
      <td><input value="<?php echo $InsVehiculo->VehColor;?>"  class="EstFormularioCaja"  name="CmpColor" type="text" id="CmpColor" size="30" maxlength="50" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
   </div>
   