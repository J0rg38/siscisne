<?php
@session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta  = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
////MENSAJES GENERALES
require_once($InsProyecto->MtdRutMensajes().'MsjGeneral.php');
////CLASES GENERALES
require_once($InsProyecto->MtdRutClases().'ClsSesion.php');
require_once($InsProyecto->MtdRutClases().'ClsSesionObjeto.php');
require_once($InsProyecto->MtdRutClases().'ClsMensaje.php');
require_once($InsProyecto->MtdRutLibrerias().'PHPMailer_5.2.4/class.phpmailer.php');
require_once($InsProyecto->MtdRutClases().'ClsCorreo.php');

////CLASES GENERALES
require_once($InsProyecto->MtdRutConexiones().'ClsConexion.php');
require_once($InsProyecto->MtdRutClases().'ClsMysql.php');
////FUNCIONES GENERALES
require_once($InsProyecto->MtdRutFunciones().'FncGeneral.php');

$GET_id = $_GET['Id'];
$GET_ImprimirCodigo = $_GET['ImprimirCodigo'];

require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirecta.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaTarea.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaDirectaFoto.php');



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenProducto.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsVentaDirecta = new ClsVentaDirecta();
$InsAlmacenStock = new ClsAlmacenStock();
$InsAlmacen = new ClsAlmacen();
$InsVentaDirecta->VdiId = $GET_id;
$InsVentaDirecta->MtdObtenerVentaDirecta();


$InsVentaDirecta->VdiId = $GET_id;
$InsVentaDirecta->MtdObtenerVentaDirecta();


$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"AlmNombre","ASC",NULL,$InsVentaDirecta->SucId );
$ArrAlmacenes = $RepAlmacen['Datos'];


$GET_ImprimirCodigo = 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de Venta No. <?php echo $InsVentaDirecta->VdiId;?></title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssImprimir.css">
<link href="css/CssVentaDirecta2.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsVentaDirectaImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsVentaDirecta->VdiId)){?> 
FncVentaDirectaImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>
<?php if($_GET['P']<>1){ ?>
<form method="get" enctype="multipart/form-data" action="#">
<input type="hidden" name="Id" id="Id" value="<?php echo $GET_id;?>" />
<input type="hidden" name="Ta" id="Ta" value="<?php echo $GET_ta;?>" />
<input type="hidden" name="P" id="P" value="1" />

<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
  <input type="submit" name="BtnImprimir" id="BtnImprimir" value="Imprimir" />
</td>
</tr>
</table>

</form>
<?php }?>


<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><span class="EstPlantillaCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  <td align="left" valign="top">&nbsp;</td>
  </tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
  <td colspan="3" align="left" valign="top"><img src="../../imagenes/membretes/cabecera_simple.png" width="100%"  /></td>
  <td align="right" valign="top">&nbsp;</td>
</tr>
<tr>
  <td width="1%" align="left" valign="top">&nbsp;</td>
  <td width="34%" align="left" valign="top">&nbsp;</td>
  <td width="28%" align="center" valign="top">&nbsp;</td>
  <td width="37%" align="right" valign="top"><span class="EstPlantillaDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> - 
    <span class="EstPlantillaDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
  <td width="0%" align="right" valign="top">&nbsp;</td>
</tr>
</table>

<hr class="EstPlantillaLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">

<tr>
  <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVentaDirectaImprimirTabla">
    <tr>
      <td colspan="6" align="center" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstPlantillaTitulo">ORDEN DE VENTA/DESPACHO </span> <br />
        <span class="EstPlantillaTituloCodigo"> <?php echo $InsVentaDirecta->VdiId;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="20%" align="left" valign="top" class="EstCotizacionProductoImprimirEtiquetaFondo"><?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirEtiqueta">Seguro:</span>
        <?php
}
?></td>
      <td width="4%" align="left" valign="top" class="EstCotizacionProductoImprimirTabla" ><?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirEtiqueta">:</span>
        <?php
}
?></td>
      <td width="26%" align="left" valign="top" class="EstCotizacionProductoImprimirTabla" >
        
        <?php
if(!empty($InsCotizacionProducto->CliIdSeguro)){
?>
        <span class="EstVentaDirectaImprimirContenido"><?php echo $InsCotizacionProducto->CliNombreSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoPaternoSeguro;?> <?php echo $InsCotizacionProducto->CliApellidoMaternoSeguro;?> </span>
        <?php
}
?></td>
      <td width="17%" align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Fecha </span></td>
      <td width="1%" align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td width="31%" align="left" valign="top" ><span class="EstVentaDirectaImprimirFecha"><?php echo $InsVentaDirecta->VdiFecha;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Cliente</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirCliente">
        
        <?php echo $InsVentaDirecta->CliNombre;?>
        <?php echo $InsVentaDirecta->CliApellidoPaterno;?>
        <?php echo $InsVentaDirecta->CliApellidoMaterno;?>
        </span>
        
        
        
        </td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">MARCA </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta">:</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiMarca;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">MODELO </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiModelo;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
    <tr>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">PLACA </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->VdiPlaca;?></span></td>
      <td align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">VIN </span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirEtiqueta"> :</span></td>
      <td align="left" valign="top" ><span class="EstVentaDirectaImprimirContenido"><?php echo $InsVentaDirecta->EinVIN;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      </tr>
  </table></td>
  </tr>
</table>





<?php
if($InsVentaDirecta->VdiRepuesto == "Si"){
?> 

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">


	<tr>
		
      <td width="98%" colspan="2" valign="top"><span class="EstVentaDirectaImprimirCabecera">Repuestos</span></td>
  </tr>
<tr>
  <td colspan="2" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstVentaDirectaImprimirTabla">
    <thead class="EstVentaDirectaImprimirTablaHead">
      <tr>
        <th width="3%" align="center" >#</th>
        <?php
		if($GET_ImprimirCodigo==1){
		?>
        <th width="7%" align="center" >Cod. Original</th>
        <?php
		}
		?>
        <th width="8%" align="center" >Cantidad</th>
        
        <th width="32%" align="center" > Nombre </th>
        <th width="37%" align="center" >STOCK</th>
        <th width="8%" align="center" >UBICACION</th>
        <th width="5%" align="center" >&nbsp;</th>
        </tr>
      </thead>
    <tbody class="EstVentaDirectaImprimirTablaBody">
      <?php
	
	$TotalRepuesto = 0;
	$i=1;
	if(!empty($InsVentaDirecta->VentaDirectaDetalle)){
		foreach($InsVentaDirecta->VentaDirectaDetalle as $DatVentaDirectaDetalle){

			if($DatVentaDirectaDetalle->VddEstado == 1){
				
		
				if($InsVentaDirecta->MonId<>$EmpresaMonedaId ){
					
					$DatVentaDirectaDetalle->VddPrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto / $InsVentaDirecta->VdiTipoCambio);
					
					$DatVentaDirectaDetalle->VddPrecioVenta = ($DatVentaDirectaDetalle->VddPrecioVenta / $InsVentaDirecta->VdiTipoCambio);
					$DatVentaDirectaDetalle->VddImporte = ($DatVentaDirectaDetalle->VddImporte / $InsVentaDirecta->VdiTipoCambio);
					
				}
				
				
				
				if(!empty($InsVentaDirecta->VdiPorcentajeDescuento)){
					
					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio * $DatVentaDirectaDetalle->VddCantidad);
						
					$DetallePrecioDescuento =  $DetallePrecio - ($DetallePrecio * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
					
					$DetalleDescuento = ($DetalleImporte * ($InsVentaDirecta->VdiPorcentajeDescuento/100));
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
				
				}else{
				
					$DetallePrecioBruto = ($DatVentaDirectaDetalle->VddPrecioBruto);
					$DetallePrecio = $DetallePrecioBruto;
					$DetalleImporte = ($DetallePrecio *  $DatVentaDirectaDetalle->VddCantidad);
					
					$DetallePrecioDescuento =  $DetallePrecio;
					
					$DetalleDescuento = 0;
					$DetalleImporteFinal = $DetalleImporte - $DetalleDescuento;
				
				}
				
				
		?>
      <tr>
        <td align="center" valign="top" class="EstVentaDirectaDetalleImprimirContenido"><?php echo $i;?></td>
        
        <?php
				if($GET_ImprimirCodigo==1){
				?>
        <td align="right" valign="top" class="EstVentaDirectaDetalleImprimirContenido" >
          
          <?php echo $DatVentaDirectaDetalle->ProCodigoOriginal;?>
          
          </td>
        
        
        <?php
				}
				?>
        <td align="right" valign="top" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo number_format($DatVentaDirectaDetalle->VddCantidad,2);?></td>
        
        
        
        <td align="left" valign="top" class="EstVentaDirectaDetalleImprimirContenido" ><?php //echo $DatVentaDirectaDetalle->ProNombre;?>
          <?php echo $DatVentaDirectaDetalle->ProNombre;?></td>
        <td align="right" valign="top" class="EstVentaDirectaDetalleImprimirContenido" ><table width="100%" class="EstVentaDirectaImprimirTabla2">
          <thead class="EstVentaDirectaImprimirTablaHead2">
            <tr>
              <?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
              <th width="80" align="center" valign="top"><?php echo $DatAlmacen->AlmNombre;?></th>
              <?php		
				}
			}
			?>
              </tr>
            </thead>
          <tbody class="EstVentaDirectaImprimirTablaBody2">
            <tr>
              <?php
			if(!empty($ArrAlmacenes)){
				foreach($ArrAlmacenes as $DatAlmacen){
			?>
              <td width="50" align="left" valign="top"><?php
 $InsAlmacenStock = new ClsAlmacenStock();
//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false)
 $ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"ProId","ASC",1,"1",NULL,date("Y")."-01-01",date("Y-m-d"),NULL,NULL,NULL,$DatVentaDirectaDetalle->ProId,NULL,$DatAlmacen->AlmId,false);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

 ?>
                <?php
 $Stock = 0;
 if(!empty($ArrAlmacenStocks)){
	 foreach($ArrAlmacenStocks as $DatAlmacenStock){
		 $Stock = $DatAlmacenStock->AstStockReal;
	 }
 }
 ?>
                <?php
 	echo number_format($Stock,2);
 ?></td>
              <?php		
				}
			}
			?>
              </tr>
            </tbody>
          </table></td>
        <td align="right" valign="top" class="EstVentaDirectaDetalleImprimirContenido" ><?php echo ($DatVentaDirectaDetalle->ProUbicacion);?></td>
        <td align="right" valign="top" class="EstVentaDirectaDetalleImprimirContenido" >[ &nbsp;&nbsp;&nbsp;]</td>
        </tr>
      <?php	
		
					//$TotalRepuesto += $DatVentaDirectaDetalle->VddImporte;
					
					$TotalRepuesto += $DetalleImporteFinal;
					$TotalDescuento += $DetalleDescuento;
					
				$i++;
				
				
			}
	

			
		}
		
		
	} 
?>
      
      <?php
	
	
	


	


?>
      </tbody>
  </table></td>
  </tr>

  <?php
  if($InsVentaDirecta->VdiPintado=="Si" or $InsVentaDirecta->VdiPlanchado == "Si" or $InsVentaDirecta->VdiCentrado == "Si" or $InsVentaDirecta->VdiTarea == "Si" or (!empty($InsVentaDirecta->VdiManoObra) and $InsVentaDirecta->VdiManoObra <> "0.00")){
	?>
  <?php
  }
  ?>
  

</table>

<?php
}
?>





 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstVentaDirectaImprimirTabla">

  <tr>
    <td width="196%" colspan="2">
      
      <table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstVentaDirectaImprimirTabla">
        <tr>
          <td width="10%" align="left" valign="top" class="EstVentaDirectaImprimirEtiquetaFondo"><span class="EstVentaDirectaImprimirEtiqueta">Observacion:</span></td>
          <td colspan="4" align="left" valign="top" ><span class="EstVentaDirectaImprimirObservacion"><?php echo $InsVentaDirecta->VdiObservacionImpresa;?></span></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
    </table></td>
    </tr>
</table>



</body>
</html>


