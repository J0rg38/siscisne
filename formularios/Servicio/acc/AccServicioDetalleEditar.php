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

$POST_ProductoId = $_POST['ProductoId'];
$POST_ProductoUnidadMedidaConvertir = $_POST['ProductoUnidadMedidaConvertir'];
$POST_ServicioDetalleCantidad = $_POST['ServicioDetalleCantidad'];

session_start();
if (!isset($_SESSION['InsServicioDetalle'.$Identificador])){
	$_SESSION['InsServicioDetalle'.$Identificador] = new ClsSesionObjeto();
}

require_once($InsPoo->MtdPaqAlmacen().'ClsProducto.php');
require_once($InsPoo->MtdPaqAlmacen().'ClsUnidadMedida.php');

$InsProducto = new ClsProducto();
$InsProducto->ProId = $POST_ProductoId;
$InsProducto->MtdObtenerProducto(false);

$InsUnidadMedida = new ClsUnidadMedida();
$InsUnidadMedida->UmeId = $POST_ProductoUnidadMedidaConvertir;
$InsUnidadMedida->MtdObtenerUnidadMedida(false);



//SesionObjeto-ServicioDetalle
//Parametro1 = SdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = SdeCantidad
//Parametro5 = SdeImporte
//Parametro6 = SdeEstado
//Parametro7 = SdeTiempoCreacion
//Parametro8 = SdeTiempoModificacion
//Parametro9 = 
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = RtiId
//Parametro14 = UmeNombre

	$InsServicioDetalle1 = array();
	$InsServicioDetalle1 = $_SESSION['InsServicioDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	$_SESSION['InsServicioDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsServicioDetalle1->Parametro1,
	$InsServicioDetalle1->Parametro2,
	$POST_ProductoUnidadMedidaConvertir,
	$POST_ServicioDetalleCantidad,
	0,
	3,
	$InsServicioDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	NULL,
	$InsProducto->ProNombre,
	$InsProducto->ProCodigoOriginal,
	$InsProducto->ProCodigoAlternativo,
	$InsProducto->RtiId,
	$InsUnidadMedida->UmeNombre
	);

?>