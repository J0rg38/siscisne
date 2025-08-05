<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta      = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones() . 'CnfConexion.php');
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
<title>Salida de Almacen No. <?php
echo $InsAlmacenMovimientoSalida->AmoId;
?></title>

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
          <?php
if ($_GET['P'] != 1) {
?>
          CLIENTE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" colspan="4" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstAlmacenMovimientoSalidaImprimirContenido">
		<?php //echo $InsAlmacenMovimientoSalida->CliApellidoPaterno;?> <?php //echo $InsAlmacenMovimientoSalida->CliApellidoMaterno;?> <?php echo $InsAlmacenMovimientoSalida->CliNombre;?>
        
        <?php echo $InsAlmacenMovimientoSalida->CliApellidoPaterno;?>
        <?php echo $InsAlmacenMovimientoSalida->CliApellidoMaterno;?>
        
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Fecha
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirContenido">
        &nbsp;&nbsp;
          <?php
		  echo $InsAlmacenMovimientoSalida->AmoFecha;
//$fecha = explode("/", $InsAlmacenMovimientoSalida->AmoFecha);
//echo $fecha[0] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[2];
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          # ficha</span><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenidoOT"><?php
echo $InsAlmacenMovimientoSalida->FinId;
?>&nbsp;&nbsp;</span></td>
      </tr>
      <tr>
        <td width="9%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MARCA
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
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
        <span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->VmaNombre;
?></span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MODELO</span><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="5%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="15%" height="23" align="center" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo">

        <span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->VmoNombre;
?></span>        </td>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          AÑO
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinAnoFabricacion;
?></span></td>
        <td width="11%" height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          PLACA</span><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="12%" height="23" align="center" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinPlaca;
?></span> </td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          VIN
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          RESPONSABLE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          <span class="EstAlmacenMovimientoSalidaImprimirContenido">
            <?php echo $InsAlmacenMovimientoSalida->PerNombre;?> <?php echo $InsAlmacenMovimientoSalida->PerApellidoPaterno;?> <?php echo $InsAlmacenMovimientoSalida->PerApellidoMaterno;?>
            </span>
        </td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          KILOMETRAJE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstAlmacenMovimientoSalidaImprimirContenido"><?php
echo $InsAlmacenMovimientoSalida->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="320" colspan="5" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenMovimientoSalidaImprimirTabla">
      <thead class="EstAlmacenMovimientoSalidaImprimirTablaHead">
        <tr>
          <th width="3%" align="center" ><span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">
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
				<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta"> CANT.</span>
            <?php
}
?>          </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="11%" align="center" >
          

			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">            UND. MED.</span>
			<?php
}
?>			</th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="11%" align="center" >
          
          
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">CODIGO </span>
              <?php
}
?>            </th>
          <th width="37%" align="center" > 
				<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">DESCRIPCION            </span>
				<?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="9%" align="center" >
			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">P.U.            </span>
              <?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="12%" align="center" ><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiqueta">TOTAL </span>
            <?php
}
?></th>
          <th width="5%" align="center" >&nbsp;</th>
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
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatAlmacenMovimientoSalidaDetalle->UmeNombre;
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
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
          <td align="left" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format(($DatAlmacenMovimientoSalidaDetalle->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdImporte, 2);
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
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
          <td colspan="7" align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">
            MATERIALES:
          </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido">&nbsp;</td>
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
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->UmeNombre;
?></td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProCodigoOriginal;
?></td>
          <td align="left" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProNombre;
?></td>
          <td align="left" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" ><?php
            echo number_format(($DatSuministro->AmdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstAlmacenMovimientoSalidaDetalleImprimirContenido" >&nbsp;</td>
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
    <td colspan="5"><table class="EstTablaTotal" width="100%" cellpadding="1" cellspacing="2" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="right">&nbsp;</td>
          <td width="56%" rowspan="5" align="left">
            
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
          <td align="right" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if(!empty($InsAlmacenMovimientoSalida->FccManoObra) and $InsAlmacenMovimientoSalida->FccManoObra<> "0.00"){
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">Mano de Obra:</span>
            <?php
}
?></td>
          <td align="right" >
		  
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
          <td align="right" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo">
            
            <?php
if(!empty($InsAlmacenMovimientoSalida->AmoDescuento) and $InsAlmacenMovimientoSalida->AmoDescuento <> "0.00"){
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">DESCUENTO:</span>
            
            <?php	
}
?>
            
            
            
          </td>
          <td align="right" ><span class="EstMonedaSimbolo">
            
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
          <td align="right" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">SUBTOTAL:</span>
            <?php
}
?></td>
          <td align="right" ><span class="EstMonedaSimbolo">
      
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
          <td align="right" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">IMPUESTO:</span>
            <?php
}
?></td>
          <td align="right" ><span class="EstMonedaSimbolo">
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
          <td width="29%" align="right" class="EstAlmacenMovimientoSalidaImprimirEtiquetaFondo">
            
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstAlmacenMovimientoSalidaImprimirEtiquetaTotal">TOTAL:</span>
            <?php
}
?>          </td>
          <td width="12%" align="right" ><span class="EstMonedaSimbolo">
		  
  
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
