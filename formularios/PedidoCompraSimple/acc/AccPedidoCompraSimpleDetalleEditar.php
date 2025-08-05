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
if (!isset($_SESSION['InsPedidoCompraDetalle'.$Identificador])){
	$_SESSION['InsPedidoCompraDetalle'.$Identificador] = new ClsSesionObjeto();
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

	
/*
SesionObjeto-PedidoCompraDetalle
Parametro1 = PcdId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = PcdPrecio
Parametro5 = PcdCantidad
Parametro6 = PcdImporte
Parametro7 = PcdTiempoCreacion
Parametro8 = PcdTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = PcdCodigo
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = VerificarStock
Parametro17 = 
Parametro18 = VddId
Parametro19 = PcdAno
Parametro20 = PcdModelo

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado

Parametro34 = PcdObservacion
*/
	$InsPedidoCompraDetalle1 = array();
	$InsPedidoCompraDetalle1 = $_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$Cantidad = round($_POST['ProductoCantidad'],3);
	$Importe = round($_POST['ProductoImporte'],2);
	$Precio = round(($Importe/$Cantidad),2);		
	
	$_SESSION['InsPedidoCompraDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsPedidoCompraDetalle1->Parametro1,
	$InsPedidoCompraDetalle1->Parametro2,
	$InsPedidoCompraDetalle1->Parametro3,
	$Precio,
	$Cantidad,
	$Importe,
	$InsPedidoCompraDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsPedidoCompraDetalle1->Parametro11,
	$_POST['PedidoCompraDetalleCodigo'],
	$InsPedidoCompraDetalle1->Parametro13,
	$InsPedidoCompraDetalle1->Parametro14,
	$InsPedidoCompraDetalle1->Parametro15,
	NULL,
	NULL,
	$InsPedidoCompraDetalle1->Parametro18,
	$_POST['PedidoCompraDetalleAno'],
	$_POST['PedidoCompraDetalleModelo'],
	$InsPedidoCompraDetalle1->Parametro21,
	$InsPedidoCompraDetalle1->Parametro22,
	NULL,
	NULL,
	NULL,
	$_POST['PedidoCompraDetalleEstado'],
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	$_POST['PedidoCompraDetalleObservacion']
	);

?>