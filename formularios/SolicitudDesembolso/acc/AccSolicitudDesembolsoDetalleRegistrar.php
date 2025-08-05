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
$POST_ServicioRepuestoId = $_POST['ServicioRepuestoId'];
$POST_ServicioRepuestoNombre = $_POST['ServicioRepuestoNombre'];
$POST_SolicitudDesembolsoDetalleImporte = $_POST['SolicitudDesembolsoDetalleImporte'];
$POST_SolicitudDesembolsoDetalleCantidad = $_POST['SolicitudDesembolsoDetalleCantidad'];

session_start();
if (!isset($_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador])){
	$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador] = new ClsSesionObjeto();
}

//	SesionObjeto-SolicitudDesembolsoDetalle
//	Parametro1 = SddId
//	Parametro2 = SdsId
//	Parametro3 = SreId
//	Parametro4 = SddDescripcion
//	Parametro5 = SddCantidad
//	Parametro6 = SddImporte
//	Parametro7 = SddTiempoCreacion
//	Parametro8 = SddTiempoModificacion
//	Parametro9 = SddEstado
//	Parametro10 = SreNombre

$_SESSION['InsSolicitudDesembolsoDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
NULL,
NULL,
$POST_ServicioRepuestoId,
"",
$POST_SolicitudDesembolsoDetalleCantidad,
$POST_SolicitudDesembolsoDetalleImporte,
date("d/m/Y H:i:s"),
date("d/m/Y H:i:s"),
3,
$POST_ServicioRepuestoNombre
);
		


?>