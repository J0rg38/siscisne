<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boleta No. <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?></title>
<link href="css/CssBoletaImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssBoletaImprimir200.css" rel="stylesheet" type="text/css" />

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
  <td height="118" colspan="5" align="left" valign="top">
  

<span class="EstBoletaDetalleImprimirContenido">
<?php
if(!empty($InsBoleta->OvvId)){
?>
<?php echo $InsBoleta->OvvId;?><br />
<?php
}
?>

</span>
<span class="EstBoletaDetalleImprimirContenido">
<?php
if(!empty($InsBoleta->VdiId)){
?>
<?php echo $InsBoleta->VdiId;?>   <br />
<?php
}
?>

</span>
                
  
   <span class="EstBoletaImprimirContenido">
   <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?>   </span>
   <br />
    <span class="EstBoletaImprimirContenido">
   <?php echo $InsBoleta->UsuUsuario;?>   </span>    </td>
  </tr>

  
  <tr>
    <td height="85" valign="top"><table class="EstBoletaImprimirTabla" width="100%" border="0" cellpadding="3" cellspacing="2">
    <tr>
      <td width="91" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
        <span class="EstBoletaImprimirEtiqueta"> Se&ntilde;ores</span>
        <?php }?></td>
      <td colspan="4" align="left" valign="top"><span class="EstBoletaImprimirContenido">
	  
	   <?php echo $InsBoleta->CliNombre;?> <?php echo $InsBoleta->CliApellidoPaterno;?> <?php echo $InsBoleta->CliApellidoMaterno;?>
			
            
     </span></td>
    </tr>
  <tr>
    <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Doc. Ident.  n&deg;</span>
      <?php }?></td>
    <td colspan="4" align="left" valign="top"><span class="EstBoletaImprimirContenido"><?php echo $InsBoleta->CliNumeroDocumento;?></span></td>
    </tr>
  <tr>
    <td align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Direccion</span>
      <?php }?></td>
    <td colspan="3" align="left" valign="top"><span class="EstBoletaImprimirContenido"><?php echo $InsBoleta->BolDireccion;?>
<!--     - 
    <?php echo $InsBoleta->CliDistrito;?>/
    <?php echo $InsBoleta->CliProvincia;?>/
    <?php echo $InsBoleta->CliDepartamento;?>-->
    </span></td>
    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td width="135" align="left" valign="top">&nbsp;</td>
    <td width="241" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Fecha de Emision:</span>
      <?php }?></td>
    <td width="269" align="left" valign="bottom"><span class="EstBoletaImprimirContenido">
      <?php 
	$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
	$fecha = explode("/", $InsBoleta->BolFechaEmision);
	
	echo $fecha[0];
	?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $meses[$fecha[1]];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo substr($fecha[2], 2);?></span></td>
    </tr>
  </table></td>
  </tr>
  

<tr>
<td height="257" colspan="5" valign="top" id = "altura">

<table  width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstBoletaImprimirTabla2">
<thead class="EstBoletaImprimirTablaHead2">

<tr>
  <td height="30" align="center" widtd="143" >&nbsp;</td>
  <td widtd="143" align="center" >
  
<?php
if($_GET['P']!=1){ 
?>
<span class="EstBoletaDetalleImprimirEtiqueta">cantidad</span>
<?php 
}
?></td>
  <td widtd="54" align="center" >&nbsp;</td>
  <td width="77" align="center" widtd="18" ><?php
if($_GET['P']!=1){ 
?>
      <span class="EstBoletaDetalleImprimirEtiqueta">u.m.</span>
      <?php 
}
?></td>
  <td widtd="54" align="center" >&nbsp;</td>
  <td widtd="782" align="center" >
<?php
if($_GET['P']!=1){ 
?>
<span class="EstBoletaDetalleImprimirEtiqueta">descripcion</span>
<?php 
}
?>  </td>
  <td width="25" align="center" widtd="18" >&nbsp;</td>
  <td widtd="104" align="center" >
<?php
if($_GET['P']!=1){ 
?>
<span class="EstBoletaDetalleImprimirEtiqueta">p/unitario</span>
<?php 
}
?></td>
  <td widtd="84" align="center" >&nbsp;</td>
  <td widtd="53" align="center" >
  	<?php
		if($_GET['P']!=1){ 
	?>
    		<span class="EstBoletaDetalleImprimirEtiqueta">importe</span>
	<?php 
		}
	?>	</td>
  	<td widtd="53" align="center" >&nbsp;</td>
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
		  <td width="2" align="center">
          <?php //deb($DatBoletaDetalle->BdeTipo);?>
          &nbsp;</td>
        <td width="70" align="right">
			
            <?php
			//if($DatBoletaDetalle->BdeDescripcion<>"MANO DE OBRA"){
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
        <td width="5" align="right">&nbsp;</td>
        <td align="right"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatBoletaDetalle->BdeUnidadMedida;?></span></td>
        <td width="9">&nbsp;</td>
        <td width="345">
			<span class="EstBoletaDetalleImprimirContenido">
				   <?php echo stripslashes($DatBoletaDetalle->BdeDescripcion);?>					</span>		</td>
        <td align="center">&nbsp;</td>
        <td width="104" align="right">
        
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
        <td width="7" align="right">&nbsp;</td>
        <td width="85" align="right">
        
<?php
if($DatBoletaDetalle->BdeTipo<>"T"){
?>
<span class="EstBoletaDetalleImprimirContenido"><?php // echo $InsBoleta->MonSimbolo;?>
<?php echo number_format($DatBoletaDetalle->BdeImporte,2);?>
</span>
<?php
}
?>

</td>
        <td width="19" align="center">&nbsp;</td>
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
			<td width="2" align="center" valign="top">&nbsp;</td>
            <td align="left" valign="top"></td>
            <td colspan="6" align="left" valign="top"><span class="EstBoletaDetalleImprimirContenido">MATERIALES: </span>
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
            <td align="left" valign="top">&nbsp;</td>
        <td width="85" align="right" valign="top"><span class="EstBoletaDetalleImprimirContenido"><?php echo number_format($MaterialImporte,2);?></span></td>
        <td width="19" align="center">&nbsp;</td>
  </tr>
  

  
<?php
		$TotalBruto = $TotalBruto + $MaterialImporte;
	} 
?>

<?php
if(!empty($InsBoleta->BolObservacionImpresa)){
?>
	<tr>
	  <td height="21" align="center"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>  
	    <span class="EstBoletaImprimirContenido">
	      
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
        
<!--          <br />
    
(*) Productos en oferta con precio especial disponibles hasta agotar stock
 
	    -->  
	      </span></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td align="center"></td>
	  </tr>
	<tr>
		<td height="21" align="center">  </td>
			<td colspan="9">
		  		<span class="EstBoletaImprimirContenido">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    		<?php
						echo $InsBoleta->BolObservacionImpresa;
					?>
				</span>			</td>
		<td align="center"></td>
    </tr>
  
<?php
}
?>

<?php
//if(!empty($InsBoleta->EinVIN)){
?>
	<?php
//}
?>


</tbody>
</table>


</td>
</tr>

  <tr>
    <td colspan="5" id = "son">
    
    
       
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
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span class="EstBoletaImprimirContenido"> 
	<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100  <?php echo $InsBoleta->MonNombre;?>        
    </span>   
    
    
    </td>
  </tr>
  <tr>
  <td colspan="5">
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">


<tr>
  <td height="39">&nbsp;</td>
  <td width="385" align="left" valign="top">
  
  
  
  </td>
  <td width="14">&nbsp;</td>
  <td width="311" align="right">&nbsp;</td>
  <td width="476" align="right"><?php if($_GET['P']!=1){ ?>
    <span class="EstBoletaImprimirEtiqueta">total</span>
    <?php }?></td>
  <td width="47" align="right">&nbsp;</td>
  <td width="157" align="center">

	<span class="EstBoletaImprimirContenido">
		<?php echo $InsBoleta->MonSimbolo; ?> <?php echo number_format($Total,2);?>
	</span>
  
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
  <td align="right">


  
  </td>
  <td colspan="4" align="right">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td width="385" align="left" valign="top"></td>
  <td>&nbsp;</td>
  <td align="right">
  
	<?php
//	if($InsBoleta->FpaId<>"FPA-10004"){
	if($InsBoleta->NpaId=="NPA-10000"){		
	?>
  
  <span class="EstBoletaImprimirContenidoFecha"><?php echo FncCambiaFechaAImpresion($InsBoleta->BolFechaEmision);?></span>
	<?php
	}
	?> 
  </td>
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