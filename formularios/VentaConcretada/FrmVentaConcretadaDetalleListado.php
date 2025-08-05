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

$Identificador = $_POST['Identificador'];
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_Descuento = eregi_replace(",","",$_POST['Descuento']);
$POST_ManoObra = eregi_replace(",","",$_POST['ManoObra']);

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_AlmacenId = $_POST['AlmacenId'];

session_start();
if (!isset($_SESSION['InsVentaConcretadaDetalle'.$Identificador])){
	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = new ClsSesionObjeto();	
}



if(empty($POST_AlmacenId)){
	die("No ha escogido un almacen.");
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');


$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
$InsAlmacenProducto = new ClsAlmacenProducto();
$InsAlmacenStock = new ClsAlmacenStock();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecio
//				Parametro5 = VcdCantidad
//				Parametro6 = VcdImporte
//				Parametro7 = VcdTiempoCreacion
//				Parametro8 = VcdTiempoModificacion
//				Parametro9 = UmeNombre
//				Parametro10 = UmeId
//				Parametro11 = RtiId
//				Parametro12 = VcdCantidadReal
//				Parametro13 = ProCodigoOriginal,
//				Parametro14 = ProCodigoAlternativo
//				Parametro15 = UmeIdOrigen
//				Parametro16 = VerificarStock
//				Parametro17 = VcdCosto
//				Parametro18 = VddId
//				Parametro19 = AmdReemplazo
//				Parametro20 = ProCodigoOriginalReemplazo
//				Parametro21 = VcdReingreso

$RepSesionObjetos = $_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];

$Sucursal  = "";

if(!empty($POST_AlmacenId)){
	
	$InsAlmacen = new ClsAlmacen();
	$InsAlmacen->AlmId = $POST_AlmacenId;
	$InsAlmacen->MtdObtenerAlmacen();
	
	$Sucursal = $InsAlmacen->SucId;
	
}

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
  <th width="2%">Id</th>
  <th width="10%">Cod. Orig.</th>
  <th width="5%">Cod. Alt.</th>
<th width="20%"> Nombre
</th>
<th width="11%">U.M.</th>
<th width="6%">
  
  Precio</th>


<th width="6%">
  Cantidad</th>
<th width="6%">Importe </th>
<th width="8%">Stock</th>
<th width="9%">Estado</th>
<th width="9%">Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
//$TotalBruto = 0;
//$CantidadTotal = 0;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){
?>

<tr>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $c;?></span>

<input style="visibility:hidden;" checked="checked" etiqueta="detalle" type="checkbox" name="CmpVentaConcretadaDetalleItem_<?php echo $DatSesionObjeto->Item;?>" id="CmpVentaConcretadaDetalleItem_<?php echo $DatSesionObjeto->Item;?>" value="<?php echo $DatSesionObjeto->Item;?>"  />

</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">



<!--<?php echo $DatSesionObjeto->Parametro13;?>-->
  
 <a href="javascript:FncProductoConsultarCargar('<?php echo trim($DatSesionObjeto->Parametro2);?>');"><?php echo $DatSesionObjeto->Parametro13;?></a>


<?php
if($DatSesionObjeto->Parametro19 == "Si"){
?>
(<?php echo $DatSesionObjeto->Parametro20;?>)
<?php	
}
?>
<!--<a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>"   title=""> <img src="imagenes/almacen_stock.jpg" alt="[Stock]" width="20" height="20" border="0" align="absmiddle" title="Stock" /> </a>


-->


</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
<?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  

	<?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  
</td>

<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo number_format($DatSesionObjeto->Parametro5,2);?>
<br />
<span class="EstFormularioSubEtiqueta">
(<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)
</span>

   
</td>
<td align="right" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  
<?php
if(!empty($POST_AlmacenId)){
?>
 <?php


$StockReal = 0;


//MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen=NULL,$oAno=NULL)
//$StockReal = $InsAlmacenProducto->MtdObtenerAlmacenProductoStockActual($DatSesionObjeto->Parametro2,$POST_AlmacenId,date("Y"),$_SESSION['SesionSucursal']);
$StockReal = $InsAlmacenStock->MtdObtenerAlmacenStockProductoStockReal($Sucursal,$POST_AlmacenId,date("Y"),$DatSesionObjeto->Parametro2);


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
?>
    (<?php echo number_format($StockReal,2);?>)
    
    <!--  <?php if(!empty($DatSesionObjeto->Parametro22)){?>+ <b><?php echo number_format($DatSesionObjeto->Parametro22,2);?></b><?php }?>) 
    -->
    
    
    </a>
<?php	
}else{
	
?>
Debes escoger un almacen
<?php	
}
?>
 
 
  
</td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  
  <select  class="<?php echo (($DatSesionObjeto->Parametro24=="1")?'EstFormularioComboAnulado':'EstFormularioCombo');?>" name="CmpVentaConcretadaDetalleEstado_<?php echo $DatSesionObjeto->Item;?>" id="CmpVentaConcretadaDetalleEstado_<?php echo $DatSesionObjeto->Item;?>" <?php echo ($POST_Editar==2 or  $VentaConcretadaDetalleFacturado == "1" or $VentaConcretadaDetalleCierre == "1")?'disabled="disabled"':'';?>>
  <option value="">-</option>
  <option <?php echo (($DatSesionObjeto->Parametro24=="1")?'selected="selected"':'');?> value="1">Anulado</option>
  <option <?php echo (($DatSesionObjeto->Parametro24=="3")?'selected="selected"':'');?> value="3">Considerar</option>
  </select>
  
</td>
<td align="center" valign="top" class="<?php echo (($c%2==0)?'Activo':'Inactivo');?>">
  
  <?php

if($POST_Editar==1){
?>
  
  
  <a class="EstSesionObjetosItem" href="javascript:FncVentaConcretadaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  
  <?php
}
?>
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncVentaConcretadaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" > <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
	$TotalItems++;
	
	if($DatSesionObjeto->Parametro24=="3"){
		$TotalBruto += $DatSesionObjeto->Parametro6;
	}
	

$c++;
}


if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){

	$TotalBruto = $TotalBruto + $POST_ManoObra;
}


if($POST_IncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto - $POST_Descuento;
	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto - $POST_Descuento;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}

?>
</tbody>
</table>
<br />

<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">

<?php
if(!empty($POST_Descuento)){
?>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total"><!--Total Repuestos:-->
    <?php
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?>
    Mano de Obra:
  <?php	
}
?></td>
  <td align="right"><!--<span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> 
  
  <?php echo number_format($TotalRepuesto,2);?>-->
    <?php
if(!empty($POST_ManoObra) and $POST_ManoObra <> "0.00"){
?>
    <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_ManoObra,2);?>
    <?php	
}
?></td>
  </tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Descuento:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_Descuento,2);?></td>
</tr>
<?php	
}
?>



<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="64%" align="right" class="Total">SubTotal:</td>
  <td width="12%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Impuesto (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
</tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Total:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>
</tbody>
</table>

<?php
}
?>