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

require_once($InsPoo->MtdPaqContabilidad().'ClsGasto.php');


$InsGasto = new ClsGasto();

$InsGasto->GasId = $GET_id;
$InsGasto->MtdObtenerGasto();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Movimiento de Entrada a Almacen No. <?php echo $InsGasto->GasId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssGasto.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsGastoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsGasto->GasId)){?> 
FncGastoImprimir(); 
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
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">COMPRAS/SERVICIOS
  <br /><?php echo $InsGasto->GasId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstGastoImprimirTabla">

<tr>
  <td colspan="5" valign="top">
    
    
    
    
    
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstGastoImprimirTabla">
      <tr>
        <td colspan="5" align="left" valign="top" class="EstGastoImprimirCabecera">Datos de la Compra/Servicio</td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td width="24%" align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta"> R.U.C.:</span></td>
        <td width="22%" align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->PrvNumeroDocumento;?></span></td>
        <td width="1%" align="left" valign="top">&nbsp;</td>
        <td width="22%" align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Proveedor:</span></td>
        <td width="29%" align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->PrvNombreCompleto;?></span></td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Tipo de Comprobante:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->CtiNombre;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Fecha de Ingreso:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasFecha;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Numero de Comprobante:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasComprobanteNumero;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Fecha de Comprobante:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasComprobanteFecha;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Moneda:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->MonNombre;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Tipo de Cambio:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasTipoCambio;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Incluye Impuesto:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido">
          
          
          <?php
    switch($InsGasto->GasIncluyeImpuesto){
		
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
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Impuesto:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasPorcentajeImpuestoVenta;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Concepto:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasConcepto;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Observacion:</span></td>
        <td colspan="4" align="left" valign="top" ><span class="EstGastoImprimirContenido"><?php echo $InsGasto->GasObservacion;?></span></td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiqueta">Estado:</span></td>
        <td align="left" valign="top" ><span class="EstGastoImprimirContenido">
          <?php
		switch($InsGasto->GasEstado){
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
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top" class="EstGastoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
    
    
    
    
    
    </td>
</tr>
<tr>
  <td colspan="5">
    
<?php

	if($InsGasto->MonId<>$EmpresaMonedaId ){
		$SubTotal = round($InsGasto->GasSubTotal / $InsGasto->GasTipoCambio,2);
		$Impuesto = round($InsGasto->GasImpuesto / $InsGasto->GasTipoCambio,2);
		$Total = round($InsGasto->GasTotal / $InsGasto->GasTipoCambio,2);
	}else{
		
		$SubTotal = round($InsGasto->GasSubTotal,2);
		$Impuesto = round($InsGasto->GasImpuesto,2);
		$Total = round($InsGasto->GasTotal,2);
	}
?>
    <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
  <tbody class="EstTablaTotalBody">
  <tr>
    <td width="21%" align="left">&nbsp;</td>
    <td width="39%" align="left">&nbsp;</td>
    <td width="18%" align="right" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiquetaTotal">SubTotal:</span></td>
    <td width="22%" align="right" class="EstGastoImprimirContenidoTotal">
      
      <span class="EstMonedaSimbolo"><?php echo $InsGasto->MonSimbolo;?></span> <?php echo number_format($SubTotal,2);?>
      
      
      </td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiquetaTotal">Impuesto (<?php echo $InsGasto->GasPorcentajeImpuestoVenta;?>%):</span></td>
    <td align="right" class="EstGastoImprimirContenidoTotal">
      
      
      <span class="EstMonedaSimbolo"><?php echo $InsGasto->MonSimbolo;?></span> <?php echo number_format($Impuesto,2);?>
      
      
      </td>
  </tr>
    
    
    
    
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right" class="EstGastoImprimirEtiquetaFondo"><span class="EstGastoImprimirEtiquetaTotal">Total:</span></td>
    <td align="right" class="EstGastoImprimirContenidoTotal">
      
      
      <span class="EstMonedaSimbolo"><?php echo $InsGasto->MonSimbolo;?></span> <?php echo number_format($Total,2);?>
      
      
      
      </td>
  </tr>
  </tbody>
  </table></td>
</tr>
</table>

</body>
</html>
