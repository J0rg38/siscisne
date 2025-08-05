
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

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

$InsAlmacenMovimientoEntrada->AmoId = $GET_id;
$InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntrada();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Entrada a Almacen No. <?php echo $InsAlmacenMovimientoEntrada->AmoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssAlmacenMovimientoEntradaSimple.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAlmacenMovimientoEntradaSimpleImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsAlmacenMovimientoEntrada->AmoId)){?> 
FncAlmacenMovimientoEntradaImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">INGRESO A ALMACEN X OTRO CONCEPTO
  <br /><?php echo $InsAlmacenMovimientoEntrada->AmoId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAlmacenMovimientoEntradaImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAlmacenMovimientoEntradaImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstAlmacenMovimientoEntradaImprimirCabecera">Datos de la Entrada a Almacen</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta"> Fecha de Ingreso:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Numero de Guia de Remision:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Fecha de Guia Remision:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstAlmacenMovimientoEntradaImprimirContenido">
        
        <?php echo $InsAlmacenMovimientoEntrada->AmoEstadoDescripcion;?>
        
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
  
  
  
  
  
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAlmacenMovimientoEntradaImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirCabecera">Comprobante de Pago</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta"> R.U.C.:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Proveedor:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->PrvNombreCompleto;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Numero de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Fecha de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido">
	  
	  
	<?php
    switch($InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto){
		
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
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoEntradaImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
    
    
    
    
    
    </td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenMovimientoEntradaImprimirTabla">
  <thead class="EstAlmacenMovimientoEntradaImprimirTablaHead">
    
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
  <tbody class="EstAlmacenMovimientoEntradaImprimirTablaBody">
  <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle)){
		
		foreach($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaSimpleDetalle){


			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$DatAlmacenMovimientoEntradaSimpleDetalle->AmdCosto = $DatAlmacenMovimientoEntradaSimpleDetalle->AmdCosto / $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$DatAlmacenMovimientoEntradaSimpleDetalle->AmdCosto = $DatAlmacenMovimientoEntradaSimpleDetalle->AmdCosto;
			}

			if($InsAlmacenMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte = $DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte / $InsAlmacenMovimientoEntrada->AmoTipoCambio;
			}else{
				$DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte = $DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte;
			}
			
			
?>

    
    <tr>
      <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaSimpleDetalle->ProId;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaSimpleDetalle->ProCodigoOriginal;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaSimpleDetalle->ProNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaSimpleDetalle->UmeNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatAlmacenMovimientoEntradaSimpleDetalle->AmdCantidad,2);?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        <?php echo number_format(($DatAlmacenMovimientoEntradaSimpleDetalle->AmdCosto),2);?>
      </td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        
        
        <?php echo number_format($DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte,2);?>
        
      </td>
      </tr>
  <?php	
		$TotalBruto += $DatAlmacenMovimientoEntradaSimpleDetalle->AmdImporte;
		
		$i++;
		}
	} 
	
//$SubTotal = round($SubTotal,2);
//$Recargo = $InsAlmacenMovimientoEntrada->AmoTotalRecargo;
//$Impuesto = round(($SubTotal + $Recargo) * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
if($InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;

}	
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
  <td width="18%" align="right" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstAlmacenMovimientoEntradaImprimirContenidoTotal">

    <span class="EstMonedaSimbolo"><?php echo $InsAlmacenMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>

 
  </td>
  </tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiquetaTotal">Recargo:</span></td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsAlmacenMovimientoEntrada->MonSimbolo; ?></span> <?php echo number_format($Recargo,2);?></td>
  </tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiquetaTotal">Impuesto (<?php echo $InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirContenidoTotal">
  

    <span class="EstMonedaSimbolo"><?php echo $InsAlmacenMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>

  
  </td>
  </tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoEntradaImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstAlmacenMovimientoEntradaImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsAlmacenMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
