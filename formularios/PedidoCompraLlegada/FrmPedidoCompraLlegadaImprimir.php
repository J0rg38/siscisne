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
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegada.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsPedidoCompraLlegadaDetalle.php');
require_once($InsPoo->MtdPaqLogistica().'ClsProveedor.php');
require_once($InsPoo->MtdPaqLogistica().'ClsComprobanteTipo.php');

$InsPedidoCompraLlegada = new ClsPedidoCompraLlegada();

$InsPedidoCompraLlegada->PleId = $GET_id;
$InsPedidoCompraLlegada = $InsPedidoCompraLlegada->MtdObtenerPedidoCompraLlegada();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrada de Almacen No. <?php echo $InsPedidoCompraLlegada->PleId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssPedidoCompraLlegada.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPedidoCompraLlegadaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsPedidoCompraLlegada->PleId)){?> 
FncPedidoCompraLlegadaImprimir(); 
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
	<input type="hidden" name="Id" id="Id" value="<?php
    echo $GET_id;
?>" />
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
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" /></td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">LLEGADA A ALMACEN
  <br /><?php echo $InsPedidoCompraLlegada->PleId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPedidoCompraLlegadaImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPedidoCompraLlegadaImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstPedidoCompraLlegadaImprimirCabecera">Datos de la Llegada a Almacen</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td width="16%" align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="35%" align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="16%" align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo"><span class="EstPedidoCompraLlegadaImprimirEtiqueta">Empleado:</span></td>
      <td width="30%" align="left" valign="top" ><span class="EstPedidoCompraLlegadaImprimirContenido"><?php echo $InsPedidoCompraLlegada->PerNombre;?></span><span class="EstPedidoCompraLlegadaImprimirContenido"> <?php echo $InsPedidoCompraLlegada->PerApellidoPaterno;?></span><span class="EstPedidoCompraLlegadaImprimirContenido"><?php echo $InsPedidoCompraLlegada->PerApellidoMaterno;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo"><span class="EstPedidoCompraLlegadaImprimirEtiqueta"> Fecha de Llegada:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraLlegadaImprimirContenido"><?php echo $InsPedidoCompraLlegada->PleFecha;?></span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo"><span class="EstPedidoCompraLlegadaImprimirEtiqueta">Estado:</span></td>
      <td align="left" valign="top" ><span class="EstPedidoCompraLlegadaImprimirContenido">
        <?php
		switch($InsPedidoCompraLlegada->PleEstado){
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
		}
	?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPedidoCompraLlegadaImprimirEtiquetaFondo"><span class="EstPedidoCompraLlegadaImprimirEtiqueta">Observacion:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstPedidoCompraLlegadaImprimirContenido"><?php echo $InsPedidoCompraLlegada->PleObservacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  

<tr>
  <td colspan="5" valign="top">&nbsp;</td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
  <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstPedidoCompraLlegadaImprimirTabla">
  <thead class="EstPedidoCompraLlegadaImprimirTablaHead">
    
  <tr>
    <th width="3%" align="center" >#</th>
    <th width="9%" align="center" >
      
      Id</th>
    <th width="10%" align="center" >Cod. Original</th>
    <th width="61%" align="center" >
      Descripcion
      
    </th>
    <th width="8%" align="center" >U.M.</th>
    <th width="9%" align="center" >Cantidad</th>
    </tr>
    
    
  </thead>
  <tbody class="EstPedidoCompraLlegadaImprimirTablaBody">
  <?php

	$TotalImporte = 0;
	$i=1;
	if(is_array($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle)){
		foreach($InsPedidoCompraLlegada->PedidoCompraLlegadaDetalle as $DatPedidoCompraLlegadaDetalle){


			
			
?>

    
    <tr>
      <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPedidoCompraLlegadaDetalle->ProId;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPedidoCompraLlegadaDetalle->ProCodigoOriginal;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPedidoCompraLlegadaDetalle->ProNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatPedidoCompraLlegadaDetalle->UmeNombre;?></td>
      <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatPedidoCompraLlegadaDetalle->PldCantidad,2);?></td>
      </tr>
  <?php	
		
			
		$SubTotal += $DatPedidoCompraLlegadaDetalle->PldImporte;
		
		$i++;
		}
		
		
	} 
	
	
	
	

$SubTotal = round($SubTotal,2);
$Recargo = $InsPedidoCompraLlegada->PleTotalRecargo;
$Impuesto = round(($SubTotal + $Recargo) * ($InsPedidoCompraLlegada->PlePorcentajeImpuestoVenta/100),2);
$Total = $SubTotal + $Recargo + $Impuesto;
				
				
//if($InsPedidoCompraLlegada->PleIncluyeImpuesto==1){
//	$ImpuestoVenta = ($InsPedidoCompraLlegada->PlePorcentajeImpuestoVenta/100);
//	$ImpuestoVenta = $ImpuestoVenta + 1;
//	$SubTotal = (($TotalBruto /$ImpuestoVenta));
//	$Impuesto = $TotalBruto - $SubTotal;
//
//	$Total = $TotalBruto;
//
//}else{
//	$SubTotal = $TotalBruto;
//	$Impuesto = $SubTotal*($InsPedidoCompraLlegada->PlePorcentajeImpuestoVenta/100);	
//
//	$Total = $SubTotal + $Impuesto;
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
      </tr>
    
    
  </tbody>
  </table></td>
</tr>

  <tr>
    <td colspan="5" align="center">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="5">
  
  
  </td>
</tr>
</table>

</body>
</html>
