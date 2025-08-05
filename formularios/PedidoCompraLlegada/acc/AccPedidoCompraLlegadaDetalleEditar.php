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
if (!isset($_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador])){
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador] = new ClsSesionObjeto();
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

//if($InsUnidadMedida->UmeId == $InsProducto->UmeId){
//	$InsUnidadMedidaConversion->UmcEquivalente = 1;
//}else{
//
//	$RepUnidadMedidaConversion = $InsUnidadMedidaConversion->MtdObtenerUnidadMedidaConversiones(NULL,NULL,NULL,"UmeId1","DESC","1",$InsUnidadMedida->UmeId,$InsProducto->UmeId);
//	$ArrUnidadMedidaConversiones = $RepUnidadMedidaConversion['Datos'];
//	
//	foreach($ArrUnidadMedidaConversiones as $DatUnidadMedidaConversion){
//		$InsUnidadMedidaConversion->UmcEquivalente = $DatUnidadMedidaConversion->UmcEquivalente;
//	}
//}
//
//if(!empty($InsUnidadMedidaConversion->UmcEquivalente)){

//SesionObjeto-PedidoCompraLlegadaDetalle
//Parametro1 = 
//Parametro2 = PcdId
//Parametro3 = PldCantidad
//Parametro4 = PldEstado
//Parametro5 = PldTiempoCreacion
//Parametro6 = PldTiempoModificacion
//Parametro7 = ProId
//Parametro8 = UmeId
//Parametro9 = PcdCantidad
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = UmeIdOrigen
//Parametro14 = UmeNombre
//Parametro15 = VdiId

//Parametro16 = VdiOrdenCompraNumero
//Parametro17 = CliNumeroDocumento
//Parametro18 = CliNombre
//Parametro19 = CliApellidoPaterno
//Parametro20 = CliApellidoMaterno
//Parametro21 = RtiId
//Parametro22 = OcoId
	
	$InsPedidoCompraLlegadaDetalle1 = array();
	$InsPedidoCompraLlegadaDetalle1 = $_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$Cantidad = round($_POST['ProductoCantidad'],3);
	
	$_SESSION['InsPedidoCompraLlegadaDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsPedidoCompraLlegadaDetalle1->Parametro1,
	$InsPedidoCompraLlegadaDetalle1->Parametro2,
	$Cantidad,	
	$InsPedidoCompraLlegadaDetalle1->Parametro4,
	$InsPedidoCompraLlegadaDetalle1->Parametro5,
	date("d/m/Y H:i:s"),
	$InsPedidoCompraLlegadaDetalle1->Parametro7,
	$InsPedidoCompraLlegadaDetalle1->Parametro8,
	$InsPedidoCompraLlegadaDetalle1->Parametro9,
	$InsPedidoCompraLlegadaDetalle1->Parametro10,
	$InsPedidoCompraLlegadaDetalle1->Parametro11,
	$InsPedidoCompraLlegadaDetalle1->Parametro12,
	$InsPedidoCompraLlegadaDetalle1->Parametro13,
	$InsPedidoCompraLlegadaDetalle1->Parametro14,
	$InsPedidoCompraLlegadaDetalle1->Parametro15,
	$InsPedidoCompraLlegadaDetalle1->Parametro16,
	$InsPedidoCompraLlegadaDetalle1->Parametro17,
	$InsPedidoCompraLlegadaDetalle1->Parametro18,
	$InsPedidoCompraLlegadaDetalle1->Parametro19,
	$InsPedidoCompraLlegadaDetalle1->Parametro20,
	$InsPedidoCompraLlegadaDetalle1->Parametro21,
	$InsPedidoCompraLlegadaDetalle1->Parametro22
	);
	
//}
?>