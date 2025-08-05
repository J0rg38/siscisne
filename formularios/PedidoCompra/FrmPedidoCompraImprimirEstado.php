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
require_once($InsPoo->MtdPaqContabilidad().'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsPagoComprobante.php');

$InsPedidoCompra = new ClsPedidoCompra();
$InsPago = new ClsPago();

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
  <span class="EstPlantillaTitulo">PEDIDO DE COMPRA/ESTADO</span><br />
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
          <th width="3%" rowspan="2" align="center" >#</th>
          <th width="6%" rowspan="2" align="center" >
            
            Cod. Original</th>
          <th width="42%" rowspan="2" align="center" >
            Descripcion          </th>
          <th width="7%" rowspan="2" align="center" >U.M.</th>
          <th width="7%" rowspan="2" align="center" >Cantidad</th>
          <th width="6%" rowspan="2" align="center" >Importe</th>
          <th colspan="2" align="center" >Back Order</th>
          <th colspan="2" align="center" >Despacho</th>
          </tr>
        <tr>
          <th width="7%" class="EstTablaListado">Fec. Llegada GM</th>
          <th width="7%" class="EstTablaListado">Status GM</th>
          <th width="7%" class="EstTablaListado">Fecha</th>
          <th width="8%" class="EstTablaListado">Cant.</th>
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
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->ProCodigoOriginal;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->ProNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPedidoCompraDetalle->UmeNombre;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdCantidad,2);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraDetalle->PcdImporte,2);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatPedidoCompraDetalle->PcdBOFecha);?></td>
          <td align="center" class="EstTablaListado" ><?php echo ($DatPedidoCompraDetalle->PcdBOEstado);?></td>
          <td align="center" class="EstTablaListado"><?php echo ($DatPedidoCompraDetalle->PleFecha);?></td>
          <td align="center" class="EstTablaListado"><?php echo number_format($DatPedidoCompraDetalle->PldCantidad,2);?></td>
          </tr>
        <?php	
		
		
			$Total += $DatPedidoCompraDetalle->PcdImporte;
	
	
		$i++;
		}
		
		
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
          <td width="11%" align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">Observacion</span></td>
          <td width="1%" align="right" valign="top"><span class="EstPedidoCompraImprimirEtiqueta">:</span></td>
          <td width="49%" align="left" valign="top"><span class="EstPedidoCompraImprimirContenido"><?php echo $InsPedidoCompra->PcoObservacion;?></span></td>
          <td width="20%" align="right" valign="top" class="EstPedidoCompraImprimirEtiquetaFondo"><span class="EstPedidoCompraImprimirEtiquetaTotal">Total:</span></td>
          <td width="19%" align="right" valign="top" ><span class="EstMonedaSimbolo"><?php
echo $InsPedidoCompra->MonSimbolo;
?></span> <span class="EstPedidoCompraImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span></td>
          </tr>
        </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" align="left"><span class="EstPedidoCompraImprimirCabecera">Informacion de abonos</span></td>
  </tr>
  <tr>
    <td colspan="5" align="left">
    
<?php
if(!empty($InsPedidoCompra->VdiId)){
?>



<?php

$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagTiempoCreacion","DESC",NULL,NULL,$InsPedidoCompra->VdiId,NULL,NULL,NULL);
$ArrPagos = $ResPago['Datos'];

?>
    
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPedidoCompraImprimirTabla">
      <thead class="EstPedidoCompraImprimirTablaHead">
        
        <tr>
          <th width="3%" align="center" >#</th>
          <th width="11%" align="center" >NUM. RECIBO</th>
          <th width="16%" align="center" >
            
            FECHA</th>
          <th width="14%" align="center" >MONEDA</th>
          <th width="34%" align="center" >T.C.</th>
          <th width="14%" align="center" >
            FESTADO</th>
          <th width="8%" align="center" >MONTO</th>
        </tr>
        </thead>
      <tbody class="EstPedidoCompraImprimirTablaBody">
        <?php
	
	$i=1;
	$Total = 0;
	if(!empty($ArrPagos)){
		foreach($ArrPagos as $DatPago){
//
//			if($InsPedidoCompra->MonId<>$EmpresaMonedaId){
//				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio / $InsPedidoCompra->PcoTipoCambio;
//			}else{
//				$DatPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
//			}

?>
        
        <tr>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPago->PagNumeroRecibo;  ?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo $DatPago->PagFecha;?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo ($DatPago->MonNombre);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo ($DatPago->PagTipoCambio);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php echo ($DatPago->PagEstadoDescripcion);?></td>
          <td align="right" class="EstPedidoCompraDetalleImprimirContenido" ><?php $DatPago->PagMonto = (($EmpresaMonedaId==$POST_Moneda or empty($POST_Moneda))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));?>
            <?php echo number_format($DatPago->PagMonto,2); ?></td>
          </tr>
        <?php	
		
		
			$Total += $DatPago->PagMonto;
	
	
		$i++;
		}
		
		
	} 
	
	
	


?>
        
        
        </tbody>
    </table>
    
<?php	
}
?>

    
    
    </td>
  </tr>
  <tr>
    <td colspan="5" align="left"></td>
  </tr>

</table>

</body>
</html>
