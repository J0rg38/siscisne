<?php
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

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
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_ImpuestoVenta = $_POST['ImpuestoVenta'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_MonedaSimbolo = $_POST['MonedaSimbolo'];
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];

session_start();
if (!isset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador])){
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();


//SesionObjeto-NotaCreditoCompraDetalleListado
//Parametro1 = NodId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = NodPrecio
//Parametro5 = NodCantidad
//Parametro6 = NodImporte
//Parametro7 = NodTiempoCreacion
//Parametro8 = NodTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 = ProNombre
//Parametro12 = ProCodigoOriginal
//Parametro13 = UmeNombre
//Parametro14 = RtiId
//Parametro15 = UmeIdOrigen
//Parametro16 = NodEstado




$RepSesionObjetos = $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="18">#</th>
  <th width="92">Estado</th>
  <th width="92">Cod. Original</th>
  <th width="542"> Descripci&oacute;n</th>
  <th width="67">U.M.</th>
  <th width="78">p/unitario</th>
  <th width="75">Cantidad</th>
  <th width="71">Importe</th>

<th width="47"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$TotalItems = 0;
foreach($ArrSesionObjetos as $DatSesionObjeto){

//$DescuentoUnitario = $DatSesionObjeto->Parametro4 * $_POST['Descuento'];
//$PrecioNeto = $DatSesionObjeto->Parametro4 - $DescuentoUnitario;
//$ImporteNeto = $DatSesionObjeto->Parametro5 * $PrecioNeto;
?>


<?php
if($InsMoneda->MonId == $EmpresaMonedaId){
?>
	<?php  $DatAlmacenMovimientoEntradaDetalle->Parametro4 = ($DatAlmacenMovimientoEntradaDetalle->Parametro4 * $POST_TipoCambio);?>
    <?php  $DatAlmacenMovimientoEntradaDetalle->Parametro6 = ($DatAlmacenMovimientoEntradaDetalle->Parametro6 * $POST_TipoCambio);?>

<?php	
}
?>
                            
                            
                            
<tr>
<td align="center" valign="top"><?php echo $c;?></td>
<td align="right" valign="top">

<?php
switch($DatSesionObjeto->Parametro16){
	case "1":
?>
		Rectificacion de Costo
<?php	
	break;
	
	case "3":
?>
		Devolucion
<?php	
	break;
	
	default:
?>
	-
<?php	
	break;
}
?>


</td>
<td align="right" valign="top"><?php echo utf8_encode($DatSesionObjeto->Parametro12);?></td>
<td align="right" valign="top">
  <?php echo utf8_encode($DatSesionObjeto->Parametro11);?>
  
  
  
</td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td width="78" align="right" valign="top">


  <?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  <?php //echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td width="75" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="71" align="right" valign="top">

  <?php echo number_format($DatSesionObjeto->Parametro6,2);?> 

</td>
<td width="47" align="center" valign="top">
<?php
if($POST_Editar==1){
?>
	<a class="EstSesionObjetosItem" href="javascript:FncNotaCreditoCompraDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>
<?php
}
?>


<?php
if($POST_Eliminar==1){
?>
	
	<a href="javascript:FncNotaCreditoCompraDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/acciones/listado_eliminar.png" alt="[Eliminar]" title="Eliminar" width="25" height="25" border="0" /></a>

<?php
}
?>
</td>
</tr>
<?php
	$TotalItems++;
	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;		
	
$c++;
}


if($POST_IncluyeImpuesto == 1){
	
	$ImpuestoVenta = $POST_ImpuestoVenta;
	$ImpuestoVenta = $ImpuestoVenta + 1;
	
	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;
	
}else{
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * $POST_ImpuestoVenta;	
	$Total = $SubTotal + $Impuesto;
	
}


/*
$ImpuestoVenta = $_POST['ImpuestoVenta'];
$ImpuestoVenta = $ImpuestoVenta + 1;
$SubTotal = round(($Total /$ImpuestoVenta),2);
$EmpresaImpuestoVenta = $Total - $SubTotal;*/


//deb($SubTotal);
//deb($Impuesto);
//deb($Total);

?>





</tbody>
</table>




<br />


<table class="EstTablaListado" width="100%" cellpadding="0" cellspacing="0" border="0">
<tbody class="EstTablaListadoBody">
<tr>
  <td colspan="6" align="right"><span class="Total">SUBTOTAL:</span></td>
  <td width="153" align="right">
 
  
  <span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?>
  
  
  </td>
  <td width="30" align="right">&nbsp;</td>
</tr>


<tr>
  <td colspan="6" align="right"><span class="Total">IMPUESTO (<?php echo number_format($POST_PorcentajeImpuestoVenta,2);?> %):</span></td>
  <td width="153" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Impuesto,2);?></td>
  <td width="30" align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right"><span class="Total">TOTAL:</span></td>
  <td width="153" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($Total,2);?></td>
  <td width="30" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
<?php
}
?>
