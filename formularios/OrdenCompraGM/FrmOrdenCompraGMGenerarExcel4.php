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

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition:  filename=\"ORDEN_COMPRA_".$GET_id.".xls\";");

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsOrdenCompra = new ClsOrdenCompra();

$InsOrdenCompra->OcoId = $GET_id;
$InsOrdenCompra = $InsOrdenCompra->MtdObtenerOrdenCompra();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>


</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" class="EstReporteImprimirTabla">

<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td align="center" valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td align="center" valign="top"><br /></td>
  <td align="center" valign="top">
  
  <img src="http:www.marketbusinessnews.com\wp-content\uploads\2014\02\general_motors-logo-1_0.jpg" alt="" width="131" height="107" />
  
  
  
  </td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td align="center" valign="top"><span class="EstReporteTitulo"><br />
  </span></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top"><span class="EstReporteTitulo"><b>ORDEN DE COMPRA PERU - C&amp;C</b></span></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top"><b><?php echo $InsOrdenCompra->OcoId;?></b></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top"><span class="EstReporteImprimirEtiqueta">Codigo Dealer:</span></td>
  <td valign="top"><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoCodigoDealer;?></span></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
  <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Fecha:</span></td>
  <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoFecha;?></span></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo">&nbsp;</td>
  <td align="left" valign="top" class="EstReporteImprimirEtiquetaFondo"><span class="EstReporteImprimirEtiqueta">Hora:</span></td>
  <td align="left" valign="top" ><span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoHora;?></span></td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td colspan="11" valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td colspan="11" valign="top">&nbsp;</td>
  <td valign="top">&nbsp;</td>
</tr>
<tr>
  <td valign="top">&nbsp;</td>
  <td colspan="11" valign="top"><table width="1159"  border="1" cellpadding="1" cellspacing="0" class="EstReporteImprimirTabla">
    <thead class="EstReporteImprimirTablaHead">
      <tr>
        <th width="18" align="center" bgcolor="#CCCCCC" >#</th>
        <th width="99" align="center" bgcolor="#CCCCCC" > GM Part Number</th>
        <th width="102" align="center" bgcolor="#CCCCCC" > GM PN Replace</th>
        <th width="102" align="center" bgcolor="#CCCCCC" >Cantidad de Pedido</th>
        <th width="100" align="center" bgcolor="#CCCCCC" >Partes a Atender</th>
        <th width="88" align="center" bgcolor="#CCCCCC" >B/O</th>
        <th width="139" align="center" bgcolor="#CCCCCC" >Descripcion</th>
        <th width="29" align="center" bgcolor="#CCCCCC" >Año</th>
        <th width="57" align="center" bgcolor="#CCCCCC" >Modelo</th>
        <th width="63" align="center" bgcolor="#CCCCCC" >Precio</th>
        <th width="114" align="center" bgcolor="#CCCCCC" >Total</th>
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
        <td align="center" class="EstReporteDetalleImprimirContenido" >-</td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatOrdenCompraDetalle->OcdCantidad,2);?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" >-</td>
        <td align="center" class="EstReporteDetalleImprimirContenido" >-</td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo ($DatOrdenCompraDetalle->ProNombre);?></td>
        <td align="center" class="EstReporteDetalleImprimirContenido" >-</td>
        <td align="center" class="EstReporteDetalleImprimirContenido" >-</td>
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
        <td colspan="10" align="right">TOTAL:</td>
        <td align="right"><span class="EstReporteImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsOrdenCompra->MonSimbolo;?></span> <?php echo number_format($Total,2);?></span></td>
      </tr>
      </tbody>
  </table></td>
  <td valign="top">&nbsp;</td>
  </tr>

  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="11" align="left"><span class="EstReporteImprimirEtiqueta">Observacion: <span class="EstReporteImprimirContenido"><?php echo $InsOrdenCompra->OcoObservacion;?></span></span></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>

</body>
</html>
