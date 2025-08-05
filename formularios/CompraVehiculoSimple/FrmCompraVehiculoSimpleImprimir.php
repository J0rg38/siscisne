<?php
session_start();
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

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsCompraVehiculoDetalle.php');

$InsCompraVehiculo = new ClsCompraVehiculo();

$InsCompraVehiculo->CvhId = $GET_id;
$InsCompraVehiculo->MtdObtenerCompraVehiculo();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Ingreso de Unidad Vehicular No. <?php echo $InsCompraVehiculo->CvhId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssCompraVehiculoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsCompraVehiculoSimpleImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsCompraVehiculo->CvhId)){?> 
FncCompraVehiculoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>

<?php
if ($_GET['P'] <> 1) {
?>

<form method="get" enctype="multipart/form-data" action="#">
	<input type="hidden" name="Id" id="Id" value="<?php   echo $GET_id;?>" />
	<input type="hidden" name="P" id="P" value="1" />
    <table cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td>
    </td>
    <td>&nbsp;</td>
    <td>
        <input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
    </td>
    </tr>
    </table>
</form>

<?php
}
?>

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top">
  
		<img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
        </td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">INGRESO DE UNIDAD VEHICULAR
  <br /><?php echo $InsCompraVehiculo->CvhId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstCompraVehiculoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstCompraVehiculoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstCompraVehiculoImprimirCabecera">Datos de la Ingreso de Unidad Vehicular</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta"> Fecha de Ingreso:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Numero de Guia de Remision:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhGuiaRemisionNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Fecha de Guia Remision:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhGuiaRemisionFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstCompraVehiculoImprimirContenido">
        
         <?php echo $InsCompraVehiculo->CvhEstadoDescripcion;?>
          <?php
		/*switch($InsCompraVehiculo->CvhEstado){
			case 1:
	?>
         Pendiente
          <?php
			break;
						
			case 3:
	?>
          Realizado
          <?php
			break;
		}*/
	?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
  
  
  
  
  
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstCompraVehiculoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstCompraVehiculoImprimirCabecera">Comprobante de Pago</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta"> R.U.C.:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->PrvNumeroDocumento;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Proveedor:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->PrvNombreCompleto;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Numero de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Fecha de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido">
	  
	  
	<?php
    switch($InsCompraVehiculo->CvhIncluyeImpuesto){
		
		case 1:
		?>
		Si
		<?php
		break;
		
		case 2:
		?>
			No
		<?php
		break;
		
		default:
		
		?>
			-
		<?php
		break;
		
    }
    ?>
      
      
	 </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstCompraVehiculoImprimirContenido"><?php echo $InsCompraVehiculo->CvhPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstCompraVehiculoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
    
    
    
    
    
    </td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstCompraVehiculoImprimirTabla">
  <thead class="EstCompraVehiculoImprimirTablaHead">
    
  <tr>
    <th width="2%" align="center" >#</th>
    <th width="3%" align="center" >
      
      Id</th>
    <th width="12%" align="center" >Cod. Original</th>
    <th width="56%" align="center" >
      Descripcion
      
    </th>
    <th width="5%" align="center" >U.M.</th>
    <th width="6%" align="center" >Cantidad</th>
    <th width="6%" align="center" >Valor Unitario</th>
    <th width="10%" align="center" >Valor Total</th>
    </tr>
    
    
  </thead>
  <tbody class="EstCompraVehiculoImprimirTablaBody">
  <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsCompraVehiculo->CompraVehiculoDetalle)){
		
		foreach($InsCompraVehiculo->CompraVehiculoDetalle as $DatCompraVehiculoDetalle){


			if($InsCompraVehiculo->MonId<>$EmpresaMonedaId){
				$DatCompraVehiculoDetalle->CvdCosto = $DatCompraVehiculoDetalle->CvdCosto / $InsCompraVehiculo->CvhTipoCambio;
			}else{
				$DatCompraVehiculoDetalle->CvdCosto = $DatCompraVehiculoDetalle->CvdCosto;
			}

			if($InsCompraVehiculo->MonId<>$EmpresaMonedaId ){
				$DatCompraVehiculoDetalle->CvdImporte = $DatCompraVehiculoDetalle->CvdImporte / $InsCompraVehiculo->CvhTipoCambio;
			}else{
				$DatCompraVehiculoDetalle->CvdImporte = $DatCompraVehiculoDetalle->CvdImporte;
			}
			
			
?>

    
    <tr>
      <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatCompraVehiculoDetalle->ProId;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatCompraVehiculoDetalle->ProCodigoOriginal;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatCompraVehiculoDetalle->ProNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatCompraVehiculoDetalle->UmeNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatCompraVehiculoDetalle->CvdCantidad,2);?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        <?php echo number_format(($DatCompraVehiculoDetalle->CvdCosto),2);?>
      </td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        
        
        <?php echo number_format($DatCompraVehiculoDetalle->CvdImporte,2);?>
        
      </td>
      </tr>
  <?php	
		$TotalBruto += $DatCompraVehiculoDetalle->CvdImporte;
		
		$i++;
		}
	} 
	
	

if($InsCompraVehiculo->MonId<>$EmpresaMonedaId){
	
	
	$Recargo = $InsCompraVehiculo->CvhNacionalTotalRecargo/ $InsCompraVehiculo->CvhTipoCambio;
}else{
	
	$Recargo = $InsCompraVehiculo->CvhNacionalTotalRecargo;
	
}

		
$SubTotal = round($TotalBruto,2);
//$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;	
	
//$Recargo = $InsCompraVehiculo->CvhNacionalTotalRecargo;
//$SubTotal = round($SubTotal,2);

//$Impuesto = round(($SubTotal + $Recargo) * ($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
/*if($InsCompraVehiculo->CvhIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsCompraVehiculo->CvhPorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;

}	*/


?>
    
    
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      <td align="right" >&nbsp;</td>
      </tr>
    
    
  </tbody>
  </table>
  
  
  
  
  </td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="5">
  
  
  <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td width="21%" align="left">&nbsp;</td>
  <td width="39%" align="left">&nbsp;</td>
  <td width="18%" align="right" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstCompraVehiculoImprimirContenidoTotal">
    
    <span class="EstMonedaSimbolo"><?php echo $InsCompraVehiculo->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
    
    
    </td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiquetaTotal">Impuesto (<?php echo $InsCompraVehiculo->CvhPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstCompraVehiculoImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsCompraVehiculo->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
    
    
    </td>
</tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstCompraVehiculoImprimirEtiquetaFondo"><span class="EstCompraVehiculoImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstCompraVehiculoImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsCompraVehiculo->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
