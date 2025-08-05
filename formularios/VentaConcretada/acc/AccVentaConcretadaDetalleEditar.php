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

session_start();
if (!isset($_SESSION['InsVentaConcretadaDetalle'.$Identificador])){
	$_SESSION['InsVentaConcretadaDetalle'.$Identificador] = new ClsSesionObjeto();
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

if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){
	

//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecio
//				Parametro5 = VcdCantidad
//				Parametro6 = VcdImporte
//				Parametro7 = VcdTiempoCreacion
//				Parametro8 = VcdTiempoModificacion
//				Parametro9 = UmeNombre
//				Parametro10 = UmeId
//				Parametro11 = RtiId
//				Parametro12 = VcdCantidadReal
//				Parametro13 = ProCodigoOriginal,
//				Parametro14 = ProCodigoAlternativo
//				Parametro15 = UmeIdOrigen
//				Parametro16 = VerificarStock
//				Parametro17 = VcdCosto
//				Parametro18 = VddId
//				Parametro19 = AmdReemplazo
//				Parametro20 = ProCodigoOriginalReemplazo
//				Parametro21 = VcdReingreso
//				Parametro22 = VcdCantidadRealAnterior
//				Parametro23 = VcdCompraOrigen
//				Parametro24 = VcdEstado
	
	$InsVentaConcretadaDetalle1 = array();
	$InsVentaConcretadaDetalle1 = $_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$Cantidad = round($_POST['ProductoCantidad'],3);
	$Importe = round($_POST['ProductoImporte'],2);
	$Precio = round(($Importe/$Cantidad),2);		
	$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);
		
	//if(($InsProducto->ProStockReal + $InsVentaConcretadaDetalle1->Parametro12)<$CantidadReal){
	if($InsProducto->ProStockReal < $CantidadReal){
		$VerificarStock = 1;
	}

	$_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsVentaConcretadaDetalle1->Parametro1,
	$InsProducto->ProId,
	$InsProducto->ProNombre,
	$Precio,
	$Cantidad,
	$Importe,
	$InsVentaConcretadaDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsProducto->RtiId,
	$CantidadReal,
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	$InsProducto->UmeId,
	$VerificarStock,
	$InsVentaConcretadaDetalle1->Parametro17,
	$InsVentaConcretadaDetalle1->Parametro18,
	$InsVentaConcretadaDetalle1->Parametro19,
	$InsVentaConcretadaDetalle1->Parametro20,
	$_POST['VentaConcretadaDetalleReingreso'],
	$InsVentaConcretadaDetalle1->Parametro22,
	$InsVentaConcretadaDetalle1->Parametro23,
	$InsVentaConcretadaDetalle1->Parametro24
	);



	//$_SESSION['InsVentaConcretadaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
//	$InsVentaConcretadaDetalle1->Parametro1,
//	$InsVentaConcretadaDetalle1->Parametro2,
//	$InsVentaConcretadaDetalle1->Parametro3,
//	$Precio,
//	$Cantidad,
//	$Importe,
//	$InsVentaConcretadaDetalle1->Parametro7,
//	date("d/m/Y H:i:s"),
//	$InsUnidadMedida->UmeNombre,
//	$InsUnidadMedida->UmeId,
//	$InsVentaConcretadaDetalle1->Parametro11,
//	$CantidadReal,
//	$InsVentaConcretadaDetalle1->Parametro13,
//	$InsVentaConcretadaDetalle1->Parametro14,
//	$InsVentaConcretadaDetalle1->Parametro15,
//	$VerificarStock,
//	$InsVentaConcretadaDetalle1->Parametro17,
//	$InsVentaConcretadaDetalle1->Parametro18
//	);

}
?>