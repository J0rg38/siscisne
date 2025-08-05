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
if (!isset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador])){
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();
}

$POST_OrdenCotizacionDetallePrecio = (empty($_POST['OrdenCotizacionDetallePrecio'])?0:$_POST['OrdenCotizacionDetallePrecio']);
$POST_OrdenCotizacionDetalleEstado = $_POST['OrdenCotizacionDetalleEstado'];
$POST_OrdenCotizacionDetalleAno = $_POST['OrdenCotizacionDetalleAno'];
$POST_OrdenCotizacionDetalleModelo = $_POST['OrdenCotizacionDetalleModelo'];
$POST_ProductoUnidadMedida = $_POST['ProductoUnidadMedida'];

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
SesionObjeto-OrdenCotizacionDetalle
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
*/
	$InsOrdenCotizacionDetalle1 = array();
	$InsOrdenCotizacionDetalle1 = $_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsOrdenCotizacionDetalle1->Parametro1,
	$InsOrdenCotizacionDetalle1->Parametro2,
	$InsOrdenCotizacionDetalle1->Parametro3,
	$POST_OrdenCotizacionDetallePrecio,
	0,
	0,
	$InsOrdenCotizacionDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsOrdenCotizacionDetalle1->Parametro11,
	$_POST['OrdenCotizacionDetalleCodigo'],
	$InsOrdenCotizacionDetalle1->Parametro13,
	$InsOrdenCotizacionDetalle1->Parametro14,
	$InsOrdenCotizacionDetalle1->Parametro15,
	NULL,
	NULL,
	$InsOrdenCotizacionDetalle1->Parametro18,
	$POST_OrdenCotizacionDetalleAno,
	$POST_OrdenCotizacionDetalleModelo,
	$InsOrdenCotizacionDetalle1->Parametro21,
	$InsOrdenCotizacionDetalle1->Parametro22,
	NULL,
	NULL,
	NULL,
	$POST_OrdenCotizacionDetalleEstado
	);

?>