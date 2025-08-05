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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ORDEN_COMPRA_".$GET_id.".xls\";");
}

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsOrdenCompra = new ClsOrdenCompra();

$InsOrdenCompra->OcoId = $GET_id;
$InsOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompra();
?>

<?php
if($_GET['P']<>2){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
if($_GET['P']<>2){
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Compra No. <?php echo $InsOrdenCompra->OcoId;?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
    <link href="css/CssOrdenCompraGM.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="js/JsOrdenCompraGMImprimir.js"></script>
    <script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>
    
    <script type="text/javascript">
    $().ready(function() {
        
    <?php if($_GET['P']==1 and !empty($InsOrdenCompra->OcoId)){?> 
    FncOrdenCompraImprimir(); 
    <?php }?>
    
    <?php if($_GET['P']==1){?>
    setTimeout("window.close();",1500);
    <?php }?>
        
    });
    </script>

<?php 
}
?>

</head>
<body>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top">
  
  
  <img src="../../imagenes/gm_logo.png" width="131" height="107" /><br />
  
	<span class="EstReporteTitulo">ORDEN DE COMPRA PERU - C&C<br />
	<?php echo $InsOrdenCompra->OcoId;?>  
	</span>
  
  
  </td>
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
      <td width="24%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Codigo SAP:</span></td>
      <td width="22%" align="left" valign="top" >&nbsp;</td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Codigo Dealer:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoCodigoDealer;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Fecha:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Hora:</span></td>
      <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoHora;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
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
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstReporteImprimirTabla">
      <thead class="EstReporteImprimirTablaHead">
        
        <tr>
          <th width="2%" align="center" >#</th>
          <th width="10%" align="center" >
            
            GM Part Number</th>
          <th width="11%" align="center" >
            GM PN Replace</th>
          <th width="10%" align="center" >Cantidad de Pedido</th>
          <th width="10%" align="center" >Partes a Atender</th>
          <th width="5%" align="center" >B/O</th>
          <th width="23%" align="center" >Descripcion</th>
          <th width="4%" align="center" >Año</th>
          <th width="10%" align="center" >Modelo</th>
          <th width="6%" align="center" >Precio</th>
          <th width="9%" align="center" >Total</th>
          </tr>
        
        
        </thead>
      <tbody class="EstReporteImprimirTablaBody">
        <?php
	$TotalCantidad = 0;
	$TotalImporte = 0;
	$i=1;
	if(is_array($InsOrdenCompra->OrdenCompraDetalle)){
		foreach($InsOrdenCompra->OrdenCompraDetalle as $DatOrdenCompraDetalle){


			if($InsOrdenCompra->MonId<>$EmpresaMonedaId and (!empty($InsOrdenCompra->OcoTipoCambio) )){
				$DatFacturaDetalle->OcdImporte = round($DatFacturaDetalle->OcdImporte / $InsOrdenCompra->OcoTipoCambio,2);
				$DatFacturaDetalle->OcdPrecio = round($DatFacturaDetalle->OcdPrecio  / $InsOrdenCompra->OcoTipoCambio,2);
			}
			
			
?>
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatOrdenCompraDetalle->OcdCodigoOtro;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatOrdenCompraDetalle->OcdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatOrdenCompraDetalle->ProNombre);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format(($DatOrdenCompraDetalle->OcdPrecio),2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatOrdenCompraDetalle->OcdImporte,2);?></td>
          </tr>
        <?php	

		
		$Total += $DatOrdenCompraDetalle->OcdImporte;
	
	
		$i++;
		}
		
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
          <td align="right" >&nbsp;</td>
          <td colspan="2" align="right" ><span class="EstReporteImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsOrdenCompra->MonSimbolo;?></span> <?php echo number_format($Total,2);?></span></td>
          </tr>
        
        
        </tbody>
    </table></td>
</tr>

  <tr>
    <td colspan="5" align="center"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstReporteImprimirTabla">
      <tr>
        <td width="5%" align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Observacion:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoObservacion;?></span></td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
</tr>
</table>

</body>
</html>
