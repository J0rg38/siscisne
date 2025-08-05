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

require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaConcretada.php');
require_once($InsPoo->MtdPaqAlmacen() . 'ClsVentaConcretadaDetalle.php');

$InsVentaConcretada = new ClsVentaConcretada();

$InsVentaConcretada->VcoId = $GET_id;
//$InsVentaConcretada        = $InsVentaConcretada->MtdObtenerVentaConcretada();
$InsVentaConcretada->MtdObtenerVentaConcretada();


if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){

	$InsVentaConcretada->VcoDescuento = round($InsVentaConcretada->VcoDescuento / $InsVentaConcretada->VcoTipoCambio,2);

}

			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salida de Almacen No. <?php
echo $InsVentaConcretada->VcoId;
?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/ClsVentaConcretadaImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVentaConcretadaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php
if ($_GET['P'] == 1 and !empty($InsVentaConcretada->VcoId)) {
?> 
FncVentaConcretadaImprimir(); 
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


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaConcretadaImprimirTabla">
  <tr>
    <td height="45" align="right" valign="top">
    
    <span class="EstVentaConcretadaImprimirTipo">
    Venta CONCRETADA<br />
    
    </span>
    
	<span class="EstVentaConcretadaImprimirContenido">
	
    <?php echo $InsVentaConcretada->VdiId;?>
	</span>
	</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVentaConcretadaImprimirTabla">
      <tr>
        <td height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          CLIENTE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" colspan="4" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstVentaConcretadaImprimirContenido">
		 <?php //echo $InsVentaConcretada->CliApellidoPaterno;?> <?php //echo $InsVentaConcretada->CliApellidoMaterno;?> <?php //echo $InsVentaConcretada->CliNombre;?>
        
        
        <?php echo $InsVentaConcretada->CliNombre;?> <?php echo $InsVentaConcretada->CliApellidoPaterno;?> <?php echo $InsVentaConcretada->CliApellidoMaterno;?>
        
        
        
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          Fecha
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td width="6%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirContenido">
          <?php
$fecha = explode("/", $InsVentaConcretada->VcoFecha);
echo $fecha[0] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[1] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $fecha[2];
?>
        </span></td>
        <td height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          # ficha</span><span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstVentaConcretadaImprimirContenido">
		
<?php echo $InsVentaConcretada->VcoId;?> <!--(<?php echo $InsVentaConcretada->VdiId;?>)-->
</span></td>
      </tr>
      <tr>
        <td width="9%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MARCA
          <?php
}
?>
        </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
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
        <span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->VmaNombre;
?>

<?php
echo $InsVentaConcretada->VdiMarca;
?>
</span></td>
        <td width="15%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          MODELO</span><span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="5%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :</span><span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="15%" height="23" align="center" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo">
		&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->VmoNombre;
?>
<?php
echo $InsVentaConcretada->VdiModelo;
?>
</span>        </td>
        <td height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          AÑO
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="left" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->EinAnoFabricacion;
?>

<?php
echo $InsVentaConcretada->VdiAnoModelo;
?>


</span></td>
        <td width="11%" height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          PLACA</span><span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="3%" height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td width="12%" height="23" align="center" valign="top" ><span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->EinPlaca;
?>

<?php
echo $InsVentaConcretada->VdiPlaca;
?>

</span> </td>
      </tr>
      <tr>
        <td height="23" align="left" valign="top" class="EstVentaConcretadaImprimirEtiquetaFondo"><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          VIN
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->EinVIN;
?></span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          RESPONSABLE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          :
          <?php
}
?>
        </span></td>
        <td height="23" colspan="4" align="left" valign="top" >
          
          
          <span class="EstVentaConcretadaImprimirContenido">
            <?php echo $InsVentaConcretada->PerNombre;?> <?php echo $InsVentaConcretada->PerApellidoPaterno;?> <?php echo $InsVentaConcretada->PerApellidoMaterno;?>
            </span>
          
        </td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          KILOMETRAJE
          <?php
}
?>
        </span></td>
        <td height="23" align="left" valign="top" ><span class="EstVentaConcretadaImprimirEtiqueta">
          <?php
if ($_GET['P'] != 1) {
?>
          </span>:<span class="EstVentaConcretadaImprimirEtiqueta">
            <?php
}
?>
          </span></td>
        <td height="23" align="center" valign="top" ><span class="EstVentaConcretadaImprimirContenido"><?php
echo $InsVentaConcretada->FinVehiculoKilometraje;
?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="320" colspan="5" valign="top">
    
    
    
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaConcretadaImprimirTabla">
      <thead class="EstVentaConcretadaImprimirTablaHead">
        <tr>
          <th width="3%" align="center" ><span class="EstVentaConcretadaImprimirEtiqueta">
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
				<span class="EstVentaConcretadaImprimirEtiqueta"> CANT.</span>
            <?php
}
?>          </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="12%" align="center" >
          

			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstVentaConcretadaImprimirEtiqueta">            UND. MED.</span>
			<?php
}
?>			</th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="10%" align="center" >
          
          
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstVentaConcretadaImprimirEtiqueta">CODIGO </span>
              <?php
}
?>            </th>
          <th width="36%" align="center" > 
				<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstVentaConcretadaImprimirEtiqueta">DESCRIPCION            </span>
				<?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="10%" align="center" >
			<?php
if ($_GET['P'] != 1) {
?>
				<span class="EstVentaConcretadaImprimirEtiqueta">P.U.            </span>
              <?php
}
?>            </th>
          <th width="1%" align="center" >&nbsp;</th>
          <th width="11%" align="center" ><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstVentaConcretadaImprimirEtiqueta">TOTAL </span>
            <?php
}
?></th>
          <th width="6%" align="center" >&nbsp;</th>
        </tr>
      </thead>
      <tbody class="EstVentaConcretadaImprimirTablaBody">
        <?php

$ArrSuministros = array();
$TotalRepuesto = 0;

$i = 1;
if (!empty($InsVentaConcretada->VentaConcretadaDetalle)) {
    foreach ($InsVentaConcretada->VentaConcretadaDetalle as $DatVentaConcretadaDetalle) {
        
		
			if($InsVentaConcretada->MonId<>$EmpresaMonedaId ){
	
				$DatVentaConcretadaDetalle->VcdCosto = round($DatVentaConcretadaDetalle->VcdCosto / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdPrecioVenta = round($DatVentaConcretadaDetalle->VcdPrecioVenta / $InsVentaConcretada->VcoTipoCambio,2);
				$DatVentaConcretadaDetalle->VcdImporte = round($DatVentaConcretadaDetalle->VcdImporte / $InsVentaConcretada->VcoTipoCambio,2);
				
				
			}



        if ($DatVentaConcretadaDetalle->RtiId <> "RTI-10003") {
?>
        <tr>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format($DatVentaConcretadaDetalle->VcdCantidad, 2);
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo $DatVentaConcretadaDetalle->UmeNombre;
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstVentaConcretadaDetalleImprimirContenido" >
		  
		  
		  <?php
            echo $DatVentaConcretadaDetalle->ProCodigoOriginal;
?>

<?php
if($DatVentaConcretadaDetalle->AmdReemplazo == "Si"){
?>
	(<?php echo $DatVentaConcretadaDetalle->ProCodigoOriginalReemplazo;?>)
<?php	
}
?>





</td>
          <td align="left" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo $DatVentaConcretadaDetalle->ProNombre;
?></td>
          <td align="left" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format(($DatVentaConcretadaDetalle->VcdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format($DatVentaConcretadaDetalle->VcdImporte, 2);
?></td>
          <td align="left" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
        </tr>
        <?php
            $i++;
            $TotalBruto += $DatVentaConcretadaDetalle->VcdImporte;
            
        } else {
            $ArrSuministros[] = $DatVentaConcretadaDetalle;
        }
        
    }
}
?>

<?php
if (!empty($ArrSuministros)) {
?>

        <tr>
          <td colspan="7" align="right" class="EstVentaConcretadaDetalleImprimirContenido">
            MATERIALES:
          </td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
          </tr>


<?php
   
    foreach ($ArrSuministros as $DatSuministro) {

?>

    <tr>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido"><?php
            echo $i;
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->VcdCantidad, 2);
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo $DatSuministro->UmeNombre;
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="center" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProCodigoOriginal;
?></td>
          <td align="left" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo $DatSuministro->ProNombre;
?></td>
          <td align="left" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format(($DatSuministro->VcdPrecioVenta), 2);
?> </td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" ><?php
            echo number_format($DatSuministro->VcdImporte, 2);
?></td>
          <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
        </tr>
<?php
		$i++;
		 $TotalBruto += $DatSuministro->VcdImporte;
    }
?>

<?php
}
    
?>



<?php
/*	if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
		
		$SubTotal = $TotalBruto - $InsVentaConcretada->VcoDescuento;
		$Impuesto = ($SubTotal  * ($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100) );
		$Total = $SubTotal + $Impuesto;
	
	}else{
		
		
	
	}*/
	
	$TotalRepuesto = $TotalBruto - $InsVentaConcretada->VcoDescuento;
	//$Total = $TotalBruto;
?>



<?php
if(!empty($InsVentaConcretada->VdiOrdenCompraNumero)){
?>

    <tr>
      <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
      <td colspan="10" align="center" >
		<span class="EstVentaConcretadaDetalleImprimirContenidoReferencia">
        O.C.:0 <?php echo $InsVentaConcretada->VdiOrdenCompraNumero;?> &nbsp; &nbsp; &nbsp; (<?php echo $InsVentaConcretada->VdiOrdenCompraFecha;?>)</span>
        
      </td>
      <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
    </tr>
<?php
}
?>


<?php
if(!empty($InsVentaConcretada->CliIdSeguro)){
?>

    <tr>
      <td align="right" class="EstVentaConcretadaDetalleImprimirContenido">&nbsp;</td>
      <td colspan="10" align="center" >
		<span class="EstVentaConcretadaDetalleImprimirContenidoReferencia">
        SEGURO: <?php echo $InsVentaConcretada->CliNombreSeguro;?>
        <?php echo $InsVentaConcretada->CliApellidoPaternoSeguro;?>
        <?php echo $InsVentaConcretada->CliApellidoMaternoSeguro;?>
		</span>
        
      </td>
      <td align="right" class="EstVentaConcretadaDetalleImprimirContenido" >&nbsp;</td>
    </tr>
<?php
}
?>

    
      </tbody>
    </table>
    
    </td>
  </tr>
  <tr>
  <?php
  // $Total = $TotalBruto - $InsVentaConcretada->VcoDescuento;
  

	if($InsVentaConcretada->VcoIncluyeImpuesto == 1){
		
		$Total = $TotalRepuesto + $InsVentaConcretada->VcoManoObra;
		$SubTotal = $Total / (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100)+1);
		$Impuesto = $Total - $SubTotal;	
		
	}else{
		
		$SubTotal = $TotalRepuesto  + $InsVentaConcretada->VcoManoObra;
		$Impuesto = $SubTotal * (($InsVentaConcretada->VcoPorcentajeImpuestoVenta/100));
		$Total = $SubTotal + $Impuesto;	
		
	}
	
	
  ?>
  
  
  
  
    <td colspan="5">
    
    <table class="EstTablaTotal" width="100%" cellpadding="0" cellspacing="0" border="0">
      <tbody class="EstTablaTotalBody">
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">
          
<?php
if($InsVentaConcretada->VcoIncluyeImpuesto == 2){
?>
Los Precios NO incluyen IGV
<?php	
}else{
?>
Los Precios incluyen IGV
<?php	
}
?>


</td>
          <td align="right" class="EstVentaConcretadaImprimirEtiquetaFondo">
		  

<?php
if (!empty($InsVentaConcretada->VcoDescuento) and $InsVentaConcretada->VcoDescuento <> "0.00") {
?>

	<span class="EstVentaConcretadaImprimirEtiquetaTotal">Descuento:</span>
    
<?php
}
?>




</td>
          <td align="right" >
		  
<?php
if (!empty($InsVentaConcretada->VcoDescuento) and $InsVentaConcretada->VcoDescuento <> "0.00") {
?>
            <span class="EstMonedaSimbolo">

			<?php
            echo $InsVentaConcretada->MonSimbolo;
            ?>

            </span> <span class="EstVentaConcretadaImprimirContenidoTotal">

			<?php
            echo number_format($InsVentaConcretada->VcoDescuento, 2);
            ?>
            
            </span>
<?php
}
?></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><span class="EstVentaConcretadaImprimirContenido">
            <?php
//echo $InsVentaConcretada->VcoObservacion;
?>
          </span></td>
          <td align="right" class="EstVentaConcretadaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstVentaConcretadaImprimirEtiquetaTotal">SUBTOTAL:</span>
            <?php
}
?></td>
          <td align="right" ><span class="EstMonedaSimbolo">
            <?php
echo $InsVentaConcretada->MonSimbolo;
?>
            </span> <span class="EstVentaConcretadaImprimirContenidoTotal">
              <?php
echo number_format($SubTotal, 2);
?>
            </span></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="right" class="EstVentaConcretadaImprimirEtiquetaFondo"><?php
if ($_GET['P'] != 1) {
?>
            <span class="EstVentaConcretadaImprimirEtiquetaTotal">IMPUESTO:</span>
            <?php
}
?></td>
          <td align="right" ><span class="EstMonedaSimbolo">
            <?php
echo $InsVentaConcretada->MonSimbolo;
?>
            </span> <span class="EstVentaConcretadaImprimirContenidoTotal">
              <?php
echo number_format($Impuesto, 2);
?>
            </span></td>
          <td align="center" >&nbsp;</td>
        </tr>
        <tr>
          <td width="2%" align="right">&nbsp;</td>
          <td width="67%" align="left">&nbsp;</td>
          <td width="13%" align="right" class="EstVentaConcretadaImprimirEtiquetaFondo">
            
            <?php
if ($_GET['P'] != 1) {
?>
            <span class="EstVentaConcretadaImprimirEtiquetaTotal">Total:</span>
            <?php
}
?>          </td>
          <td width="12%" align="right" ><span class="EstMonedaSimbolo"><?php
echo $InsVentaConcretada->MonSimbolo;
?></span> <span class="EstVentaConcretadaImprimirContenidoTotal"><?php
echo number_format($Total, 2);
?></span></td>
          <td width="6%" align="center" >&nbsp;</td>
        </tr>
        </tbody>
    </table>
    
    
    </td>
  </tr>
</table>
</body>
</html>


