<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta      = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes() . 'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases() . 'ClsSesion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMensaje.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones() . 'ClsConexion.php');
require_once($InsProyecto->MtdRutClases() . 'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones() . 'FncGeneral.php');

require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqContabilidad() . 'ClsPago.php');
require_once($InsPoo->MtdPaqContabilidad() . 'ClsPagoComprobante.php');


require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');

$InsPago = new ClsPago();

$InsPago->PagId = $GET_id;
$InsPago->MtdObtenerPago();

	if($InsPago->MonId<>$EmpresaMonedaId ){
		$InsPago->PagMonto = round($InsPago->PagMonto / $InsPago->PagTipoCambio,3);
	}
	
?>
      


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Abono No. <?php
echo $InsPago->PagId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssPagoFacturaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPagoFacturaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsPago->PagId)) {
?> 
	FncFacturaImprimir(); 
<?php
}
?>

<?php
if ($_GET['P'] == 1) {
?>
	setTimeout("window.close();",1500);
<?php
}
?>
	
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







<?php /*if($_GET['P']<>1){ ?>
<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
	<input name="ImprimirCodigo" id="ImprimirCodigo" type="checkbox" value="1" <?php echo ($GET_ImprimirCodigo==1)?'checked="checked"':'';?>  /> Imprimir Codigos</td>
<td>&nbsp;</td>
<td>
	<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }*/?>
<hr class="EstPlantillaLinea">



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">


<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td height="120" colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoImprimirTabla">
    <tr>
      <td colspan="5" align="right" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">NUM. DOC. </span></td>
      <td width="3%" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta"> :</span></td>
      <td width="49%" align="left" valign="top" ><span class="EstPagoImprimirContenido"><?php echo $InsPago->TdoNombre;?>/<?php echo $InsPago->CliNumeroDocumento;?></span></td>
      <td width="14%" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">FECHA. </span></td>
      <td width="16%" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta"><?php echo $InsPago->PagFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstPagoImprimirCliente">
        
        <?php echo $InsPago->CliNombre;?>
        <?php echo $InsPago->CliApellidoPaterno;?>
        <?php echo $InsPago->CliApellidoMaterno;?>
        </span>
        
        
        
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr><tr>
  <td valign="top">&nbsp;</td>
  <td colspan="2" valign="top">
   <!--<div  class="EstCapPagoTotal">-->
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoImprimirTabla">
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">REFERENCIA</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagReferencia;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">CONCEPTO</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagConcepto;?></span></td>
      <td width="19%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">FORMA DE PAGO</span></td>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td width="59%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirContenido">
        <?php
	  echo ($InsPago->FpaNombre)
	  ?>
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">MONTO</span></td>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirContenido">
        <?php
	  echo number_format($InsPago->PagMonto,2)
	  ?>
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta"> La suma de </span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><?php
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($InsPago->PagMonto,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}
$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");
?>
        <span class="EstPagoImprimirContenido"> <?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsPago->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="17%" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">CONCEPTO</span></td>
      <td width="5%" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstPagoImprimirObservacion"><?php echo $InsPago->PagConcepto;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table>
 <!-- </div>-->
  </td>
  <td>&nbsp;</td>
</tr>
</table>













</body>
</html>
