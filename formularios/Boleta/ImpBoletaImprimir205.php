<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boleta No. <?php echo $InsBoleta->BtaNumero;?> - <?php echo $InsBoleta->BolId;?></title>
<link href="css/CssBoletaImprimir.css" rel="stylesheet" type="text/css" />
<link href="css/CssBoletaImprimir205.css" rel="stylesheet" type="text/css" />

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
//setTimeout("window.close();",1500);
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
<!--
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
-->
</form>


<?php }?>



<div class="EstBoletaImprimirCapaPrincipal">


   	<?php
	/*if($InsBoleta->BolObsequio == 1){
	?> 
	<div class="EstBoletaImprimirObsequio">
    <img src="../../imagenes/transferencia_gratuita.png" width="369" height="288" />
  </div>
    <?php
	}*/
	?>
    
    
<table width="770"  border="0" cellpadding="0" cellspacing="0" class="EstBoletaImprimirTabla">

<tr>
  <td height="118"  align="left" valign="top">
  
  
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
   <?php echo $InsBoleta->UsuUsuario;?>   </span>    
     
   
   </td>
  <td  align="right" valign="top">
  
  
  <?php
	/*if($GET_TiempoImpresion!=1){
	?>
	<!--<span class="EstBoletaImprimirContenido"><?php echo date("d/m/Y");?> - <?php echo date("H:i:s");?></span>-->
    <span class="EstBoletaImprimirContenido"> <?php echo date("ymdHis");?></span>
	<?php
	}*/
	?>
    
    </td>
  </tr>

  
  <tr>
    <td height="80" colspan="2" valign="top"><table class="EstBoletaImprimirTabla" width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr>
      <td width="140" align="left" valign="bottom"><?php if($_GET['P']!=1){ ?>
        <span class="EstBoletaImprimirEtiqueta"> Se&ntilde;ores</span>
        <?php }?></td>
      <td colspan="4" align="left" valign="bottom"><span class="EstBoletaImprimirContenido">
      
      <?php
	  
	  if(!empty($InsBoleta->OrdenVentaVehiculoPropietario)){
	 		
			foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
			?>
				<?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoPaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;?> <?php echo $DatOrdenVentaVehiculoPropietario->CliNombre;?> /
            <?php	
			}
			
	  }else{
		?>
         <?php echo $InsBoleta->CliNombre;?> <?php echo $InsBoleta->CliApellidoPaterno;?> <?php echo $InsBoleta->CliApellidoMaterno;?>
        <?php  
	  }
	  
	  ?>
      </span>
       
       
       
       </td>
    </tr>
  <tr>
    <td align="left" valign="bottom"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Doc. Ident.  n&deg;</span>
      <?php }?></td>
    <td colspan="4" align="left" valign="bottom"><span class="EstBoletaImprimirContenido">
	
	      <?php
	  
	  if(!empty($InsBoleta->OrdenVentaVehiculoPropietario)){
	 		
			foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
			?>
            <?php echo $DatOrdenVentaVehiculoPropietario->CliNumeroDocumento;?>  /
            <?php	
			}
			
	  }else{
		?>
        <?php echo $InsBoleta->CliNumeroDocumento;?>
        <?php  
	  }
	  
	  ?>
	
	</span></td>
    </tr>
  <tr>
    <td align="left" valign="bottom"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Direccion</span>
      <?php }?></td>
    <td colspan="2" align="left" valign="bottom"><span class="EstBoletaImprimirContenido2"><?php echo $InsBoleta->BolDireccion;?>
  <!--    - 
    <?php echo $InsBoleta->CliDistrito;?>/
    <?php echo $InsBoleta->CliProvincia;?>/
    <?php echo $InsBoleta->CliDepartamento;?>-->
      
    </span></td>
    <td align="left" valign="bottom">&nbsp;</td>
    </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td width="120" align="left" valign="top">&nbsp;</td>
    <td width="167" align="left" valign="top"><?php if($_GET['P']!=1){ ?>
      <span class="EstBoletaImprimirEtiqueta">Fecha de Emision:</span>
      <?php }?></td>
    <td width="319" align="right" valign="top"><span class="EstBoletaImprimirContenido">
      <?php 
	$meses = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
	$fecha = explode("/", $InsBoleta->BolFechaEmision);
	?>
    
   
&nbsp;&nbsp;&nbsp; <?php
	echo $fecha[0];
	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $meses[$fecha[1]];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo substr($fecha[2], 2);?></span></td>
    </tr>
  </table></td>
  </tr>
  

<tr>
<td height="240" colspan="2" valign="top" id = "altura">

<table  width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstBoletaImprimirTabla2">
<thead class="EstBoletaImprimirTablaHead2">

<tr>
  <td height="22" align="center" widtd="143" >&nbsp;</td>
  <td widtd="143" align="center" >
  
<?php
if($_GET['P']!=1){ 
?>
<span class="EstBoletaDetalleImprimirEtiqueta">cantidad</span>
<?php 
}
?></td>
  <td widtd="54" align="center" >&nbsp;</td>
  <td width="59" align="center" widtd="18" ><?php
if($_GET['P']!=1){ 
?>
      <span class="EstBoletaDetalleImprimirEtiqueta">u.m.</span>
      <?php 
}
?></td>
  <td width="14" align="center" widtd="54" >&nbsp;</td>
  <td width="323" align="center" widtd="782" >
<?php
if($_GET['P']!=1){ 
?>
<span class="EstBoletaDetalleImprimirEtiqueta">descripcion</span>
<?php 
}
?>  </td>
  <td width="2" align="center" widtd="18" >&nbsp;</td>
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
  	</tr>
</thead>
<tbody class="EstBoletaImprimirTablaBody2">
<?php

	$ArrMateriales = array();
	
	if(!empty($InsBoleta->BoletaDetalle)){
		foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
			
			//if($DatBoletaDetalle->BdeTipo <> "M"){
				
				if($InsBoleta->MonId<>$EmpresaMonedaId and (!empty($InsBoleta->BolTipoCambio) )){
					$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
					$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
				}
			
?>
		<tr>
		  <td width="2" align="center">&nbsp;</td>
        <td width="91" align="right" valign="top">
			
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
        <td width="7" align="right" valign="top">&nbsp;</td>
        <td align="right" valign="top"><span class="EstBoletaDetalleImprimirContenido"><?php echo $DatBoletaDetalle->BdeUnidadMedida;?></span></td>
        <td valign="top">
         
         
         </td>
        <td valign="top">
        
         <span class="EstBoletaDetalleImprimirContenido">
            <?php echo stripslashes($DatBoletaDetalle->BdeDescripcion);?>			
            
            
            </span>		

      
          
        </td>
        <td valign="top">&nbsp;</td>
        <td width="141" align="right" valign="top">
        
            
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
        <td width="6" align="right" valign="top">&nbsp;</td>
        <td width="105" align="right" valign="top">
            
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
        </tr>
<?php	
				$TotalBruto = $TotalBruto + $DatBoletaDetalle->BdeImporte;		
			//}else{
			//	$ArrMateriales[] = $DatBoletaDetalle;
			//}
		}
	} 
?>

<?php
/*if(!empty($InsBoleta->OvvId)){
?>
	<tr>
		<td height="21" align="center">  </td>
			<td>
			
            
         
          
      
      
            </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
			  
			  
			  
                
                
			  			  </td>
			<td>
			    
            
                </td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
  
<?php
}*/
?>





<?php
	
	
	if(!empty($ArrMateriales)){
?>
	<?php		
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
            <td colspan="6" align="left" valign="top">
            
            <span class="EstBoletaDetalleImprimirContenido">MATERIALES: </span>
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
              </table>
              
              
              
              </td>
            <td width="6" align="right" valign="top"></td>
        <td width="105" align="center"><span class="EstBoletaDetalleImprimirContenido"><?php echo number_format($MaterialImporte,2);?></span></td>
  </tr>
  

  
<?php
		$TotalBruto = $TotalBruto + $MaterialImporte;
	} 
?>




	      <?php
  //      if(!empty($InsBoleta->EinVIN) or !empty($InsBoleta->FinId) or !empty($InsBoleta->AmoId)){
        ?>
        
      

<tr>
	  <td height="21" align="center"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>
      
      <?php
	  if(!empty($InsBoleta->OvvId)){
		 ?>
           <table width="371" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Marca:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional1;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Tracci&oacute;n:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional2;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Modelo:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional3;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Carroceria:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional4;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">A&ntilde;o Fabric.:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional5;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Puertas:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional6;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Motor:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional7;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Combustible:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional8;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Cilindros:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional9;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Peso Bruto:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional10;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Ejes:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional11;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Carga Util:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional12;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Chasis:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional13;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Peso Seco:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional14;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Color:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional15;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Alto:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional16;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Cilindrada:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional17;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Largo:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional18;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Asientos:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional19;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Ancho:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional20;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Cap. Pasajeros:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional21;?></span></td>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">Dist. Ejes:</span></td>
      <td><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional22;?></span></td>
    </tr>
    <tr>
      <td><span class="EstBoletaImprimirEtiquetaCaracteristica">No. Poliza:</span></td>
      <td colspan="3"><span class="EstBoletaImprimirContenidoCaracteristica"><?php echo $InsBoleta->BolDatoAdicional23;?></span></td>
      </tr>
    </table>
      
         <?php 
	  }
	  ?>
      
    
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
	<!--        <br />
    
(*) Productos en oferta con precio especial disponibles hasta agotar stock
 -->
	      </span>
          
          </td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
      
      
        <?php
//		}
		?>
      
      
<?php
if(!empty($InsBoleta->BolObservacionImpresa)){
?>

	
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
		</tr>
  
<?php
}
?>



</tbody>
</table>



    
    
</td>
</tr>

  <tr>
    <td colspan="2"  id = "son">
    
   
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
  <td height="118" colspan="2" valign="bottom">
  
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
  <td width="157" align="center" valign="top">

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
  <td width="385" align="left" valign="top">
  
   
                  
            </td>
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
      
	
	
	 
    
  
  </td>
  <td width="11" colspan="4" align="right">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>
</div>
</body>
</html>