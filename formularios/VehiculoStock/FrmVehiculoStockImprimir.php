<?php
session_start();
require_once('../../proyecto/ClsProyecto.php');
require_once('../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../';
$InsPoo->Ruta = '../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
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
$GET_Almacen = $_GET['AlmId'];
$GET_Sucursal = $_GET['SucId'];
$GET_Ano = $_GET['Ano'];

require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenStock.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoEntradaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacenMovimientoSalidaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsVentaConcretadaDetalle.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsAlmacen.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsKardex.php');
require_once($InsPoo->MtdPaqEmpresa().'ClsSucursal.php');

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();

$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
$InsVentaConcretadaDetalle = new ClsVentaConcretadaDetalle();




$InsAlmacenStock = new ClsAlmacenStock();
$InsAlmacen = new ClsAlmacen();

$InsAlmacenStock = new ClsAlmacenStock();
$InsKardex = new ClsKardex();

$InsSucursal = new ClsSucursal();


$InsAlmacenStock->ProId = $GET_id;
$InsAlmacenStock->MtdObtenerAlmacenStock();

$RepAlmacen = $InsAlmacen->MtdObtenerAlmacenes(NULL,NULL,"SucNombre","ASC",NULL,$GET_Sucursal);
$ArrAlmacenes = $RepAlmacen['Datos'];



$InsAlmacen->AlmId = $GET_Almacen;
$InsAlmacen->MtdObtenerAlmacen();

$InsSucursal->SucId = $GET_Sucursal;
$InsSucursal->MtdObtenerSucursal();

if(!empty($GET_Almacen)){
		
}else{
	$stipo = "1,2";
}


$Sucursal = "";

if(empty($InsAlmacen->SucId)){
	$Sucursal = $_SESSION['SesionSucursal'];
}else{
	$Sucursal = $InsAlmacen->SucId;
}


//MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL) {

//$ResAlmacenMovimientoEntradaDetalle = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,NULL,NULL,3,$POST_ProductoId,$GET_Ano."-01-01",$GET_Ano."-12-31",$GET_Almacen);
$ResAlmacenMovimientoEntradaDetalle = $InsKardex->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',1,NULL,NULL,3,$InsAlmacenStock->ProId,$GET_Ano."-01-01",$GET_Ano."-12-31",NULL,0,NULL,NULL,NULL,$GET_Almacen,$stipo ,$Sucursal);
$ArrAlmacenMovimientoEntradaDetalles = $ResAlmacenMovimientoEntradaDetalle['Datos'];






/*
ENTRADAS
1 - ALMACEN MOVIMIENTO ENTRADA / compras
2 - otros ingresos
6 - TRASLADO ALMACEN
7 - CONVERSION
SALIDAS
1 - ALMACEN MOVIMIENTO SALIDA
2 - TALLER PEDIDO
3 - VENTA CONCRETADA
6 - TRASLADO ALMACEN
7 - CONVERSION
8 - TRANSFERENCIA SALIDA

*/

//deb($GET_Almacen);

if(!empty($GET_Almacen)){
//	$stipo = "1,2,3,6,7,8";		
}else{
	$stipo = "1,2,3,7";
}

/// MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL) 

//MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL)
$ResAlmacenMovimientoSalidaDetalle = $InsKardex->MtdObtenerAlmacenMovimientoSalidaDetalles(NULL,NULL,NULL,'AmoFecha','ASC',NULL,NULL,3,$InsAlmacenStock->ProId,NULL,NULL,NULL,$GET_Ano."-01-01",$GET_Ano."-12-31",$GET_Almacen,$stipo,$Sucursal);
$ArrAlmacenMovimientoSalidaDetalles = $ResAlmacenMovimientoSalidaDetalle['Datos'];





//MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) 
$ResAlmacenStock = $InsAlmacenStock->MtdObtenerAlmacenStocks(NULL,NULL,NULL,"AstStock","DESC",NULL,"1",NULL,$GET_Ano."-01-01",date("Y-m-d"),NULL,NULL,NULL,$InsAlmacenStock->ProId,NULL,NULL,false,$GET_Sucursal,$GET_Ano);
$ArrAlmacenStocks = $ResAlmacenStock['Datos'];

$StockReal = 0;

if(!empty($ArrAlmacenStocks)){
	foreach($ArrAlmacenStocks as $DatAlmacenStock){
		$StockReal = $DatAlmacenStock->AstStockReal;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stock</title>

<link rel="stylesheet" type="text/css" href="<?php echo $InsProyecto->MtdRutEstilos();?>CssReporte.css">
<link href="css/CssAlmacenStockImprimir.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/JsAlmacenStockImprimir.js"></script>
<script type="text/javascript" src="<?php echo $InsProyecto->MtdRutLibrerias();?>jquery-1.4.3.min.js"></script>

<script type="text/javascript">
$().ready(function() {
	
<?php if($_GET['P']==1 and !empty($InsAlmacenStock->ProId)){?> 
FncAlmacenStockImprimir(); 
<?php }?>

<?php if($_GET['P']==1){?>
setTimeout("window.close();",1500);
<?php }?>
	
});
</script>


</head>
<body>

<?php
if ($_GET['P'] <> 1) {
?>

<form method="get" enctype="multipart/form-data" action="#">



	<input type="hidden" name="Id" id="Id" value="<?php   echo $GET_id;?>" />
	<input type="hidden" name="P" id="P" value="1" />
    <input type="hidden" name="AlmId" id="AlmId" value="<?php echo $GET_Almacen;?>" />
    <input type="hidden" name="SucId" id="SucId" value="<?php echo $GET_Sucursal;?>" />
    <input type="hidden" name="Ano" id="Ano" value="<?php echo $GET_Ano;?>" />
    
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

<table cellpadding="0" cellspacing="0" width="100%" border="0">
<tr>
  <td colspan="3" align="left" valign="top"><span class="EstReporteCabecera"><?php echo $EmpresaNombre;?> - <?php echo $EmpresaCodigo;?></span></td>
  </tr>
<tr>
  <td width="20%" align="left" valign="top"><img src="../../imagenes/logos/logo_impresion.png" width="150" alt="Logo" title="Logo" border="0" />
        
        </td>
  <td width="52%" align="center" valign="top"><span class="EstReporteTitulo">MOVIMIENTOS DE STOCK
  <br /><?php echo $InsAlmacenStock->AstId;?></span></td>
  <td width="28%" align="right" valign="top">
    <span class="EstReporteDatosImpresion"><?php echo date("d/m/Y");?> <?php echo date("H:i:s");?> <?php echo date("a");?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SisSucNombre'];?></span> <br />
    <span class="EstReporteDatosImpresion"><?php echo $_SESSION['SesionUsuario'];?></span></td>
</tr>
</table>

<hr class="EstReporteLinea">





<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EstAlmacenStockImprimirTabla">

<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2" class="EstAlmacenStockImprimirTabla">
    <tr>
      <td colspan="5" align="left" valign="top"><span class="EstAlmacenStockImprimirCabecera">Datos del Producto y Stock</span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="16%" align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta"> Codigo Original:</span></td>
      <td width="30%" align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->AstFecha;?></span></td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="16%" align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Sucursal:</span></td>
      <td width="35%" align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"> <?php echo $InsSucursal->SucNombre;?> </span></td>
      <td width="2%" align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Nombre:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->ProNombre;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Referencia:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->ProReferencia;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">U.M.:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"> <?php echo $InsAlmacenStock->UmeNombre;?>
        
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Prom. Mensual:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->ProPromedioMensua;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Dias Inmovilizados:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"> <?php echo $InsAlmacenStock->ProDiasInmovilizado;?>
        
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Fecha Ult. Salida:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->ProFechaUltimaSalida;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Almacen:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"> <?php echo $InsAlmacen->AlmNombre;?>
        
      </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Ubicacion:</span></td>
      <td align="left" valign="top" ><span class="EstAlmacenStockImprimirContenido"><?php echo $InsAlmacenStock->AstUbicacion;?></span></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiqueta">Año:</span></td>
      <td align="left" valign="top" >
        <span class="EstAlmacenStockImprimirContenido">
          
          <?php echo $GET_Ano;?>
          </span></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" class="EstAlmacenStockImprimirEtiquetaFondo">&nbsp;</td>
      <td align="left" valign="top" >&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
  
<tr>
  <td colspan="5" valign="top"><span class="EstAlmacenStockImprimirCabecera">Ingresos</span></td>
</tr>
<tr>
  <td colspan="5" valign="top"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenStockImprimirTabla">
    <thead class="EstAlmacenStockImprimirTablaHead">
      <tr>
        <th width="2%" align="center" >#</th>
        <th width="8%" align="center" > Codigo</th>
        <th width="9%" align="center" >Operacion</th>
        <th width="8%" align="center" >Fec. Ingreso</th>
        <th width="34%" align="center" > Proveedor</th>
        <th width="6%" align="center" >Num. Comprob.</th>
        <th width="6%" align="center" >Fec. Comprob.</th>
        <th width="6%" align="center" >Ord. Comp.</th>
        <th width="7%" align="center" >Cantidad</th>
        <th width="5%" align="center" >U.M.</th>
        <th width="6%" align="center" >Cantidad Base</th>
        <th width="3%" align="center" >U.M.</th>
        </tr>
    </thead>
    <tbody class="EstAlmacenStockImprimirTablaBody">
      <?php

 $i=1;
  $TotalIngresos = 0;
  $TotalIngresosReal = 0;
	if(is_array($ArrAlmacenMovimientoEntradaDetalles)){
		
		foreach($ArrAlmacenMovimientoEntradaDetalles as $DatAlmacenMovimientoEntradaDetalle){

			
			
?>
      <tr>
        <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" >
		
        
          
    
    <?php 
    switch($DatAlmacenMovimientoEntradaDetalle->AmoSubTipo){
        case "2":
  ?>
   <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
    	
  <?php  
        break;
        
		 case "6":
  ?>
   <?php echo $DatAlmacenMovimientoEntradaDetalle->TalId?>
   
  <?php  
        break;
		
		 case "7":
  ?>
    <?php echo $DatAlmacenMovimientoEntradaDetalle->PprId?>
  	
  <?php  
        break;
		
        default:
  ?>
    <?php echo $DatAlmacenMovimientoEntradaDetalle->AmoId?>
   
<?php	  
        break;
    }
?>

</td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->TopNombre?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoFecha?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->PrvNombreCompleto;?> <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoPaterno;?> <?php echo $DatAlmacenMovimientoEntradaDetalle->PrvApellidoMaterno;?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteNumero?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->AmoComprobanteFecha?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->OcoId?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatAlmacenMovimientoEntradaDetalle->AmdCantidad,2);?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombreEntrada?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal?></td>
        <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoEntradaDetalle->UmeNombre?></td>
        </tr>
      <?php	
		 $TotalIngresosReal += $DatAlmacenMovimientoEntradaDetalle->AmdCantidadReal;
  		$TotalIngresos += $DatAlmacenMovimientoEntradaDetalle->AmdCantidad;
 		 $i++;  
  
  
		}
	} 
	
	


?>
      </tbody>
  </table></td>
</tr>
<tr>
  <td colspan="5" valign="top"><table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
    <tbody class="EstTablaTotalBody">
      <tr>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right" class="EstAlmacenStockImprimirEtiquetaFondo">&nbsp;</td>
        <td align="right" class="EstAlmacenStockImprimirContenidoTotal">&nbsp;</td>
      </tr>
      <tr>
        <td width="21%" align="right">&nbsp;</td>
        <td width="39%" align="right">&nbsp;</td>
        <td width="18%" align="right" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiquetaTotal">Tota Ingresos:</span></td>
        <td width="22%" align="right" class="EstAlmacenStockImprimirContenidoTotal"> <?php echo number_format($TotalIngresosReal,2);?></td>
      </tr>
    </tbody>
  </table></td>
</tr>
<tr>
  <td colspan="5" valign="top"><span class="EstAlmacenStockImprimirCabecera">Egresos</span></td>
</tr>
<tr>
  <td colspan="5" valign="top">
    
    <table width="100%"  border="0" cellpadding="1" cellspacing="0" class="EstAlmacenStockImprimirTabla">
      <thead class="EstAlmacenStockImprimirTablaHead">
        
        <tr>
          <th width="2%" align="center" >#</th>
          <th width="8%" align="center" >
            
            Codigo</th>
          <th width="9%" align="center" >Operacion</th>
          <th width="7%" align="center" >Fecha Salida</th>
          <th width="28%" align="center" >
            Cliente
            
          </th>
          <th width="4%" align="center" >Ord. Ven.</th>
          <th width="5%" align="center" >Ord. Trab.</th>
          <th width="6%" align="center" >Modalidad</th>
          <th width="6%" align="center" >Num. Comprob.</th>
          <th width="6%" align="center" >Fec. Comprob.</th>
          <th width="5%" align="center" >Cantidad</th>
          <th width="4%" align="center" >U.M.</th>
          <th width="6%" align="center" >Cantidad Base</th>
          <th width="4%" align="center" >U.M.</th>
          </tr>
        
        
        </thead>
      <tbody class="EstAlmacenStockImprimirTablaBody">
        <?php

  $i=1;
			  $TotalSalidas = 0;
			  $TotalSalidasReal = 0;
			  
	if(is_array($ArrAlmacenMovimientoSalidaDetalles)){
		
		foreach($ArrAlmacenMovimientoSalidaDetalles as $DatAlmacenMovimientoSalidaDetalle){


			
			
?>
        
        
        <tr>
          <td align="right" class="EstReporteDetalleImprimirContenido"><?php echo $i;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
		  
          
			<?php 
			
		//deb($DatAlmacenMovimientoSalidaDetalle->AmoSubTipo);
					switch($DatAlmacenMovimientoSalidaDetalle->AmoSubTipo){
						case "4":
				  ?>
				<?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> 
					
				  <?php  
						break;
						
					 case "6":
  ?>
  <?php echo $DatAlmacenMovimientoSalidaDetalle->TalId;?>
  
  <?php  
        break;
		
		 case "7":
  ?>

    <?php echo $DatAlmacenMovimientoSalidaDetalle->PprId?>
   	
  <?php  
        break;
						
						default:
				  ?>
				  <?php echo $DatAlmacenMovimientoSalidaDetalle->AmoId?> 
					
					
				  <?php	  
						break;
					}
					
					 ;
					 
					 
					 ?>
					
                    
                    
            </td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->TopNombre?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFecha?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->CliNombre;?> <?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoPaterno;?> <?php echo $DatAlmacenMovimientoSalidaDetalle->CliApellidoMaterno;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->VdiId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->FinId;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->MinNombre;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFactura;?> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoleta;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdFacturaFechaEmision;?> <?php echo $DatAlmacenMovimientoSalidaDetalle->AmdBoletaFechaEmision;?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo number_format($DatAlmacenMovimientoSalidaDetalle->AmdCantidad,2);?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->UmeNombreSalida?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" ><?php echo $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal?></td>
          <td align="right" class="EstReporteDetalleImprimirContenido" >
            
            
            <?php echo ($DatAlmacenMovimientoSalidaDetalle->UmeNombre);?>
            
            </td>
          </tr>
        <?php	
		 $TotalSalidasReal += $DatAlmacenMovimientoSalidaDetalle->AmdCantidadReal;
				  $TotalSalidas += $DatAlmacenMovimientoSalidaDetalle->AmdCantidad;
				  $i++;  
		}
	} 
	
	

?>
        
        
        </tbody>
      </table>
    
    
    
    
    </td>
</tr>

 
  <tr>
  <td colspan="5">
  
  
  <table class="EstTablaTotal" width="100%" cellpadding="3" cellspacing="2" border="0">
<tbody class="EstTablaTotalBody">
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstAlmacenStockImprimirEtiquetaFondo">&nbsp;</td>
  <td align="right" class="EstAlmacenStockImprimirContenidoTotal">&nbsp;</td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiquetaTotal">Total Egresos:</span></td>
  <td align="right" class="EstAlmacenStockImprimirContenidoTotal"><?php echo number_format($TotalSalidasReal,2);?></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td align="right">&nbsp;</td>
  <td align="right" class="EstAlmacenStockImprimirEtiquetaFondo"><span class="EstAlmacenStockImprimirEtiquetaTotal">Saldo:</span></td>
  <td align="right" class="EstAlmacenStockImprimirContenidoTotal"><span class="EstAlmacenStockImprimirContenido"><?php echo number_format($StockReal,2);?></span></td>
</tr>
<tr>
  <td width="21%" align="right">&nbsp;</td>
  <td width="39%" align="right">&nbsp;</td>
  <td width="18%" align="right" class="EstAlmacenStockImprimirEtiquetaFondo">&nbsp;</td>
  <td width="22%" align="right" class="EstAlmacenStockImprimirContenidoTotal">&nbsp;</td>
</tr>
</tbody>
</table></td>
</tr>
</table>

</body>
</html>
