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

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');

$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();

$InsAlmacenMovimientoSalida->AmoId = $GET_id;
$InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ficha de Salida No. <?php echo $InsAlmacenMovimientoSalida->AmoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssAlmacenMovimientoSalidaSimpleImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAlmacenMovimientoSalidaSimpleImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsAlmacenMovimientoSalida->AmoId)){?> 
FncAlmacenMovimientoSalidaImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">SALIDAS DE ALMACEN X OTROS CONCEPTOS<br />
  <?php echo $InsAlmacenMovimientoSalida->AmoId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAlmacenMovimientoSalidaSimpleImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAlmacenMovimientoSalidaSimpleImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstAlmacenMovimientoSalidaSimpleImprimirCabecera">Datos de la Salida de Almacen</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta"> Fecha de Salida:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->AmoFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Documento:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->AmoComprobanteNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Responsable:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->AmoResponsable;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->AmoTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido">
          
          <?php echo $InsAlmacenMovimientoSalida->AmoEstadoDescripcion;?>
          <?php
		/*switch($InsAlmacenMovimientoSalida->AmoEstado){
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
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaSimpleImprimirContenido"><?php echo $InsAlmacenMovimientoSalida->AmoObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenMovimientoSalidaSimpleImprimirTabla">
      <thead class="EstAlmacenMovimientoSalidaSimpleImprimirTablaHead">
        
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
          <th width="8%" align="center" >Valor Unitario</th>
          <th width="8%" align="center" >Valor Total</th>
          </tr>
        
        
        </thead>
      <tbody class="EstAlmacenMovimientoSalidaSimpleImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)){
		
		foreach($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle){


			if($InsAlmacenMovimientoSalida->MonId<>$EmpresaMonedaId){
				$DatAlmacenMovimientoSalidaDetalle->AmdCosto = $DatAlmacenMovimientoSalidaDetalle->AmdCosto / $InsAlmacenMovimientoSalida->AmoTipoCambio;
			}else{
				$DatAlmacenMovimientoSalidaDetalle->AmdCosto = $DatAlmacenMovimientoSalidaDetalle->AmdCosto;
			}

			if($InsAlmacenMovimientoSalida->MonId<>$EmpresaMonedaId ){
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte / $InsAlmacenMovimientoSalida->AmoTipoCambio;
			}else{
				$DatAlmacenMovimientoSalidaDetalle->AmdImporte = $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
			}
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->ProId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->ProNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            <?php echo number_format(($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta),2);?>
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            
            
            <?php echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdImporte,2);?>
            
            </td>
          </tr>
        <?php	
		$TotalBruto += $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
		
		$i++;
		}
	} 
	
//$SubTotal = round($SubTotal,2);
//$Recargo = $InsAlmacenMovimientoSalida->AmoTotalRecargo;
//$Impuesto = round(($SubTotal + $Recargo) * ($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
if($InsAlmacenMovimientoSalida->AmoIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100);	
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
  <td width="21%" align="right">&nbsp;</td>
  <td width="39%" align="right">&nbsp;</td>
  <td width="18%" align="right" class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaSimpleImprimirEtiquetaTotal">Total:</span></td>
  <td width="22%" align="right" class="EstAlmacenMovimientoSalidaSimpleImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsAlmacenMovimientoSalida->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
