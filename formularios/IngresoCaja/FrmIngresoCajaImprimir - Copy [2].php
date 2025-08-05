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

$GET_id = $_GET['Id'];

require_once($InsPoo->MtdPaqContabilidad().'ClsIngreso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoDestino.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsIngresoComprobante.php');

$InsIngreso = new ClsIngreso();

$InsIngreso->IngId = $GET_id;
$InsIngreso->MtdObtenerIngreso();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Deseembolso <?php
echo $InsIngreso->IngId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssIngresoImprimir.css" rel="stylesheet" type="text/css" />

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript" src="js/JsIngresoCajaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsIngreso->IngId)) {
?> 
FncIngresoImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstIngresoImprimirTabla">
  <tr>
    <td height="20" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstIngresoImprimirTabla">
      <tr>
        <td width="15%" height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="3%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="15%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="10%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="3%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="23%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="10%" height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="2%" height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="19%" height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          BANCO:
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstIngresoImprimirEtiqueta">
  <?php
}
?>
</span></td>
        <td height="23" colspan="4" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirContenido"> <?php echo $InsIngreso->BanNombre;?></span></td>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Fecha
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirContenido">
          <?php
echo $InsIngreso->IngFecha;
 ?>
        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?> CTA. CTE.
</span><span class="EstIngresoImprimirEtiqueta">
<?php
}
?>
</span></td>
        <td height="23" align="left" valign="top" ><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:</span><span class="EstIngresoImprimirEtiqueta">
<?php
}
?>
</span></td>
        <td height="23" colspan="7" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirContenido"><?php echo $InsIngreso->CueNumero;?> </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
cheque nro.
<?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:
<?php
}
?>
        </span></td>
        <td height="23" colspan="7" align="left" valign="top" ><span class="EstIngresoImprimirContenido">
          <?php
echo $InsIngreso->IngNumeroCheque;
?>
        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          A LA ORDEN de
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstIngresoImprimirEtiqueta">
  <?php
}
?>
</span></td>
        <td height="23" colspan="7" align="left" valign="top" ><span class="EstIngresoImprimirContenido"> <?php echo $InsIngreso->CliNombre;?> <?php echo $InsIngreso->CliApellidoPaterno;?> <?php echo $InsIngreso->CliApellidoMaterno;?> <?php echo $InsIngreso->PrvNombre;?> <?php echo $InsIngreso->PrvApellidoPaterno;?> <?php echo $InsIngreso->PrvApellidoMaterno;?> <?php echo $InsIngreso->PerNombre;?> <?php echo $InsIngreso->PerApellidoPaterno;?> <?php echo $InsIngreso->PerApellidoMaterno;?> </span></td>
        </tr>
      <tr>
        <td height="23" colspan="9" align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          DOCUMENTO QUE SE CANCELA
          <?php
}
?>
        </span></td>
        </tr>
      <tr>
        <td align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstIngresoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
          <span class="EstIngresoImprimirEtiquetaTotal">importe:</span>
          <?php
}
?></td>
        <td align="left" valign="top" ><span class="EstIngresoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:
<?php
}
?>
        </span></td>
        <td align="left" valign="top" ><?php
if($InsIngreso->MonId<>$EmpresaMonedaId ){
	$InsIngreso->IngMonto = round($InsIngreso->IngMonto / $InsIngreso->IngTipoCambio,2);

}
?>
          <span class="EstMonedaSimbolo">
            <?php
echo $InsIngreso->MonSimbolo;
?>
            </span> <span class="EstIngresoImprimirContenidoTotal">
            <?php
echo number_format($InsIngreso->IngMonto, 2);
?>
          </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="3%" align="right">&nbsp;</td>
          <td width="94%" height="110" align="left" valign="top"><span class="EstIngresoImprimirContenido">
            <?php
echo $InsIngreso->IngConcepto;
?>
          </span></td>
          <td width="3%" align="center" >&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td width="3%" align="right">&nbsp;</td>
          <td width="11%" align="left"><span class="EstIngresoImprimirEtiqueta">
            <?php
if ($_GET['P'] != 1) {
?>
TOTAL
<?php
}
?>
          </span></td>
          <td width="83%" align="LEFT" class="EstIngresoImprimirEtiquetaFondo">
          
          
          <?php
		  
			
			
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($InsIngreso->IngMonto,2);
list($parte_entero,$parte_decimal) = explode(".",$Total);

if(empty($parte_decimal)){
	$parte_decimal = 0;
}

$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);


$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");
?>

<span class="EstIngresoImprimirContenido">
<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsIngreso->MonNombre;?>    
</span>

</td>
          <td width="3%" align="center" >&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
  </tr>
</table>
</body>
</html>

