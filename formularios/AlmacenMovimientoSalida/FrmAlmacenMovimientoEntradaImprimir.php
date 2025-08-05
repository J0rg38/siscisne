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
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsAlmacenMovimientoEntrada = new ClsAlmacenMovimientoEntrada();

$InsAlmacenMovimientoEntrada->AmoId = $GET_id;
$InsAlmacenMovimientoEntrada = $InsAlmacenMovimientoEntrada->MtdObtenerAlmacenMovimientoEntrada();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrada de Almacen No. <?php echo $InsAlmacenMovimientoEntrada->AmoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssAlmacenMovimientoEntrada.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAlmacenMovimientoEntradaImprimir.js"></script>
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


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">ENTRADA A ALMACEN
  <br /><?php echo $InsAlmacenMovimientoEntrada->AmoId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstReporteImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstReporteImprimirCabecera">Datos de la Entrada a Almacen</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta"> Fecha de Ingreso:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Numero de Guia de Remision:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoGuiaRemisionNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Fecha de Guia Remision:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstReporteImprimirContenido">
          <?php
		switch($InsAlmacenMovimientoEntrada->AmoEstado){
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
		}
	?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top" class="EstReporteImprimirCabecera">Comprobante de Pago</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta"> R.U.C.:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->PrvNumeroDocumento;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Proveedor:</span></td>
      <td width="29%" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->PrvNombre;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Numero de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Fecha de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Impuesto</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstReporteImprimirTabla">
  <thead class="EstReporteImprimirTablaHead">
    
  <tr>
    <th width="2%" align="center" >#</th>
    <th width="6%" align="center" >
      
      Id</th>
    <th width="56%" align="center" >
      Descripcion
      
    </th>
    <th width="8%" align="center" >U.M.</th>
    <th width="8%" align="center" >Cantidad</th>
    <th width="9%" align="center" >Valor Unitario</th>
    <th width="11%" align="center" >Valor Total</th>
    </tr>
    
    
  </thead>
  <tbody class="EstReporteImprimirTablaBody">
  <?php
	$TotalCantidad = 0;
	$TotalImporte = 0;
	$i=1;
	if(is_array($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle)){
		
		foreach($InsAlmacenMovimientoEntrada->AlmacenMovimientoEntradaDetalle as $DatAlmacenMovimientoEntradaDetalle){

?>

    
    <tr>
      <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->ProId;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->ProNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatAlmacenMovimientoEntradaDetalle->AmdCantidad,2);?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        <?php echo number_format(($DatAlmacenMovimientoEntradaDetalle->AmdCosto),2);?>
      </td>
      <td align="right" class="EstReporteDetalleImprimirContenido" >
        
        
        <?php echo number_format($DatAlmacenMovimientoEntradaDetalle->AmdImporte,2);?>
        
      </td>
      </tr>
  <?php	
		/*$TotalCantidad += $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
		$TotalImporte += $DatAlmacenMovimientoEntradaDetalle->AmdImporte;*/
			
		$TotalBruto += $DatAlmacenMovimientoEntradaDetalle->AmdImporte;
		$TotalCantidad += $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
	
		$i++;
		}
		
		
	} 
	
	
	
	
	
	
if($InsAlmacenMovimientoEntrada->AmoIncluyeImpuesto==1){
	$ImpuestoVenta = ($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;
	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;

	$Total = $TotalBruto;

}else{
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal*($InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta/100);	

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
      </tr>
    
    
  </tbody>
  </table></td>
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
  <td width="18%" align="right" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstReporteImprimirContenidoTotal">

    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($SubTotal,2);?>

 
  </td>
  </tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiquetaTotal">Impuesto (<?php echo $InsAlmacenMovimientoEntrada->AmoPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstReporteImprimirContenidoTotal">
  

    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($Impuesto,2);?>

  
  </td>
  </tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstReporteImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $EmpresaMoneda;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
