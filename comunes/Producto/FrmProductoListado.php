<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');

$InsProducto = new ClsProducto();
// MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1)
$ResProducto = $InsProducto->MtdObtenerProductos($_POST['Campo'],$_POST['Condicion'],$_POST['Filtro'],"ProNombre","ASC",NULL,1,$_POST['ProductoTipo'],NULL);
$ArrProductos = $ResProducto['Datos'];
$ProductosTotal = $ResProducto['Total'];

?>

<?php
if(empty($ArrProductos)){
?>
No se encontraron elementos
<?php
}else{
?>
Se encontraron <?php echo $ProductosTotal;?> elemento(s)
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="7%">C&oacute;digo</th>
  <th width="14%">Cod. Alternativo</th>
  <th width="13%">Cod. Original</th>
  <th width="38%">
    Nombre</th>
  <th width="6%"> U.M.</th>
<th width="4%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
foreach($ArrProductos as $DatProductos){
?>
<tr>
<td align="center"><?php echo $c;?></td>
<td align="right"><?php echo $DatProductos->ProId;?></td>
<td align="right"><?php echo $DatProductos->ProCodigoAlternativo;?></td>
<td align="right"><?php echo $DatProductos->ProCodigoOriginal;?></td>
<td align="right">
  <?php echo $DatProductos->ProNombre;?></td>
<td align="right">
  <?php echo $DatProductos->ProUnidadMedida;?></td>
<td align="center">
  
  
  <a class="EstProductosItem" href="javascript:FncProductoEscoger('<?php echo $DatProductos->ProId;?>','<?php echo $DatProductos->ProNombre;?>','<?php echo $DatProductos->ProPrecio;?>','<?php echo $DatProductos->ProCosto;?>','','','<?php echo $DatProductos->RtiId;?>','<?php echo $DatProductos->UmeId;?>','<?php echo $DatProductos->ProCodigoOriginal;?>','<?php echo $DatProductos->ProCodigoAlternativo;?>');">
  <img border="0"  align="absmiddle" src="imagenes/escoger.gif" alt="[Escoger]" title="Escoger" width="15" height="15"  /></a>
  
  
</td>
</tr>
<?php
$c++;
}
?>
</tbody>
</table>

<?php
}
?>

