<?php
require_once('../../../proyecto/ClsProyecto.php');
require_once('../../../proyecto/ClsPoo.php');

$InsProyecto->Ruta = '../../../';
$InsPoo->Ruta = '../../../';

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
if (!isset($_SESSION['InsVentaDirectaDetalle'.$Identificador])){
	$_SESSION['InsVentaDirectaDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

$InsProducto = new ClsProducto();
$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedidaConversion = new ClsUnidadMedidaConversion();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$GuardarDetalle = true;
$VerificarStock = 2;

if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
	$InsUnidadMedidaConversion->UmcEquivalente = 1;
}else{
	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];

	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
	}
}

//if(empty($InsUnidadMedidaConversion->UmcEquivalente)){
//	$GuardarDetalle = false;
//}

//if($GuardarDetalle){


$POST_PorcentajeDescuento = (empty($_POST['DescuentoPorcentaje'])?0:$_POST['DescuentoPorcentaje']);
$VentaDirectaDetalleTipoPedido = ($_POST['VentaDirectaDetalleTipoPedido']);

$VentaDirectaDetallePorcentajeUtilidad = (empty($_POST['VentaDirectaDetallePorcentajeUtilidad'])?0:$_POST['VentaDirectaDetallePorcentajeUtilidad']);
$VentaDirectaDetallePorcentajeOtroCosto = (empty($_POST['VentaDirectaDetallePorcentajeOtroCosto'])?0:$_POST['VentaDirectaDetallePorcentajeOtroCosto']);
$VentaDirectaDetallePorcentajeManoObra = (empty($_POST['VentaDirectaDetallePorcentajeManoObra'])?0:$_POST['VentaDirectaDetallePorcentajeManoObra']);
$VentaDirectaDetallePorcentajePedido = (empty($_POST['VentaDirectaDetallePorcentajePedido'])?0:$_POST['VentaDirectaDetallePorcentajePedido']);

$VentaDirectaDetallePorcentajeAdicional = (empty($_POST['VentaDirectaDetallePorcentajeAdicional'])?0:$_POST['VentaDirectaDetallePorcentajeAdicional']);
$VentaDirectaDetallePorcentajeDescuento = (empty($_POST['VentaDirectaDetallePorcentajeDescuento'])?0:$_POST['VentaDirectaDetallePorcentajeDescuento']);

$VentaDirectaDetalleValorVenta = (empty($_POST['VentaDirectaDetalleValorVenta'])?0:$_POST['VentaDirectaDetalleValorVenta']);
$VentaDirectaDetalleDescuento = (empty($_POST['VentaDirectaDetalleDescuento'])?0:$_POST['VentaDirectaDetalleDescuento']);
$VentaDirectaDetalleAdicional = (empty($_POST['VentaDirectaDetalleAdicional'])?0:$_POST['VentaDirectaDetalleAdicional']);

$VentaDirectaDetalleEstado = ($_POST['VentaDirectaDetalleEstado']);
$VentaDirectaDetalleTipoPedido = ($_POST['VentaDirectaDetalleTipoPedido']);


$Cantidad = round($_POST['ProductoCantidad'],6);
$Importe = round($_POST['ProductoImporte'],6);
$Costo = round($_POST['ProductoCosto'],6);
//

$Precio = round(($Importe/$Cantidad),6);
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
$Estado = $_POST['ProductoEstado'];

$MonedaId = $_POST['MonedaId'];
$TipoCambio = $_POST['TipoCambio'];
$ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];


	//if($InsProducto->ProStockReal < $CantidadReal){		
//		$VerificarStock = 1;
//	}

	$CantidadPedirFecha = NULL;
	$CantidadPedir = 0;

	$PrecioBruto = 0;
	$ImporteBruto = 0;
	$DescuentoTotal = 0;
	$AdicionalTotal = 0;
	
	$PrecioBruto  = $Precio + ($VentaDirectaDetalleDescuento) - ($VentaDirectaDetalleAdicional);	
	$DescuentoTotal = $VentaDirectaDetalleDescuento * $Cantidad;
	$AdicionalTotal = $VentaDirectaDetalleAdicional * $Cantidad;
	$ImporteBruto = $PrecioBruto * $Cantidad;

/*


SesionObjeto-VentaDirectaDetalle
Parametro1 = VddId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = VddPrecioVenta
Parametro5 = VddCantidad
Parametro6 = VddImporte
Parametro7 = VddTiempoCreacion
Parametro8 = VddTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = VddCantidadReal
Parametro13 = ProCodigoOriginal
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = VddCosto
Parametro18 = ProStock
Parametro19 = ProStockReal
Parametro20 = VddCantidadPedir
Parametro21 = VddCantidadPedirFecha
Parametro22 = VddId
Parametro23 = VddNuevo
Parametro24 = VddCantidadPorLlegar
Parametro25 = AmdCantidad
Parametro26 = VddEstado
Parametro27 = VdiId

Parametro28 = VddRemplazo
Parametro29 = ProIdPedido
Parametro30 = ProCodigoOriginalPedido

Parametro31 = PcdBOFecha
Parametro32 = PcdBOEstado
Parametro33 = VddFechaPorLlegar
Parametro34 = AmdEstado
Parametro35 = VddTipoPedido

Parametro36 = VddPrecioBruto

Parametro37 = VddValorVenta
Parametro38 = VddDescuento
Parametro39 = VddPorcentajeUtilidad
Parametro40 = VddPorcentajeOtroCosto
Parametro41 = VddPorcentajeManoObra
Parametro42 = VddPorcentajePedido

Parametro43 = VddPorcentajeAdicional
Parametro44 = VddPorcentajeDescuento
Parametro45 = VddAdicional
Parametro46 = VddDescuentoUnitario
Parametro47 = VddImporteBruto
Parametro48 = VddAdicionalUnitario

*/
	$_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$InsProducto->ProId,
	($InsProducto->ProNombre),
	$Precio,
	$Cantidad,
	$Importe,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsProducto->RtiId,
	$CantidadReal,
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	$_POST['ProductoUnidadMedida'],
	$VerificarStock,
	$Costo,
	$InsProducto->ProStock,
	$InsProducto->ProStockReal,
	$CantidadPedir,
	$CantidadPedirFecha,
	NULL,
	NULL,
	NULL,
	NULL,
	1,//$Estado,$VentaDirectaDetalleEstado,
	
	NULL,
	NULL,
	NULL,
	NULL,
	
	NULL,
	NULL,
	NULL,
	NULL,
	$VentaDirectaDetalleTipoPedido,//35
	$PrecioBruto,
	$VentaDirectaDetalleValorVenta,
	$DescuentoTotal,
	
	$VentaDirectaDetallePorcentajeUtilidad,
	$VentaDirectaDetallePorcentajeOtroCosto,
	$VentaDirectaDetallePorcentajeManoObra,
	$VentaDirectaDetallePorcentajePedido,
	
	$VentaDirectaDetallePorcentajeAdicional,
	$VentaDirectaDetallePorcentajeDescuento,
	
	$AdicionalTotal,
	$VentaDirectaDetalleDescuento,
	$ImporteBruto,
	$VentaDirectaDetalleAdicionalTotaldicional
	);

	
	
//}else{
	
//}
?>