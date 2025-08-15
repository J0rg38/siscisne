<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');





$Identificador = $_POST['Identificador'];
$POST_Descuento = (empty($_POST['Descuento'])?0:preg_replace("/,/", "", $_POST['Descuento']));
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador])){
	$_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador] = new ClsSesionObjeto();	
}


require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();

//	SesionObjeto-TrasladoAlmacenSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	
	

$RepSesionObjetos = $_SESSION['InsTrasladoAlmacenSalidaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>

<?php
if(empty($ArrSesionObjetos)){
?>
No se encontraron elementos
<?php
}else{
?>
<!--Se encontraron <?php echo $SesionObjetosTotalSeleccionado;?> elemento(s)-->
<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead class="EstTablaListadoHead">
<tr>
  <th width="2%">#</th>
  <th width="4%">Id</th>
  <th width="9%">Cod. Orig.</th>
  <th width="11%">Cod. Alt.</th>
  <th width="48%"> Nombre
</th>
<th width="6%">U.M.</th>
<th width="6%">
  Cantidad</th>
<th width="6%">Stock</th>
<th width="8%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $c;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
<?php echo $DatSesionObjeto->Parametro2;?>
</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  <?php echo $DatSesionObjeto->Parametro3;?>
  
  <!--(<?php echo $DatSesionObjeto->Parametro16;?>)--></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <span title="<?php echo $DatSesionObjeto->Parametro10;?>"><?php echo $DatSesionObjeto->Parametro9;?></span>
  
</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <?php echo number_format($DatSesionObjeto->Parametro5,3);?><br />
 <span class="EstFormularioSubEtiqueta"> (<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)</span>
</td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <?php


$StockReal = 0;

//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen,$oAno)
$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);

$InsUnidadMedida->UmeId = $DatSesionObjeto->Parametro10;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

$CantidadReal = round($DatSesionObjeto->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

if($StockReal < $CantidadReal){		
	$VerificarStock = 1;
}

?>
  
  <a href="javascript:FncAlmacenStockConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');">
    <?php
//if($DatSesionObjeto->Parametro16 == 1){
if($VerificarStock == 1){
?>
    <span style="color:#F00; font-weight:bold;">SIN STOCK </span>
    <?php	
}else{
?>
    EN STOCK 
    <?php	
}
?><br />
    (<?php echo number_format($StockReal,2);?>)
    
<!--    <?php if(!empty($DatSesionObjeto->Parametro18)){?>+ <b><?php echo number_format($DatSesionObjeto->Parametro18,2);?></b><?php }?>-->
 
    </a>
  

</td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <?php
if($_POST['Editar']==1){
?>
  
  
  <a class="EstSesionObjetosItem" href="javascript:FncTrasladoAlmacenSalidaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  
  <?php
}
?>
  
  <?php
if($_POST['Eliminar']==1){
?>
  <a href="javascript:FncTrasladoAlmacenSalidaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
  <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?>
  
  
</td>
</tr>
<?php
	$TotalBruto += $DatSesionObjeto->Parametro6;

$c++;
}





?>
</tbody>
</table>


<?php
}
?>