<?php
@session_start();
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

$GET_id = $_GET['Id'];
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

$InsVentaDirecta = new ClsVentaDirecta();

$InsVentaDirecta->VdiId = $GET_id;
$InsVentaDirecta->MtdObtenerVentaDirecta();

$GET_ImprimirCodigo = 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta No. <?php echo $InsVentaDirecta->VdiId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVentaDirecta2.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVentaDirectaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVentaDirecta->VdiId)){?> 
FncVentaDirectaImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>
<?php if($_GET['P']<>1){ ?>
<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
	<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos</td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }?>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  <td align="left" valign="top">&nbsp;</td>
  </tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
  <td align="right" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
  <td width="34%" align="left" valign="top">&nbsp;</td>
  <td width="28%" align="center" valign="top">&nbsp;</td>
  <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
  <td width="0%" align="right" valign="top">&nbsp;</td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">

<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVentaDirectaImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstPlantillaTitulo">ORDEN DE VENTA </span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsVentaDirecta->VdiId;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%" align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="4%" align="left" valign="top" >&nbsp;</td>
      <td width="26%" align="left" valign="top" >&nbsp;</td>
      <td width="17%" align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="31%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirEtiqueta">Seguro:</span>
        <?php
}
?></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirTabla" ><?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirEtiqueta">:</span>
        <?php
}
?></td>
      <td align="left" valign="top" class="EstCotizacionProductoImprimirTabla" >
	  
<?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirContenido"><?php echo $InsCotizacionProducto->CliNombreSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoPaternoSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoMaternoSeguro;?> </span>
        <?php
}
?></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Fecha </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirFecha"><?php echo $InsVentaDirecta->VdiFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirCliente">
	  
	  <?php echo $InsVentaDirecta->CliNombre;?>
      <?php echo $InsVentaDirecta->CliApellidoPaterno;?>
      <?php echo $InsVentaDirecta->CliApellidoMaterno;?>
      </span>
      
     

      </td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">NUM. DOCUMENTO </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->TdoNombre;?>/<?php echo $InsVentaDirecta->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">DIRECCION </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiDireccion;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">O.C. REF.</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiOrdenCompraNumero;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">O.C. REF. FECHA</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiOrdenCompraFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">MARCA </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiMarca;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">MODELO </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">PLACA </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiPlaca;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">VIN </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->EinVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr>
</table>




<?php
$SaltarLineaRepuesto = false;
$SaltarLineaManoObra = false;
$SaltarLineaPlanchado = false;
$SaltarLineaPintado = false;
$SaltarLineaCentrado = false;
$SaltarLineaTarea = false;
//$SaltarLineaTotales = false;


//
//if($InsVentaDirecta->VdiRepuesto == "SI"){
//	
//	if(count($InsVentaDirecta->VentaDirectaDetalle)>20){
//		
//	}
//	
//}
//
//if($InsVentaDirecta->VdiPlanchado == "SI"){
//
//	if(count($InsVentaDirecta->VentaDirectaPlanchado)>20){
//		
//	}
//	
//}
//
//if($InsVentaDirecta->VdiPintado == "SI"){
//
//	if(count($InsVentaDirecta->VentaDirectaPintado)>20){
//		
//	}
//	
//}
//
//if($InsVentaDirecta->VdiCentrado == "SI"){
//
//	if(count($InsVentaDirecta->VentaDirectaCentrado)>20){
//		
//	}
//	
//}
?>

<?php
if(
	count($InsVentaDirecta->VentaDirectaDetalle) >= 30
){
	$SaltarLineaManoObra = true;
}



if(
	count($InsVentaDirecta->VentaDirectaPlanchado) >= 30
){
	$SaltarLineaPlanchado = true;
}

if(
	count($InsVentaDirecta->VentaDirectaPintado) >= 30
){
	$SaltarLineaPintado = true;
}

if(
	count($InsVentaDirecta->VentaDirectaCentrado) >= 30
){
	$SaltarLineaCentrado = true;
}


if(
	count($InsVentaDirecta->VentaDirectaTarea) >= 30
){
	$SaltarLineaTarea = true;
}
?>



<?php
if($InsVentaDirecta->VdiRepuesto == "Si"){
?> 

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">


	<tr>
		
        <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><span class="EstVentaDirectaImprimirCabecera">Repuestos</span></td>
  <td width="1%" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
    <thead class="EstVentaDirectaImprimirTablaHead">
      <tr>
        <th width="3%" align="center" >#</th>
       <?php
		if($GET_ImprimirCodigo==1){
		?>
        <th width="8%" align="center" >Cod. Original</th>
		<?php
		}
		?>
        <th width="9%" align="center" >Cantidad</th>
      
  <th width="32%" align="center" > Nombre </th>
        <th width="10%" align="center" >Precio</th>
        <th width="12%" align="center" >IMPORTE</th>
        <th width="13%" align="center" >DSCTO. </th>
        <th width="13%" align="center" >IMP. FINAL</th>
        </tr>
      </thead>
    <tbody class="EstVentaDirectaImprimirTablaBody">
      <?php
	
	$TotalRepuesto = 0;
	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
		foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){

			if($DatVentaDirectaDetalle->VddEstado == 1){
				
		
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
					
					$DatVentaDirectaDetalle->VddPrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto / $InsVentaDirecta->VdiTipoCambio);
					
					$DatVentaDirectaDetalle->VddPrecioVenta = ($DatVentaDirectaDetalle->VddPrecioVenta / $InsVentaDirecta->VdiTipoCambio);
					$DatVentaDirectaDetalle->VddImporte = ($DatVentaDirectaDetalle->VddImporte / $InsVentaDirecta->VdiTipoCambio);
					
				}
				
				
				
				if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
					
					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->VddCantidad);
						
					$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
					
					$DetalleDescuento = ($DetalleImporte * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
				
				}else{
				
					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio *  $DatVentaDirectaDetalle->VddCantidad);
					
					$DetallePrecioDescuento =  $DetallePrecio;
					
					$DetalleDescuento = 0;
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
				
				}
				
				
				
		?>
			  <tr>
				<td align="center" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
		
		<?php
				if($GET_ImprimirCodigo==1){
				?>
						<td align="right" class="EstVentaDirectaDetalleImprimirContenido" >
		
					 <?php echo $DatVentaDirectaDetalle->ProCodigoOriginal;?>
				
				</td>
				
				   
				<?php
				}
				?>
				<td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);?></td>
			   
				
			  
				<td align="left" class="EstVentaDirectaDetalleImprimirContenido" ><?php //echo $DatVentaDirectaDetalle->ProNombre;?>
				  <?php echo $DatVentaDirectaDetalle->ProNombre;?></td>
				<td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format(($DetallePrecio),2);?></td>
				<td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DetalleImporte,2);?></td>
				<td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DetalleDescuento,2);?></td>
				<td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DetalleImporteFinal,2);?></td>
				</tr>
			  <?php	
		
					//$TotalRepuesto += $DatVentaDirectaDetalle->VddImporte;
					
					$TotalRepuesto += $DetalleImporteFinal;
					$TotalDescuento += $DetalleDescuento;
					
				$i++;
				
				
			}
	

			
		}
		
		
	} 
?>
   
      <?php
	
	
	


	


?>
      </tbody>
  </table></td>
  <td valign="top">&nbsp;</td>
</tr>

  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td width="85%" align="left" class="EstVentaDirectaImprimirEtiquetaFondo">
    
    <?php
	if(!empty($InsVentaDirecta->VdiPorcentajeDescuento ) and $InsVentaDirecta->VdiPorcentajeDescuento <> 0.00 and $InsVentaDirecta->VdiPorcentajeDescuento <> "0.00"){	
	?>
    <span class="EstVentaDirectaImprimirContenido">DESCUENTO APLICADO: <?php echo number_format($InsVentaDirecta->VdiPorcentajeDescuento,2);?> %</span>
    <?php
	}
	?>
    </td>
    <td width="13%" align="right" class="EstTablaTotal">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  
  
  <?php
  if($InsVentaDirecta->VdiPintado=="Si" or $InsVentaDirecta->VdiPlanchado == "Si" or $InsVentaDirecta->VdiCentrado == "Si" or $InsVentaDirecta->VdiTarea == "Si" or (!empty($InsVentaDirecta->VdiManoObra) and $InsVentaDirecta->VdiManoObra <> "0.00")){
	?>
  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td align="right" class="EstVentaDirectaImprimirEtiquetaFondo">
    
  
    <span class="EstVentaDirectaImprimirEtiquetaTotal">TOTAL POR REPUESTOS:</span>    
 
    
    </td>
    <td align="right" class="EstTablaTotal"><span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalRepuesto,2);?></span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  

</table>

<?php
}
?>


<?php
	///$TotalRepuesto = $TotalRepuesto;
//	if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
//		$Descuento = $TotalRepuesto * ($InsVentaDirecta->VdiPorcentajeDescuento/100);
//		$TotalRepuesto = $TotalRepuesto - $Descuento;
//	}
	
?>
	

  	<?php
    if($SaltarLineaRepuesto){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
if(!empty($InsVentaDirecta->VdiManoObra) and $InsVentaDirecta->VdiManoObra <> "0.00"){
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">

<tr>
  <td width="1%" align="center">&nbsp;</td>
  <td width="85%" align="right"><span class="EstVentaDirectaImprimirEtiquetaTotal">MANO DE OBRA:</span></td>
  <td width="13%" align="right">
    
  <span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($InsVentaDirecta->VdiManoObra,2);?></span>
    
    
  </td>
  <td width="1%" align="center">&nbsp;</td>
  
</tr>
</table>
 <?php  
}
?>





     <?php
    if($SaltarLineaManoObra){
    ?>
<H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?> 

<?php
//if($InsVentaDirecta->VdiPlanchado=="Si"){
//deb($InsVentaDirecta->VdiVerificar ." -  ".$InsVentaDirecta->VdiPlanchadoVerificado);
if( $InsVentaDirecta->VdiPlanchado == "Si"){
	
?>
	
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">
    <tr>
    
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="left"><span class="EstVentaDirectaImprimirCabecera">Planchado</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="center">



<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
  <thead class="EstVentaDirectaImprimirTablaHead">
	<tr>
	  <th width="3%" align="center" >#</th>
	  
	  <th width="83%" align="center" > Nombre </th>
	  <th width="14%" align="center" >Importe</th>
	</tr>
  </thead>
  <tbody class="EstVentaDirectaImprimirTablaBody">
	<?php
$TotalPlanchado = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaPlanchado)){
	foreach($InsVentaDirecta->VentaDirectaPlanchado as $DatVentaDirectaPlanchado){

		
			
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				
					$DatVentaDirectaPlanchado->VdtImporte = round($DatVentaDirectaPlanchado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
				
			}
?>

        
    <tr>
	  <td align="right" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
  
	  <td align="right" class="EstVentaDirectaDetalleImprimirContenido" >
		<?php echo $DatVentaDirectaPlanchado->VdtDescripcion;?></td>
	  <td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaPlanchado->VdtImporte,2);?></td>
	</tr>
<?php	
			$TotalPlanchado += $DatVentaDirectaPlanchado->VdtImporte;
			$i++;

		}
	
} 
?>
	</tbody>
</table>



</td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td width="84%" align="right" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
<td width="14%" align="right" class="EstTablaTotal">&nbsp;</td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td align="right" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiquetaTotal">Total POR PLANCHADO:</span></td>
<td align="right" class="EstTablaTotal"><span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalPlanchado,2);?></span></td>
<td width="1%" align="center">&nbsp;</td>

	</tr>
    </table>

<?php  
}
?>
    
    
          

	<?php
    if($SaltarLineaPlanchado){
    ?>
        <H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiPintado=="Si"){
if($InsVentaDirecta->VdiPintado == "Si" ){
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">
	<tr>
    
    <td width="1%" align="center">&nbsp;</td>
    <td colspan="2" align="left"><span class="EstVentaDirectaImprimirCabecera">Pintado</span></td>
    <td width="1%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
      <thead class="EstVentaDirectaImprimirTablaHead">
        <tr>
          <th width="3%" align="center" >#</th>
          
          <th width="84%" align="center" > Nombre </th>
          <th width="13%" align="center" >Importe</th>
        </tr>
      </thead>
      <tbody class="EstVentaDirectaImprimirTablaBody">
        <?php
	
	$TotalPintado = 0;
	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaPintado)){
		foreach($InsVentaDirecta->VentaDirectaPintado as $DatVentaDirectaPintado){

			
	
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
					
						$DatVentaDirectaPintado->VdtImporte = round($DatVentaDirectaPintado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
					
				}
?>


        <tr>
          <td align="right" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
          
          <td align="right" class="EstVentaDirectaDetalleImprimirContenido" >
            <?php echo $DatVentaDirectaPintado->VdtDescripcion;?></td>
          <td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaPintado->VdtImporte,2);?></td>
        </tr>
        <?php	
				$TotalPintado += $DatVentaDirectaPintado->VdtImporte;
				$i++;

			

		}
		
	} 
?>
    
        <?php
	
	
	
	
	

?>
        </tbody>
    </table></td>
    <td width="1%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td width="85%" align="right" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
    <td width="13%" align="right" class="EstTablaTotal">&nbsp;</td>
    <td width="1%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" align="center">&nbsp;</td>
    <td align="right" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiquetaTotal">Total POR PINTADO:</span></td>
    <td align="right" class="EstTablaTotal"> <span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalPintado,2);?></span></td>
    <td width="1%" align="center">&nbsp;</td>
	
    </tr> 
</table>  
<?php  
}
?>
 
  

	<?php
    if($SaltarLineaPintado){
    ?>
        <H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiCentrado=="Si"){
if( $InsVentaDirecta->VdiCentrado == "Si"){
?>




	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">
	<tr>
    
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="left"><span class="EstVentaDirectaImprimirCabecera">Centrado</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
<thead class="EstVentaDirectaImprimirTablaHead">
  <tr>
	<th width="3%" align="center" >#</th>
	
	<th width="84%" align="center" > Nombre </th>
	<th width="13%" align="center" >Importe</th>
  </tr>
</thead>
<tbody class="EstVentaDirectaImprimirTablaBody">
  <?php
$TotalCentrado = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaCentrado)){
	foreach($InsVentaDirecta->VentaDirectaCentrado as $DatVentaDirectaCentrado){


//deb($DatVentaDirectaPlanchado->VdtEstado ." :::: ". $InsVentaDirecta->VdiVerificar);




		
	
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaCentrado->VdtImporte = round($DatVentaDirectaCentrado->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
?>

            <tr>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido" >
                <?php echo $DatVentaDirectaCentrado->VdtDescripcion;?></td>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaCentrado->VdtImporte,2);?></td>
            </tr>
<?php	
			  $TotalCentrado += $DatVentaDirectaCentrado->VdtImporte;
			$i++;
		

	}

} 
?>
  </tbody>
</table></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td width="85%" align="right" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
<td width="13%" align="right" class="EstTablaTotal">&nbsp;</td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td align="right" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiquetaTotal">Total POR CENTRADO:</span></td>
<td align="right" class="EstTablaTotal"><span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalCentrado,2);?></span></td>
<td width="1%" align="center">&nbsp;</td>
	
    </tr>
</table>
<?php  
}
?>  
  



	<?php
    if($SaltarLineaCentrado){
    ?>
        <H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>

<?php
//if($InsVentaDirecta->VdiTarea=="Si"){
if($InsVentaDirecta->VdiTarea == "Si"){
?>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">
	<tr>
    
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="left"><span class="EstVentaDirectaImprimirCabecera">Tareas/Reparacion</span></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td colspan="2" align="center"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
<thead class="EstVentaDirectaImprimirTablaHead">
  <tr>
	<th width="3%" align="center" >#</th>
	
	<th width="83%" align="center" > Nombre </th>
	<th width="14%" align="center" >Importe</th>
  </tr>
</thead>
<tbody class="EstVentaDirectaImprimirTablaBody">
  <?php
$TotalTarea = 0;

$i=1;
if(!empty($InsVentaDirecta->VentaDirectaTarea)){
	foreach($InsVentaDirecta->VentaDirectaTarea as $DatVentaDirectaTarea){

			//deb($DatVentaDirectaPlanchado->VdtEstado ." :::: ". $InsVentaDirecta->VdiVerificar);
			if($InsVentaDirecta->MonId<>$EmpresaMonedaId){
				$DatVentaDirectaTarea->VdtImporte = round($DatVentaDirectaTarea->VdtImporte / $InsVentaDirecta->VdiTipoCambio,2);
			}
?>

            <tr>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido" >
                <?php echo $DatVentaDirectaTarea->VdtDescripcion;?></td>
                <td align="right" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaTarea->VdtImporte,2);?></td>
            </tr>
<?php	
			  $TotalTarea += $DatVentaDirectaTarea->VdtImporte;
			$i++;
	
	}

} 
?>
  </tbody>
</table></td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td width="84%" align="right" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
<td width="14%" align="right" class="EstTablaTotal">&nbsp;</td>
<td width="1%" align="center">&nbsp;</td>
</tr>
<tr>
<td width="1%" align="center">&nbsp;</td>
<td align="right" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiquetaTotal">Total POR TAREAS/REPARACION:</span></td>
<td align="right" class="EstTablaTotal"><span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalTarea,2);?></span></td>
<td width="1%" align="center">&nbsp;</td>
	
    </tr>
</table>


<?php  
}
?>  

  	<?php
    if($SaltarLineaTarea){
    ?>
        <H1 class="SaltoDePagina"> </H1> 	 
    <?php
    }
    ?>
    
    
    
 
 
     <?php
	 
	// deb($TotalRepuesto);



//	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
//		
//		$TotalBruto = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
//		
//		$SubTotal = $TotalBruto / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$SubTotal = $SubTotal - $InsVentaDirecta->VdiDescuento;
//		
//		$InsVentaDirecta->VdiManoObra = $InsVentaDirecta->VdiManoObra / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalPlanchado = $InsVentaDirecta->VdiPlanchadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalPintado = $InsVentaDirecta->VdiPintadoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalCentrado = $InsVentaDirecta->VdiCentradoTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		$TotalTarea = $InsVentaDirecta->VdiTareaTotal / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//		
//		
//	}else{
//
//		$InsVentaDirecta->VdiSubTotal = $InsVentaDirecta->VdiTotalBruto - $InsVentaDirecta->VdiDescuento;
//
//	}
	
//	$SubTotal = $SubTotal + $InsVentaDirecta->VdiManoObra + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea;
//	$Impuesto = $SubTotal * ($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100);
//	$Total = $SubTotal + $Impuesto;	
	
	
	
	
	if($InsVentaDirecta->VdiIncluyeImpuesto == 1){
		
		$Total = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$SubTotal = $Total / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
		
		$SubTotal = $TotalRepuesto + $TotalPlanchado + $TotalPintado + $TotalCentrado + $TotalTarea + $InsVentaDirecta->VdiManoObra;
		$Impuesto = $SubTotal * (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
	
	
	
?>


 
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">

  <tr>
    <td width="1%">&nbsp;</td>
    <td colspan="2">
    
<?php
	//$Total = $TotalRepuesto;
//	$SubTotal = $Total / (($InsVentaDirecta->VdiPorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	
	
?>
  <hr class="EstPlantillaLinea" />
   
   
     <table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
       <tr>
         <td align="right" class="EstVentaDirectaImprimirEtiquetaFondo">
		 
         <?php
//if(!empty($InsVentaDirecta->VdiPorcentajeDescuento )){
/*if(!empty($InsVentaDirecta->VdiPorcentajeDescuento ) and $InsVentaDirecta->VdiPorcentajeDescuento <> 0.00 and $InsVentaDirecta->VdiPorcentajeDescuento <> "0.00"){	
?> 
<span class="EstVentaDirectaImprimirEtiquetaTotal">DESCT.
 (<?php echo number_format($InsVentaDirecta->VdiPorcentajeDescuento,2);?> %): </span>
<?php	
}*/
?>


</td>
         <td align="right" >
		 
         <?php
//if(!empty($InsVentaDirecta->VdiPorcentajeDescuento )){
/*if(!empty($InsVentaDirecta->VdiPorcentajeDescuento ) and $InsVentaDirecta->VdiPorcentajeDescuento <> 0.00 and $InsVentaDirecta->VdiPorcentajeDescuento <> "0.00"){
	
?>   
          <span class="EstVentaDirectaImprimirContenidoTotal">
		  <?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($TotalDescuento,2);?>
          </span>
          
    <?php	
}*/
?>


</td>
       </tr>
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="644" align="right"><span class="EstVentaDirectaImprimirEtiquetaTotal">SubTotal:</span></td>
          <td width="107" align="right" > <span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($SubTotal,2);?></span></td>
        </tr>
        <tr>
          <td align="right"><span class="EstVentaDirectaImprimirEtiquetaTotal">I.G.V. (<?php echo $InsVentaDirecta->VdiPorcentajeImpuestoVenta;?>%):</span></td>
          <td align="right"> <span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($Impuesto,2);?></span></td>
        </tr>
        </tbody>
    </table>
    
     
    
    
    
    
    </td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="right">
    
    <div  class="EstCapVentaDirectaTotal">
    <table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="1" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="643" align="right" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiquetaTotal">Total:</span></td>
          <td width="102" align="right"><span class="EstVentaDirectaImprimirContenidoTotal"><?php echo $InsVentaDirecta->MonSimbolo;?> <?php echo number_format($Total,2);?></span></td>
        </tr>
      </tbody>
    </table>
    </div>
    
    </td>
    <td>&nbsp;</td>
  </tr>

	<tr>
      <td >&nbsp;</td>
      <td colspan="2">
      
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVentaDirectaImprimirTabla">
        <tr>
          <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
          <td colspan="4" align="left" valign="top" >&nbsp;</td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="10%" align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Observacion:</span></td>
          <td colspan="4" align="left" valign="top" ><span class="EstVentaDirectaImprimirObservacion"><?php echo $InsVentaDirecta->VdiObservacionImpresa;?></span></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table></td>
      <td >&nbsp;</td>
    </tr>
    




    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">_______________________ </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td >&nbsp; </td>
      <td width="49%" align="left">
      
      
      <div class="EstVentaDirectaImprimirNota1">
              
              <p><strong>Nota:</strong></p>
				<ul type="disc">
                <li>Los precios están expresados en <?php echo $InsVentaDirecta->MonNombre;?>.</li>
                
                <?php
				if(!empty($InsVentaDirecta->VdiTipoCambio)){
					?>
                <li> Tipo de Cambio <?php echo $InsVentaDirecta->VdiTipoCambio;?>.    </li>                
                <?php
				}
				?>
                <li>Repuestos       originales.</li>
                   

                </ul>
              
              </div>
              
              
      </td>
      <td width="49%" align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>


<div class="EstVentaDirectaPie">

        <span class="EstVentaDirectaImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
  Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>

</div>


<div class="EstVentaDirectaPieAux">

</div>    



</body>
</html>


