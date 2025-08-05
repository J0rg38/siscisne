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
<title>PEDIDO DE COMPRA No. <?php echo $InsPedidoCompra->PcoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssPedidoCompra.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPedidoCompraImprimir.js"></script>
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
  <span class="EstPlantillaTitulo">PEDIDO DE COMPRA</span><br />
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
      <td colspan="6" align="left" valign="top"><span class="EstPedidoCompraImprimirCabecera">Datos del Pedido de Compra</span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="14%" align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="24%" align="left" valign="top" >&nbsp;</td>
      <td width="14%" align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">Fecha</span></td>
      <td width="1%" align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td width="45%" align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PcoFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">NUM. DOCUMENTO</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->TdoNombre;?>/<?php echo $InsPedidoCompra->CliNumeroDocumento;?></span></td>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">CLIENTE</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido">
	  
	  <?php echo $InsPedidoCompra->CliNombre;?> <?php echo $InsPedidoCompra->CliApellidoPaterno;?> <?php echo $InsPedidoCompra->CliApellidoMaterno;?>
      
	  </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">COTIZACION</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->CprId;?></span></td>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">ORD. VENTA</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->VdiId;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">ORDEN COMPRA</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirContenido">
	  

        <?php
				  
				  if(!empty($InsPedidoCompra->OcoId)){
				?>
                <?php echo $InsPedidoCompra->OcoId;?>
                <?php
				  }else{
				?>
                No tiene orden a proveedor
                <?php	  
				  }
				  
				  ?>
                
      
      </span></td>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiqueta">Estado</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" >
        <span class="EstPedidoCompraImprimirContenido">
          
          <?php echo $InsPedidoCompra->PcoEstadoDescripcion?>
          </span></td>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
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
          <th width="10%" align="center" >
            
            Cod. Original</th>
          <th width="58%" align="center" >
            Descripcion
            
            </th>
          <th width="9%" align="center" >U.M.</th>
          <th width="10%" align="center" >Cantidad</th>
          <th width="10%" align="center" >Importe</th>
          </tr>
        
        
        </thead>
      <tbody class="EstPedidoCompraImprimirTablaBody">
        <?php
	
	$i=1;
	$TotalBruto = 0;
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
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>
          </tr>
        <?php	
		
		
			$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
	
	
		$i++;
		}
		
		
	} 
	
	
if($InsPedidoCompra->PcoIncluyeImpuesto == 2){
	
	$SubTotal = $TotalBruto;
	$Impuesto = $SubTotal * ($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100);	
	$Total = $SubTotal + $Impuesto;
	
}else{
	
	$Total = $TotalBruto;
	$SubTotal = $Total / (($InsPedidoCompra->PcoPorcentajeImpuestoVenta/100)+1);
	$Impuesto = $Total - $SubTotal;	

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
          <td width="11%" rowspan="3" align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">Observacion</span></td>
          <td align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
          <td width="55%" rowspan="3" align="left" valign="top"><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PcoObservacion;?></span></td>
          <td align="right" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">SUB Total:</span></td>
          <td align="right" valign="top" ><span class="EstMonedaSimbolo">
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
          <td align="right" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">IMPUESTO (<?php echo $InsPedidoCompra->PcoPorcentajeImpuestoVenta; ?>):</span></td>
          <td align="right" valign="top" ><span class="EstMonedaSimbolo">
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
          <td width="1%" align="right" valign="top">&nbsp;</td>
          <td width="16%" align="right" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">Total:</span></td>
          <td width="17%" align="right" valign="top" ><span class="EstMonedaSimbolo"><?php
echo $InsPedidoCompra->MonSimbolo;
?></span> <span class="EstPedidoCompraImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span></td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left"><p><strong>Nota:</strong></p>
      <ul type="disc">
        <li>Los precios están expresados en <?php echo $InsPedidoCompra->MonNombre;?>.</li>
        <?php
				if(!empty($InsPedidoCompra->PcoTipoCambio)){
					?>
        <li> Tipo de Cambio <?php echo $InsPedidoCompra->PcoTipoCambio;?>. </li>
        <?php
				}
				?>
       
    </ul></td>
  </tr>
  <tr>
    <td colspan="5" align="center"></td>
  </tr>

</table>

</body>
</html>
