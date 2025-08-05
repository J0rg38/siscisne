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

$POST_ProductoId = $_POST['ProductId'];
$POST_ProductoNombre = $_POST['ProductoNombre'];
$POST_ProductoCodigoOriginal = $_POST['ProductoCodigoOriginal'];

$POST_ProductoUnidadMedida = $_POST['CmpProductoUnidadMedida'];
$POST_ProductoUnidadMedidaConvertir = $_POST['ProductoUnidadMedidaConvertir'];
$POST_NotaCreditoCompraDetallePrecio = $_POST['NotaCreditoCompraDetallePrecio'];
$POST_NotaCreditoCompraDetalleCantidad = $_POST['NotaCreditoCompraDetalleCantidad'];
$POST_NotaCreditoCompraDetalleImporte = $_POST['NotaCreditoCompraDetalleImporte'];
$POST_NotaCreditoCompraDetalleEstado = $_POST['NotaCreditoCompraDetalleEstado'];

session_start();
if (!isset($_SESSION['InsNotaCreditoCompraDetalle'.$Identificador])){
	$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
}



require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoAno.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsListaPrecio.php');
//require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCosto.php');

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





//SesionObjeto-NotaCreditoCompraDetalleListado
//Parametro1 = NodId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = NodPrecio
//Parametro5 = NodCantidad
//Parametro6 = NodImporte
//Parametro7 = NodTiempoCreacion
//Parametro8 = NodTiempoModificacion
//Parametro9 = AmdId
//Parametro10 = AmoId
//Parametro11 = ProNombre
//Parametro12 = ProCodigoOriginal
//Parametro13 = UmeNombre
//Parametro14 = RtiId
//Parametro15 = UmeIdOrigen
//Parametro16 = NodEstado
//Parametro17 = NodCantidadReal

$InsNotaCreditoCompraDetalle1 = array();
$InsNotaCreditoCompraDetalle1 = $_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$Cantidad = round($POST_NotaCreditoCompraDetalleCantidad,2);
$Importe = round($POST_NotaCreditoCompraDetalleImporte,2);
$Precio = round(($Importe/$Cantidad),2);
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,3);
	
$_SESSION['InsNotaCreditoCompraDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsNotaCreditoCompraDetalle1->Parametro1,
$InsNotaCreditoCompraDetalle1->Parametro2,
$InsNotaCreditoCompraDetalle1->Parametro3,
$Precio,
$Cantidad,
$Importe,
$InsNotaCreditoCompraDetalle1->Parametro7,
date("d/m/Y H:i:s"),
$InsNotaCreditoCompraDetalle1->Parametro9,
$InsNotaCreditoCompraDetalle1->Parametro10,
$InsNotaCreditoCompraDetalle1->Parametro11,
$InsNotaCreditoCompraDetalle1->Parametro12,
$InsNotaCreditoCompraDetalle1->Parametro13,
$InsNotaCreditoCompraDetalle1->Parametro14,
$InsNotaCreditoCompraDetalle1->Parametro15,
$POST_NotaCreditoCompraDetalleEstado,
$CantidadReal

);

?>