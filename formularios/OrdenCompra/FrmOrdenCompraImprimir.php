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

if($_GET['P']==2){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition:  filename=\"ORDEN_COMPRA_".$GET_id.".xls\";");
}

require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsOrdenCompraPedido.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsOrdenCompra = new ClsOrdenCompra();

$InsOrdenCompra->OcoId = $GET_id;
$InsOrdenCompra->MtdObtenerOrdenCompra();
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
    <link href="css/CssOrdenCompra.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="js/JsOrdenCompraImprimir.js"></script>
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
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top">
  
    <span class="EstPlantillaTitulo">ORDEN DE COMPRA PERU - C&C</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsOrdenCompra->OcoId;?>  </span>
    

  
  
  </td>
  <td width="28%" align="right" valign="top">
   
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span>
    
    
   </td>
</tr>
</table>

<hr class="EstPlantillaLinea">


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstOrdenCompraImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenCompraImprimirTabla">
    <tr>
      <td width="24%" align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">Codigo SAP:</span></td>
      <td width="22%" align="left" valign="top" >&nbsp;</td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="22%" align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td width="29%" align="left" valign="top" >&nbsp;</td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">Codigo Dealer:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoCodigoDealer;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">Fecha:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">VIN:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">Hora:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoHora;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">ORDEN DE TRABAJO:</span></td>
      <td align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoOrdenTrabajo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
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
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstOrdenCompraImprimirTabla">
      <thead class="EstOrdenCompraImprimirTablaHead">
        
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
      <tbody class="EstOrdenCompraImprimirTablaBody">
        <?php
		

$TotalBruto = 0;

$SubTotal = 0;
$Impuesto = 0;
$Total = 0;

$i=1;	
if(!empty($InsOrdenCompra->OrdenCompraPedido)){
	foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
		
		$InsPedidoCompra1 = new ClsPedidoCompra();
		$InsPedidoCompra1->PcoId = $DatOrdenCompraPedido->PcoId;
		$InsPedidoCompra1->MtdObtenerPedidoCompra();
					
			$InsPedidoCompra1->PcoSubTotal = 0;
			$InsPedidoCompra1->PcoImpuesto = 0;
			$InsPedidoCompra1->PcoTotal = 0;
			$InsPedidoCompra1->PcoTotalBruto = 0;
			
			foreach($InsPedidoCompra1->PedidoCompraDetalle as $DatPedidoCompraDetalle){
			
				if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
					$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra1->PcoTipoCambio,2);
					$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $InsPedidoCompra1->PcoTipoCambio,2);
				}
					
?>
        <tr>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->PcdCodigo;?></td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" ><?php echo ($DatPedidoCompraDetalle->ProNombre);?></td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" ><?php echo number_format(($DatPedidoCompraDetalle->PcdPrecio),2);?></td>
          <td align="right" class="EstOrdenCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>
          </tr>
<?php
				
				$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
				$i++;

			}
		
		if($InsPedidoCompra1->PcoIncluyeImpuesto==2){
			$InsPedidoCompra1->PcoSubTotal = round($TotalBruto,6);
			$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoSubTotal * ($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)),6);
			$InsPedidoCompra1->PcoTotal = round($InsPedidoCompra1->PcoSubTotal + $InsPedidoCompra1->PcoImpuesto,6);
		}else{
			$InsPedidoCompra1->PcoTotal = round($TotalBruto,6);	
			$InsPedidoCompra1->PcoSubTotal = round($InsPedidoCompra1->PcoTotal / (($InsPedidoCompra1->PcoPorcentajeImpuestoVenta/100)+1),6);
			$InsPedidoCompra1->PcoImpuesto = round(($InsPedidoCompra1->PcoTotal - $InsPedidoCompra1->PcoSubTotal),6);
		}
		
		$SubTotal += $InsPedidoCompra1->PcoSubTotal;
		$Impuesto += $InsPedidoCompra1->PcoImpuesto;
		$Total += $InsPedidoCompra1->PcoTotal;
								
	}
}

	

	
	
//if($InsOrdenCompra->OcoIncluyeImpuesto == 2){
//	
//	$SubTotal = $TotalBruto;
//	$Impuesto = $SubTotal * ($InsOrdenCompra->OcoPorcentajeImpuestoVenta/100);	
//	$Total = $SubTotal + $Impuesto;
//	
//}else{
//	
//	$Total = $TotalBruto;
//	$SubTotal = $Total / (($InsOrdenCompra->OcoPorcentajeImpuestoVenta/100)+1);
//	$Impuesto = $Total - $SubTotal;	
//
//}

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
          <td align="right" ></td>
          <td align="right" >&nbsp;</td>
          </tr>
        
        
        </tbody>
    </table></td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstOrdenCompraImprimirTabla">
      <tr>
        <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo"><span class="EstOrdenCompraImprimirEtiqueta">Observacion:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstOrdenCompraImprimirContenido"><?php echo $InsOrdenCompra->OcoObservacion;?></span></td>
        <td align="left" valign="top"><span class="EstOrdenCompraImprimirEtiquetaFondo">
          <?php
if ($_GET['P'] != 1) {
?>
          <span class="EstOrdenCompraImprimirEtiquetaTotal">Sub Total:</span>
          <?php
}
?>
        </span></td>
        <td align="left" valign="top"><span class="EstOrdenCompraImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsOrdenCompra->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?></span></td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
        <td colspan="4" align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top"><span class="EstOrdenCompraImprimirEtiquetaFondo">
          <?php
if ($_GET['P'] != 1) {
?>
          <span class="EstOrdenCompraImprimirEtiquetaTotal">Impuesto:</span>
          <?php
}
?>
        </span></td>
        <td align="left" valign="top"><span class="EstOrdenCompraImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsOrdenCompra->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?></span></td>
        </tr>
      <tr>
        <td width="14%" align="left" valign="top" class="EstOrdenCompraImprimirEtiquetaFondo">&nbsp;</td>
        <td colspan="4" align="left" valign="top" >&nbsp;</td>
        <td width="13%" align="left" valign="top"><span class="EstOrdenCompraImprimirEtiquetaFondo">
          <?php
if ($_GET['P'] != 1) {
?>
          <span class="EstOrdenCompraImprimirEtiquetaTotal">Total:</span>
          <?php
}
?>
        </span></td>
        <td width="14%" align="left" valign="top"><span class="EstOrdenCompraImprimirContenidoTotal"><span class="EstMonedaSimbolo"><?php echo $InsOrdenCompra->MonSimbolo;?></span> <?php echo number_format($Total,2);?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
</tr>
</table>

</body>
</html>
