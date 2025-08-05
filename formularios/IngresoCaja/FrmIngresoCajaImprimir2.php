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
<link href="css/CssIngresoCajaImprimir2.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsIngresoCajaImprimir2.js"></script>
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


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  <td align="left" valign="top">&nbsp;</td>
  </tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
  <td align="right" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
  <td width="34%" align="left" valign="top">&nbsp;</td>
  <td width="28%" align="center" valign="top">&nbsp;</td>
  <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
  <td width="0%" align="right" valign="top">&nbsp;</td>
</tr>
</table>

<hr class="EstPlantillaLinea">



	<?php
	if($InsIngreso->IngEstado == 6){
	?> 
	<div class="EstIngresoCajaImprimirAnulado">
    <img src="../../imagenes/comprobantes/anulado.png" width="600" height="600" />
  </div>
    <?php
	}
	?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstIngresoCajaImprimirTabla">


<tr>
  <td width="1%" valign="top">&nbsp;</td>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstIngresoCajaImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstPlantillaTitulo">ABONO</span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsIngreso->IngId;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="12%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo">&nbsp;</td>
      <td width="1%" align="left" valign="top" >&nbsp;</td>
      <td width="37%" align="left" valign="top" >&nbsp;</td>
      <td colspan="3" align="right" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">
        
		
		<?php 
list($Dia,$Mes,$Ano) = explode("/",$InsIngreso->IngFecha);
?>
        <?php
if ($_GET['P'] != 1) {
?>
         <?php echo ucwords(strtolower($InsIngreso->SucDepartamento));?>,
<?php
}
?>
        &nbsp; <?php echo $Dia;?> &nbsp;
        <?php
if ($_GET['P'] != 1) {
?>
        de
        <?php
}
?>
        &nbsp; <?php echo FncConvertirMes($Mes);?> &nbsp;
        
        del
        <?php
$Digito = substr($Ano,3,1);
?>
        201<?php echo $Digito;?> </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">NUM. DOC. </span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta"> :</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstIngresoCajaImprimirContenido"><?php echo $InsIngreso->TdoNombre;?> <?php echo $InsIngreso->CliNumeroDocumento;?> <?php echo $InsIngreso->TdoNombreProveedor;?> <?php echo $InsIngreso->PrvNumeroDocumento;?> <?php echo $InsIngreso->TdoNombrePersonal;?> <?php echo $InsIngreso->PerNumeroDocumento;?> </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td colspan="4" align="left" valign="top" ><span class="EstIngresoCajaImprimirCliente"> <?php echo $InsIngreso->CliNombre;?> <?php echo $InsIngreso->CliApellidoPaterno;?> <?php echo $InsIngreso->CliApellidoMaterno;?> <?php echo $InsIngreso->PrvNombre;?> <?php echo $InsIngreso->PrvApellidoPaterno;?> <?php echo $InsIngreso->PrvApellidoMaterno;?> <?php echo $InsIngreso->PerNombre;?> <?php echo $InsIngreso->PerApellidoPaterno;?> <?php echo $InsIngreso->PerApellidoMaterno;?> </span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  <td width="1%">&nbsp;</td>
  </tr><tr>
  <td valign="top">&nbsp;</td>
  <td colspan="2" valign="top">
   <div  class="EstCapPagoTotal">
  <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstIngresoCajaImprimirTabla">
    <tr>
      <td width="13%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">REFERENCIA</span></td>
      <td width="2%" align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirObservacion"><?php echo $InsIngreso->IngReferencia;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">CONCEPTO</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstIngresoCajaImprimirObservacion"><?php echo $InsIngreso->IngConcepto;?></span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">FORMA DE PAGO</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td width="85%" align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirContenido">
        <?php
	  echo ($InsIngreso->FpaNombre)
	  ?>
      </span></td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">MONTO</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" class="EstIngresoCajaImprimirEtiquetaFondo"><span class="EstIngresoCajaImprimirContenido">
        <?php
	  echo number_format($InsIngreso->IngMonto,2)
	  ?>
      </span></td>
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
    </tr>
    </table>
  </div>
  </td>
  <td>&nbsp;</td>
</tr>
</table>









    
    
          

    
 
 
     <?php
	 
	
	
?>




<!--<div class="EstIngresoCajaPie">

        <span class="EstIngresoCajaImprimirNota2">Urb. Los Cedros Mz. B Lte. 10 Av. Manuel A. Odria Via Panamericana Sur (Costado Grifo Municipal)<br />
        Tel&eacute;fono 51-52 315216 Anexo 210 Fono Fax: 851-52 315207 E-mail: canepa@cyc.com.pe<br />
  Inscritos en los Registros P&uacute;blicos de Tacna Ficha 2986 </span>

</div>


<div class="EstIngresoCajaPieAux">

</div>   --> 



</body>
</html>
 