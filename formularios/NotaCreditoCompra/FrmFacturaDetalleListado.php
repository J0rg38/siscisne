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
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$Identificador = $_POST['Identificador'];
$POST_Editar = $_POST['Editar'];
$POST_Eliminar = $_POST['Eliminar'];

$POST_OvvId = $_POST['OrdenVentaVehiculoId'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_ImpuestoVenta = $_POST['ImpuestoVenta'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_MonedaSimbolo = $_POST['MonedaSimbolo'];
$POST_PorcentajeImpuestoVenta = $_POST['PorcentajeImpuestoVenta'];



session_start();
if (!isset($_SESSION['InsFacturaDetalle'.$Identificador])){
	$_SESSION['InsFacturaDetalle'.$Identificador] = new ClsSesionObjeto();	
}



require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoCondicionVenta.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoObsequio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoVersionCaracteristica.php');

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenVentaVehiculoPropietario.php');





/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida

*/

$RepSesionObjetos = $_SESSION['InsFacturaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
$ArrSesionObjetos = $RepSesionObjetos['Datos'];
$SesionObjetosTotal = $RepSesionObjetos['Total'];
$SesionObjetosTotalSeleccionado = $RepSesionObjetos['TotalSeleccionado'];


?>

<?php
if(!empty($POST_OvvId)){
	
	$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
	$InsOrdenVentaVehiculo->OvvId = $POST_OvvId;
	$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo();

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
  <th width="20">#</th>
  <th width="50">Tipo</th>
  <th width="526"> Descripci&oacute;n</th>
  <th width="95">U.M.</th>
  <th width="91">p/unitario</th>
  <th width="89">Cantidad</th>
  <th width="86">Importe</th>

<th width="56"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$Total = 0;
$CantidadTotal = 0;
$TotalItems = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){

//$DescuentoUnitario = $DatSesionObjeto->Parametro4 * $_POST['Descuento'];
//$PrecioNeto = $DatSesionObjeto->Parametro4 - $DescuentoUnitario;
//$ImporteNeto = $DatSesionObjeto->Parametro5 * $PrecioNeto;
?>

<tr>
<td align="center" valign="top"><?php echo $c;?></td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro12;?></td>
<td align="right" valign="top">
  <?php echo utf8_encode($DatSesionObjeto->Parametro2);?>
  
  
  <?php
  if(!empty($POST_OvvId)){
	?>
    <table width="502" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="97"><span class="EstFacturaImprimirEtiquetaCaracteristica">Marca:</span></td>
                  <td width="87"><span class="EstFacturaImprimirContenidoCaracteristica">
				<?php echo $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmaNombre;?>			</span>		</td>
                  <td width="10">&nbsp;</td>
                  <td width="80"><span class="EstFacturaImprimirEtiquetaCaracteristica">TRACCI&Oacute;N:</span></td>
                  <td width="68"><span class="EstFacturaImprimirContenidoCaracteristica"> <?php echo $InsOrdenVentaVehiculo->VveCaracteristica7;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Modelo:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica">
				  
				  
				  <?php
		

		
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("SEDAN","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("HATCHBACK","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("GT","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		
		
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("MAX","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("MOVE","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("CARGO","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		
		$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre = eregi_replace("WORK","",$InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre);
		
		
		
		?>
		
		
		<?php echo $InsOrdenVentaVehiculo->OrdenVentaVehiculoVmoNombre;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">CARROCERIA:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica8;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">A&ntilde;o Fabricac.:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinAnoFabricacion;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">NO. puertas:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica9;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Motor:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinNumeroMotor;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">combustible:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica10;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Clindros:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica1;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">peso bruto:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica11;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Ejes:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica2;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">carga util:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica12;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Chasis:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica">
				  
				  <a href="javascript:FncVehiculoIngresoCargarFormulario('Editar','<?php echo $InsOrdenVentaVehiculo->EinId;?>')">
				  <?php echo $InsOrdenVentaVehiculo->EinVIN;?>
                  </a>
                  
                  </span>
                  
                  
                  </td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">peso seco:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica13;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Color:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinColor;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">alto:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica14;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Cilindrada:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica3;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">largo:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica15;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Asientos:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica4;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">ancho:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica16;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">Cap. Pasajeros:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica5;?></span></td>
                  <td>&nbsp;</td>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">dist. ejes:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->VveCaracteristica17;?></span></td>
                  </tr>
                <tr>
                  <td><span class="EstFacturaImprimirEtiquetaCaracteristica">No. Poliza:</span></td>
                  <td><span class="EstFacturaImprimirContenidoCaracteristica"><?php echo $InsOrdenVentaVehiculo->EinDUA;?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                </table>
  
   
    <?php  
  }
  ?>
 
  </td>
<td align="right" valign="top"><?php echo $DatSesionObjeto->Parametro13;?></td>
<td width="91" align="right" valign="top">

<?php
if($POST_MonedaId<>$EmpresaMonedaId){
?>
  <?php echo number_format(($DatSesionObjeto->Parametro4),2);?>
  <?php	
}else{

?>
  <?php echo number_format(($DatSesionObjeto->Parametro4 * $POST_TipoCambio),2);?>
  <?php	
}
?>
  <?php //echo number_format($DatSesionObjeto->Parametro4,2);?></td>
<td width="89" align="right" valign="top"><?php echo number_format($DatSesionObjeto->Parametro5,2);?></td>
<td width="86" align="right" valign="top">
  <?php
if($POST_MonedaId<>$EmpresaMonedaId){
?>
  <?php echo number_format($DatSesionObjeto->Parametro6,2);?> 
  <?php	
}else{
?>
  <?php echo number_format($DatSesionObjeto->Parametro6 * $POST_TipoCambio,2);?> 
  <?php
}
?>
  
</td>
<td width="56" align="center" valign="top">
<?php
if($POST_Editar==1){
?>
	<a class="EstSesionObjetosItem" href="javascript:FncFacturaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/editar.gif" alt="[Editar]" title="Editar" width="15" height="15"  /></a>
<?php
}
?>


<?php
if($POST_Eliminar==1){
?>
	
	<a href="javascript:FncFacturaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
<img align="absmiddle" src="imagenes/eliminar.gif" alt="[Eliminar]" title="Eliminar" width="15" height="15" border="0" /></a>

<?php
}
?>
</td>
</tr>
<?php
	$TotalItems++;

	$TotalBruto = $TotalBruto + $DatSesionObjeto->Parametro6;		
	$CantidadTotal = $CantidadTotal + $DatSesionObjeto->Parametro5;
$c++;
}

deb($POST_IncluyeImpuesto);
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
  <td width="153" align="right"><?php
if($POST_MonedaId<>$EmpresaMonedaId){
?>
    <span class="EstMonedaSimbolo"><?php echo $POST_MonedaSimbolo; ?></span><?php echo number_format($SubTotal,2);?>
    <?php
}else{
?>
    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($SubTotal*$POST_TipoCambio,2);?>
    <?php	
}
?></td>
  <td width="30" align="right">&nbsp;</td>
</tr>


<tr>
  <td colspan="6" align="right"><span class="Total">IMPUESTO (<?php echo $POST_PorcentajeImpuestoVenta;?>%):</span></td>
  <td width="153" align="right"><?php
if($POST_MonedaId<>$EmpresaMonedaId){
?>
    <span class="EstMonedaSimbolo"><?php echo $POST_MonedaSimbolo; ?></span> <?php echo number_format($Impuesto,2);?>
    <?php
}else{
?>
    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($Impuesto*$POST_TipoCambio,2);?>
    <?php	
}
  ?></td>
  <td width="30" align="right">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" align="right"><span class="Total">TOTAL:</span></td>
  <td width="153" align="right"><?php
if($POST_MonedaId<>$EmpresaMonedaId){
?>
    <span class="EstMonedaSimbolo"><?php echo $POST_MonedaSimbolo; ?></span><?php echo number_format($Total,2);?>
    <?php
}else{
?>
    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($Total*$POST_TipoCambio,2);?>
    <?php	
}
  ?></td>
  <td width="30" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
<?php
}
?>
