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
$POST_Descuento = $_POST['Descuento'];
$POST_Eliminar = $_POST['Eliminar'];
$POST_Editar = $_POST['Editar'];
$POST_MonedaId = $_POST['MonedaId'];
$POST_TipoCambio = $_POST['TipoCambio'];
$POST_IncluyeImpuesto = $_POST['IncluyeImpuesto'];
$POST_VerEstado = $_POST['VerEstado'];


session_start();
if (!isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoTipoUnidadMedida.php');		

$InsMoneda = new ClsMoneda();
$InsMoneda->MonId = $POST_MonedaId;
$InsMoneda->MtdObtenerMoneda();



$InsProductoTipoUnidadMedida = new ClsProductoTipoUnidadMedida();

/*
SesionObjeto-VentaDirectaDetalle
Parametro1 = VddId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = VddPrecio
Parametro5 = VddCantidad
Parametro6 = VddImporte
Parametro7 = VddTiempoCreacion
Parametro8 = VddTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = VddCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = VddCosto
Parametro18 = ProStock
Parametro19 = ProStockReal
Parametro20 = VddCantidadPedir
Parametro21 = VddCantidadPedirFecha
Parametro22 = CrdId
*/

$RepSesionObjetos = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjetos(true);
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
  <th width="2%">Id</th>
  <th width="7%">Cod. Orig.</th>
  <th width="7%">Cod. Alt.</th>
  <th width="34%"> Nombre
</th>
<th width="17%">U.M.</th>
<th width="6%">
  
  Precio</th>


<th width="6%">
  Cantidad</th>
<th width="6%">
  Importe</th>
<?php
if($POST_VerEstado == 1){
?>
<th width="5%">Cant. Llegada</th>

<?php
}
?>
<th width="2%">&nbsp;</th>
<th width="6%"> Acc.</th>
</tr>
</thead>
<tbody class="EstTablaListadoBody">
<?php
$c = 1;
$TotalBruto = 0;

foreach($ArrSesionObjetos as $DatSesionObjeto){
?>


<?php
if($POST_VerEstado == 1){
?>

	<?php
	if(empty($DatSesionObjeto->Parametro24)){
		$fondo = "#F30";
	}else if($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5){
		$fondo = "#6F3";
	}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
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
<tr>
<td align="right"  bgcolor="<?php echo $fondo;?>"><?php echo $c;?>

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  <span title="<?php echo $DatSesionObjeto->Parametro1;?>"><?php echo $DatSesionObjeto->Parametro2;?></span>
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  
  
  
  <?php echo $DatSesionObjeto->Parametro13;?>
  
  
  
  
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">

	
        <?php echo $DatSesionObjeto->Parametro14;?>
  

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


        <?php echo $DatSesionObjeto->Parametro3;?>
  

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">


		<?php echo $DatSesionObjeto->Parametro9;?>
   

</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  

	<?php echo number_format(($DatSesionObjeto->Parametro4),2);?>

  
</td>

<td align="right"  bgcolor="<?php echo $fondo;?>">

	
		<?php echo number_format($DatSesionObjeto->Parametro5,3);?>
   
  
  
   <!--(<?php echo number_format($DatSesionObjeto->Parametro12,3);?>)-->
</td>
<td align="right"  bgcolor="<?php echo $fondo;?>">
  <?php echo number_format($DatSesionObjeto->Parametro6,2);?>
</td>

<?php
if($POST_VerEstado == 1){
?>

	<?php
	/*if(empty($DatSesionObjeto->Parametro24)){
		$fondo = "#FF0000";
	}else if($DatSesionObjeto->Parametro24 >= $DatSesionObjeto->Parametro5){
		$fondo = "#00CC33";
	}else if($DatSesionObjeto->Parametro24 < $DatSesionObjeto->Parametro5){
		$fondo = "#FF6600";		
	}else{
		$fondo = "#FFFFFF";	
	}*/
	?>
    
	<td align="center" bgcolor="<?php echo $fondo;?>">
    
    <?php
	//if($DatSesionObjeto->Parametro24>$DatSesionObjeto->Parametro5){
	?>
    <?php
	echo number_format($DatSesionObjeto->Parametro24,2);
	?>
    
    <?php	
	//}
	?>
    </td>
	
<?php
}
?>

<td align="center">


<?php
if($DatSesionObjeto->Parametro16 == 1){
?>
<a target="_blank" href="principal.php?Mod=AlmacenStock&Form=Ver&Id=<?php echo $DatSesionObjeto->Parametro2;?>">

<img src="imagenes/advertencia.png" title="No hay stock suficiente [<?php echo number_format($DatSesionObjeto->Parametro18,3);?>]" alt="No hay stock suficiente" width="15" height="15" border="0" /></a>
    
   <!-- ()-->

<?php	
}
?>

</td>
<td align="center">

<?php

if($POST_Editar==1){
?>


<a class="EstSesionObjetosItem" href="javascript:FncVentaDirectaDetalleEscoger('<?php echo $DatSesionObjeto->Item;?>');"><img border="0"  align="absmiddle" src="imagenes/acciones/listado_editar.png" alt="[Editar]" title="Editar" width="25" height="25"  /></a>

<?php
}
?>



<?php
//if($_POST['Eliminar']==1 and empty($DatSesionObjeto->Parametro22)){
if($POST_Eliminar==1){
?>
<a href="javascript:FncVentaDirectaDetalleEliminar('<?php echo $DatSesionObjeto->Item;?>');" >
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

//		$Total = $TotalBruto;
//		$SubTotal = $TotalBruto / (($POST_PorcentajeImpuestoVenta/100)+1);
//		$Impuesto = $Total - $SubTotal;	
//		$TotalBruto = $TotalBruto - $POST_Descuento;


	
	if($POST_IncluyeImpuesto == 1){

		

		$SubTotal = $TotalBruto / (($POST_PorcentajeImpuestoVenta/100)+1);
		$SubTotal = $SubTotal - $POST_Descuento;
		$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);
		$Total = $SubTotal + $Impuesto;



	}else{

		$SubTotal = $TotalBruto  - $POST_Descuento;
		$Impuesto = $SubTotal * ($POST_PorcentajeImpuestoVenta/100);	
		$Total = $SubTotal + $Impuesto;

	}
	
	/*
	84.75		15.25		100
	100 		18 			118	

	
	74.75		13.45		88.2
	90			16.2		106.2
	*/
	
	
?>
</tbody>
</table>
<br />
<table class="EstTablaTotal" width="100%" cellpadding="2" cellspacing="0" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right" class="Total">&nbsp;</td>
  <td align="left" >&nbsp;</td>
  <td align="right" class="Total">Descuento:</td>
  <td align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($POST_Descuento,2);?></td>
  </tr>
<tr>
  <td width="17%" align="right" class="Total">&nbsp;</td>
  <td width="7%" align="left" >&nbsp;</td>
  <td width="61%" align="right" class="Total">SubTotal:</td>
  <td width="15%" align="right"><span class="EstMonedaSimbolo"><?php echo $InsMoneda->MonSimbolo; ?></span> <?php echo number_format($SubTotal,2);?></td>
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

<?php
if($POST_VerEstado == 1){
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