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

require_once($InsPoo->MtdPaqAlmacen() . 'ClsAlmacenMovimientoSalida.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsAlmacenMovimientoSalidaDetalle.php');

$InsAlmacenMovimientoSalida = new ClsAlmacenMovimientoSalida();

$InsAlmacenMovimientoSalida->AmoId = $GET_id;
$InsAlmacenMovimientoSalida        = $InsAlmacenMovimientoSalida->MtdObtenerAlmacenMovimientoSalida();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ficha de Salida  No. 
<?php echo $InsAlmacenMovimientoSalida->AmoId;?>
</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssAlmacenMovimientoSalidaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAlmacenMovimientoSalidaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsAlmacenMovimientoSalida->AmoId)) {
?> 
FncAlmacenMovimientoSalidaImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAlmacenMovimientoSalidaImprimirTabla">
  <tr>
    <td height="45" align="right" valign="top">
    
     <span class="EstVentaConcretadaImprimirTipo">
   FICHA DE SALIDA<br />
    
    </span>
    
    
	<span class="EstAlmacenMovimientoSalidaImprimirTipo">
	<?php echo $InsAlmacenMovimientoSalida->MinNombre;?>
    </span>
   
<br />
<span class="EstAlmacenMovimientoSalidaImprimirContenido">
<?php echo $InsAlmacenMovimientoSalida->AmoId;?>
	</span>
	</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAlmacenMovimientoSalidaImprimirTabla">
      <tr>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          CLIENTE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          :</span></td>
        <td height="23" colspan="4" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido">
		<?php //echo $InsAlmacenMovimientoSalida->CliApellidoPaterno;?> <?php //echo $InsAlmacenMovimientoSalida->CliApellidoMaterno;?> <?php echo $InsAlmacenMovimientoSalida->CliNombre;?>
        
        <?php echo $InsAlmacenMovimientoSalida->CliApellidoPaterno;?>
        <?php echo $InsAlmacenMovimientoSalida->CliApellidoMaterno;?>
        
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          Fecha
          
        </span></td>
        <td width="2%" height="23" align="left" valign="top">
          
          :        </td>
        <td width="8%" height="23" align="left" valign="top">
          <?php
		  echo $InsAlmacenMovimientoSalida->AmoFecha;
//$fecha = explode("/", $InsAlmacenMovimientoSalida->AmoFecha);
//echo $fecha[0] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[2];
?>        </td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          # ficha</span></td>
        <td height="23" align="left" valign="top" >:</td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenidoOT"><?php
echo $InsAlmacenMovimientoSalida->FinId;
?></span></td>
      </tr>
      <tr>
        <td width="7%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          MARCA
          
        </span></td>
        <td width="2%" height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          :
          
        </span></td>
        <td width="15%" height="23" align="left" valign="top" >
        
        <span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->VmaNombre;
?></span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          MODELO</span></td>
        <td width="2%" height="23" align="left" valign="top">
          :</td>
        <td width="18%" height="23" align="left" valign="top">        <?php
echo $InsAlmacenMovimientoSalida->VmoNombre;
?>        </td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          AÑO
          
        </span></td>
        <td height="23" align="left" valign="top" >:</td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinAnoFabricacion;
?></span></td>
        <td width="11%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          PLACA</span></td>
        <td width="1%" height="23" align="left" valign="top" >:</td>
        <td width="13%" height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinPlaca;
?></span> </td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          VIN
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          :
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          RESPONSABLE
          
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          :
          
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          <span class="EstAlmacenMovimientoSalidaImprimirContenido">
            <?php echo $InsAlmacenMovimientoSalida->PerNombre;?> <?php echo $InsAlmacenMovimientoSalida->PerApellidoPaterno;?> <?php echo $InsAlmacenMovimientoSalida->PerApellidoMaterno;?>
            </span>
        </td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          
          KILOMETRAJE
          
        </span></td>
        <td height="23" align="left" valign="top" >:</td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="320" colspan="5" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenMovimientoSalidaImprimirTabla">
      <thead class="EstAlmacenMovimientoSalidaImprimirTablaHead">
        <tr>
          <th width="3%" align="center" >
            
            #
            
         </th>
          <th width="7%" align="center" > CANT.</th>
          <th width="10%" align="center" >UND. MED.</th>
          <th width="10%" align="center" >CODIGO</th>
          <th width="37%" align="center" >DESCRIPCION </th>
          <th width="11%" align="center" >P.U.</th>
          <th width="11%" align="center" >TOTAL</th>
          <th width="11%" align="center" >FECHA SALIDA FISICA </th>
          </tr>
      </thead>
      <tbody class="EstAlmacenMovimientoSalidaImprimirTablaBody">
        <?php

$ArrSuministros = array();

$i = 1;
if (!empty($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle)) {
    foreach ($InsAlmacenMovimientoSalida->AlmacenMovimientoSalidaDetalle as $DatAlmacenMovimientoSalidaDetalle) {
        
        if ($DatAlmacenMovimientoSalidaDetalle->RtiId <> "RTI-10003" and $DatAlmacenMovimientoSalidaDetalle->AmdEstado == 3) {
?>
        <tr>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdCantidad, 2);
?></td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre;
?></td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatAlmacenMovimientoSalidaDetalle->ProCodigoOriginal;
?></td>
          <td align="left" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatAlmacenMovimientoSalidaDetalle->ProNombre;
?>
            
            
            
            <?php
	if(!empty($DatAlmacenMovimientoSalidaDetalle->AmdCompraOrigen)){
	?>
            <b>[<?php echo $DatAlmacenMovimientoSalidaDetalle->AmdCompraOrigen;?>]</b>
            <?php	
	}
	?>
            
          </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format(($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdImporte, 2);
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><span class="EstTallerPedidoDetalleImprimirContenido">
            <?php
				echo ($DatAlmacenMovimientoSalidaDetalle->AmdFecha);
	?>
          </span></td>
          </tr>
        <?php
            $i++;
            $TotalBruto += $DatAlmacenMovimientoSalidaDetalle->AmdImporte;
            
        } else if($DatAlmacenMovimientoSalidaDetalle->AmdEstado == 3){
            $ArrSuministros[] = $DatAlmacenMovimientoSalidaDetalle;
        }
        
    }
}
?>

<?php
if (!empty($ArrSuministros)) {
?>

        <tr>
          <td colspan="5" align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">
            MATERIALES:
          </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">&nbsp;</td>
          </tr>


<?php
   
    foreach ($ArrSuministros as $DatSuministro) {

?>
    <tr>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->AmdCantidad, 2);
?></td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->UmeNombre;
?></td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProCodigoOriginal;
?></td>
          <td align="left" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProNombre;
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format(($DatSuministro->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->AmdImporte, 2);
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          </tr>
<?php
		$i++;
		 $TotalBruto += $DatSuministro->AmdImporte;
    }
    
?>
    
<?php
    
}
$TotalRepuesto = $TotalBruto - $InsAlmacenMovimientoSalida->AmoDescuento;

//deb($InsAlmacenMovimientoSalida->AmoIncluyeImpuesto);
	
	if($InsAlmacenMovimientoSalida->AmoIncluyeImpuesto == 1){
		
		$Total = $TotalRepuesto + $InsAlmacenMovimientoSalida->AmoManoObra + $InsAlmacenMovimientoSalida->FccManoObra;
		$SubTotal = $Total / (($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
		
		$SubTotal = $TotalRepuesto  + $InsAlmacenMovimientoSalida->AmoManoObra + $InsAlmacenMovimientoSalida->FccManoObra;
		$Impuesto = $SubTotal * (($InsAlmacenMovimientoSalida->AmoPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
?>

      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="5"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="right">&nbsp;</td>
          <td width="56%" rowspan="5" align="left" valign="top">
            
            <span class="EstAlmacenMovimientoSalidaImprimirObsequio">
              
              <?php
if($InsAlmacenMovimientoSalida->FimObsequio == 1){
?>
              Este SERVICIO es GRATUITO
              <?php
}
?>
              
              </span>           <span class="EstAlmacenMovimientoSalidaImprimirContenido"> 
			  
			  
			  <?php
if($InsAlmacenMovimientoSalida->AmoIncluyeImpuesto == 2){
?>
<br />Los Precios NO incluyen IGV
  <?php	
}else{
?>
<br />Los Precios incluyen IGV
<?php	
}
?>
            
          </span></td>
          <td align="right" valign="middle" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if(!empty($InsAlmacenMovimientoSalida->FccManoObra) and $InsAlmacenMovimientoSalida->FccManoObra<> "0.00"){
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">Mano de Obra:</span>
            <?php
}
?></td>
          <td align="right" valign="middle" >
		  
		  <?php
if(!empty($InsAlmacenMovimientoSalida->FccManoObra) and $InsAlmacenMovimientoSalida->FccManoObra<> "0.00"){
?>
            <?php echo number_format($InsAlmacenMovimientoSalida->FccManoObra,2);?>
            <?php	
}
?></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" valign="middle" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo">
            
            <?php
if(!empty($InsAlmacenMovimientoSalida->AmoDescuento) and $InsAlmacenMovimientoSalida->AmoDescuento <> "0.00"){
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">DESCUENTO:</span>
            
            <?php	
}
?>
            
            
            
          </td>
          <td align="right" valign="middle" ><span class="EstMonedaSimbolo">
            
            <?php
if(!empty($InsAlmacenMovimientoSalida->AmoDescuento) and $InsAlmacenMovimientoSalida->AmoDescuento <> "0.00"){
?>
            
            
            <?php
echo $EmpresaMoneda;
?>
            </span> <span class="EstAlmacenMovimientoSalidaImprimirContenidoTotal">
              <?php
echo number_format($InsAlmacenMovimientoSalida->AmoDescuento, 2);
?>
              </span>
            
            
            <?php	
}
?>
            
            
            
            </td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" valign="middle" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">SUBTOTAL:</span>
            <?php
}
?></td>
          <td align="right" valign="middle" ><span class="EstMonedaSimbolo">
      
            <?php
echo $EmpresaMoneda;
?>
          </span> <span class="EstAlmacenMovimientoSalidaImprimirContenidoTotal">
          <?php
echo number_format($SubTotal, 2);
?>
          </span></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" valign="middle" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">IMPUESTO:</span>
            <?php
}
?></td>
          <td align="right" valign="middle" ><span class="EstMonedaSimbolo">
            <?php
echo $EmpresaMoneda;
?>
          </span> <span class="EstAlmacenMovimientoSalidaImprimirContenidoTotal">
          <?php
echo number_format($Impuesto, 2);
?>
          </span></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td width="1%" align="right">&nbsp;</td>
          <td width="29%" align="right" valign="middle" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo">
            
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">TOTAL:</span>
            <?php
}
?>          </td>
          <td width="12%" align="right" valign="middle" ><span class="EstMonedaSimbolo">
		  
  
		  <?php
echo $EmpresaMoneda;
?></span> <span class="EstAlmacenMovimientoSalidaImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span>


</td>
          <td width="2%" align="center" >&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
  </tr>
</table>
</body>
</html>
