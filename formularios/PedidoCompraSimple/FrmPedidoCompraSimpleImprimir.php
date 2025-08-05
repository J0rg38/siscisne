<?php
@session_start();
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

require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompra.php');
require_once($InsPoo->MtdPaqLogistica().'ClsPedidoCompraDetalle.php');

$InsPedidoCompra = new ClsPedidoCompra();

$InsPedidoCompra->PcoId = $GET_id;
$InsPedidoCompra = $InsPedidoCompra->MtdObtenerPedidoCompra();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ORDEN DE COMPRA (OTROS PROVEEDORES) No. <?php echo $InsPedidoCompra->PcoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssPedidoCompraSimpleImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPedidoCompraSimpleImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsPedidoCompra->PcoId)){?> 
FncPedidoCompraImprimir(); 
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
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top">
  <span class="EstPlantillaTitulo">ORDEN DE COMPRA</span><br />
    <span class="EstPlantillaTituloCodigo"><?php echo $InsPedidoCompra->PcoId;?></span>
  
  
  </td>
  <td width="28%" align="right" valign="top">
    <span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />

    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPedidoCompraImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPedidoCompraImprimirTabla">
    <tr>
      <td colspan="6" align="left" valign="top"><span class="EstPedidoCompraImprimirCabecera">Datos del Orden de Compra</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">PROVEEDOR</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td width="35%" align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"> <?php echo $InsPedidoCompra->PrvNombre;?> <?php echo $InsPedidoCompra->PrvApellidoPaterno;?> <?php echo $InsPedidoCompra->PrvApellidoMaterno;?> </span></td>
      <td width="12%" align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td width="36%" align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PcoFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">NUM. DOC.</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PrvNumeroDocumento;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">MONEDA</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->MonNombre?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPedidoCompraImprimirTabla">
      <thead class="EstPedidoCompraImprimirTablaHead">
        
        <tr>
          <th width="3%" align="center" >#</th>
          <th width="9%" align="center" >
            
            Cod. Original</th>
          <th width="52%" align="center" >
            Descripcion
            
            </th>
          <th width="9%" align="center" >Cantidad</th>
          <th width="10%" align="center" >U.M.</th>
          <th width="9%" align="center" >PRECIO</th>
          <th width="8%" align="center" >Importe</th>
          </tr>
        
        
        </thead>
      <tbody class="EstPedidoCompraImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
		foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){


			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
			}

			if($InsPedidoCompra->MonId<>$EmpresaMonedaId ){
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte / $InsPedidoCompra->PcoTipoCambio;
			}else{
				$DatPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
			}
			
			
			
?>
        
        <tr>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->PcdCodigo;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdPrecio,2);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>
          </tr>
        <?php	
		
		
			$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
	
	
		$i++;
		}
		
		
	} 
	
	
	if($InsPedidoCompra->PcoIncluyeImpuesto==2){
		$SubTotal = round($TotalBruto,6);
		$Impuesto = round(($SubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)),6);
		$Total = round($SubTotal + $Impuesto,6);
	}else{
		$Total = round($TotalBruto,6);	
		$SubTotal = round($Total / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1),6);
		$Impuesto = round(($Total - $SubTotal),6);
	}


?>
        
        
        </tbody>
    </table></td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">Observaciones</span></td>
          <td align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
          <td width="49%" rowspan="3" align="left" valign="top"><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PcoObservacionImpresa;?></span></td>
          <td align="right" valign="middle" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">SUBTOTAL:</span></td>
          <td align="right" valign="middle" ><span class="EstPedidoCompraImprimirMoneda">
            <?php
echo $InsPedidoCompra->MonSimbolo;
?>
          </span> <span class="EstPedidoCompraImprimirContenidoTotal">
          <?php
echo number_format($SubTotal, 2);
?>
          </span></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="right" valign="middle" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">IMPUESTO:</span></td>
          <td align="right" valign="middle" ><span class="EstPedidoCompraImprimirMoneda">
            <?php
echo $InsPedidoCompra->MonSimbolo;
?>
          </span> <span class="EstPedidoCompraImprimirContenidoTotal">
          <?php
echo number_format($Impuesto, 2);
?>
          </span></td>
        </tr>
        <tr>
          <td width="11%" align="right" valign="top">&nbsp;</td>
          <td width="1%" align="right" valign="top">&nbsp;</td>
          <td width="20%" align="right" valign="middle" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">Total:</span></td>
          <td width="19%" align="right" valign="middle" ><span class="EstPedidoCompraImprimirMoneda"><?php
echo $InsPedidoCompra->MonSimbolo;
?></span> <span class="EstPedidoCompraImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span></td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left"></td>
  </tr>
  <tr>
    <td colspan="5" align="center"><table class="EstTablaTotal" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top" >&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" align="center" valign="top">_________________________________<br />
            <span class="EstPedidoCompraImprimirContenidoFirma"><?php echo $InsPedidoCompra->PerNombre;?> <?php echo $InsPedidoCompra->PerApellidoPaterno;?> <?php echo $InsPedidoCompra->PerApellidoMaterno;?><br />
            <?php echo $InsPedidoCompra->PerNumeroDocumento;?></span></td>
          <td width="50%" align="center" valign="top" >&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
  </tr>

</table>

</body>
</html>
