<?php
/*
*Archivos de Sistema
*/
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsPoo->Ruta = '../../';
$InsProyecto->Ruta = '../../';

?>

<?php
$POST_cnt = $_POST['CmpCantidad'];
$POST_arr =  $_POST['CmpArriba'];
$POST_der =  $_POST['CmpDerecha'];
$POST_izq =  $_POST['CmpIzquierda'];

if(empty($POST_cnt)){
	$POST_cnt = 1;
}

if(empty($POST_arr)){
	$POST_arr = "CANEPA CYC";
}

if(empty($POST_der)){
	$POST_der = "A";
}

if(empty($POST_izq)){
	$POST_izq = "B";
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Codigo de Barras: <?php echo $_GET['text'];?> Cantidad:<?php echo $POST_cnt;?></title>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>/jquery-1.4.3.min.js"></script>   
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>/CssGeneral.css">
<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutFormularios();?>/Producto/css/CssProducto.css">



<!--
Librerias de Validacion
-->
<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextField.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="<?php echo $InsProyecto->MtdRutSpry();?>/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<script src="<?php echo $InsProyecto->MtdRutFormularios();?>/Producto/js/JsProductoFunciones.js" type="text/javascript"></script>

<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>/jquery-flipv/cvi_text_lib.js" type="text/javascript"></script>

<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>/jquery-flipv/jquery.flipv.js" type="text/javascript"></script>
<!--<script src="<?php echo $InsProyecto->MtdRutLibrerias();?>/jquery-flipv/jquery.js" type="text/javascript"></script>-->

<script type="text/javascript">
$().ready(function() {

<?php if($_GET['P']==1){?> 
FncImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
	setTimeout("window.close();",1500);
<?php }?>


//$(".EstCodigoBarraLateral").flipv();
//

});
</script>

<head>



<?php if($_GET['P']<>1){ ?>
<form id="FrmGenerar" name="FrmGenerar" method="post" action="<?php echo $_SERVER ["PHP_SELF"]; ?>?o=<?php echo $_GET['o'];?>&t=<?php echo $_GET['t'];?>&r=<?php echo $_GET['r']; ?>&text=<?php echo urlencode($_GET['text']);?>&f=<?php echo $_GET['f'];?>&a1=<?php echo $_GET['a1'];?>&a2=<?php echo $_GET['a2'];?>">

<table class="EstFormularioTabla" border="0" cellpadding="2" cellspacing="2">

<tr>
  <td>Cantidad: </td>
  <td>
    
    <span id="sprytextfield1">
      <input class="EstFormularioCaja" name="CmpCantidad" type="text" id="CmpCantidad" size="5" maxlength="10" value="<?php echo $POST_cnt;?>" />
      <span class="textfieldRequiredMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Debe completar este campo" alt="[A]"  /></span><span class="textfieldInvalidFormatMsg"><img src="imagenes/advertencia.png" width="20" height="20" border="0" align="absmiddle" title="Formato no valido" alt="[A]"  /></span></span>
</td>
  <td><input class="EstFormularioBoton" type="submit" name="BtnGenerar" id="BtnGenerar" value="Generar" /></td>
<td>
<input onclick="FncImprimirCodigoBarra();" class="EstFormularioBoton" type="button" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
<tr>
  <td>Arriba:</td>
  <td><input class="EstFormularioCaja"  type="text" name="CmpArriba" id="CmpArriba" value="<?php echo $POST_arr;?>" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Izquierda:</td>
  <td><input class="EstFormularioCaja" type="text" name="CmpIzquierda" id="CmpIzquierda" value="<?php echo $POST_izq;?>" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Derecha:</td>
  <td><input class="EstFormularioCaja"  type="text" name="CmpDerecha" id="CmpDerecha" value="<?php echo $POST_der;?>" /></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
</form>
<?php
}
?>
<table cellpadding="0" cellspacing="0" border="0" >
<tr>

<?php
for($i=1;$i<=$POST_cnt;$i++){
?>

<td>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
  <td>&nbsp;</td>
  <td align="center"><div class="EstCodigoBarraArriba"><?php echo $POST_arr;?></div></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right"><div class="EstCodigoBarraLateral"><?php echo $POST_izq?></div></td>
  <td align="center"><img src="cb.php?o=<?php echo $_GET['o'];?>&t=<?php echo $_GET['t'];?>&r=<?php echo $_GET['r']; ?>&text=<?php echo urlencode($_GET['text']);?>&f=<?php echo $_GET['f'];?>&a1=<?php echo $_GET['a1'];?>&a2=<?php echo $_GET['a2'];?>" alt="[Error]"    /></td>
  <td align="left"><div class="EstCodigoBarraLateral"><?php echo $POST_der?></div></td>
</tr>
</table>

 </td> 
<?php
if($i%3==0){
?>
</tr><tr>
<?php	
}
?> 

   
<?php	
}
?>


</tr>  
</table>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer");
</script>
</body>
</html>