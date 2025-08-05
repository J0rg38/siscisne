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

require_once($InsPoo->MtdPaqAlmacen().'ClsPagoVehiculoIngreso.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPagoVehiculoIngreso.php');

$InsPagoVehiculoIngreso = new ClsPagoVehiculoIngreso();

$InsPagoVehiculoIngreso->PviId = $GET_id;
$InsPagoVehiculoIngreso->MtdObtenerPagoVehiculoIngreso();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Pago de Vehiculo No. <?php echo $InsPagoVehiculoIngreso->PviId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssPagoVehiculoIngresoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPagoVehiculoIngresoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsPagoVehiculoIngreso->PviId)){?> 
FncPagoVehiculoIngresoImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">PAGO DE VEHICULO
  <br /><?php echo $InsPagoVehiculoIngreso->PviId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoVehiculoIngresoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoVehiculoIngresoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstPagoVehiculoIngresoImprimirCabecera">Datos del Pago de Vehiculo</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta"> Fecha de Ingreso:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta"> R.U.C.:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PrvNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Proveedor:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PrvNombreCompleto;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Tipo de Comprobante:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->CtiNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Numero  Doc. Entrada:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Fecha Doc. Entrada:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviComprobanteFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Incluye Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido">
        <?php
    switch($InsPagoVehiculoIngreso->PviIncluyeImpuesto){
		
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
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Impuesto:</span></td>
      <td align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstPagoVehiculoIngresoImprimirContenido">
        
         <?php echo $InsPagoVehiculoIngreso->PviEstadoDescripcion;?>
          <?php
		/*switch($InsPagoVehiculoIngreso->PviEstado){
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
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstPagoVehiculoIngresoImprimirContenido"><?php echo $InsPagoVehiculoIngreso->PviObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPagoVehiculoIngresoImprimirTabla">
      <thead class="EstPagoVehiculoIngresoImprimirTablaHead">
        
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
      <tbody class="EstPagoVehiculoIngresoImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsPagoVehiculoIngreso->PagoVehiculoIngreso)){
		
		foreach($InsPagoVehiculoIngreso->PagoVehiculoIngreso as $DatPagoVehiculoIngreso){


			if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId){
				$DatPagoVehiculoIngreso->PvdCosto = $DatPagoVehiculoIngreso->PvdCosto / $InsPagoVehiculoIngreso->PviTipoCambio;
			}else{
				$DatPagoVehiculoIngreso->PvdCosto = $DatPagoVehiculoIngreso->PvdCosto;
			}

			if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId ){
				$DatPagoVehiculoIngreso->PvdImporte = $DatPagoVehiculoIngreso->PvdImporte / $InsPagoVehiculoIngreso->PviTipoCambio;
			}else{
				$DatPagoVehiculoIngreso->PvdImporte = $DatPagoVehiculoIngreso->PvdImporte;
			}
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->VehId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->EinVIN;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->VmaNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->VmoNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->VveNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->EinColor;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->EinColorExterior;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->EinAnoFabricacion;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPagoVehiculoIngreso->EinAnoModelo;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatPagoVehiculoIngreso->UmeNombre);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatPagoVehiculoIngreso->PvdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            <?php echo number_format(($DatPagoVehiculoIngreso->PvdCosto),2);?>
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatPagoVehiculoIngreso->PvdImporte,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatPagoVehiculoIngreso->PvdObservacion);?></td>
          </tr>
        <?php	
		$TotalBruto += $DatPagoVehiculoIngreso->PvdImporte;
		
		$i++;
		}
	} 
	
	

if($InsPagoVehiculoIngreso->MonId<>$EmpresaMonedaId){
	
	
	$Recargo = $InsPagoVehiculoIngreso->PviNacionalTotalRecargo/ $InsPagoVehiculoIngreso->PviTipoCambio;
}else{
	
	$Recargo = $InsPagoVehiculoIngreso->PviNacionalTotalRecargo;
	
}

		
$SubTotal = round($TotalBruto,2);
//$Recargo = $POST_TotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;	
	
//$Recargo = $InsPagoVehiculoIngreso->PviNacionalTotalRecargo;
//$SubTotal = round($SubTotal,2);

//$Impuesto = round(($SubTotal + $Recargo) * ($InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
/*if($InsPagoVehiculoIngreso->PviIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta/100);	
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
  <td width="18%" align="right" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiquetaTotal">SubTotal:</span></td>
  <td width="22%" align="right" class="EstPagoVehiculoIngresoImprimirContenidoTotal">
    
    <span class="EstMonedaSimbolo"><?php echo $InsPagoVehiculoIngreso->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
    
    
    </td>
</tr>
<tr>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiquetaTotal">Impuesto (<?php echo $InsPagoVehiculoIngreso->PviPorcentajeImpuestoVenta;?>%):</span></td>
  <td align="right" class="EstPagoVehiculoIngresoImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsPagoVehiculoIngreso->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
    
    
    </td>
</tr>



  
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstPagoVehiculoIngresoImprimirEtiquetaFondo"><span class="EstPagoVehiculoIngresoImprimirEtiquetaTotal">Total:</span></td>
  <td align="right" class="EstPagoVehiculoIngresoImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsPagoVehiculoIngreso->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
