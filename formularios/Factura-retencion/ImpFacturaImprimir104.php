<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factura No.  <?php echo $InsFactura->FtaNumero;?> - <?php echo $InsFactura->FacId;?></title>
<link href="css/CssFacturaImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssFacturaImprimir104.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFacturaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript">
$().ready(function() {

<?php if($_GET['P']==1 and !empty($InsFactura->FacId) and !empty($InsFactura->FtaId)){?> 
FncFacturaImprimir(); 
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

<div class="EstFacturaImprimirCapaPrincipal">

	<?php
	if($InsFactura->FacSpot == 1){
	?>
  	<div class="EstFacturImprimirSpot">
    <img src="../../imagenes/spot.png" width="518" height="66" />
    </div>  
    <?php
	}
	?>

   	<?php
	if($InsFactura->FacObsequio == 1){
	?> 
	<div class="EstFacturImprimirObsequio">
    <img src="../../imagenes/transferencia_gratuita.png" width="357" height="287" />
  </div>
    <?php
	}
	?>
    
<table width="780" border="0" cellpadding="0" cellspacing="0" class="EstFacturaImprimirTabla">

<tr>
  <td width="1203" height="230" colspan="5" align="left" valign="top">
  
  <span class="EstFacturaImprimirContenido">
  <?php echo $InsFactura->FtaNumero;?> - <?php echo $InsFactura->FacId;?>   </span><br />
   
     <span class="EstFacturaImprimirContenido">
  <?php echo $InsFactura->UsuUsuario;?>   </span>    </td>
  </tr>

  
  <tr>
    <td>
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstFacturaImprimirTabla">
    <tr>
      <td width="12%" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
        <span class="EstFacturaImprimirEtiqueta"> Señores:</span>
        <?php }?></td>
      <td colspan="3" align="left" valign="top"><span class="EstFacturaImprimirContenido"><?php echo $InsFactura->CliNombre;?> <?php echo $InsFactura->CliApellidoPaterno;?> <?php echo $InsFactura->CliApellidoMaterno;?></span></td>
      <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
        <span class="EstFacturaImprimirEtiqueta">Fecha  :</span>
        <?php }?></td>
      <td align="left" valign="top"><span class="EstFacturaImprimirContenido"><?php echo $InsFactura->FacFechaEmision;?></span></td>
    </tr>
  <tr>
    <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstFacturaImprimirEtiqueta">R.U.C.:</span>
      <?php }?></td>
    <td width="26%" align="left" valign="top"><span class="EstFacturaImprimirContenido"><?php echo $InsFactura->CliNumeroDocumento;?></span></td>
    <td width="14%" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstFacturaImprimirEtiqueta">Localidad:</span>
      <?php }?></td>
    <td width="18%" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstFacturaImprimirEtiqueta">Nª Guia: </span>
      <?php }?></td>
    <td align="left" valign="top"><span class="EstFacturaImprimirContenido"><?php echo $InsFactura->GrtNumero;?> - <?php echo $InsFactura->GreId;?></span></td>
  </tr>
  <tr>
    <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstFacturaImprimirEtiqueta">Direccion</span>
      <?php }?></td>
    <td colspan="3" align="left" valign="top"><span class="EstFacturaImprimirContenido"><?php echo $InsFactura->FacDireccion;?>
    <!--     - 
    <?php echo $InsFactura->CliDistrito;?>/
    <?php echo $InsFactura->CliProvincia;?>/
    <?php echo $InsFactura->CliDepartamento;?>-->
    
    </span></td>
    <td width="12%" align="left" valign="top">&nbsp;</td>
    <td width="18%" align="left" valign="top">&nbsp;</td>
  </tr>
    </table>    </td>
  </tr>
  

<tr>
<td height="640" colspan="5" valign="top">


<?php
if($InsFactura->FacTipo == "2"){
?>

<table  width="100%"  border="0" cellpadding="0" cellspacing="0" class="EstFacturaImprimirTabla">
<thead class="EstFacturaImprimirTablaHead">

<tr>
  <td height="33" align="center" widtd="143" >&nbsp;</td>
  <td height="33" align="center" widtd="143" >
  
  <?php
if($_GET['P']!=1){ 
?>
<span class="EstFacturaDetalleImprimirEtiqueta">CANT.</span>

<?php 
}
?></td>
  <td height="33" align="center" widtd="54" >&nbsp;</td>
  <td height="33" align="center" widtd="54" ><?php
if($_GET['P']!=1){ 
?>
    <span class="EstFacturaDetalleImprimirEtiqueta">UNIDAD</span>
    <?php 
}
?></td>
  <td height="33" align="center" widtd="54" >&nbsp;</td>
  <td height="33" align="center" widtd="782" >
  
  <?php
if($_GET['P']!=1){ 
?>
<span class="EstFacturaDetalleImprimirEtiqueta">DESCRIPCION</span>

<?php 
}
?></td>
  <td width="5" height="33" align="center" widtd="18" >&nbsp;</td>
  <td height="33" align="center" widtd="104" >
    <?php
if($_GET['P']!=1){ 
?><span class="EstFacturaDetalleImprimirEtiqueta">P. UNIT. </span><?php 
}
?></td>
  <td height="33" align="center" widtd="84" >&nbsp;</td>
  <td height="33" align="center" widtd="53" ><?php
if($_GET['P']!=1){ 
?>
    <span class="EstFacturaDetalleImprimirEtiqueta">VALOR TOTAL </span>
    <?php 
}
?></td>
  <td height="33" align="center" widtd="53" >&nbsp;</td>
</tr>
</thead>
<tbody class="EstFacturaImprimirTablaBody">

		<tr>
		  <td width="5" align="center" valign="top">&nbsp;</td>
        <td width="64" align="right" valign="top">&nbsp;</td>
        <td width="6" align="right" valign="top">&nbsp;</td>
        <td width="61" align="right" valign="top">&nbsp;</td>
        <td width="11" align="right" valign="top">&nbsp;</td>
        <td width="391" align="left" valign="top">
        
<?php
echo stripslashes($InsFactura->FacConcepto);
?>
        </td>
        <td align="right" valign="top">&nbsp;</td>
        <td width="83" align="right" valign="top">&nbsp;</td>
        <td width="7" align="right" valign="top">&nbsp;</td>
        <td width="123" align="right" valign="top">&nbsp;</td>
        <td width="19" align="right" valign="top">&nbsp;</td>
  </tr>





		
  

  



<?php
if(!empty($InsFactura->FacObservacionImpresa)){
?>
<tr>
		  <td width="5" align="center">&nbsp;</td>
        <td colspan="10" align="left">
		<span class="EstFacturaImprimirContenido"> 
		<?php echo $InsFactura->FacObservacionImpresa;?>        </span>        </td>
        </tr>
<?php
}
?>

<tr>
  <td width="5" align="center">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
  <td align="left">&nbsp;</td>
</tr>

</tbody>
</table>

<?php

if($InsFactura->FacTipo == "2"){
	$TotalBruto = $InsFactura->FacTotal;
}
	
if($InsFactura->FacIncluyeImpuesto==2){

	$SubTotal = round($TotalBruto,6);
	$Impuesto = round(($SubTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100)),6);
	$Total = round($SubTotal + $Impuesto,6);

}else{

	$Total = round($TotalBruto,6);	
	$SubTotal = round($Total / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1),6);
	$Impuesto = round(($Total - $SubTotal),6);

}

?>

<?php
}else{
?>

<table  width="100%"  border="0" cellpadding="0" cellspacing="0" class="EstFacturaImprimirTabla">
    <thead class="EstFacturaImprimirTablaHead">
    
    <tr>
      <td height="33" align="center" widtd="143" >&nbsp;</td>
      <td height="33" align="center" widtd="143" >
      
      <?php
    if($_GET['P']!=1){ 
    ?>
    <span class="EstFacturaDetalleImprimirEtiqueta">CANT.</span>
    
    <?php 
    }
    ?></td>
      <td height="33" align="center" widtd="54" >&nbsp;</td>
      <td height="33" align="center" widtd="54" ><?php
    if($_GET['P']!=1){ 
    ?>
        <span class="EstFacturaDetalleImprimirEtiqueta">UNIDAD</span>
        <?php 
    }
    ?></td>
      <td height="33" align="center" widtd="54" >&nbsp;</td>
      <td height="33" align="center" widtd="782" >
      
      <?php
    if($_GET['P']!=1){ 
    ?>
    <span class="EstFacturaDetalleImprimirEtiqueta">DESCRIPCION</span>
    
    <?php 
    }
    ?></td>
      <td width="9" height="33" align="center" widtd="18" >&nbsp;</td>
      <td height="33" align="center" widtd="104" >
        <?php
    if($_GET['P']!=1){ 
    ?><span class="EstFacturaDetalleImprimirEtiqueta">P. UNIT. </span><?php 
    }
    ?></td>
      <td height="33" align="center" widtd="84" >&nbsp;</td>
      <td height="33" align="center" widtd="53" ><?php
    if($_GET['P']!=1){ 
    ?>
        <span class="EstFacturaDetalleImprimirEtiqueta">VALOR TOTAL </span>
        <?php 
    }
    ?></td>
      <td height="33" align="center" widtd="53" >&nbsp;</td>
    </tr>
    </thead>
    <tbody class="EstFacturaImprimirTablaBody">
    <?php
        
        $ArrMateriales = array();
        
        if(!empty($InsFactura->FacturaDetalle)){
            foreach($InsFactura->FacturaDetalle as $DatFacturaDetalle){
    
                if($DatFacturaDetalle->FdeTipo <> "M"){
    
                    if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
                        $DatFacturaDetalle->FdeImporte = round($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio,2);
                        $DatFacturaDetalle->FdePrecio = round($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio,2);
                    }
    //			if($InsFactura->MonId<>$EmpresaMonedaId){
    //				if(!empty($InsFactura->FacTipoCambio)){
    //					$DatFacturaDetalle->FdeImporte = round($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio,2);
    //					$DatFacturaDetalle->FdePrecio = round($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio,2);
    //				}else{
    //					$DatFacturaDetalle->FdeImporte = 0;
    //					$DatFacturaDetalle->FdePrecio = 0;
    //				}
    //			}
    ?>
            <tr>
              <td width="6" align="center">&nbsp;</td>
            <td width="102" align="left">
            
            
<?php
if($DatFacturaDetalle->FdeTipo<>"T"){
?>
	<span class="EstFacturaDetalleImprimirContenido"><?php echo $DatFacturaDetalle->FdeCantidad;?></span>
<?php
}
?>
            
            </td>
            <td width="6" align="right">&nbsp;</td>
            <td width="117" align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo $DatFacturaDetalle->FdeUnidadMedida;?></span></td>
            <td width="6" align="right">&nbsp;</td>
            <td width="494" align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo stripslashes( $DatFacturaDetalle->FdeDescripcion);?></span></td>
            <td align="right">&nbsp;</td>
            <td width="135" align="right">
            
            
            
            <?php
if($DatFacturaDetalle->FdeTipo<>"T"){
?>
  <span class="EstFacturaDetalleImprimirContenido"><?php echo number_format(($DatFacturaDetalle->FdePrecio),2);?></span>    
     
<?php
}
?>
          
     
     
     
         </td>
            <td width="5" align="right">&nbsp;</td>
            <td width="133" align="right">
          
<?php
if($DatFacturaDetalle->FdeTipo<>"T"){
?>
<span class="EstFacturaDetalleImprimirContenido"><?php echo number_format($DatFacturaDetalle->FdeImporte,2);?></span>
<?php
}
?>
            </td>
            <td width="11" align="right">&nbsp;</td>
      </tr>
    <?php	
    
                    $TotalBruto = $TotalBruto + $DatFacturaDetalle->FdeImporte;		
                    
                }else{
                    $ArrMateriales[] = $DatFacturaDetalle;
                }
                
                
            }
        } 
    ?>
    
    
    
    <?php
        
        
        if(!empty($ArrMateriales)){
            
            $MaterialImporte = 0;
            
            foreach($ArrMateriales as $DatMaterial){
    
                if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
                    $DatMaterial->FdeImporte = round($DatMaterial->FdeImporte / $InsFactura->FacTipoCambio,2);
                    $DatMaterial->FdePrecio = round($DatMaterial->FdePrecio  / $InsFactura->FacTipoCambio,2);
                }
                
                $MaterialImporte += $DatMaterial->FdeImporte;
            }
            
    ?>
    
		<tr>
                <td width="6" align="center" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="5" align="left" valign="top"><span class="EstFacturaDetalleImprimirContenido">MATERIALES: </span>
                  <table>
                    <?php
    
            foreach($ArrMateriales as $DatMaterial){
    
                if($InsFactura->MonId<>$EmpresaMonedaId and (!empty($InsFactura->FacTipoCambio) )){
                    $DatMaterial->FdeImporte = round($DatMaterial->FdeImporte / $InsFactura->FacTipoCambio,2);
                    $DatMaterial->FdePrecio = round($DatMaterial->FdePrecio  / $InsFactura->FacTipoCambio,2);
                }
    ?>
                    <tr>
                      <td width="80" align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo $DatMaterial->FdeCantidad;?></span></td>
                      <td align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo $DatMaterial->FdeDescripcion;?></span></td>
                      <td align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo $DatMaterial->FdeUnidadMedida;?></span></td>
                      <td align="left"><span class="EstFacturaDetalleImprimirContenido"><?php echo number_format($DatMaterial->FdeImporte,2);?></span></td>
                    </tr>
                    <?php
            }
            
            
          ?>
                </table></td>
                <td align="left" valign="top">&nbsp;</td>
            <td width="133" align="right" valign="top"><span class="EstFacturaDetalleImprimirContenido"><?php echo number_format($MaterialImporte,2);?></span></td>
            <td width="11" align="center">&nbsp;</td>
      </tr>
      
    
      
    <?php
            $TotalBruto = $TotalBruto + $MaterialImporte;
        } 
    ?>
    
    
    
    
    <?php
    if(!empty($InsFactura->FacObservacionImpresa)){
    ?>
        <tr>
        <td width="6" align="center">&nbsp;</td>
        <td colspan="10" align="left">
        <span class="EstFacturaImprimirContenido"> 
        <?php echo $InsFactura->FacObservacionImpresa;?>        </span>        
        </td>
        </tr>
    <?php
    }
    ?>
    
    
    
        <tr>
            <td width="6" align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">
        
        	  <?php
if(!empty($InsFactura->FacFechaVencimiento)){
?>
    
  <span class="EstFacturaImprimirContenido">FECHA DE VENCIMIENTO: <?php echo $InsFactura->FacFechaVencimiento;?> </span> <br />
  <?php
}
?>


    
    <span class="EstFacturaImprimirContenido">
        
        <?php
        if(!empty($InsFactura->EinVIN)){
        ?>
            VIN: <?php echo $InsFactura->EinVIN;?> - <?php echo $InsFactura->EinPlaca;?><br />
            <?php echo $InsFactura->VmaNombre;?> <?php echo $InsFactura->VmoNombre;?> <?php echo $InsFactura->VveNombre;?> <br />
        <?php		
        }
        ?>
    
        <?php
        if(!empty($InsFactura->FinId)){
        ?>
            <br />O.T.: <?php echo $InsFactura->FinId;?>
            <br />Kilom.: <?php echo $InsFactura->FinVehiculoKilometraje;?> <?php echo (!empty($InsFactura->FinVehiculoKilometraje))?'KM':'';?> 
        <?php
        }
        ?>
        
        <?php
        if(!empty($InsFactura->AmoId)){
        ?>	
            <br />Ficha: <?php echo $InsFactura->AmoId;?>
        <?php	
        }
        ?>
        
       

<?php
//if($InsFactura->FacIncluyeImpuesto==1){
//	$ImpuestoVenta = ($InsFactura->FacPorcentajeImpuestoVenta/100);
//	$ImpuestoVenta = $ImpuestoVenta + 1;
//	$SubTotal = (($TotalBruto /$ImpuestoVenta));
//	$Impuesto = $TotalBruto - $SubTotal;
//	$Total = $TotalBruto;
//}else{
//	$SubTotal = $TotalBruto;
//	$Impuesto = $SubTotal*($InsFactura->FacPorcentajeImpuestoVenta/100);	
//	$Total = $SubTotal + $Impuesto;
//}


if($InsFactura->FacIncluyeImpuesto==2){

	$SubTotal = round($TotalBruto,6);
	$Impuesto = round(($SubTotal * ($InsFactura->FacPorcentajeImpuestoVenta/100)),6);
	$Total = round($SubTotal + $Impuesto,6);

}else{

	$Total = round($TotalBruto,6);	
	$SubTotal = round($Total / (($InsFactura->FacPorcentajeImpuestoVenta/100)+1),6);
	$Impuesto = round(($Total - $SubTotal),6);

}


?> 
    
    <?php
   //deb($InsFactura->FacObsequio);
	if($InsFactura->FacObsequio==1){
		
	?><br /><br />
    ENTREGA A TITULO GRATUITO.<br /> VALOR REFERENCIAL <?php echo number_format($Total,2);?>
    <?php	
	
		$SubTotal = 0;
        $Impuesto = 0;
        $Total = 0;
		
		
	}
	?>
   
<!--        <br />
    
(*) Productos en oferta con precio especial disponibles hasta agotar stock
 -->
    </span>
    
    
    
            
            </td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
        </tr>
    
  
    
    </tbody>
    </table>








<?php	
}
?>


</td>
</tr>

  <tr>
    <td height="21" colspan="5" align="center">
	
	
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="13%" height="30" align="left">&nbsp;</td>
	<td width="87%">
    
   
<?php
//list($parte_entero,$parte_decimal) = explode(".",$InsFactura->FacTotal);
$Total = round($Total,2);
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

	
	<span class="EstFacturaImprimirContenido"> 
	
	<?php if($_GET['P']!=1){ ?>SON: <?php } ?>
	<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100 <?php echo $InsFactura->MonNombre;?>    </span>    </td>
    </tr>
    </table>
    
    </td>
  </tr>
  <tr>
  <td colspan="5">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="9" height="28">&nbsp;</td>
  <td height="28" colspan="2" align="left"><?php
	/*if($GET_TiempoImpresion!=1){
	?>
    <!--<span class="EstFacturaImprimirContenido"> <?php echo date("d/m/Y");?> - <?php echo date("H:i:s");?></span>-->
    <span class="EstFacturaImprimirContenido"> <?php echo rand().date("Hdimsy").rand();?></span>
    <?php
	}*/
	?></td>
  <td width="429" height="28" align="center">&nbsp;</td>
  <td width="9" height="28" align="right">&nbsp;</td>
  <td width="178" height="28" align="right"><?php if($_GET['P']!=1){ ?><span class="EstFacturaImprimirEtiqueta">sub total</span><?php }?></td>
  <td width="44" height="28" align="right">&nbsp;</td>
  <td width="216" height="28" align="right">
  <span class="EstFacturaImprimirContenido">
    
    <?php echo $InsFactura->MonSimbolo; ?> <?php echo number_format($SubTotal,2);?></span>  </td>
  </tr>
<tr>
  <td height="28">&nbsp;</td>
  <td width="73" height="28" align="right">&nbsp;</td>
  <td width="216" align="left" valign="top">&nbsp;</td>
  <td height="28" align="center" valign="top"><?php
	if($InsFactura->NpaId=="NPA-10000"){		
	list($Dia,$Mes,$Ano) = explode("/",$InsFactura->FacFechaEmision);
	
	?>
    <span class="EstFacturaImprimirContenidoFecha"> <?php echo $Dia;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo FncConvertirMes($Mes);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Ano;?>
    <?php //echo FncCambiaFechaAImpresion($InsFactura->FacFechaEmision);?>
    </span>
    <?php
	}
	?></td>
  <td height="28" align="right">&nbsp;</td>
  <td height="28" align="right"><?php if($_GET['P']!=1){ ?><span class="EstFacturaImprimirEtiqueta">i.g.v. </span><?php }?></td>
  <td height="28" align="right">
  
  <span class="EstFacturaImprimirContenido"><?php echo number_format($InsFactura->FacPorcentajeImpuestoVenta,0);?> % </span>  </td>
  
  
  <td height="28" align="right">
    <span class="EstFacturaImprimirContenido">
      
      
      <?php echo $InsFactura->MonSimbolo; ?> 
      
      <?php echo number_format($Impuesto,2);?>  </span>  </td>
  </tr>
<tr>
  <td height="28">&nbsp;</td>
  <td height="28" align="left">&nbsp;</td>
  <td width="216" align="left" valign="top">&nbsp;</td>
  <td height="28" align="left">&nbsp;</td>
  <td height="28" align="right">&nbsp;</td>
  <td height="28" align="right"><?php if($_GET['P']!=1){ ?>
    <span class="EstFacturaImprimirEtiqueta">total</span>
    <?php }?></td>
  <td height="28" align="right">&nbsp;</td>
  <td height="28" align="right">
    <span class="EstFacturaImprimirContenido">
      
      <?php echo $InsFactura->MonSimbolo; ?> <?php echo number_format($Total,2);?> </span>  </td>
  </tr>

</table></td>
</tr>
</table>


</div>

</body>
</html>
