<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FacturaExportacion No. <?php echo $InsFacturaExportacion->FetNumero;?> - <?php echo $InsFacturaExportacion->FexId;?></title>
<link href="css/CssFacturaExportacionImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssFacturaExportacionImprimir200F.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsFacturaExportacionImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.7.2.min.js"></script> 

<!--
Libreria para convertir Numeros a letras
-->
<?php require_once($InsProyecto->MtdRutLibrerias().'class.numeroaletras.php');?>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsFacturaExportacion->FexId) and !empty($InsFacturaExportacion->FetId)){?> 
FncFacturaExportacionImprimir(); 
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
	if($InsFacturaExportacion->FexObsequio == 1){
	?> 
	<div class="EstFacturaExportacionImprimirObsequio">
    <img src="../../imagenes/transferencia_gratuita.png" width="369" height="288" />
  </div>
    <?php
	}
	?>

<table width="770"  border="0" cellpadding="0" cellspacing="0" class="EstFacturaExportacionImprimirTabla">

<tr>
  <td height="118" colspan="6" align="left" valign="top">
  
  
   <span class="EstFacturaExportacionImprimirContenido">
   <?php echo $InsFacturaExportacion->FetNumero;?> - <?php echo $InsFacturaExportacion->FexId;?>   </span>
   <br />
    <span class="EstFacturaExportacionImprimirContenido">
   <?php echo $InsFacturaExportacion->UsuUsuario;?>   </span>    </td>
  </tr>

  
  <tr>
    <td width="442" height="85" rowspan="2" valign="top" class="EstFacturaExportacionImprimirFormatoCabecera2">
  
  
    <div class="EstFacturaExportacionImprimirSeparacion"  />
    <table class="EstFacturaExportacionImprimirTabla" width="100%" border="0" cellpadding="3" cellspacing="2">
    <tr>
      <td width="117" align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta"> Se&ntilde;ores</span></td>
      <td width="6" align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">:</span></td>
      <td align="left" valign="top"><span class="EstFacturaExportacionImprimirContenido"> <?php echo $InsFacturaExportacion->CliNombre;?> <?php echo $InsFacturaExportacion->CliApellidoPaterno;?> <?php echo $InsFacturaExportacion->CliApellidoMaterno;?></span></td>
      </tr>
  <tr>
    <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">Doc. Ident.  n&deg;</span></td>
    <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">:</span></td>
    <td align="left" valign="top"><span class="EstFacturaExportacionImprimirContenido"><?php echo $InsFacturaExportacion->CliNumeroDocumento;?></span></td>
    </tr>
  <tr>
    <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">Direccion</span></td>
    <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">:</span></td>
    <td width="348" align="left" valign="top"><span class="EstFacturaExportacionImprimirContenido"><?php echo $InsFacturaExportacion->FexDireccion;?>
    
    
    <!-- - 
    <?php echo $InsFacturaExportacion->CliDistrito;?>/
    <?php echo $InsFacturaExportacion->CliProvincia;?>/
    <?php echo $InsFacturaExportacion->CliDepartamento;?>-->
    
    </span></td>
  </tr>
  </table>
  
 
  </td>
    <td width="328" height="45" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="40" align="right" valign="top">
    
    
  
    <table class="EstFacturaExportacionImprimirTabla" border="0" cellpadding="3" cellspacing="2">
      <tr>
        <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">Fecha</span></td>
        <td align="left" valign="top"><span class="EstFacturaExportacionImprimirEtiqueta">:</span></td>
        <td align="left" valign="top"><span class="EstFacturaExportacionImprimirContenido">
          <?php 
	$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
	$fecha = explode("/", $InsFacturaExportacion->FexFechaEmision);
	?>
          <?php echo $fecha[0];?> de <?php echo $meses[$fecha[1]];?> del <?php echo $fecha[2];?></span></td>
      </tr>
    </table>
    
    
    </td>
  </tr>
  
  <tr>
  <td height="257" colspan="6" valign="top" id = "altura" class="EstFacturaExportacionImprimirFormatoDetalle2">
    
    
  <div class="EstFacturaExportacionImprimirSeparacion"  />
  <table  width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstFacturaExportacionImprimirTabla2">
  <thead class="EstFacturaExportacionImprimirTablaHead2">
    
  <tr>
    <td height="30" align="center" widtd="143" ><span class="EstFacturaExportacionDetalleImprimirEtiqueta">cantidad</span>
      <div class="EstFacturaExportacionImprimirSeparacion"  />
    </td>
    <td width="80" align="center" widtd="18" ><span class="EstFacturaExportacionDetalleImprimirEtiqueta">u.m.</span>
      
      <div class="EstFacturaExportacionImprimirSeparacion"  /></td>
    <td widtd="782" align="center" ><span class="EstFacturaExportacionDetalleImprimirEtiqueta">descripcion</span>
      <div class="EstFacturaExportacionImprimirSeparacion"  />
    </td>
    <td widtd="104" align="center" ><span class="EstFacturaExportacionDetalleImprimirEtiqueta">p/unitario</span>
      <div class="EstFacturaExportacionImprimirSeparacion"  /></td>
    <td widtd="53" align="center" ><span class="EstFacturaExportacionDetalleImprimirEtiqueta">importe</span>
      <div class="EstFacturaExportacionImprimirSeparacion"  /></td>
    </tr>
  </thead>
  <tbody class="EstFacturaExportacionImprimirTablaBody2">
  <?php
	$ArrMateriales = array();
	
	if(!empty($InsFacturaExportacion->FacturaExportacionDetalle)){
		foreach($InsFacturaExportacion->FacturaExportacionDetalle as $DatFacturaExportacionDetalle){
			
			if($DatFacturaExportacionDetalle->FedTipo <> "M"){

			
				if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and (!empty($InsFacturaExportacion->FexTipoCambio) )){
					$DatFacturaExportacionDetalle->FedImporte = round($DatFacturaExportacionDetalle->FedImporte / $InsFacturaExportacion->FexTipoCambio,2);
					$DatFacturaExportacionDetalle->FedPrecio = round($DatFacturaExportacionDetalle->FedPrecio  / $InsFacturaExportacion->FexTipoCambio,2);
				}
			
?>
    <tr>
      <td width="73" align="center">
        
        <?php
			if($DatFacturaExportacionDetalle->FedDescripcion<>"MANO DE OBRA"){
			?>
        
        <span class="EstFacturaExportacionDetalleImprimirContenido">
          <?php echo $DatFacturaExportacionDetalle->FedCantidad;?>			</span>	
        
        <?php
			}						
			?>
        
        
        
        
      </td>
      <td align="center"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo $DatFacturaExportacionDetalle->FedUnidadMedida;?></span></td>
      <td width="354">
        <span class="EstFacturaExportacionDetalleImprimirContenido">
          <?php echo $DatFacturaExportacionDetalle->FedDescripcion;?>			</span>		</td>
      <td width="102" align="right"><span class="EstFacturaExportacionDetalleImprimirContenido">
        <?php //echo $InsFacturaExportacion->MonSimbolo;?> 		
        <?php echo number_format($DatFacturaExportacionDetalle->FedPrecio,2);?>
      </span></td>
      <td width="106" align="right"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php // echo $InsFacturaExportacion->MonSimbolo;?>
        <?php echo number_format($DatFacturaExportacionDetalle->FedImporte,2);?>
        
      </span></td>
      </tr>
    
  <?php			$TotalBruto = $TotalBruto + $DatFacturaExportacionDetalle->FedImporte;		

			}else{
				$ArrMateriales[] = $DatFacturaExportacionDetalle;
			}
			
			

		}
	} 
?>
    
    
  <?php
	
	
	if(!empty($ArrMateriales)){
		
		$MaterialImporte = 0;
		
		foreach($ArrMateriales as $DatMaterial){

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and (!empty($InsFacturaExportacion->FexTipoCambio) )){
				$DatMaterial->FedImporte = round($DatMaterial->FedImporte / $InsFacturaExportacion->FexTipoCambio,2);
				$DatMaterial->FedPrecio = round($DatMaterial->FedPrecio  / $InsFacturaExportacion->FexTipoCambio,2);
			}
			
			$MaterialImporte += $DatMaterial->FedImporte;
		}
		
?>
    <tr>
      <td align="left" valign="top"></td>
      <td colspan="3" align="left" valign="top"><span class="EstFacturaExportacionDetalleImprimirContenido">MATERIALES: </span>
        <table>
          <?php

		foreach($ArrMateriales as $DatMaterial){

			if($InsFacturaExportacion->MonId<>$EmpresaMonedaId and (!empty($InsFacturaExportacion->FexTipoCambio) )){
				$DatMaterial->FedImporte = round($DatMaterial->FedImporte / $InsFacturaExportacion->FexTipoCambio,2);
				$DatMaterial->FedPrecio = round($DatMaterial->FedPrecio  / $InsFacturaExportacion->FexTipoCambio,2);
			}
?>
          <tr>
            <td width="80" align="right"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo $DatMaterial->FedCantidad;?></span></td>
            <td align="right"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo $DatMaterial->FedDescripcion;?></span></td>
            <td align="right"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo $DatMaterial->FedUnidadMedida;?></span></td>
            <td align="right"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo number_format($DatMaterial->FedImporte,2);?></span></td>
            </tr>
          <?php
		}
		
		
	  ?>
        </table></td>
      <td width="106" align="right" valign="top"><span class="EstFacturaExportacionDetalleImprimirContenido"><?php echo number_format($MaterialImporte,2);?></span></td>
      </tr>
    
    
    
  <?php
		$TotalBruto = $TotalBruto + $MaterialImporte;
	} 
?>
    
  <?php
if(!empty($InsFacturaExportacion->FexObservacionImpresa)){
?>
    <tr>
      <td height="21" colspan="5">
        <span class="EstFacturaExportacionImprimirContenido">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
						echo $InsFacturaExportacion->FexObservacionImpresa;
					?>
        </span>			</td>
      </tr>
    
  <?php
}
?>
    
  <?php
//if(!empty($InsFacturaExportacion->EinVIN)){
?>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <span class="EstFacturaExportacionImprimirContenido">
        
<?php
if(!empty($InsFacturaExportacion->EinVIN)){
?>
	VIN: <?php echo $InsFacturaExportacion->EinVIN;?> - <?php echo $InsFacturaExportacion->EinPlaca;?><br />
<?php echo $InsFacturaExportacion->VmaNombre;?> <?php echo $InsFacturaExportacion->VmoNombre;?> <?php echo $InsFacturaExportacion->VveNombre;?> <br />
<?php
}
?>       
          
<?php
if(!empty($InsFacturaExportacion->FinId)){
?>
	<br />O.T.: <?php echo $InsFacturaExportacion->FinId;?>
	<br />Kilom.: <?php echo $InsFacturaExportacion->FinVehiculoKilometraje;?> <?php echo (!empty($InsFacturaExportacion->FinVehiculoKilometraje))?'KM':'';;?> 
<?php
}
?>

<?php
if(!empty($InsFacturaExportacion->AmoId)){
?>
	<br />Ficha: <?php echo $InsFacturaExportacion->AmoId;?>
<?php
}
?>

        </span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    
  <?php
//}
?>
    
    
  </tbody>
  </table>
    
    
  <?php
$Total = $TotalBruto;
?>
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

<div class="EstFacturaExportacionImprimirSeparacion"  />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstFacturaExportacionImprimirEtiqueta">SON: </span>
    <span class="EstFacturaExportacionImprimirContenido"> 
	<?php echo $numalet->letra();?> CON <?php echo $parte_decimal;?>/100  <?php echo $InsFacturaExportacion->MonNombre;?>        
    </span>   
  <div class="EstFacturaExportacionImprimirSeparacion"  />  
    
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
//	if($InsFacturaExportacion->FpaId<>"FPA-10004"){
	/*if($InsFacturaExportacion->NpaId=="NPA-10000"){		
	?>
  
  <span class="EstFacturaExportacionImprimirContenidoFecha"><?php echo FncCambiaFechaAImpresion($InsFacturaExportacion->FexFechaEmision);?></span>
  <?php
	}*/
	?>
    
  <br />
  <span class="EstFacturaExportacionImprimirContenido">____________________________</span>
  <span class="EstFacturaExportacionImprimirContenido">CANCELADO</span>
	  </td>
  <td width="476" align="right"><span class="EstFacturaExportacionImprimirEtiqueta">totaL:</span></td>
  <td width="47" align="right">&nbsp;</td>
  <td width="157" align="center">

	<span class="EstFacturaExportacionImprimirContenido">
		<?php echo $InsFacturaExportacion->MonSimbolo; ?> <?php echo number_format($Total,2);?>
	</span>
  <div class="EstFacturaExportacionImprimirSeparacion"  />
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
	<!--<span class="EstFacturaExportacionImprimirContenido"><?php echo date("d/m/y");?> - <?php echo date("H:i:s");?></span>-->
    <span class="EstFacturaExportacionImprimirContenido"> <?php echo rand().date("Hdimsy").rand();?></span>
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