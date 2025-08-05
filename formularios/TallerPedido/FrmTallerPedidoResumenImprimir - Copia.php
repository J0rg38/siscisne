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

require_once($InsPoo->MtdPaqActividad().'ClsFichaIngreso.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoLlamada.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoGasto.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaDetalle.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsPreEntregaSeccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoManoObra.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoModalidad.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoHerramienta.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoSuministro.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaIngresoMantenimiento.php');

require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');


//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalida.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');


$InsFichaIngreso = new ClsFichaIngreso();
$InsFichaIngreso->FinId = $GET_id;
$InsFichaIngreso->MtdObtenerFichaIngreso();

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resumen Salidas de Repuestos <?php echo $InsFichaIngreso->FinId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssTallerPedidoImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTallerPedidoResumenImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsFichaIngreso->FinId)) {
?> 
FncTallerPedidoResumenImprimir(); 
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
    <td height="45" align="center" valign="top">
    
      <span class="EstVentaConcretadaImprimirTipo">
    RESUMEN SALIDAS DE O.T.
    
    <br />
    <span class="EstTallerPedidoImprimirContenidoOT">
    <?php
echo $InsFichaIngreso->FinId;
?>
    </span><br />
    
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
        <td height="23" colspan="7" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido">
          <?php //echo $InsFichaIngreso->CliApellidoPaterno;?> <?php //echo $InsFichaIngreso->CliApellidoMaterno;?> <?php echo $InsFichaIngreso->CliNombre;?>
          
          <?php echo $InsFichaIngreso->CliApellidoPaterno;?>
          <?php echo $InsFichaIngreso->CliApellidoMaterno;?>
          
        </span></td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta"> Fecha EMISION </span></td>
        <td height="23" align="left" valign="top"> : </td>
        <td height="23" align="left" valign="top"><?php
		  echo $InsFichaIngreso->FinFecha;
?></td>
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
echo $InsFichaIngreso->VmaNombre;
?></span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          MODELO</span></td>
        <td width="3%" height="23" align="left" valign="top">
          :</td>
        <td width="12%" height="23" align="left" valign="top">        <?php
echo $InsFichaIngreso->VmoNombre;
?>        </td>
        <td width="4%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          
          AÑO
          
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
         :
            
          </span></td>
        <td width="11%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsFichaIngreso->EinAnoFabricacion;
?></span></td>
        <td width="8%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          PLACA</span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
            
          </span></td>
        <td width="17%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsFichaIngreso->EinPlaca;
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
echo $InsFichaIngreso->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          RESPONSABLE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
          
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          <span class="EstTallerPedidoImprimirContenido">
            <?php echo $InsFichaIngreso->PerNombre;?> <?php echo $InsFichaIngreso->PerApellidoPaterno;?> <?php echo $InsFichaIngreso->PerApellidoMaterno;?>
            </span>
        </td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          KILOMETRAJE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          
          :
            
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsFichaIngreso->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="320" colspan="5" valign="top">
    
    
    
<?php
$SumaTotal = 0;
$MismaMoneda = true;
$modalidades = 1;
if(!empty($InsFichaIngreso->FichaIngresoModalidad)){
		foreach($InsFichaIngreso->FichaIngresoModalidad as $DatFichaIngresoModalidad){
?>

	<?php echo $DatFichaIngresoModalidad->MinNombre; ?> - <?php echo $DatFichaIngresoModalidad->MinSigla;?>: 
    <br />
    <br />
    
<?php
			$InsFichaAccion = $DatFichaIngresoModalidad->FichaAccion;
			
			$InsTallerPedido = $InsFichaAccion->TallerPedido;
			
			//deb($InsTallerPedido);
//			echo "aaa";
//			echo "<br>";
//			echo "<br>";

		if($InsTallerPedido->MonId <> $MonedaIdAnterior && $modalidades > 1){
			$MismaMoneda = false;
		}
				
?>

Ficha: <?php echo $InsTallerPedido->AmoId;?> / <?php echo $InsTallerPedido->AmoFecha;?>


<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTallerPedidoImprimirTabla">
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
    
    $TienePromocion = false;
    $TotalRepuesto = 0;
	
    $i = 1;
    if (!empty($InsTallerPedido->TallerPedidoDetalle)) {
        foreach ($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle) {
    
            //if($DatTallerPedidoDetalle->AmdEstado == 3 or $DatTallerPedidoDetalle->AmdEstado == 2){
            if($DatTallerPedidoDetalle->AmdEstado == 3){
                
            
                if($InsTallerPedido->MonId<>$EmpresaMonedaId ){
        
                    $DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
                    $DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
                    $DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
                    
                    
                }
    
                
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
                    
            
            }
            
        }
    }
    ?>

<?php

$TotalRepuesto = $TotalBruto;

//deb($InsTallerPedido->AmoIncluyeImpuesto);

	if($InsTallerPedido->AmoIncluyeImpuesto == 1){
		//echo "a";
		$TotalRepuesto = $TotalRepuesto - $InsTallerPedido->AmoDescuento;
		//deb($TotalRepuesto);
		$Total = $TotalRepuesto + $InsTallerPedido->AmoManoObra  + $InsTallerPedido->FccManoObra;
		$SubTotal = $Total / (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
//				echo "b";
		$TotalRepuesto = $TotalRepuesto - $InsTallerPedido->AmoDescuento;
		
		$SubTotal = $TotalRepuesto  + $InsTallerPedido->AmoManoObra  + $InsTallerPedido->FccManoObra;
		$Impuesto = $SubTotal * (($InsTallerPedido->AmoPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
	
	
	$SumaTotal += $Total;
?>

      </tbody>
    </table>


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
			 /* if(!empty($InsFichaIngreso->FccManoObraDetalle)){
			?>
              <?php echo ($InsFichaIngreso->FccManoObraDetalle);?>:
              <?php	  
			  }else{
				?>
                 MANO DE OBRA:
                <?php  
			  }*/
			  ?>
                  
                  
               <?php //echo number_format($InsTallerPedido->FccManoObra,2);?><br />
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
/*if($InsTallerPedido->AmoIncluyeImpuesto == 2){
?>
              <br />Los Precios NO incluyen IGV
              <?php	
}else{
?>
              <br />Los Precios incluyen IGV
              <?php	
}*/
?>
                  
              <?php
//echo $InsFichaIngreso->AmoObservacion;
?>
              </span>
                
              <span class="EstTallerPedidoImprimirContenido">
              <?php
/*if($TienePromocion){
?>
              (*) Oferta con precio especial disponibles hasta agotar stock
              <?php	
}*/
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
//if(!empty($InsFichaIngreso->FccManoObra) and $InsFichaIngreso->FccManoObra<> "0.00"){
	if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">MANO DE OBRA:</span>
            <?php	
}
?></td>
          <td align="right" valign="middle" ><?php
//if(!empty($InsFichaIngreso->FccManoObra) and $InsFichaIngreso->FccManoObra<> "0.00"){
?>
            <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal"> <?php echo number_format($InsTallerPedido->FccManoObra,2);?> </span>
            <?php	
//}
?></td>
          </tr>
        <tr>
          <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo">
            
            <?php
//if(!empty($InsFichaIngreso->AmoDescuento) and $InsFichaIngreso->AmoDescuento <> "0.00"){
	if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">DESCUENTO:</span>
            
            <?php	
}
?>
            
            
            
            </td>
          <td align="right" valign="middle" >
            
            <?php
//if(!empty($InsFichaIngreso->AmoDescuento) and $InsFichaIngreso->AmoDescuento <> "0.00"){
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
            <span class="EstTallerPedidoImprimirEtiquetaTotal">Tota FICHA:</span>
            <?php
}
?></td>
          <td align="right" valign="middle" ><?php
//$Total = $TotalRepuesto - $InsFichaIngreso->AmoDescuento + $InsFichaIngreso->FccManoObra;
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




<?php		$modalidades++;
			$MonedaIdAnterior = $InsTallerPedido->MonId;
				
		}
}
?>
    
    
    
    
    
    
    </td>
  </tr>
  <tr>
    <td colspan="5">
   
 <?php
		  if($GET_Precio<>"NO" and $MismaMoneda ){
		?>
    
    <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
          <tr>
            <td width="56%" rowspan="2" align="left" valign="top">&nbsp;</td>
            <td align="right" valign="middle" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
              <span class="EstTallerPedidoImprimirEtiquetaTotal">SUMA Total:</span>
            <?php
}
?></td>
            <td align="right" valign="middle" ><?php
//$Total = $TotalRepuesto - $InsFichaIngreso->AmoDescuento + $InsFichaIngreso->FccManoObra;
?>
              <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal">
              <?php
echo number_format($SumaTotal, 2);
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
