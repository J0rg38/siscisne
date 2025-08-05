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


require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoDestino.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoComprobante.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsMoneda.php');
require_once($InsPoo->MtdPaqLogistica().'ClsBanco.php');

require_once($InsPoo->MtdPaqContabilidad().'ClsCuenta.php');

require_once($InsPoo->MtdPaqLogistica().'ClsTipoDocumento.php');
require_once($InsPoo->MtdPaqLogistica().'ClsFormaPago.php');


$InsIngreso = new ClsIngreso();
$InsMoneda = new ClsMoneda();
$InsBanco = new ClsBanco();
$InsCuenta = new ClsCuenta();
$InsTipoDocumento = new ClsTipoDocumento();
$InsFormaPago = new ClsFormaPago();

$InsIngreso->IngId = $GET_id;
$InsIngreso->MtdObtenerIngreso();			

if($InsIngreso->MonId<>$EmpresaMonedaId ){
	$InsIngreso->IngMonto = round($InsIngreso->IngMonto / $InsIngreso->IngTipoCambio,2);
}
	
?>
      

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Abono No. <?php
echo $InsIngreso->IngId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssIngresoCajaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsIngresoCajaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsIngreso->IngId)) {
?> 
	FncIngresoCajaImprimir(); 
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



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstIngresoCajaImprimirTabla">


<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td height="120" colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstIngresoCajaImprimirTabla">
    <tr>
      <td colspan="5" align="right" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
      <td width="3%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="15%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">NUM. DOC. </span></td>
      <td width="3%" align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta"> :</span></td>
      <td width="49%" align="left" valign="top" ><span class="EstIngresoCajaImprimirContenido">
	  
	  <?php echo $InsIngreso->TdoNombre;?> <?php echo $InsIngreso->CliNumeroDocumento;?>
        <?php echo $InsIngreso->TdoNombreProveedor;?> <?php echo $InsIngreso->PrvNumeroDocumento;?>
          <?php echo $InsIngreso->TdoNombrePersonal;?> <?php echo $InsIngreso->PerNumeroDocumento;?>
          
      
      </span></td>
      <td width="14%" align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">FECHA. </span></td>
      <td width="16%" align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta"><?php echo $InsIngreso->IngFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td colspan="3" align="left" valign="top" ><span class="EstIngresoCajaImprimirCliente">
        
        <?php echo $InsIngreso->CliNombre;?>
        <?php echo $InsIngreso->CliApellidoPaterno;?>
        <?php echo $InsIngreso->CliApellidoMaterno;?>
        
              
        <?php echo $InsIngreso->PrvNombre;?>
        <?php echo $InsIngreso->PrvApellidoPaterno;?>
        <?php echo $InsIngreso->PrvApellidoMaterno;?>
              
        <?php echo $InsIngreso->PerNombre;?>
        <?php echo $InsIngreso->PerApellidoPaterno;?>
        <?php echo $InsIngreso->PerApellidoMaterno;?>
        
        
        </span>
        
        
        
      </td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr><tr>
  <td valign="top">&nbsp;</td>
  <td colspan="2" valign="top">
   <!--<div  class="EstCapIngresoCajaTotal">-->
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstIngresoCajaImprimirTabla">
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">REFERENCIA</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirObservacion"><?php echo $InsIngreso->IngReferencia;?></span></td>
      <td width="19%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">FORMA DE PAGO</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td width="59%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirContenido">
        <?php
	  echo ($InsIngreso->FpaNombre)
	  ?>
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">MONTO</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirContenido">
        <?php
	  echo number_format($InsIngreso->IngMonto,2)
	  ?>
        </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta"> La suma de </span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><?php
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($InsIngreso->IngMonto,2);
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
        <span class="EstIngresoCajaImprimirContenido"> <?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsIngreso->MonNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="17%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">CONCEPTO</span></td>
      <td width="5%" align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirObservacion"><?php echo $InsIngreso->IngConcepto;?></span></td>
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
