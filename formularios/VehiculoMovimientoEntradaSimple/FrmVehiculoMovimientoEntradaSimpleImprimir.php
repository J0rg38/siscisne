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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntrada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoEntradaDetalle.php');

$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();

$InsVehiculoMovimientoEntrada->VmvId = $GET_id;
$InsVehiculoMovimientoEntrada->MtdObtenerVehiculoMovimientoEntrada();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Ingreso de Unidad Vehicular No. <?php echo $InsVehiculoMovimientoEntrada->VmvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssVehiculoMovimientoEntradaSimpleImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoMovimientoEntradaSimpleImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoMovimientoEntrada->VmvId)){?> 
FncVehiculoMovimientoEntradaImprimir(); 
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
  <br /><?php echo $InsVehiculoMovimientoEntrada->VmvId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoMovimientoEntradaImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoMovimientoEntradaImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstVehiculoMovimientoEntradaImprimirCabecera">Datos de la Ingreso de Unidad Vehicular</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta"> Fecha de Ingreso:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta"> R.U.C.:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->PrvNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Proveedor:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->PrvNombreCompleto;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Numero  Doc. Entrada:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Fecha Doc. Entrada:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido">
        <?php
    switch($InsVehiculoMovimientoEntrada->VmvIncluyeImpuesto){
		
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
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstVehiculoMovimientoEntradaImprimirContenido">
        
         <?php echo $InsVehiculoMovimientoEntrada->VmvEstadoDescripcion;?>
          <?php
		/*switch($InsVehiculoMovimientoEntrada->VmvEstado){
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
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstVehiculoMovimientoEntradaImprimirContenido"><?php echo $InsVehiculoMovimientoEntrada->VmvObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVehiculoMovimientoEntradaImprimirTabla">
      <thead class="EstVehiculoMovimientoEntradaImprimirTablaHead">
        
        <tr>
          <th width="3%" align="center" >#</th>
          <th width="3%" align="center" >
            
            Id</th>
          <th width="5%" align="center" >VIN</th>
          <th width="6%" align="center" >Marca</th>
          <th width="7%" align="center" >Modelo</th>
          <th width="7%" align="center" >Version</th>
          <th width="10%" align="center" >Color Exterior</th>
          <th width="10%" align="center" >Color Interior</th>
          <th width="10%" align="center" >Año Fab.</th>
          <th width="8%" align="center" >Año Mod.</th>
          <th width="7%" align="center" >U.M.</th>
          <th width="7%" align="center" >Cantidad</th>
          <th width="8%" align="center" >Valor Unitario</th>
          <th width="6%" align="center" >Valor Total </th>
          <th width="10%" align="center" >Observaciones</th>
          </tr>
        
        
        </thead>
      <tbody class="EstVehiculoMovimientoEntradaImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle)){
		
		foreach($InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle as $DatVehiculoMovimientoEntradaDetalle){


			if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId){
				$DatVehiculoMovimientoEntradaDetalle->VmdCosto = $DatVehiculoMovimientoEntradaDetalle->VmdCosto / $InsVehiculoMovimientoEntrada->VmvTipoCambio;
			}else{
				$DatVehiculoMovimientoEntradaDetalle->VmdCosto = $DatVehiculoMovimientoEntradaDetalle->VmdCosto;
			}

			if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId ){
				$DatVehiculoMovimientoEntradaDetalle->VmdImporte = $DatVehiculoMovimientoEntradaDetalle->VmdImporte / $InsVehiculoMovimientoEntrada->VmvTipoCambio;
			}else{
				$DatVehiculoMovimientoEntradaDetalle->VmdImporte = $DatVehiculoMovimientoEntradaDetalle->VmdImporte;
			}
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->VehId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->EinVIN;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->VmaNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->VmoNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->VveNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->EinColor;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->EinColorExterior;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->EinAnoFabricacion;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoEntradaDetalle->EinAnoModelo;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatVehiculoMovimientoEntradaDetalle->UmeNombre);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoMovimientoEntradaDetalle->VmdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            <?php echo number_format(($DatVehiculoMovimientoEntradaDetalle->VmdCosto),2);?>
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoMovimientoEntradaDetalle->VmdImporte,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatVehiculoMovimientoEntradaDetalle->VmdObservacion);?></td>
          </tr>
        <?php	
		$TotalBruto += $DatVehiculoMovimientoEntradaDetalle->VmdImporte;
		
		$i++;
		}
	} 
	
	

if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId){
	
	
	$Recargo = $InsVehiculoMovimientoEntrada->VmvNacionalTotalRecargo/ $InsVehiculoMovimientoEntrada->VmvTipoCambio;
}else{
	
	$Recargo = $InsVehiculoMovimientoEntrada->VmvNacionalTotalRecargo;
	
}

		
$SubTotal = round($TotalBruto,2);
//$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;	
	
//$Recargo = $InsVehiculoMovimientoEntrada->VmvNacionalTotalRecargo;
//$SubTotal = round($SubTotal,2);

//$Impuesto = round(($SubTotal + $Recargo) * ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
/*if($InsVehiculoMovimientoEntrada->VmvIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100);	
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
  <td width="18%" align="right" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstVehiculoMovimientoEntradaImprimirContenidoTotal">
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
    
    
    </td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiquetaTotal">Impuesto (<?php echo $InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstVehiculoMovimientoEntradaImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
    
    
    </td>
</tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstVehiculoMovimientoEntradaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoEntradaImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstVehiculoMovimientoEntradaImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoEntrada->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
