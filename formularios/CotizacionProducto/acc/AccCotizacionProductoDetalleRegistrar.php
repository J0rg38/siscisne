<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta  = '../../../';

////CONFIGURACIONES GENERALES
require_once($InsProyecto->MtdRutConfiguraciones().'CnfSistema.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfEmpresa.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfConexion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfNotificacion.php');
require_once($InsProyecto->MtdRutConfiguraciones().'CnfFormularioNota.php');
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

$Identificador = $_POST['Identificador'];

session_start();
if (!isset($_SESSION['InsCotizacionProductoDetalle'.$Identificador])){
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador] = new ClsSesionObjeto();	
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');

require_once($InsPoo->MtdPaqLogistica().'ClsCotizacionProductoDetalle.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;

}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
	
	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

/*$Cantidad = round($_POST['ProductoCantidad'],3);
$Importe = round($_POST['ProductoImporte'],3);
$Costo = round($_POST['ProductoCosto'],3);
$Costo = round($_POST['ProductoValorVenta'],3);
*/
$POST_PorcentajeDescuento = (empty($_POST['DescuentoPorcentaje'])?0:$_POST['DescuentoPorcentaje']);
$CotizacionProductoDetalleTipoPedido = ($_POST['CotizacionProductoDetalleTipoPedido']);

$CotizacionProductoDetallePorcentajeUtilidad = (empty($_POST['CotizacionProductoDetallePorcentajeUtilidad'])?0:$_POST['CotizacionProductoDetallePorcentajeUtilidad']);
$CotizacionProductoDetallePorcentajeOtroCosto = (empty($_POST['CotizacionProductoDetallePorcentajeOtroCosto'])?0:$_POST['CotizacionProductoDetallePorcentajeOtroCosto']);
$CotizacionProductoDetallePorcentajeManoObra = (empty($_POST['CotizacionProductoDetallePorcentajeManoObra'])?0:$_POST['CotizacionProductoDetallePorcentajeManoObra']);
$CotizacionProductoDetallePorcentajePedido = (empty($_POST['CotizacionProductoDetallePorcentajePedido'])?0:$_POST['CotizacionProductoDetallePorcentajePedido']);

$CotizacionProductoDetallePorcentajeAdicional = (empty($_POST['CotizacionProductoDetallePorcentajeAdicional'])?0:$_POST['CotizacionProductoDetallePorcentajeAdicional']);
$CotizacionProductoDetallePorcentajeDescuento = (empty($_POST['CotizacionProductoDetallePorcentajeDescuento'])?0:$_POST['CotizacionProductoDetallePorcentajeDescuento']);

$CotizacionProductoDetalleValorVenta = (empty($_POST['CotizacionProductoDetalleValorVenta'])?0:$_POST['CotizacionProductoDetalleValorVenta']);
$CotizacionProductoDetalleDescuento = (empty($_POST['CotizacionProductoDetalleDescuento'])?0:$_POST['CotizacionProductoDetalleDescuento']);
$CotizacionProductoDetalleAdicional = (empty($_POST['CotizacionProductoDetalleAdicional'])?0:$_POST['CotizacionProductoDetalleAdicional']);
//$CotizacionProductoDetalleCosto = (empty($_POST['CotizacionProductoDetalleCosto'])?0:$_POST['CotizacionProductoDetalleCosto']);

$Cantidad = round($_POST['ProductoCantidad'],6);
$Importe = round($_POST['ProductoImporte'],6);
$Costo = round($_POST['ProductoCosto'],6);
//$ValorVenta = round($_POST['ProductoValorVenta'],6);

$Precio = round(($Importe/$Cantidad),6);
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
$Estado = $_POST['ProductoEstado'];

$MonedaId = $_POST['MonedaId'];
$TipoCambio = $_POST['TipoCambio'];
$ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];

	$PrecioBruto = 0;
	$ImporteBruto = 0;
	$DescuentoTotal = 0;
	$AdicionalTotal = 0;
	
	$PrecioBruto  = $Precio + $CotizacionProductoDetalleDescuento - $CotizacionProductoDetalleAdicional;	
	$DescuentoTotal = $CotizacionProductoDetalleDescuento * $Cantidad;
	$AdicionalTotal = $CotizacionProductoDetalleAdicional * $Cantidad;
	$ImporteBruto = $PrecioBruto * $Cantidad;
	
		
//						SesionObjeto-CotizacionProductoDetalle
//						Parametro1 = CpdId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = CrdPrecio
//						Parametro5 = CrdCantidad
//						Parametro6 = CrdImporte
//						Parametro7 = CrdTiempoCreacion
//						Parametro8 = CrdTiempoModificacion

//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = AmdCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo

//						Parametro15 = AmdPrecioVenta
//						Parametro16 = CrdDescripcion
//						Parametro17 = CrdCodigo
//						Parametro18 = CrdValorVenta

//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

//						Parametro25 = CrdPorcentajeUtilidad
//						Parametro26 = CrdPorcentajeOtroCosto
//						Parametro27 = CrdPorcentajeManoObra
//						Parametro28 = CrdPorcentajePedido

//						Parametro29 = CrdPorcentajeAdicional
//						Parametro30 = CrdPorcentajeDescuento
//						Parametro31 = CrdAdicional
//						Parametro32 = CrdDescuentoUnitario
//						Parametro33 = CrdImporteBruto
//						Parametro34 = CrdAdicionalUnitario

	
	$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$InsProducto->ProId,
	$InsProducto->ProNombre,
	$Precio,
	$Cantidad,
	$Importe,
	(date("d/m/Y H:i:s")),
	(date("d/m/Y H:i:s")),
	
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsProducto->RtiId,
	$CantidadReal,
	
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	0,
	"",
	"",
	$CotizacionProductoDetalleValorVenta,
	$ProductoUnidadMedida,
	$Costo,
	3,//$Estado,
	$CotizacionProductoDetalleTipoPedido,	
	$DescuentoTotal,
	
	$PrecioBruto,
	
	$CotizacionProductoDetallePorcentajeUtilidad,
	$CotizacionProductoDetallePorcentajeOtroCosto,
	$CotizacionProductoDetallePorcentajeManoObra,
	$CotizacionProductoDetallePorcentajePedido,
	
	$CotizacionProductoDetallePorcentajeAdicional,
	$CotizacionProductoDetallePorcentajeDescuento,
	
	$AdicionalTotal,
	$CotizacionProductoDetalleDescuento,
	$ImporteBruto,
	$CotizacionProductoDetalleAdicional);
			
?>