<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nota de Credito No.  <?php echo $InsNotaCredito->NctNumero;?> - <?php echo $InsNotaCredito->NcrId;?></title>

<link href="css/CssNotaCreditoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsNotaCreditoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 


<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>





<script type="text/javascript">
$().ready(function() {

<?php if($_GET['P']==1 and !empty($InsNotaCredito->NcrId) and !empty($InsNotaCredito->NctId)){?> 
FncNotaCreditoImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
	setTimeout("window.close();",1500);
<?php }?>

});
</script>
</head>

<body >

<?php /*if($_GET['P']<>1){ ?>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="38%">
<form method="get" action="#" enctype="application/x-www-form-urlencoded" >
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />

<select class="EstFormularioCombo" id="Mon" name="Mon">
<?php
foreach($ArrMonedas as $DatMoneda){				
?>
<option <?php if($GET_mon == $DatMoneda->MonId){ echo 'selected="selected"';}?> value="<?php echo $DatMoneda->MonId;?>"><?php echo $DatMoneda->MonNombre;?> <?php echo $DatMoneda->MonSimbolo;?></option>
<?php
}
?>
</select>
<input type="submit" name="BtnCambiarMoneda" id="BtnCambiarMoneda" value="Cambiar moneda" />
</form>
</td>
<td width="62%">
<input type="button" name="BtnImprimir" id="BtnImprimir" value="Imprimir" 
onclick="window.open('<?php echo $_SERVER ["PHP_SELF"]; ?>?Id=<?php echo $GET_id;?>&Ta=<?php echo $GET_ta;?>&P=1&Mon=<?php echo $GET_mon;?>','_self');" />
</td>
</tr>
</table>
<?php }*/?>
<?php if($_GET['P']<>1){ ?>
<!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="62%">
<input type="button" name="BtnImprimir" id="BtnImprimir" value="Imprimir" 
onclick="window.open('<?php echo $_SERVER ["PHP_SELF"]; ?>?Id=<?php echo $GET_id;?>&Ta=<?php echo $GET_ta;?>&P=1&Mon=<?php echo $GET_mon;?>','_self');" />
</td>
</tr>
</table>-->


<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<input name="TiempoImpresion" id="TiempoImpresion" type="checkbox" value="1" <?php echo ($GET_TiempoImpresion==1)?'checked="checked"':'';?>  /> Ignorar Fecha de Impresion</td>
<td>&nbsp;</td>
<td>
<input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />

<!--<input type="button" name="BtnImprimir" id="BtnImprimir" value="Imprimir" 
onclick="window.open('<?php echo $_SERVER ["PHP_SELF"]; ?>?Id=<?php echo $GET_id;?>&Ta=<?php echo $GET_ta;?>&P=1&Mon=<?php echo $GET_mon;?>','_self');" />--></td>
</tr>
</table>

</form>

<?php }?>
<table width="1447" height="570" border="0" cellpadding="0" cellspacing="0" class="EstNotaCreditoImprimirTabla">

<tr>
  <td width="1055" height="160" rowspan="2" align="left" valign="top">
  
  <span class="EstNotaCreditoImprimirContenido">
  <?php echo $InsNotaCredito->NctNumero;?> - <?php echo $InsNotaCredito->NcrId;?>   </span><br />
   
     <span class="EstNotaCreditoImprimirContenido">
  <?php echo $InsNotaCredito->UsuUsuario;?>   </span>    </td>
  <td width="392" height="80" align="left" valign="bottom">&nbsp;</td>
  </tr>
<tr>
  <td height="80" align="left" valign="top">&nbsp;</td>
</tr>

  
  <tr>
    <td valign="top" colspan="2">
    <table width="100%" border="0" cellpadding="0" cellspacing="1" class="EstNotaCreditoImprimirTabla">
    <tr>
      <td width="8%" height="25" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
        <span class="EstNotaCreditoImprimirEtiqueta"> Señores</span>
        <?php }?></td>
      <td height="25" colspan="9" align="left" valign="top"><span class="EstNotaCreditoImprimirContenidoEspecial"><?php echo $InsNotaCredito->CliNombre;?></span></td>
    </tr>
  <tr>
    <td height="25" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstNotaCreditoImprimirEtiqueta">R.U.C. n°</span>
      <?php }?></td>
    <td width="15%" height="25" align="left" valign="top"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->CliNumeroDocumento;?></span></td>
    <td width="9%" height="25" align="left" valign="top">&nbsp;</td>
    <td width="18%" height="25" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstNotaCreditoImprimirEtiqueta">Fecha de Emision:</span>
      <?php }?></td>
    <td height="25" align="left" valign="top"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->NcrFechaEmision;?></span></td>
    <td height="25" align="left" valign="top">&nbsp;</td>
    <td height="25" align="left" valign="top">&nbsp;</td>
  
  
    <td height="25" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstNotaCreditoImprimirEtiqueta">Direccion</span>
      <?php }?></td>
    <td height="25" colspan="3" align="left" valign="top"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->NcrDireccion;?></span></td>
    <td height="25" colspan="2" align="left" valign="top">
	
	<?php if($_GET['P']!=1){ ?>
      <span class="EstNotaCreditoImprimirEtiqueta">Documento que modifica:</span>
      <?php }?>	  </td>
    <td height="25" align="left" valign="top">&nbsp;</td>
    <td height="25" align="left" valign="top"><?php
	switch($InsNotaCredito->NcrTipo){
		case 2:
	?>
      <span class="EstNotaCreditoImprimirContenido">FACTURA</span>
      <?php
		break;
		
		case 3:
	?>
      <span class="EstNotaCreditoImprimirContenido">BOLETA</span>
      <?php		
		break;
	}
	?></td>
  </tr>
  
  <tr>
    <td colspan="4" align="left" valign="top">
	
		<?php if($_GET['P']!=1){ ?>
		<span class="EstNotaCreditoImprimirEtiqueta">Sirvase a tomar nota que hemos acreditado en su estimada cuenta los siguientes conceptos:</span>
		<?php }?>	</td>
    
    <td  width="12%" align="left" valign="top">
	<?php if($_GET['P']!=1){ ?>
		<span class="EstNotaCreditoImprimirEtiqueta">No:</span>
		<?php }?>	</td>
	<td width="14%" align="left" valign="top">
		<span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->DtaNumero;?> - <?php echo $InsNotaCredito->DocId;?></span>	</td>
	<td width="8%" align="left" valign="top">
	
	<?php if($_GET['P']!=1){ ?>
		<span class="EstNotaCreditoImprimirEtiqueta">Fecha:</span>
		<?php }?>	</td>
	
    <td width="16%" align="left" valign="top">
	
	
	
		<span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->DocFechaEmision;?></span>	</td>
	</tr>
    </table>    
	
	
	</td>
  </tr>
  

<tr>
<td height="250" colspan="2" valign="top">

<table  width="100%"  border="0" cellpadding="0" cellspacing="0" class="EstNotaCreditoImprimirTabla2">
<thead class="EstNotaCreditoImprimirTablaHead2">

<tr>
  <td height="24" align="center" widtd="143" >&nbsp;</td>
  <td widtd="143" align="center" >
  
  <?php
if($_GET['P']!=1){ 
?>
<span class="EstNotaCreditoDetalleImprimirEtiqueta">cantidad</span>

<?php 
}
?></td>
  <td widtd="54" align="center" >&nbsp;</td>
  <td widtd="782" align="center" >
  
  <?php
if($_GET['P']!=1){ 
?>
<span class="EstNotaCreditoDetalleImprimirEtiqueta">descripcion</span>

<?php 
}
?></td>
  <td width="140" align="center" widtd="18" >&nbsp;</td>
  <td widtd="104" align="center" >
    <?php
if($_GET['P']!=1){ 
?><span class="EstNotaCreditoDetalleImprimirEtiqueta">p/unitario</span><?php 
}
?></td>
  <td widtd="84" align="center" >&nbsp;</td>
  <td widtd="53" align="center" >  <?php
if($_GET['P']!=1){ 
?><span class="EstNotaCreditoDetalleImprimirEtiqueta">importe</span><?php 
}
?></td>
</tr>



</thead>
<tbody class="EstNotaCreditoImprimirTablaBody2">
<?php
	
	if(is_array($InsNotaCredito->NotaCreditoDetalle)){
		foreach($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle){
?>
		<tr>
		  <td width="5" align="center">&nbsp;</td>
        <td width="109" align="center" valign="top"><span class="EstNotaCreditoDetalleImprimirContenido"><?php echo $DatNotaCreditoDetalle->NcdCantidad;?></span></td>
        <td width="42" valign="top">&nbsp;</td>
        <td width="744" valign="top"><span class="EstNotaCreditoDetalleImprimirContenido"><?php echo stripslashes( $DatNotaCreditoDetalle->NcdDescripcion);?></span></td>
        <td align="center" valign="top">&nbsp;</td>
        <td width="141" align="center" valign="top">
        
        <span class="EstNotaCreditoDetalleImprimirContenido">
<?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatNotaCreditoDetalle->NcdPrecio/($InsTipoCambio->TcaMontoCompra),2);?>        </span>        </td>
        <td width="46" align="center" valign="top">&nbsp;</td>
        <td width="195" align="center" valign="top"><span class="EstNotaCreditoDetalleImprimirContenido"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($DatNotaCreditoDetalle->NcdImporte/($InsTipoCambio->TcaMontoCompra),2);?></span></td>
  </tr>
<?php	
		}
	} 
?>

<?php
if(!empty($InsNotaCredito->NcrObservacionImpresa)){
?>
<tr>
		  <td width="5" align="center">&nbsp;</td>
        <td colspan="7" align="left">
		<span class="EstNotaCreditoImprimirContenido"> 
		<?php echo stripslashes($InsNotaCredito->NcrObservacionImpresa);?>        
        </span>
        </td>
        </tr>
<?php
}
?>
</tbody>
</table

></td>
</tr>

  <tr>
    <td height="40" colspan="2" align="center">
	
	
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="24%">&nbsp;</td>
	<td width="76%">
    
   
<?php
list($parte_entero,$parte_decimal) = explode(".",$InsNotaCredito->NcrTotal);

$numalet= new CNumeroaletra;
$numalet->setNumero($parte_entero);
$numalet->setMayusculas(1);
$numalet->setGenero(1);
$numalet->setMoneda("");
$numalet->setPrefijo("");
$numalet->setSufijo("");
?>
	
	<span class="EstNotaCreditoImprimirContenido"> SON: 
	<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsMoneda->MonNombre;?>    
    </span>   
    
    
    </td>
    </tr>
    </table>
    
    </td>
  </tr>
  <tr>
  <td colspan="2">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="23">&nbsp;</td>
  <td width="262" align="right">&nbsp;</td>
  <td width="473" align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php if($_GET['P']!=1){ ?><span class="EstNotaCreditoImprimirEtiqueta">sub total</span><?php }?></td>
  <td width="67" align="center">&nbsp;</td>
  <td width="183" align="center"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsMoneda->MonSimbolo;?> 
  <?php echo number_format($InsNotaCredito->NcrSubTotal,2);?></span></td>
  <td width="19" colspan="4" align="center">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td rowspan="2" align="right" valign="top"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsNotaCredito->NcrMotivo;?></span></td>
  <td align="right">&nbsp;</td>
  <td align="right"><?php if($_GET['P']!=1){ ?><span class="EstNotaCreditoImprimirEtiqueta">i.g.v. 19%</span><?php }?></td>
  <td align="right">
  
  <span class="EstNotaCreditoImprimirContenido"><?php echo number_format($InsNotaCredito->NcrPorcentajeImpuestoVenta,0);?> % </span>  </td>
  <td align="center"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($InsNotaCredito->NcrImpuesto,2);?></span></td>
  <td colspan="4" align="center">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="right">
  

	<?php
	if($InsNotaCredito->NpaId=="NPA-10000"){		
	?>
	<span class="EstNotaCreditoImprimirContenidoFecha"><?php echo FncCambiaFechaAImpresion($InsNotaCredito->NcrFechaEmision);?></span>
	<?php
	}
	?>  </td>
  <td align="right"><?php if($_GET['P']!=1){ ?>
    <span class="EstNotaCreditoImprimirEtiqueta">total</span>
    <?php }?></td>
  <td align="center">&nbsp;</td>
  <td align="center"><span class="EstNotaCreditoImprimirContenido"><?php echo $InsMoneda->MonSimbolo;?> <?php echo number_format($InsNotaCredito->NcrTotal,2);?></span></td>
  <td colspan="4" align="center">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="2" align="left">
    
    
        	<?php
	if($GET_TiempoImpresion!=1){
	?>
		<span class="EstNotaCreditoImprimirContenido"> <?php echo date("d/m/Y");?> - <?php echo date("H:i:s");?></span>
	<?php
	}
	?> 
    
<!--    <span class="EstNotaCreditoImprimirContenido"> <?php echo $dias[date("N")-1]; ?>, <?php echo date("d");?> de <?php echo FncConvertirMes(date("n"));?> del <?php echo date("Y");?> horas <?php echo date("H:i:s");?> <?php echo date("a");?></span>  
	
	-->
	
	</td>
  <td width="188" align="right">&nbsp;</td>
  
  <td width="229" align="right">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td align="center">&nbsp;</td>
  <td colspan="4" align="center">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>

</body>
</html>
