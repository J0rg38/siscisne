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

$InsPago = new ClsPago();

$InsPago->PagId = $GET_id;
$InsPago->MtdObtenerPago();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Cobro No. <?php
echo $InsPago->PagId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php
echo $InsProyecto->MtdRutEstilos();
?>CssImprimir.css">
<link href="css/CssPago.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsPagoImprimir.js"></script>
<script type="text/javascript" src="<?php
echo $InsProyecto->MtdRutLibrerias();
?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsPago->PagId)) {
?> 
FncPagoImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstPagoImprimirTabla">
  <tr>
    <td height="45" align="right" valign="top">
	
<span class="EstPagoImprimirContenido">
<?php echo $InsPago->PagId;?>
	</span>
	</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstPagoImprimirTabla">
      <tr>
        <td height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">&nbsp;</td>
        <td height="23" align="left" valign="top" >&nbsp;</td>
        <td width="53%" height="23" align="left" valign="top" >&nbsp;</td>
        <td height="23" colspan="4" align="right" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
        
<?php 
list($Dia,$Mes,$Ano) = explode("/",$InsPago->PagFecha);
?>
        
          <?php
if ($_GET['P'] != 1) {
?>
Tacna,
<?php
}
?>

&nbsp;

<?php echo $Dia;?>

&nbsp;

<?php
if ($_GET['P'] != 1) {
?>
de
<?php
}
?>

&nbsp;

<?php echo FncConvertirMes($Mes);?>

&nbsp;

del

<?php
$Digito = substr($Ano,3,1);
?>
201
<?php echo $Digito;?>




        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">&nbsp;</td>
        <td height="23" align="left" valign="top" >&nbsp;</td>
        <td height="23" align="left" valign="top" >&nbsp;</td>
        <td height="23" colspan="4" align="center" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirContenido">
        
        <?php echo $InsPago->MonSimbolo;?>
          <?php
echo number_format($InsPago->PagMonto);
?>
        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Recibimos de 
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstPagoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" colspan="2" align="left" valign="top" ><span class="EstPagoImprimirContenido">
          
          <?php echo $InsPago->CliNombre;?>
          <?php echo $InsPago->CliApellidoPaterno;?>
          <?php echo $InsPago->CliApellidoMaterno;?>
          
        </span></td>
        <td height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          CODIGO</span><span class="EstPagoImprimirEtiqueta">
  <?php
}
?>
</span></td>
        <td height="23" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
        </span>:<span class="EstPagoImprimirEtiqueta">
        <?php
}
?>
        </span></td>
        <td height="23" align="right" valign="top" ><span class="EstPagoImprimirContenido">
          <?php
echo $InsPago->CliNumeroDocumento;
?>
        </span></td>
      </tr>
      <tr>
        <td width="9%" height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          La suma de
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" colspan="2" align="left" valign="top" >
          
          
          
          <?php
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
          
          
          <span class="EstPagoImprimirContenido"> 
            
            
            <?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsPago->MonNombre;?>    </span>      
          
          
          
          
</td>
        <td width="5%" height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="3%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="18%" height="23" align="center" valign="top" >&nbsp;</td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstPagoImprimirEtiquetaFondo"><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Por concepto de
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstPagoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" colspan="2" align="left" valign="top" ><span class="EstPagoImprimirContenido">
          
          
          <?php
echo stripslashes($InsPago->PagConcepto);
?></span>
          
          
          
</td>
        <td height="23" align="left" valign="top" >&nbsp;</td>
        <td height="23" align="left" valign="top" >&nbsp;</td>
        <td height="23" align="center" valign="top" >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
