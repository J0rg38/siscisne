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
if (!isset($_SESSION['InsVehiculoRecepcionDetalle'.$Identificador])){
	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador] = new ClsSesionObjeto();	
}

	
$InsVehiculoRecepcionDetalle1 = array();
$InsVehiculoRecepcionDetalle1 = $_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdObtenerSesionObjeto($_POST['Item']);
	
	
$POST_VehiculoRecepcionDetalleZonaComprometida = $_POST['VehiculoRecepcionDetalleZonaComprometida'];
$POST_VehiculoRecepcionDetalleRepuestoDetalle = $_POST['VehiculoRecepcionDetalleRepuestoDetalle'];
$POST_VehiculoRecepcionDetalleSolucion = $_POST['VehiculoRecepcionDetalleSolucion'];
$POST_VehiculoRecepcionDetalleObservacion = $_POST['VehiculoRecepcionDetalleObservacion'];

//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado

	$_SESSION['InsVehiculoRecepcionDetalle'.$Identificador]->MtdEditarSesionObjeto($_POST['Item'],1,
	$InsVehiculoRecepcionDetalle1->Parametro1,
	$InsVehiculoRecepcionDetalle1->Parametro2,
	$POST_VehiculoRecepcionDetalleZonaComprometida,
	$POST_VehiculoRecepcionDetalleRepuestoDetalle,
	$POST_VehiculoRecepcionDetalleSolucion,
	$POST_VehiculoRecepcionDetalleObservacion,
	$InsVehiculoRecepcionDetalle1->Parametro7,
	date("d/m/Y H:i:s"),
	$InsVehiculoRecepcionDetalle1->Parametro9
	);


?>