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

require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompra.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsNotaCreditoCompraDetalle.php');

$InsNotaCreditoCompra = new ClsNotaCreditoCompra();

$InsNotaCreditoCompra->NccId = $GET_id;
$InsNotaCreditoCompra->MtdObtenerNotaCreditoCompra();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Entrada a Almacen No. <?php echo $InsNotaCreditoCompra->NccId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssNotaCreditoCompraImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsNotaCreditoCompraImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsNotaCreditoCompra->NccId)){?> 
FncNotaCreditoCompraImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">NOTA DE CREDITO X COMPRA
  <br />
  <?php echo $InsNotaCreditoCompra->NccId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstNotaCreditoCompraImprimirTabla">

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
  
  
  
  
  
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstNotaCreditoCompraImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstNotaCreditoCompraImprimirCabecera">Comprobante</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td width="16%" align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta"> R.U.C.:</span></td>
      <td width="30%" align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->PrvNumeroDocumento;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="15%" align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Proveedor:</span></td>
      <td width="36%" align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->PrvNombreCompleto;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Numero de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->NccComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Fecha de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->NccFechaEmision;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->NccTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido">
	  
	  
	<?php
    switch($InsNotaCreditoCompra->NccIncluyeImpuesto){
		
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
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->NccPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Doc. Ref.:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->AmoComprobanteNumero;?></span></td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Observacion:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"><?php echo $InsNotaCreditoCompra->NccObservacion;?></span></td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" ><span class="EstNotaCreditoCompraImprimirContenido"> <?php echo $InsNotaCreditoCompra->NccEstadoDescripcion;?>
        <?php
		/*switch($InsNotaCreditoCompra->NccEstado){
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
	?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstNotaCreditoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
    
    
    
    
    
    </td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstNotaCreditoCompraImprimirTabla">
  <thead class="EstNotaCreditoCompraImprimirTablaHead">
    
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
  <tbody class="EstNotaCreditoCompraImprimirTablaBody">
  <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsNotaCreditoCompra->NotaCreditoCompraDetalle)){
		
		foreach($InsNotaCreditoCompra->NotaCreditoCompraDetalle as $DatNotaCreditoCompraDetalle){


			if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId){
				$DatNotaCreditoCompraDetalle->NodCosto = $DatNotaCreditoCompraDetalle->NodCosto / $InsNotaCreditoCompra->NccTipoCambio;
			}else{
				$DatNotaCreditoCompraDetalle->NodCosto = $DatNotaCreditoCompraDetalle->NodCosto;
			}

			if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId ){
				$DatNotaCreditoCompraDetalle->NodImporte = $DatNotaCreditoCompraDetalle->NodImporte / $InsNotaCreditoCompra->NccTipoCambio;
			}else{
				$DatNotaCreditoCompraDetalle->NodImporte = $DatNotaCreditoCompraDetalle->NodImporte;
			}
			
			
?>

    
    <tr>
      <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatNotaCreditoCompraDetalle->ProId;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatNotaCreditoCompraDetalle->ProCodigoOriginal;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatNotaCreditoCompraDetalle->ProNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatNotaCreditoCompraDetalle->UmeNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatNotaCreditoCompraDetalle->NodCantidad,2);?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        <?php echo number_format(($DatNotaCreditoCompraDetalle->NodCosto),2);?>
      </td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        
        
        <?php echo number_format($DatNotaCreditoCompraDetalle->NodImporte,2);?>
        
      </td>
      </tr>
  <?php	
		$TotalBruto += $DatNotaCreditoCompraDetalle->NodImporte;
		
		$i++;
		}
	} 
	
	

if($InsNotaCreditoCompra->MonId<>$EmpresaMonedaId){
	
	
	$Recargo = $InsNotaCreditoCompra->NccNacionalTotalRecargo/ $InsNotaCreditoCompra->NccTipoCambio;
}else{
	
	$Recargo = $InsNotaCreditoCompra->NccNacionalTotalRecargo;
	
}

		
$SubTotal = round($TotalBruto,2);
//$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;	
	
//$Recargo = $InsNotaCreditoCompra->NccNacionalTotalRecargo;
//$SubTotal = round($SubTotal,2);

//$Impuesto = round(($SubTotal + $Recargo) * ($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
/*if($InsNotaCreditoCompra->NccIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsNotaCreditoCompra->NccPorcentajeImpuestoVenta/100);	
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
  <td width="18%" align="right" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstNotaCreditoCompraImprimirContenidoTotal">
    
    <span class="EstMonedaSimbolo"><?php echo $InsNotaCreditoCompra->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
    
    
    </td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiquetaTotal">Impuesto (<?php echo $InsNotaCreditoCompra->NccPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstNotaCreditoCompraImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsNotaCreditoCompra->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
    
    
    </td>
</tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstNotaCreditoCompraImprimirEtiquetaFondo"><span class="EstNotaCreditoCompraImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstNotaCreditoCompraImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsNotaCreditoCompra->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
