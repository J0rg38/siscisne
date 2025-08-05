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

require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVehiculoMovimientoSalidaDetalle.php');

$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();

$InsVehiculoMovimientoSalida->VmvId = $GET_id;
$InsVehiculoMovimientoSalida->MtdObtenerVehiculoMovimientoSalida();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Salida de Unidad Vehicular No. <?php echo $InsVehiculoMovimientoSalida->VmvId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssVehiculoMovimientoSalidaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVehiculoMovimientoSalidaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVehiculoMovimientoSalida->VmvId)){?> 
FncVehiculoMovimientoSalidaImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">SALIDA DE UNIDAD VEHICULAR
  <br /><?php echo $InsVehiculoMovimientoSalida->VmvId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVehiculoMovimientoSalidaImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVehiculoMovimientoSalidaImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstVehiculoMovimientoSalidaImprimirCabecera">Datos de la Salida de Unidad Vehicular</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta"> Fecha de Salida:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta"> R.U.C.:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Cliente:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->CliNombreCompleto;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Numero de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Fecha de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido">
        <?php
    switch($InsVehiculoMovimientoSalida->VmvIncluyeImpuesto){
		
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
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstVehiculoMovimientoSalidaImprimirContenido">
        
         <?php echo $InsVehiculoMovimientoSalida->VmvEstadoDescripcion;?>
          <?php
		/*switch($InsVehiculoMovimientoSalida->VmvEstado){
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
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstVehiculoMovimientoSalidaImprimirContenido"><?php echo $InsVehiculoMovimientoSalida->VmvObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVehiculoMovimientoSalidaImprimirTabla">
      <thead class="EstVehiculoMovimientoSalidaImprimirTablaHead">
        
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
          <th width="7%" align="center" >Cantidad</th>
          <th width="8%" align="center" >Valor Unitario</th>
          <th width="6%" align="center" >Valor Total </th>
          <th width="10%" align="center" >Observaciones</th>
          </tr>
        
        
        </thead>
      <tbody class="EstVehiculoMovimientoSalidaImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle)){
		
		foreach($InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){


			if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
				$DatVehiculoMovimientoSalidaDetalle->VmdCosto = $DatVehiculoMovimientoSalidaDetalle->VmdCosto / $InsVehiculoMovimientoSalida->VmvTipoCambio;
			}else{
				$DatVehiculoMovimientoSalidaDetalle->VmdCosto = $DatVehiculoMovimientoSalidaDetalle->VmdCosto;
			}

			if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId ){
				$DatVehiculoMovimientoSalidaDetalle->VmdImporte = $DatVehiculoMovimientoSalidaDetalle->VmdImporte / $InsVehiculoMovimientoSalida->VmvTipoCambio;
			}else{
				$DatVehiculoMovimientoSalidaDetalle->VmdImporte = $DatVehiculoMovimientoSalidaDetalle->VmdImporte;
			}
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->VehId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->EinVIN;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->VmaNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->VmoNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->VveNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->EinColor;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->EinColorExterior;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->EinAnoFabricacion;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatVehiculoMovimientoSalidaDetalle->EinAnoModelo;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoMovimientoSalidaDetalle->VmdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            <?php echo number_format(($DatVehiculoMovimientoSalidaDetalle->VmdCosto),2);?>
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatVehiculoMovimientoSalidaDetalle->VmdImporte,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatVehiculoMovimientoSalidaDetalle->VmdObservacion);?></td>
          </tr>
        <?php	
		$TotalBruto += $DatVehiculoMovimientoSalidaDetalle->VmdImporte;
		
		$i++;
		}
	} 
	
	

if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
	
	
	$Recargo = $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo/ $InsVehiculoMovimientoSalida->VmvTipoCambio;
}else{
	
	$Recargo = $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo;
	
}

		
$SubTotal = round($TotalBruto,2);
//$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;	
	
//$Recargo = $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo;
//$SubTotal = round($SubTotal,2);

//$Impuesto = round(($SubTotal + $Recargo) * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
/*if($InsVehiculoMovimientoSalida->VmvIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100);	
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
  <td width="18%" align="right" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstVehiculoMovimientoSalidaImprimirContenidoTotal">
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoSalida->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
    
    
    </td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiquetaTotal">Impuesto (<?php echo $InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstVehiculoMovimientoSalidaImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoSalida->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
    
    
    </td>
</tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstVehiculoMovimientoSalidaImprimirEtiquetaFondo"><span class="EstVehiculoMovimientoSalidaImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstVehiculoMovimientoSalidaImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsVehiculoMovimientoSalida->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
