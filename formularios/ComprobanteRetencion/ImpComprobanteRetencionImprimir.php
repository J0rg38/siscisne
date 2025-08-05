<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ComprobanteRetencion No.  <?php echo $InsComprobanteRetencion->CrtNumero;?> - <?php echo $InsComprobanteRetencion->CrnId;?></title>
<link href="css/CssComprobanteRetencionImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssComprobanteRetencionImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsComprobanteRetencionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript">
$().ready(function() {

<?php if($_GET['P']==1 and !empty($InsComprobanteRetencion->CrnId) and !empty($InsComprobanteRetencion->CrtId)){?> 
FncComprobanteRetencionImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>

});
</script>
</head>
<body>
<?php if($_GET['P']<>1){ ?>
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

<div class="EstComprobanteRetencionImprimirCapaPrincipal">




</div>


<table width="770" border="0" cellpadding="0" cellspacing="0" class="EstComprobanteRetencionImprimirTabla">

<tr>
  <td width="770" height="240" colspan="5" align="left" valign="top">
  
  <span class="EstComprobanteRetencionImprimirContenido">
  <?php echo $InsComprobanteRetencion->CrtNumero;?> - <?php echo $InsComprobanteRetencion->CrnId;?>   </span><br />
   
     <span class="EstComprobanteRetencionImprimirContenido">
  <?php echo $InsComprobanteRetencion->UsuUsuario;?>   </span>    </td>
  </tr>

  
  <tr>
    <td>
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstComprobanteRetencionImprimirTabla">
    <tr>
      <td width="13%" align="left" valign="top"><span class="EstComprobanteRetencionImprimirEtiqueta"> Señores:</span></td>
      <td colspan="3" align="left" valign="top"><span class="EstComprobanteRetencionImprimirContenidoEspecial"><?php echo $InsComprobanteRetencion->CliNombre;?> <?php echo $InsComprobanteRetencion->CliApellidoPaterno;?> <?php echo $InsComprobanteRetencion->CliApellidoMaterno;?></span></td>
      </tr>
  <tr>
    <td align="left" valign="top"><span class="EstComprobanteRetencionImprimirEtiqueta">R.U.C.:</span></td>
    <td width="38%" align="left" valign="top"><span class="EstComprobanteRetencionImprimirContenido"><?php echo $InsComprobanteRetencion->CliNumeroDocumento;?></span></td>
    <td width="25%" align="left" valign="top">&nbsp;</td>
    <td width="24%" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><span class="EstComprobanteRetencionImprimirEtiqueta">Direccion</span></td>
    <td align="left" valign="top"><span class="EstComprobanteRetencionImprimirContenido"><?php echo $InsComprobanteRetencion->CrnDireccion;?></span></td>
    <td align="left" valign="top"><span class="EstComprobanteRetencionImprimirEtiqueta">Fecha de emision:</span></td>
    <td align="left" valign="top">
<?php
list($dia,$mes,$ano) = explode("/",$InsComprobanteRetencion->CrnFechaEmision);
?>
    
    <span class="EstComprobanteRetencionImprimirContenido">
	<?php echo $dia;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $mes;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $ano;?>
    </span>
    
    
    </td>
    </tr>
    </table>    </td>
  </tr>
  

<tr>
  <td height="641" colspan="5" valign="top">
    
  <table  width="100%"  border="0" cellpadding="0" cellspacing="0" class="EstComprobanteRetencionImprimirTabla">
  <thead class="EstComprobanteRetencionImprimirTablaHead">
    
  <tr>
    <td height="35" align="center" widtd="143" >&nbsp;</td>
    <td height="35" align="center" widtd="143" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">Tipo.</span></td>
    <td height="35" align="center" widtd="54" >&nbsp;</td>
    <td height="35" align="center" widtd="54" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">Serie</span></td>
    <td height="35" align="center" widtd="54" >&nbsp;</td>
    <td align="center" widtd="782" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">Num. Correlativo</span></td>
    <td height="35" align="center" widtd="782" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">Fecha de Emision</span></td>
    <td width="4" height="35" align="center" widtd="18" >&nbsp;</td>
    <td height="35" align="center" widtd="104" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">MONTO A PAGAR</span></td>
    <td height="35" align="center" widtd="84" >&nbsp;</td>
    <td align="center" widtd="53" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">PORCENTAJE RETENCION </span></td>
    <td align="center" widtd="53" >&nbsp;</td>
    <td align="center" widtd="53" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta"> IMPORTE RETENIDO</span></td>
    <td align="center" widtd="53" >&nbsp;</td>
    <td height="35" align="center" widtd="53" ><span class="EstComprobanteRetencionDetalleImprimirEtiqueta">MONTO EFECTIVO PAGADO</span></td>
    <td height="35" align="center" widtd="53" >&nbsp;</td>
  </tr>
  </thead>
  <tbody class="EstComprobanteRetencionImprimirTablaBody">
  <?php
	
	$ArrMateriales = array();
	
	if(!empty($InsComprobanteRetencion->ComprobanteRetencionDetalle)){
		foreach($InsComprobanteRetencion->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){

			if($InsComprobanteRetencion->MonId<>$EmpresaMonedaId){
				
				$DatComprobanteRetencionDetalle->CedRetenido = round($DatComprobanteRetencionDetalle->CedRetenido / $InsComprobanteRetencion->CrnTipoCambio,2);
				$DatComprobanteRetencionDetalle->CedTotal = round($DatComprobanteRetencionDetalle->CedTotal  / $InsComprobanteRetencion->CrnTipoCambio,2);
				$DatComprobanteRetencionDetalle->CedPagado = round($DatComprobanteRetencionDetalle->CedPagado  / $InsComprobanteRetencion->CrnTipoCambio,2);
				
			}
					
?>
    <tr>
      <td width="5" align="center" valign="top">&nbsp;</td>
      <td width="73" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo $DatComprobanteRetencionDetalle->CedTipoDocumento;?></span></td>
      <td width="6" align="right" valign="top">&nbsp;</td>
      <td width="76" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo $DatComprobanteRetencionDetalle->CedSerie;?></span></td>
      <td width="4" align="right" valign="top">&nbsp;</td>
      <td width="408" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo $DatComprobanteRetencionDetalle->CedNumero;?></span></td>
      <td width="408" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo stripslashes( $DatComprobanteRetencionDetalle->CedFechaEmision);?></span></td>
      <td align="right" valign="top">&nbsp;</td>
      <td width="81" align="right" valign="top">
        <span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo number_format(($DatComprobanteRetencionDetalle->CedTotal),2);?>        </span>        </td>
      <td width="8" align="right" valign="top">&nbsp;</td>
      <td width="92" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo number_format($DatComprobanteRetencionDetalle->CedPorcentajeRetencion,2);?></span></td>
      <td width="92" align="right" valign="top">&nbsp;</td>
      <td width="92" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo $InsComprobanteRetencion->MonSimbolo;?> <?php echo number_format($DatComprobanteRetencionDetalle->CedRetenido,2);?></span></td>
      <td width="92" align="right" valign="top">&nbsp;</td>
      <td width="92" align="right" valign="top"><span class="EstComprobanteRetencionDetalleImprimirContenido"><?php echo $InsComprobanteRetencion->MonSimbolo;?> <?php echo number_format($DatComprobanteRetencionDetalle->CedPagado,2);?></span></td>
      <td width="19" align="right" valign="top">&nbsp;</td>
      </tr>
  <?php	

				$TotalPagado = $DatComprobanteRetencionDetalle->CedPagado;		
			
			
				
	
		}
	} 
?>
    
    
    
    
  <?php
if(!empty($InsComprobanteRetencion->CrnObservacionImpresa)){
?>
  <tr>
    <td width="5" align="center">&nbsp;</td>
    <td colspan="15" align="left">
      <span class="EstComprobanteRetencionImprimirContenido"> 
        <?php echo $InsComprobanteRetencion->CrnObservacionImpresa;?>        </span>        </td>
    </tr>
  <?php
}
?>
    
  </tbody>
  </table>
    
    
    

    
  </td>
</tr>

  <tr>
    <td colspan="5">
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9" height="28">&nbsp;</td>
    <td width="51" height="28" align="right">&nbsp;</td>
    <td width="224" align="left" valign="top"></td>
    <td width="245" height="28" align="center"><?php
	if($InsComprobanteRetencion->NpaId=="NPA-10000"){		
	list($Dia,$Mes,$Ano) = explode("/",$InsComprobanteRetencion->CrnFechaEmision);
	
	?>
      <span class="EstComprobanteRetencionImprimirContenidoFecha"> <?php echo $Dia;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo FncConvertirMes($Mes);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Ano;?>
        <?php //echo FncCambiaFechaAImpresion($InsComprobanteRetencion->CrnFechaEmision);?>
        </span>
      <?php
	}
	?></td>
    <td width="22" height="28" align="right">&nbsp;</td>
    <td width="82" height="28" align="right"><span class="EstComprobanteRetencionImprimirEtiqueta">total</span></td>
    <td width="37" height="28" align="right">&nbsp;</td>
    <td width="85" height="28" align="right"><span class="EstComprobanteRetencionImprimirContenido"> <?php echo $InsComprobanteRetencion->MonSimbolo; ?> <?php echo number_format($TotalPagado,2);?></span></td>
    <td width="60" height="28" colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td height="28" colspan="7" align="left"><?php
	if($GET_TiempoImpresion!=1){
	?>
      <span class="EstComprobanteRetencionImprimirContenido"> <?php echo date("d/m/y");?> - <?php echo date("H:i:s");?></span>
      <?php
	}
	?></td>
    <td height="28" colspan="4" align="center">&nbsp;</td>
  </tr>
  </table></td>
</tr>
</table>

</body>
</html>
