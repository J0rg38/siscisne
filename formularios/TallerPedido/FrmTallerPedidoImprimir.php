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

$GET_id = $_GET['Id'];
$GET_Precio = $_GET['Precio'];

require_once($InsPoo->MtdPaqAlmacen() . 'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsTallerPedidoDetalle.php');

$InsTallerPedido = new ClsTallerPedido();

$InsTallerPedido->AmoId = $GET_id;
$InsTallerPedido->MtdObtenerTallerPedido();



	if($InsTallerPedido->MonId<>$EmpresaMonedaId ){

		$InsTallerPedido->FccManoObra = round($InsTallerPedido->FccManoObra / $InsTallerPedido->AmoTipoCambio,2);
		
		$InsTallerPedido->AmoDescuento = round($InsTallerPedido->AmoDescuento / $InsTallerPedido->AmoTipoCambio,2);

	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salida de O.T. No. <?php echo $InsTallerPedido->AmoId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssTallerPedidoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTallerPedidoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsTallerPedido->AmoId)) {
?> 
FncTallerPedidoImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstTallerPedidoImprimirTabla">
  <tr>
    <td height="45" align="right" valign="top">
    
      <span class="EstVentaConcretadaImprimirTipo">
    SALIDA DE O.T.<br />
    
    </span>
    
    
	<span class="EstTallerPedidoImprimirTipo">
	<?php echo $InsTallerPedido->MinNombre;?>
    </span>
   
<br />
<span class="EstTallerPedidoImprimirContenido">
<?php echo $InsTallerPedido->AmoId;?>
	</span>
    
    
   
    
	</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTallerPedidoImprimirTabla">
      <tr>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          CLIENTE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          :</span></td>
        <td height="23" colspan="4" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido">
		<?php //echo $InsTallerPedido->CliApellidoPaterno;?> <?php //echo $InsTallerPedido->CliApellidoMaterno;?> <?php echo $InsTallerPedido->CliNombre;?>
        
        <?php echo $InsTallerPedido->CliApellidoPaterno;?>
        <?php echo $InsTallerPedido->CliApellidoMaterno;?>
        
        </span></td>
        <td width="4%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          Fecha EMISION
          
        </span></td>
        <td width="3%" height="23" align="left" valign="top">
          
          :        </td>
        <td width="11%" height="23" align="left" valign="top">
          <?php
		  echo $InsTallerPedido->AmoFecha;
?>        </td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          # ficha</span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
         :
            
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenidoOT"><?php
echo $InsTallerPedido->FinId;
?>&nbsp;&nbsp;</span></td>
      </tr>
      <tr>
        <td width="9%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          MARCA
          
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
          
        </span></td>
        <td width="12%" height="23" align="left" valign="top" >
        
        <span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->VmaNombre;
?></span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          MODELO</span></td>
        <td width="3%" height="23" align="left" valign="top">
          :</td>
        <td width="12%" height="23" align="left" valign="top">        <?php
echo $InsTallerPedido->VmoNombre;
?>        </td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          AÑO
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
         :
            
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinAnoFabricacion;
?></span></td>
        <td width="8%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          PLACA</span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
            
          </span></td>
        <td width="17%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinPlaca;
?></span> </td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          VIN
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          RESPONSABLE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
          
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          <span class="EstTallerPedidoImprimirContenido">
            <?php echo $InsTallerPedido->PerNombre;?> <?php echo $InsTallerPedido->PerApellidoPaterno;?> <?php echo $InsTallerPedido->PerApellidoMaterno;?>
            </span>
        </td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          KILOMETRAJE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
            
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="320" colspan="5" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTallerPedidoImprimirTabla">
      <thead class="EstTallerPedidoImprimirTablaHead">
        <tr>
          <th width="3%" align="center" >
            
            #
            
         </th>
          <th width="7%" align="center" > CANT.</th>
          <th width="9%" align="center" >           UND. MED.</th>
          <th width="9%" align="center" >CODIGO </th>
          <th width="41%" align="center" >DESCRIPCION       </th>
          
          <?php
		  if($GET_Precio<>"NO"){
		?>
        <th width="11%" align="center" >P.U.           </th>
          <th width="11%" align="center" >TOTAL </th>
        <?php
		  }
		  ?>
          
          <th width="9%" align="center" >FECHA SALIDA FISICA </th>
          </tr>
      </thead>
      <tbody class="EstTallerPedidoImprimirTablaBody">
        <?php

$ArrSuministros = array();
$TienePromocion = false;

$i = 1;
if (!empty($InsTallerPedido->TallerPedidoDetalle)) {
    foreach ($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle) {



		if($DatTallerPedidoDetalle->AmdEstado == 3 or $DatTallerPedidoDetalle->AmdEstado == 2){
			
		
			if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
	
				$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
				$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
				$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
				
				
			}

			if ($DatTallerPedidoDetalle->RtiId <> "RTI-10003") {
	?>
			<tr>
			  <td align="right" class="EstTallerPedidoDetalleImprimirContenido"><?php
				echo $i;
	?></td>
			  <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo number_format($DatTallerPedidoDetalle->AmdCantidad, 2);
	?></td>
			  <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo $DatTallerPedidoDetalle->UmeNombre;
	?></td>
			  <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo $DatTallerPedidoDetalle->ProCodigoOriginal;
	?>
			    <?php
	if($DatTallerPedidoDetalle->ProTienePromocion==1){
	?>
			    (*)
			    <?php	
		$TienePromocion = true;
	}
	?>
		      </td>
			  <td align="left" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo $DatTallerPedidoDetalle->ProNombre;
	?>
    
    <?php
	if(!empty($DatTallerPedidoDetalle->AmdCompraOrigen)){
	?>
		<b>[<?php echo $DatTallerPedidoDetalle->AmdCompraOrigen;?>]</b>
    <?php	
	}
	?>
    
    
    </td>
    
    
      <?php
		  if($GET_Precio<>"NO"){
		?>
			  <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo number_format(($DatTallerPedidoDetalle->AmdPrecioVenta), 2);
	?> </td>
			  <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo number_format($DatTallerPedidoDetalle->AmdImporte, 2);
	?></td>
    
       <?php	
	}
	?>
    
			  <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
				echo ($DatTallerPedidoDetalle->AmdFecha);
	?></td>
		    </tr>
			<?php
				$i++;
				$TotalBruto += $DatTallerPedidoDetalle->AmdImporte;
				
			} else {
				$ArrSuministros[] = $DatTallerPedidoDetalle;
			}
			
		
		}
		
		
        
    }
}
?>

<?php
	if (!empty($ArrSuministros)) {
?>

        <tr>
          <td colspan="5" align="right" class="EstTallerPedidoDetalleImprimirContenido">
            MATERIALES:
          </td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido">&nbsp;</td>
          </tr>


<?php
   
    foreach ($ArrSuministros as $DatSuministro) {

?>
    <tr>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->AmdCantidad, 2);
?></td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->UmeNombre;
?></td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProCodigoOriginal;
?>
            
            <?php
	if($DatSuministro->ProTienePromocion==1){
	?>
            (*)
            <?php	
		$TienePromocion = true;
	}
	?>
            
            
          </td>
          <td align="left" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProNombre;
?></td>


<?php
		  if($GET_Precio<>"NO"){
		?>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format(($DatSuministro->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->AmdImporte, 2);
?></td>

       <?php	
		
	}
	?>

          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          </tr>
<?php
		$i++;
		
		
		if($DatTallerPedidoDetalle->AmdEstado == 3 or $DatTallerPedidoDetalle->AmdEstado == 2){
		
			 $TotalBruto += $DatSuministro->AmdImporte;
			
		}
		
    }
    
?>
    
<?php
    
}

	
	$TotalRepuesto = $TotalBruto;

	if($InsTallerPedido->AmoIncluyeImpuesto == 1){
		
		//$TotalRepuesto = $TotalRepuesto - $InsTallerPedido->AmoDescuento;
		
		
		$Total = $TotalRepuesto + $InsTallerPedido->AmoManoObra  + $InsTallerPedido->FccManoObra - $InsTallerPedido->AmoDescuento;;
		$SubTotal = $Total / (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;
		
	}else{

		//$TotalRepuesto = $TotalRepuesto - $InsTallerPedido->AmoDescuento;
		
		$SubTotal = $TotalRepuesto  + $InsTallerPedido->AmoManoObra  + $InsTallerPedido->FccManoObra;
		$Impuesto = $SubTotal * (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto - $InsTallerPedido->AmoDescuento;
		
	}
	
	
?>

      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5">
    <?php
		  if($GET_Precio<>"NO"){
		?>
    
    <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
          <tr>
            <td width="56%" rowspan="5" align="left" valign="top">
                
              <?php
if(!empty($InsTallerPedido->FccManoObra) and $InsTallerPedido->FccManoObra<> "0.00"){
?>
              <span class="EstTallerPedidoImprimirManoObra">
                  
              <?php
			  if(!empty($InsTallerPedido->FccManoObraDetalle)){
			?>
              <?php echo ($InsTallerPedido->FccManoObraDetalle);?>:
              <?php	  
			  }else{
				?>
                 MANO DE OBRA:
                <?php  
			  }
			  ?>
                  
                  
               <?php echo number_format($InsTallerPedido->FccManoObra,2);?><br />
              </span>
              <?php	
}
?>      
                
                
              <span class="EstTallerPedidoImprimirObsequio">
                  
              <?php
if($InsTallerPedido->FimObsequio == 1){
?>
              Este SERVICIO es GRATUITO
              <?php
}
?>
                  
                  
              </span>
                
              <span class="EstTallerPedidoImprimirContenido">
              <?php
if($InsTallerPedido->AmoIncluyeImpuesto == 2){
?>
              <br />Los Precios NO incluyen IGV
              <?php	
}else{
?>
              <br />Los Precios incluyen IGV
              <?php	
}
?>
                  
              <?php
//echo $InsTallerPedido->AmoObservacion;
?>
              </span>
                
              <span class="EstTallerPedidoImprimirContenido">
              <?php
if($TienePromocion){
?>
              (*) Oferta con precio especial disponibles hasta agotar stock
              <?php	
}
?>
              </span>
            </td>
              <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
                <span class="EstTallerPedidoImprimirEtiquetaTotal">TOTAL REPUESTOS:</span>
              <?php
}
?></td>
              <td align="right" valign="middle" ><span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal"> <?php echo number_format($TotalRepuesto,2);?></span></td>
          </tr>
          <tr>
          <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo">
		  
		  
		  <?php
//if(!empty($InsTallerPedido->FccManoObra) and $InsTallerPedido->FccManoObra<> "0.00"){
	if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">MANO DE OBRA:</span>
            <?php	
}
?></td>
          <td align="right" valign="middle" ><?php
//if(!empty($InsTallerPedido->FccManoObra) and $InsTallerPedido->FccManoObra<> "0.00"){
?>
            <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal"> <?php echo number_format($InsTallerPedido->FccManoObra,2);?> </span>
            <?php	
//}
?></td>
          </tr>
        <tr>
          <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo">
            
            <?php
//if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
	if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">DESCUENTO:</span>
            
            <?php	
}
?>
            
            
            
            </td>
          <td align="right" valign="middle" >
            
            <?php
//if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
?>
            
            <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> 
            
            
            <span class="EstTallerPedidoImprimirContenidoTotal">
              <?php
echo number_format($InsTallerPedido->AmoDescuento, 2);
?>
              </span>
            
            
            <?php	
//}
?>
            
            
            
          </td>
          </tr>
        <tr>
          <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">Total:</span>
            <?php
}
?></td>
          <td align="right" valign="middle" ><?php
//$Total = $TotalRepuesto - $InsTallerPedido->AmoDescuento + $InsTallerPedido->FccManoObra;
?>
            <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal">
              <?php
echo number_format($Total, 2);
?>
            </span></td>
          </tr>
        <tr>
          <td width="30%" align="right" valign="middle">&nbsp;</td>
          <td width="12%" align="right" valign="middle" >&nbsp;</td>
          </tr>
        </tbody>
    </table>
    <?php
		  }
		?>
    </td>
  </tr>
</table>
</body>
</html>
