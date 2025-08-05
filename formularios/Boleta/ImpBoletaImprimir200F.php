<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boleta No. <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?></title>
<link href="css/CssBoletaImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssBoletaImprimir200F.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsBoletaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsBoleta->BolId) and !empty($InsBoleta->BtaId)){?> 
FncBoletaImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>
</head>

<body>
<?php if($_GET['P']<>1){?>

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
</td>
</tr>
</table>

</form>


<?php }?>


<div class="EstFacturaImprimirCapaPrincipal">


   	<?php
	if($InsBoleta->BolObsequio == 1){
	?> 
	<div class="EstBoletaImprimirObsequio">
    <img src="../../imagenes/transferencia_gratuita.png" width="369" height="288" />
  </div>
    <?php
	}
	?>

<table width="770"  border="0" cellpadding="0" cellspacing="0" class="EstBoletaImprimirTabla">

<tr>
  <td height="118" colspan="6" align="left" valign="top">
  
  
   <span class="EstBoletaImprimirContenido">
   <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?>   </span>
   <br />
    <span class="EstBoletaImprimirContenido">
   <?php echo $InsBoleta->UsuUsuario;?>   </span>    </td>
  </tr>

  
  <tr>
    <td width="442" height="85" rowspan="2" valign="top" class="EstBoletaImprimirFormatoCabecera2">
  
  
    <div class="EstBoletaImprimirSeparacion"  />
    <table class="EstBoletaImprimirTabla" width="100%" border="0" cellpadding="3" cellspacing="2">
    <tr>
      <td width="117" align="left" valign="top"><span class="EstBoletaImprimirEtiqueta"> Se&ntilde;ores</span></td>
      <td width="6" align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top"><span class="EstBoletaImprimirContenido"> <?php echo $InsBoleta->CliNombre;?> <?php echo $InsBoleta->CliApellidoPaterno;?> <?php echo $InsBoleta->CliApellidoMaterno;?></span></td>
      </tr>
  <tr>
    <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">Doc. Ident.  n&deg;</span></td>
    <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">:</span></td>
    <td align="left" valign="top"><span class="EstBoletaImprimirContenido"><?php echo $InsBoleta->CliNumeroDocumento;?></span></td>
    </tr>
  <tr>
    <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">Direccion</span></td>
    <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">:</span></td>
    <td width="348" align="left" valign="top"><span class="EstBoletaImprimirContenido"><?php echo $InsBoleta->BolDireccion;?>
    
    
    <!-- - 
    <?php echo $InsBoleta->CliDistrito;?>/
    <?php echo $InsBoleta->CliProvincia;?>/
    <?php echo $InsBoleta->CliDepartamento;?>-->
    
    </span></td>
  </tr>
  </table>
  
 
  </td>
    <td width="328" height="45" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="40" align="right" valign="top">
    
    
  
    <table class="EstBoletaImprimirTabla" border="0" cellpadding="3" cellspacing="2">
      <tr>
        <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">Fecha</span></td>
        <td align="left" valign="top"><span class="EstBoletaImprimirEtiqueta">:</span></td>
        <td align="left" valign="top"><span class="EstBoletaImprimirContenido">
          <?php 
	$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
	$fecha = explode("/", $InsBoleta->BolFechaEmision);
	?>
          <?php echo $fecha[0];?> de <?php echo $meses[$fecha[1]];?> del <?php echo $fecha[2];?></span></td>
      </tr>
    </table>
    
    
    </td>
  </tr>
  
  <tr>
  <td height="257" colspan="6" valign="top" id = "altura" class="EstBoletaImprimirFormatoDetalle2">
    
    
  <div class="EstBoletaImprimirSeparacion"  />
  <table  width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstBoletaImprimirTabla2">
  <thead class="EstBoletaImprimirTablaHead2">
    
  <tr>
    <td height="30" align="center" widtd="143" ><span class="EstBoletaDetalleImprimirEtiqueta">cantidad</span>
      <div class="EstBoletaImprimirSeparacion"  />
    </td>
    <td width="80" align="center" widtd="18" ><span class="EstBoletaDetalleImprimirEtiqueta">u.m.</span>
      
      <div class="EstBoletaImprimirSeparacion"  /></td>
    <td widtd="782" align="center" ><span class="EstBoletaDetalleImprimirEtiqueta">descripcion</span>
      <div class="EstBoletaImprimirSeparacion"  />
    </td>
    <td widtd="104" align="center" ><span class="EstBoletaDetalleImprimirEtiqueta">p/unitario</span>
      <div class="EstBoletaImprimirSeparacion"  /></td>
    <td widtd="53" align="center" ><span class="EstBoletaDetalleImprimirEtiqueta">importe</span>
      <div class="EstBoletaImprimirSeparacion"  /></td>
    </tr>
  </thead>
  <tbody class="EstBoletaImprimirTablaBody2">
  <?php
	$ArrMateriales = array();
	
	if(!empty($InsBoleta->BoletaDetalle)){
		foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
			
			if($DatBoletaDetalle->BdeTipo <> "M"){

			
				if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
					$DatBoletaDetalle->BdeImporte = round($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio,2);
					$DatBoletaDetalle->BdePrecio = round($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio,2);
				}
			
?>
    <tr>
      <td width="73" align="center">
        
        <?php
//			if($DatBoletaDetalle->BdeDescripcion<>"MANO DE OBRA"){
			?>
  
  <?php
            if($DatBoletaDetalle->BdeTipo<>"T"){
            ?>
            
                  
        <span class="EstBoletaDetalleImprimirContenido">
          <?php echo $DatBoletaDetalle->BdeCantidad;?>			</span>	
        
        <?php
			}						
			?>
        
        
        
        
      </td>
      <td align="center"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatBoletaDetalle->BdeUnidadMedida;?></span></td>
      <td width="354">
        <span class="EstBoletaDetalleImprimirContenido">
             <?php echo stripslashes($DatBoletaDetalle->BdeDescripcion);?>						</span>		</td>
      <td width="102" align="right">
      
      <?php
            if($DatBoletaDetalle->BdeTipo<>"T"){
            ?>
            <span class="EstBoletaDetalleImprimirContenido">
        <?php //echo $InsBoleta->MonSimbolo;?> 		
        <?php echo number_format($DatBoletaDetalle->BdePrecio,2);?>
        
        
      </span>
      <?php
			}
	  ?>
      </td>
      <td width="106" align="right">
      <?php
            if($DatBoletaDetalle->BdeTipo<>"T"){
            ?><span class="EstBoletaDetalleImprimirContenido"><?php // echo $InsBoleta->MonSimbolo;?>
        <?php echo number_format($DatBoletaDetalle->BdeImporte,2);?>
        
      </span>
      <?php
			}
	  ?></td>
      </tr>
    
  <?php			$TotalBruto = $TotalBruto + $DatBoletaDetalle->BdeImporte;		

			}else{
				$ArrMateriales[] = $DatBoletaDetalle;
			}
			
			

		}
	} 
?>
    
    
  <?php
	
	
	if(!empty($ArrMateriales)){
		
		$MaterialImporte = 0;
		
		foreach($ArrMateriales as $DatMaterial){

			if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
				$DatMaterial->BdeImporte = round($DatMaterial->BdeImporte / $InsBoleta->BolTipoCambio,2);
				$DatMaterial->BdePrecio = round($DatMaterial->BdePrecio  / $InsBoleta->BolTipoCambio,2);
			}
			
			$MaterialImporte += $DatMaterial->BdeImporte;
		}
		
?>
    <tr>
      <td align="left" valign="top"></td>
      <td colspan="3" align="left" valign="top"><span class="EstBoletaDetalleImprimirContenido">MATERIALES: </span>
        <table>
          <?php

		foreach($ArrMateriales as $DatMaterial){

			if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
				$DatMaterial->BdeImporte = round($DatMaterial->BdeImporte / $InsBoleta->BolTipoCambio,2);
				$DatMaterial->BdePrecio = round($DatMaterial->BdePrecio  / $InsBoleta->BolTipoCambio,2);
			}
?>
          <tr>
            <td width="80" align="right"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatMaterial->BdeCantidad;?></span></td>
            <td align="right"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatMaterial->BdeDescripcion;?></span></td>
            <td align="right"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatMaterial->BdeUnidadMedida;?></span></td>
            <td align="right"><span class="EstBoletaDetalleImprimirContenido"><?php echo number_format($DatMaterial->BdeImporte,2);?></span></td>
            </tr>
          <?php
		}
		
		
	  ?>
        </table></td>
      <td width="106" align="right" valign="top"><span class="EstBoletaDetalleImprimirContenido"><?php echo number_format($MaterialImporte,2);?></span></td>
      </tr>
    
    
    
  <?php
		$TotalBruto = $TotalBruto + $MaterialImporte;
	} 
?>
    
     <tr>
      <td height="21">&nbsp;</td>
      <td height="21">&nbsp;</td>
      <td height="21"> <span class="EstBoletaImprimirContenido">
        
<?php
if(!empty($InsBoleta->EinVIN)){
?>
	VIN: <?php echo $InsBoleta->EinVIN;?> - <?php echo $InsBoleta->EinPlaca;?><br />
<?php echo $InsBoleta->VmaNombre;?> <?php echo $InsBoleta->VmoNombre;?> <?php echo $InsBoleta->VveNombre;?> <br />
<?php
}
?>       
          
<?php
if(!empty($InsBoleta->FinId)){
?>
	<br />O.T.: <?php echo $InsBoleta->FinId;?>
	<br />Kilom.: <?php echo $InsBoleta->FinVehiculoKilometraje;?> <?php echo (!empty($InsBoleta->FinVehiculoKilometraje))?'KM':'';;?> 
<?php
}
?>

<?php
if(!empty($InsBoleta->AmoId)){
?>
	<br />Ficha: <?php echo $InsBoleta->AmoId;?>
<?php
}
?>

<!--  <br />
    
(*) Productos en oferta con precio especial disponibles hasta agotar stock
 -->
  
  <?php
$Total = $TotalBruto;
?>


        <?php
   //deb($InsFactura->FacObsequio);
	if($InsBoleta->BolObsequio==1){
		
	?>
    <br />
    <br />
    ENTREGA A TITULO GRATUITO. <br />VALOR REFERENCIAL <?php echo number_format($Total,2);?>
    <?php	
	
		$SubTotal = 0;
        $Impuesto = 0;
        $Total = 0;
		
		
	}
	?>
        </span></td>
      <td height="21">&nbsp;</td>
      <td height="21">&nbsp;</td>
    </tr>
    
    
  <?php
if(!empty($InsBoleta->BolObservacionImpresa)){
?>
   
    <tr>
      <td height="21" colspan="5">
        <span class="EstBoletaImprimirContenido">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
						echo $InsBoleta->BolObservacionImpresa;
					?>
        </span>			</td>
      </tr>
    
  <?php
}
?>
    

    
    
  </tbody>
  </table>
    
  
  </td>
</tr>

  <tr>
    <td colspan="6" id = "son">
    
    
       
<?php

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

<div class="EstBoletaImprimirSeparacion"  />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstBoletaImprimirEtiqueta">SON: </span>
    <span class="EstBoletaImprimirContenido"> 
	<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100  <?php echo $InsBoleta->MonNombre;?>        
    </span>   
  <div class="EstBoletaImprimirSeparacion"  />  
    
    </td>
  </tr>
  <tr>
  <td colspan="6">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">


<tr>
  <td height="39">&nbsp;</td>
  <td width="385" align="left" valign="top">
  
  
  
  </td>
  <td width="14">&nbsp;</td>
  <td width="311" rowspan="3" align="center">
  
	<?php
//	if($InsBoleta->FpaId<>"FPA-10004"){
	/*if($InsBoleta->NpaId=="NPA-10000"){		
	?>
  
  <span class="EstBoletaImprimirContenidoFecha"><?php echo FncCambiaFechaAImpresion($InsBoleta->BolFechaEmision);?></span>
  <?php
	}*/
	?>
    
  <br />
  <span class="EstBoletaImprimirContenido">____________________________</span><br />
  <span class="EstBoletaImprimirContenido">CANCELADO</span>
	  </td>
  <td width="476" align="right"><span class="EstBoletaImprimirEtiqueta">totaL:</span></td>
  <td width="47" align="right">&nbsp;</td>
  <td width="157" align="center">

	<span class="EstBoletaImprimirContenido">
		<?php echo $InsBoleta->MonSimbolo; ?> <?php echo number_format($Total,2);?>
	</span>
  <div class="EstBoletaImprimirSeparacion"  />
  </td>
  <td colspan="4" align="right">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td width="385" align="left" valign="top"></td>
  <td>&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">


  
  </td>
  <td colspan="4" align="right">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td width="385" align="left" valign="top"></td>
  <td>&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td colspan="4" align="right">&nbsp;</td>
</tr>
<tr>
  <td width="42">&nbsp;</td>
  <td colspan="6">
      
	<?php
	/*if($GET_TiempoImpresion!=1){
	?>
	<!--<span class="EstBoletaImprimirContenido"><?php echo date("d/m/Y");?> - <?php echo date("H:i:s");?></span>-->
    <span class="EstBoletaImprimirContenido"> <?php echo rand().date("Hdimsy").rand();?></span>
	<?php
	}*/
	?>
	
	 
    
  
  </td>
  <td width="11" colspan="4" align="right">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>
</div>
</body>
</html>