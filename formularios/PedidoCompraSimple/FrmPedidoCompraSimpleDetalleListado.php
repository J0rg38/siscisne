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
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_OrdenCompraId = $_POST['OrdenCompraId'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];

$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_VerEstado = $_POST['VerEstado'];

session_start();
if (!isset($_SESSION['InsPedidoCompraDetalle'.$Identificador])){
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProductoDisponibilidad.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
$InsProductoListaPrecio = new ClsProductoListaPrecio();
$InsProductoReemplazo = new ClsProductoReemplazo();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();
	
/*
SesionObjeto-PedidoCompraDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = PcdCantidad
Parametro6 = PcdImporte
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado


Parametro27 = PleFecha
Parametro28 = PldCantidad

Parametro34 = PcdObservacion
*/		

$RepSesionObjetos = $_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


//deb($ArrSesionObjetos);
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
  <th width="4%">Cod. Orig.</th>
  <th width="5%">Cod. Alt.</th>
  <th width="6%">Cod. Proveedor</th>
  <th width="27%"> Nombre</th>
  <th width="6%">U.M.</th>
  <th width="7%">Precio</th>
  <th width="8%"> Cantidad</th>
  <th width="7%">Importe</th>
  <th width="3%">Obs.</th>
  <th width="7%">Estado</th>
  <th width="5%">Stk.</th>
  <?php
if($POST_VerEstado==1){
?>
  <?php
}
?>
  <th> Acc.</th>
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

<?php
if($POST_VerEstado == 1){
?>

	<?php
	if(empty($DatSesionObjeto->Parametro23)){
		$fondo = "#F30";
	}else if($DatSesionObjeto->Parametro23 >= $DatSesionObjeto->Parametro5){
		$fondo = "#6F3";
	}else if($DatSesionObjeto->Parametro23 < $DatSesionObjeto->Parametro5){
		$fondo = "#FC0";		
	}else{
		$fondo = "";	
	}
	?>
    
<?php
}else{
	$fondo = "";	
}
?>


<?php	
	
//	if($InsMoneda->MonId<>$EmpresaMonedaId){
//	
//		$DatSesionObjeto->Parametro6 = round($DatSesionObjeto->Parametro6 / $POST_TipoCambio,2);
//		$DatSesionObjeto->Parametro4 = round($DatSesionObjeto->Parametro4  / $POST_TipoCambio,2);
//		
//	}
//	
?>

<tr>
<td align="right" bgcolor="<?php echo $fondo;?>">
<span title="<?php echo $DatSesionObjeto->Parametro1;?>">
<?php echo $c;?>
</span>
</td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro2;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
  
  <?php echo $DatSesionObjeto->Parametro13;?>
  
  <a target="_blank" href="principal.php?Mod=Producto&Form=Consulta&ProCodigoOriginal=<?php echo $DatSesionObjeto->Parametro13;?>"   title=""> <img src="imagenes/producto_consulta.jpg" alt="[Producto]" width="20" height="20" border="0" align="absmiddle" title="Producto " /> </a>
  
</td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro14;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
  <?php echo $DatSesionObjeto->Parametro3;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo $DatSesionObjeto->Parametro9;?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td align="right" bgcolor="<?php echo $fondo;?>">
	
	    <?php echo number_format($DatSesionObjeto->Parametro5,3);?>


</td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo number_format($DatSesionObjeto->Parametro6,2);?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php echo ($DatSesionObjeto->Parametro34);?></td>
<td align="right" bgcolor="<?php echo $fondo;?>"><?php
switch($DatSesionObjeto->Parametro26){

	case "3":
?>
  Considerar
  <?php
	break;
	

	
	case "6":
?>
  Anulado
  <?php
	break;
	
	
	default:
?>
  -
  <?php
	break;
}
?></td>
<td align="center" >
  
  
  
  
  
  
  <?php
$InsProducto = new ClsProducto();
$InsProducto->ProId = $DatSesionObjeto->Parametro2;
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedida->UmeId = $DatSesionObjeto->Parametro10;
$InsUnidadMedida->MtdObtenerUnidadMedida();

$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];

	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

$CantidadReal = round($DatSesionObjeto->Parametro5 * $InsUnidadMedidaConversion->UmcEquivalente,6);

//deb($InsUnidadMedidaConversion->UmcEquivalente);

//deb($InsProducto->ProStockReal." - ".$CantidadReal);

if($InsProducto->ProStockReal < $CantidadReal){		
	$VerificarStock = 1;
}
	
?>
  
  
  <a href="javascript:FncAlmacenStockConsultarCargar('<?php echo $DatSesionObjeto->Parametro2;?>');">
    
    <!--
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatCotizacionProductoDetalle->Parametro2;?>">-->
    <?php
if($VerificarStock == 1){
?>
    <span style="color:#F00; font-weight:bold;">SIN STOCK</span>
    <?php	
}else{
?>
    EN STOCK
    <?php	
}
?>
    </a>
  (<?php echo number_format($InsProducto->ProStockReal,2);?>)
  
  
</td>

<?php
if($POST_VerEstado==1){
?>
<?php
}
?>
<td width="9%" align="center">  
  
  <?php
	if($POST_Editar==1){
?>
  <a class="EstSesionObjetosItem" href="javascript:FncPedidoCompraDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
  <?php
}
?>
  
  <?php
if($POST_Eliminar==1){
?>
  <a href="javascript:FncPedidoCompraDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
    <img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>
  <?php
}
?></td>
</tr>
<?php
	$TotalItems++;
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;

$c++;
}



if($POST_IncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($POST_PorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

}
?>
</tbody>
</table>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Sub Total:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
  </tr>
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Impuesto (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
  </tr>
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="64%" align="right" class="Total">Total:</td>
  <td width="12%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
</tr>
</tbody>
</table>

<?php
}
?>

<?php
if($POST_VerEstado==1){
?>
<table border="0" cellpadding="2" cellspacing="2" class="EstPanelTablaListado">
<tbody class="EstPanelTablaListadoBody">
<tr>

<td>
<span class="EstPanelTablaListadoTitulo">LEYENDA: </span>
</td>
<td><div style="background-color:#F30; width:30px;">&nbsp;</div></td>


<td width="120">
<span class="EstPanelTablaListadoEtiqueta">No Llego</span>
</td>
<td><div style="background-color:#FC0; width:30px;">&nbsp;</div></td>
<td width="120">
<span class="EstPanelTablaListadoEtiqueta">Llegada Parcial</span>
</td>
<td><div style="background-color:#6F3; width:30px;">&nbsp;</div></td>
<td width="120">
  <span class="EstPanelTablaListadoEtiqueta">Llegada Completa</span>
</td>
</tr>
</tbody>
</table>
<?php
}
?>