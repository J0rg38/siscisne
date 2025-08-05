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

require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolso.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolsoDestino.php');
require_once($InsPoo->MtdPaqContabilidad().'ClsDesembolsoComprobante.php');

$InsDesembolso = new ClsDesembolso();

$InsDesembolso->DesId = $GET_id;
$InsDesembolso->MtdObtenerDesembolso();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Deseembolso <?php
echo $InsDesembolso->DesId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssDesembolsoImprimir.css" rel="stylesheet" type="text/css" />

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript" src="js/JsDesembolsoCajaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsDesembolso->DesId)) {
?> 
FncDesembolsoImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstDesembolsoImprimirTabla">
  <tr>
    <td height="20" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstDesembolsoImprimirTabla">
      <tr>
        <td width="15%" height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="3%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="15%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="10%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="3%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="23%" height="23" align="left" valign="top" >&nbsp;</td>
        <td width="10%" height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="2%" height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td width="19%" height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          BANCO:
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstDesembolsoImprimirEtiqueta">
  <?php
}
?>
</span></td>
        <td height="23" colspan="4" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirContenido"> <?php echo $InsDesembolso->BanNombre;?></span></td>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Fecha
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirContenido">
          <?php
echo $InsDesembolso->DesFecha;
 ?>
        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?> CTA. CTE.
</span><span class="EstDesembolsoImprimirEtiqueta">
<?php
}
?>
</span></td>
        <td height="23" align="left" valign="top" ><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:</span><span class="EstDesembolsoImprimirEtiqueta">
<?php
}
?>
</span></td>
        <td height="23" colspan="7" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirContenido"><?php echo $InsDesembolso->CueNumero;?> </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
cheque nro.
<?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:
<?php
}
?>
        </span></td>
        <td height="23" colspan="7" align="left" valign="top" ><span class="EstDesembolsoImprimirContenido">
          <?php
echo $InsDesembolso->DesNumeroCheque;
?>
        </span></td>
        </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          A LA ORDEN de
  <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstDesembolsoImprimirEtiqueta">
  <?php
}
?>
</span></td>
        <td height="23" colspan="7" align="left" valign="top" ><span class="EstDesembolsoImprimirContenido"> <?php echo $InsDesembolso->CliNombre;?> <?php echo $InsDesembolso->CliApellidoPaterno;?> <?php echo $InsDesembolso->CliApellidoMaterno;?> <?php echo $InsDesembolso->PrvNombre;?> <?php echo $InsDesembolso->PrvApellidoPaterno;?> <?php echo $InsDesembolso->PrvApellidoMaterno;?> <?php echo $InsDesembolso->PerNombre;?> <?php echo $InsDesembolso->PerApellidoPaterno;?> <?php echo $InsDesembolso->PerApellidoMaterno;?> </span></td>
        </tr>
      <tr>
        <td height="23" colspan="9" align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><span class="EstDesembolsoImprimirEtiqueta">
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
        <td align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo">&nbsp;</td>
        <td align="left" valign="top" class="EstDesembolsoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
          <span class="EstDesembolsoImprimirEtiquetaTotal">importe:</span>
          <?php
}
?></td>
        <td align="left" valign="top" ><span class="EstDesembolsoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
:
<?php
}
?>
        </span></td>
        <td align="left" valign="top" ><?php
if($InsDesembolso->MonId<>$EmpresaMonedaId ){
	$InsDesembolso->DesMonto = round($InsDesembolso->DesMonto / $InsDesembolso->DesTipoCambio,2);

}
?>
          <span class="EstMonedaSimbolo">
            <?php
echo $InsDesembolso->MonSimbolo;
?>
            </span> <span class="EstDesembolsoImprimirContenidoTotal">
            <?php
echo number_format($InsDesembolso->DesMonto, 2);
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
          <td width="94%" height="110" align="left" valign="top"><span class="EstDesembolsoImprimirContenido">
            <?php
echo $InsDesembolso->DesConcepto;
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
          <td width="11%" align="left"><span class="EstDesembolsoImprimirEtiqueta">
            <?php
if ($_GET['P'] != 1) {
?>
TOTAL
<?php
}
?>
          </span></td>
          <td width="83%" align="LEFT" class="EstDesembolsoImprimirEtiquetaFondo">
          
          
          <?php
		  
			
			
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($InsDesembolso->DesMonto,2);
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

<span class="EstDesembolsoImprimirContenido">
<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsDesembolso->MonNombre;?>    
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

