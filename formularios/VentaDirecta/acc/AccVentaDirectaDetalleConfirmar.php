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

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

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

if(empty($InsUnidadMedidaConversion->UmcEquivalente)){
	$GuardarDetalle = false;
}

if($GuardarDetalle){
	
//						SesionObjeto-VentaDirectaDetalle
//						Parametro1 = VddId
//						Parametro2 = ProId
//						Parametro3 = ProNombre
//						Parametro4 = VddPrecioVenta
//						Parametro5 = VddCantidad
//						Parametro6 = VddImporte
//						Parametro7 = VddTiempoCreacion
//						Parametro8 = VddTiempoModificacion
//						Parametro9 = UmeNombre
//						Parametro10 = UmeId
//						Parametro11 = RtiId
//						Parametro12 = VddCantidadReal
//						Parametro13 = ProCodigoOriginal
//						Parametro14 = ProCodigoAlternativo
//						Parametro15 = UmeIdOrigen
//						Parametro16 = VerificarStock
//						Parametro17 = VddCosto
//						Parametro18 = ProStock
//						Parametro19 = ProStockReal
//						Parametro20 = VddCantidadPedir
//						Parametro21 = VddCantidadPedirFecha
//						Parametro22 = CrdId
//						Parametro23 = VddNuevo
//						Parametro24 = VddCantidadLlegada
//						Parametro25 = AmdCantidad
//						Parametro26 = VddEstado

	$InsVentaDirectaDetalle1 = array();
	$InsVentaDirectaDetalle1 = $_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$Cantidad = round($_POST['ProductoCantidad'],3);
	$Importe = round($_POST['ProductoImporte'],2);
	$Precio = round(($Importe/$Cantidad),2);		
	$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
	$VentaDirectaDetalleEstado = ($_POST['VentaDirectaDetalleEstado']);

	//if(($InsProducto->ProStockReal + $InsVentaDirectaDetalle1->Parametro12)<$CantidadReal){
	//if(($InsProducto->ProStock + $InsVentaDirectaDetalle1->Parametro5)<$Cantidad){
	if($InsProducto->ProStockReal < $CantidadReal){
		$VerificarStock = 1;
	}
	
	$CantidadPedirFecha = NULL;
	$CantidadPedir = 0;
	
	$_SESSION['InsVentaDirectaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsVentaDirectaDetalle1->Parametro1,
	$InsVentaDirectaDetalle1->Parametro2,
	$InsVentaDirectaDetalle1->Parametro3,
	$Precio,
	$Cantidad,
	$Importe,
	$InsVentaDirectaDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsVentaDirectaDetalle1->Parametro11,
	$CantidadReal,
	$InsVentaDirectaDetalle1->Parametro13,
	$InsVentaDirectaDetalle1->Parametro14,
	$InsVentaDirectaDetalle1->Parametro15,
	$VerificarStock,
	$InsVentaDirectaDetalle1->Parametro17,
	$InsProducto->ProStock,
	$InsProducto->ProStockReal,
	$CantidadPedir,
	$CantidadPedirFecha,
	$InsVentaDirectaDetalle1->Parametro22,
	NULL,
	NULL,
	NULL,
	$VentaDirectaDetalleEstado
	);

}
?>