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

$InsProducto->ProId = $_POST['ProductoId'];
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida->UmeId = $_POST['ProductoUnidadMedidaConvertir'];
$InsUnidadMedida->MtdObtenerUnidadMedida();
/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = OodId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = 
Parametro5 = 
Parametro6 = 
Parametro7 = OodTiempoCreacion
Parametro8 = OodTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = 
Parametro17 = 
Parametro18 = 
Parametro19 = OodAno
Parametro20 = OodModelo

Parametro21 - 
Parametro22 - 
Parametro23 = 

Parametro24 = 
Parametro25 = 

Parametro26 = PcdEstado
*/
	
	
	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
	NULL,
	$InsProducto->ProId,
	($InsProducto->ProNombre),
	$POST_OrdenCotizacionDetallePrecio,
	0,
	0,
	date("d/m/Y H:i:s"),
	date("d/m/Y H:i:s"),
	$InsUnidadMedida->UmeNombre,
	$InsUnidadMedida->UmeId,
	$InsProducto->RtiId,
	NULL,
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	$POST_ProductoUnidadMedida,
	NULL,
	NULL,
	NULL,
	$POST_OrdenCotizacionDetalleAno,
	$POST_OrdenCotizacionDetalleModelo,
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	$POST_OrdenCotizacionDetalleEstado
	);


?>