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

require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTrasladoProductoDetalle.php');

$InsTrasladoProducto = new ClsTrasladoProducto();

$InsTrasladoProducto->TptId = $GET_id;
$InsTrasladoProducto->MtdObtenerTrasladoProducto();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ficha de Salida No. <?php echo $InsTrasladoProducto->TptId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssTrasladoProductoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTrasladoProductoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsTrasladoProducto->TptId)){?> 
FncTrasladoProductoImprimir(); 
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
  <?php echo $InsTrasladoProducto->TptId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTrasladoProductoImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTrasladoProductoImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstTrasladoProductoImprimirCabecera">Datos de la Traslado de Producto</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="24%" align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta"> Fecha de Salida:</span></td>
      <td width="22%" align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->TptFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Documento:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->TptReferenciaNumero;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Responsable:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->TptResponsable;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Moneda:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Tipo de Cambio:</span></td>
      <td align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->TptTipoCambio;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" >
        <span class="EstTrasladoProductoImprimirContenido">
          
          <?php echo $InsTrasladoProducto->TptEstadoDescripcion;?>
          <?php
		/*switch($InsTrasladoProducto->TptEstado){
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
      <td align="left" valign="top" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstTrasladoProductoImprimirContenido"><?php echo $InsTrasladoProducto->TptObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTrasladoProductoImprimirTabla">
      <thead class="EstTrasladoProductoImprimirTablaHead">
        
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
      <tbody class="EstTrasladoProductoImprimirTablaBody">
        <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsTrasladoProducto->TrasladoProductoDetalle)){
		
		foreach($InsTrasladoProducto->TrasladoProductoDetalle as $DatTrasladoProductoDetalle){


			if($InsTrasladoProducto->MonId<>$EmpresaMonedaId){
				$DatTrasladoProductoDetalle->TpdCosto = $DatTrasladoProductoDetalle->TpdCosto / $InsTrasladoProducto->TptTipoCambio;
			}else{
				$DatTrasladoProductoDetalle->TpdCosto = $DatTrasladoProductoDetalle->TpdCosto;
			}

			if($InsTrasladoProducto->MonId<>$EmpresaMonedaId ){
				$DatTrasladoProductoDetalle->TpdImporte = $DatTrasladoProductoDetalle->TpdImporte / $InsTrasladoProducto->TptTipoCambio;
			}else{
				$DatTrasladoProductoDetalle->TpdImporte = $DatTrasladoProductoDetalle->TpdImporte;
			}
			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoProductoDetalle->ProId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoProductoDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoProductoDetalle->ProNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatTrasladoProductoDetalle->UmeNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatTrasladoProductoDetalle->TpdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            <?php echo number_format(($DatTrasladoProductoDetalle->TpdPrecioVenta),2);?>
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            
            
            <?php echo number_format($DatTrasladoProductoDetalle->TpdImporte,2);?>
            
            </td>
          </tr>
        <?php	
		$TotalBruto += $DatTrasladoProductoDetalle->TpdImporte;
		
		$i++;
		}
	} 
	
//$SubTotal = round($SubTotal,2);
//$Recargo = $InsTrasladoProducto->TptTotalRecargo;
//$Impuesto = round(($SubTotal + $Recargo) * ($InsTrasladoProducto->TptPorcentajeImpuestoVenta/100),2);
//$Total = $SubTotal + $Recargo + $Impuesto;
if($InsTrasladoProducto->TptIncluyeImpuesto == 2){

	$ImpuestoVenta = ($InsTrasladoProducto->TptPorcentajeImpuestoVenta/100);
	$ImpuestoVenta = $ImpuestoVenta + 1;

	$SubTotal = (($TotalBruto /$ImpuestoVenta));
	$Impuesto = $TotalBruto - $SubTotal;
	$Total = $TotalBruto;

}else{

	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsTrasladoProducto->TptPorcentajeImpuestoVenta/100);	
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
  <td width="18%" align="right" class="EstTrasladoProductoImprimirEtiquetaFondo"><span class="EstTrasladoProductoImprimirEtiquetaTotal">Total:</span></td>
  <td width="22%" align="right" class="EstTrasladoProductoImprimirContenidoTotal">
    
    
    <span class="EstMonedaSimbolo"><?php echo $InsTrasladoProducto->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
    
    
    
    </td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
