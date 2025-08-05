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
$ModalidadIngreso = $_POST['ModalidadIngreso'];
$POST_TallerPedidoDetalleEstado = $_POST['TallerPedidoDetalleEstado'];
$POST_TallerPedidoDetalleReingreso = $_POST['TallerPedidoDetalleReingreso'];
$POST_AlmacenId = $_POST['AlmacenId'];
$POST_TallerPedidoDetalleFecha = $_POST['TallerPedidoDetalleFecha'];

session_start();
if (!isset($_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador])){
	$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedidaConversion.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoFoto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsProductoCodigoReemplazo.php');require_once($InsPoo->MtdPaqAlmacen().'ClsProductoVehiculoVersion.php');
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


			//	SesionObjeto-TallerPedidoDetalle/InsTallerPedidoDetalle
				//	Parametro1 = AmdId
				//	Parametro2 = ProId
				//	Parametro3 = ProNombre
				//	Parametro4 = AmdPrecioVenta
				//	Parametro5 = AmdCantidad
				//	Parametro6 = AmdImporte
				//	Parametro7 = AmdTiempoCreacion
				//	Parametro8 = AmdTiempoModificacion
				//	Parametro9 = UmeNombre
				//	Parametro10 = UmeId
				//	Parametro11 = RtiId
				//	Parametro12 = AmdCantidadReal
				//	Parametro13 = ProCodigoOriginal,
				//	Parametro14 = ProCodigoAlternativo
				//	Parametro15 = UmeIdOrigen
				//	Parametro16 = VerificarStock
				//	Parametro17 = AmdCosto
				//	Parametro18 = Origen
				//	Parametro19 = Verificar
				//	Parametro20 = FaaId
				
				//	Parametro21 = PmtId
				//	Parametro22 = FaaAccion
				//	Parametro23 = FaaNivel
				//	Parametro24 = FaaVerificar1
				//	Parametro25 = 
				//	Parametro26 = FapId	
				//	Parametro27 = AmdCantidadRealAnterior
				//	Parametro28 = AmdEstado
				//	Parametro29 = AmdReingreso
				//	Parametro30 = VddId
				
				//	Parametro31 = AlmId
				//	Parametro32 = AmdFecha
								//	Parametro33 = AmdFacturado
				//	Parametro34 = AmdCierre
	
	
$InsTallerPedidoDetalle1 = array();
$InsTallerPedidoDetalle1 = $_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);

$Cantidad = round($_POST['ProductoCantidad'],3);
$Precio = round($_POST['ProductoPrecio'],3);
$Importe = round($_POST['ProductoImporte'],3);
	
$CantidadReal = round($Cantidad * $InsUnidadMedidaConversion->UmcEquivalente,6);

if($InsProducto->ProStockReal < $CantidadReal){
	$VerificarStock = 1;
}

$_SESSION['InsTallerPedidoDetalle'.$ModalidadIngreso.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
$InsTallerPedidoDetalle1->Parametro1,
$InsTallerPedidoDetalle1->Parametro2,
$InsTallerPedidoDetalle1->Parametro3,
$Precio,
$Cantidad,
$Importe,
$InsTallerPedidoDetalle1->Parametro7,
date("d/m/Y H:i:s"),
$InsUnidadMedida->UmeNombre,
$InsUnidadMedida->UmeId,
$InsTallerPedidoDetalle1->Parametro11,
$CantidadReal,
$InsTallerPedidoDetalle1->Parametro13,
$InsTallerPedidoDetalle1->Parametro14,
$InsTallerPedidoDetalle1->Parametro15,
$VerificarStock,
$InsTallerPedidoDetalle1->Parametro17,
$InsTallerPedidoDetalle1->Parametro18,
$InsTallerPedidoDetalle1->Parametro19,
$InsTallerPedidoDetalle1->Parametro20,
$InsTallerPedidoDetalle1->Parametro21,
$InsTallerPedidoDetalle1->Parametro22,
$InsTallerPedidoDetalle1->Parametro23,
$InsTallerPedidoDetalle1->Parametro24,
$InsTallerPedidoDetalle1->Parametro25,
$InsTallerPedidoDetalle1->Parametro26,
$InsTallerPedidoDetalle1->Parametro27,
$POST_TallerPedidoDetalleEstado,
$POST_TallerPedidoDetalleReingreso,
$InsTallerPedidoDetalle1->Parametro30,

$POST_AlmacenId,
$POST_TallerPedidoDetalleFecha,

$InsTallerPedidoDetalle1->Parametro33,
$InsTallerPedidoDetalle1->Parametro34
);

?>