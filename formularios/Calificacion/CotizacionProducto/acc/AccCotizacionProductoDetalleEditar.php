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

$POST_PorcentajeDescuento = $_POST['PorcentajeDescuento'];
$CotizacionProductoDetalleTipoPedido = ($_POST['CotizacionProductoDetalleTipoPedido']);

$Cantidad = round($_POST['ProductoCantidad'],6);
$Importe = round($_POST['ProductoImporte'],6);
$Costo = round($_POST['ProductoCosto'],6);
$ValorVenta = round($_POST['ProductoValorVenta'],6);

$Precio = round(($Importe/$Cantidad),6);
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
$Estado = $_POST['ProductoEstado'];

$MonedaId = $_POST['MonedaId'];
$TipoCambio = $_POST['TipoCambio'];
$ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];
	
$InsCotizacionProductoDetalle1 = array();
$InsCotizacionProductoDetalle1 = $_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	

		
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
//						Parametro16 = 
//						Parametro17 = 
//						Parametro18 = CrdValorVenta
//						Parametro19 = UmeIdOrigen
//						Parametro20 = CrdCosto
//						Parametro21 = CrdEstado
//						Parametro22 = CrdTipoPedido
//						Parametro23 = CrdDescuento
//						Parametro24 = CrdPrecioBruto

	$_SESSION['InsCotizacionProductoDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsCotizacionProductoDetalle1->Parametro1,
	$InsCotizacionProductoDetalle1->Parametro2,
	$InsCotizacionProductoDetalle1->Parametro3,
	$Precio,
	$Cantidad,
	$Importe,
	$InsCotizacionProductoDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsCotizacionProductoDetalle1->Parametro11,
	$CantidadReal,
	$InsCotizacionProductoDetalle1->Parametro13,
	$InsCotizacionProductoDetalle1->Parametro14,
	$InsCotizacionProductoDetalle1->Parametro15,
	NULL,
	NULL,
	$ValorVenta,
	$InsCotizacionProductoDetalle1->Parametro19,
	$InsCotizacionProductoDetalle1->Parametro20,
	$Estado,
	$CotizacionProductoDetalleTipoPedido,
	0,
	$Precio
	);


?>