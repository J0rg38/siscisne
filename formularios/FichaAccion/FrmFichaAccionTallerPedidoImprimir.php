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

$GET_id = $_GET['FinId'];


require_once($InsPoo->MtdPaqActividad().'ClsFichaAccion.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSalidaExterna.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionFoto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTarea.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionProducto.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionTempario.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionMantenimiento.php');
require_once($InsPoo->MtdPaqActividad().'ClsFichaAccionSuministro.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedido.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsTallerPedidoDetalle.php');

$InsFichaAccion = new ClsFichaAccion();
$InsTallerPedido = new ClsTallerPedido();

$InsFichaAccion->FccId = $GET_id;
$InsFichaAccion->MtdObtenerFichaAccion();

$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoFecha','DESC',NULL,NULL,NULL,NULL,$InsFichaAccion->FccId);
$ArrTallerPedidos = $ResTallerPedido['Datos'];
	
//deb($ArrTallerPedidos);					
//
//$InsTallerPedido->AmoId = $GET_id;
//$InsTallerPedido        = $InsTallerPedido->MtdObtenerTallerPedido();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ficha No. <?php echo $InsFichaAccion->FccId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssFichaAccionImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsTallerPedidoImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsFichaAccion->FccId)) {
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



<?php
foreach ($ArrTallerPedidos as $DatTallerPedido){

$InsTallerPedido = new ClsTallerPedido();
$InsTallerPedido->AmoId = $DatTallerPedido->AmoId;
$InsTallerPedido->MtdObtenerTallerPedido();

$Total = 0;
if (!empty($InsTallerPedido->TallerPedidoDetalle)) {
?>
  <tr>
    <td height="45" align="right" valign="top">
	<span class="EstTallerPedidoImprimirTipo">
	<?php echo $InsTallerPedido->MinNombre;?>&nbsp;&nbsp;
    </span>
   
<br />
<span class="EstTallerPedidoImprimirContenido">
<?php echo $InsTallerPedido->AmoId;?>
	</span>
	</td>
  </tr>
  
  
  
  <tr>
    <td valign="top">
    
    
    <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstTallerPedidoImprimirTabla">
      <tr>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          CLIENTE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" colspan="4" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstTallerPedidoImprimirContenido">
		<?php //echo $InsTallerPedido->CliApellidoPaterno;?> <?php //echo $InsTallerPedido->CliApellidoMaterno;?> <?php echo $InsTallerPedido->CliNombre;?>
        
        <?php echo $InsTallerPedido->CliApellidoPaterno;?>
        <?php echo $InsTallerPedido->CliApellidoMaterno;?>
        
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Fecha
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirContenido">
        &nbsp;&nbsp;
          <?php
		  echo $InsTallerPedido->AmoFecha;
//$fecha = explode("/", $InsTallerPedido->AmoFecha);
//echo $fecha[0] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[2];
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          # ficha</span><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstTallerPedidoImprimirContenidoOT"><?php
echo $InsTallerPedido->FinId;
?>&nbsp;&nbsp;</span></td>
      </tr>
      <tr>
        <td width="9%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MARCA
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td width="12%" height="23" align="left" valign="top" >
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->VmaNombre;
?></span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MODELO</span><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="5%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="15%" height="23" align="center" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo">

        <span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->VmoNombre;
?></span>        </td>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          AÑO
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinAnoFabricacion;
?></span></td>
        <td width="11%" height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          PLACA</span><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="12%" height="23" align="center" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinPlaca;
?></span> </td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstTallerPedidoImprimirEtiquetaFondo"><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          VIN
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          RESPONSABLE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          <span class="EstTallerPedidoImprimirContenido">
            <?php echo $InsTallerPedido->PerNombre;?> <?php echo $InsTallerPedido->PerApellidoPaterno;?> <?php echo $InsTallerPedido->PerApellidoMaterno;?>
            </span>
        </td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          KILOMETRAJE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstTallerPedidoImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstTallerPedidoImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstTallerPedidoImprimirContenido"><?php
echo $InsTallerPedido->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td height="320" colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstTallerPedidoImprimirTabla">
      <thead class="EstTallerPedidoImprimirTablaHead">
        <tr>
          <th width="3%" align="center" ><span class="EstTallerPedidoImprimirEtiqueta">
            <?php
if ($_GET['P'] != 1) {
?>
            #
            <?php
}
?>
          </span></th>
          <th width="8%" align="center" >
          
            <?php
if ($_GET['P'] != 1) {
?>
				<span class="EstTallerPedidoImprimirEtiqueta"> CANT.</span>
            <?php
}
?>          </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="11%" align="center" >
          

			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstTallerPedidoImprimirEtiqueta">            UND. MED.</span>
			<?php
}
?>			</th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="11%" align="center" >
          
          
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiqueta">CODIGO </span>
              <?php
}
?>            </th>
          <th width="37%" align="center" > 
				<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstTallerPedidoImprimirEtiqueta">DESCRIPCION            </span>
				<?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="9%" align="center" >
			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstTallerPedidoImprimirEtiqueta">P.U.            </span>
              <?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="12%" align="center" ><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiqueta">TOTAL </span>
            <?php
}
?></th>
          <th width="5%" align="center" >&nbsp;</th>
        </tr>
      </thead>
      <tbody class="EstTallerPedidoImprimirTablaBody">
        <?php

$ArrSuministros = array();
 $TotalBruto =0;
$i = 1;
if (!empty($InsTallerPedido->TallerPedidoDetalle)) {
    foreach ($InsTallerPedido->TallerPedidoDetalle as $DatTallerPedidoDetalle) {
		
		
		
			if($InsTallerPedido->MonId<>$EmpresaMonedaId and !empty($InsTallerPedido->MonId)){
	
				$DatTallerPedidoDetalle->AmdCosto = round($DatTallerPedidoDetalle->AmdCosto / $InsTallerPedido->AmoTipoCambio,2);
				$DatTallerPedidoDetalle->AmdPrecioVenta = round($DatTallerPedidoDetalle->AmdPrecioVenta / $InsTallerPedido->AmoTipoCambio,2);
				$DatTallerPedidoDetalle->AmdImporte = round($DatTallerPedidoDetalle->AmdImporte / $InsTallerPedido->AmoTipoCambio,2);
				
				
			}
        
        if ($DatTallerPedidoDetalle->RtiId <> "RTI-10003" and $DatTallerPedidoDetalle->AmdEstado == 3) {
?>
        <tr>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format($DatTallerPedidoDetalle->AmdCantidad, 2);
?></td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatTallerPedidoDetalle->UmeNombre;
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatTallerPedidoDetalle->ProCodigoOriginal;
?></td>
          <td align="left" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatTallerPedidoDetalle->ProNombre;
?></td>
          <td align="left" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format(($DatTallerPedidoDetalle->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format($DatTallerPedidoDetalle->AmdImporte, 2);
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
        </tr>
        <?php
            $i++;
            $TotalBruto += $DatTallerPedidoDetalle->AmdImporte;
            
        } else if($DatTallerPedidoDetalle->AmdEstado == 3){
            $ArrSuministros[] = $DatTallerPedidoDetalle;
        }
        
    }
}
?>

<?php
//deb($ArrSuministros);
if (!empty($ArrSuministros)) {
?>

        <tr>
          <td colspan="7" align="right" class="EstTallerPedidoDetalleImprimirContenido">
            MATERIALES:
          </td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido">&nbsp;</td>
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
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->UmeNombre;
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProCodigoOriginal;
?></td>
          <td align="left" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProNombre;
?></td>
          <td align="left" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format(($DatSuministro->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->AmdImporte, 2);
?></td>
          <td align="right" class="EstTallerPedidoDetalleImprimirContenido" >&nbsp;</td>
        </tr>
<?php
		$i++;
		 $TotalBruto += $DatSuministro->AmdImporte;
    }
    
?>
    
<?php
    
}
//$Total = $TotalBruto - $InsTallerPedido->AmoDescuento;



$TotalRepuesto = $TotalBruto;

//deb($TotalRepuesto);
//deb($InsTallerPedido->AmoPorcentajeImpuestoVenta);
//deb($InsTallerPedido->AmoIncluyeImpuesto);
//deb($InsTallerPedido->AmoDescuento);
//deb($InsTallerPedido->AmoManoObra);
//deb($InsTallerPedido->FccManoObra);

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
	
	
?>

      </tbody>
    </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="5"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
          <tr>
            <td align="right">&nbsp;</td>
            <td width="61%" rowspan="5" align="left"><?php
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
              TIENE MANO DE OBRA<!--:-->
<?php  
			  }
			  ?>
<!--  <?php echo number_format($InsTallerPedido->FccManoObra,2);?><br />-->
              </span>
              
               <br />
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
            
            
             <span class="EstTallerPedidoImprimirContenido"> Los Precios incluyen IGV<br />
              <?php
//echo $InsTallerPedido->AmoObservacion;
?>
            </span></td>
            <td align="right" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
              <span class="EstTallerPedidoImprimirEtiquetaTotal">TOTAL REPUESTOS:</span>
            <?php
}
?></td>
            <td align="right" >
			
			
	
              <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal"> <?php echo number_format($TotalRepuesto,2);?></span>
           </td>
            <td align="center" >&nbsp;</td>
          </tr>
          <tr>
          <td align="right">&nbsp;</td>
          <td align="right" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if(!empty($InsTallerPedido->FccManoObra) and $InsTallerPedido->FccManoObra<> "0.00"){
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">MANO DE OBRA:</span>
            <?php	
}
?></td>
          <td align="right" ><?php
if(!empty($InsTallerPedido->FccManoObra) and $InsTallerPedido->FccManoObra<> "0.00"){
?>
            <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal"> <?php echo number_format($InsTallerPedido->FccManoObra,2);?></span>
            <?php	
}
?></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" class="EstTallerPedidoImprimirEtiquetaFondo">
            
  <?php
//if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
	if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">DESCUENTO:</span>
            
  <?php	
}
?>
            
            
            
</td>
          <td align="right" ><span class="EstMonedaSimbolo">

<?php
//if(!empty($InsTallerPedido->AmoDescuento) and $InsTallerPedido->AmoDescuento <> "0.00"){
?>

 <span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> 
 
          </span> <span class="EstTallerPedidoImprimirContenidoTotal">
          <?php
echo number_format($InsTallerPedido->AmoDescuento, 2);
?>
          </span>


<?php	
//}
?>
          

          
          </td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="right" class="EstTallerPedidoImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstTallerPedidoImprimirEtiquetaTotal">Total:</span>
            <?php
}
?></td>
          <td align="right" ><span class="EstMonedaSimbolo"><?php echo $InsTallerPedido->MonSimbolo;?></span> <span class="EstTallerPedidoImprimirContenidoTotal">
            <?php
echo number_format($Total, 2);
?>
          </span></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td width="4%" align="right">&nbsp;</td>
          <td width="17%" align="right" class="EstTallerPedidoImprimirEtiquetaFondo">&nbsp;</td>
          <td width="17%" align="right" >&nbsp;</td>
          <td width="1%" align="center" >&nbsp;</td>
        </tr>
        </tbody>
    </table></td>
  </tr>
<tr>
    <td  colspan="5" valign="top"><hr />-</td>
  </tr>
<?php	
}
?>


  
  <?php	
}
?>

  
  
  
</table>
</body>
</html>
